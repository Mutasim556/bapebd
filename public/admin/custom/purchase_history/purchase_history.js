$(document).on('submit','#search_form',function(e){
    e.preventDefault();
    var formData = $(this).serialize();
    // $('#search_btn').empty().append(submit_btn_after);
    $.ajax({
        method : 'post',
        data : formData,
        url : index_url,
        success : function(data){
            
            // $('#basic-1 tbody').empty()
            var tr = ``
            $.each(data.purchases,function(key,value){
                var pstatus = `${no_permission}`;
                if(data.hasEditPermission){
                    pstatus = `<span class="mx-2">${ value.payment_status == 0 ? 'Unpaid' : 'Paid' }</span><input data-status="${ value.payment_status == 0 ? 1 : 0 }" id="status_change" type="checkbox" data-toggle="switchery" data-color="green" data-secondary-color="red" data-size="small" ${ value.payment_status == 1 ? 'checked' : '' } />`
                }
                tr = tr + `<tr>
                                <td>${value.id}</td>
                                <td>${value.phone??'Empty'}</td>
                                <td>${value.total_amount}</td>
                                <td>${value.dicount_amount}</td>
                                <td>${value.subtotal}</td>
                                <td>${value.payment_method}</td>
                                <td>${value.payment_option}</td>
                                <td>${value.transaction_id}</td>
                                <td>
                                    ${pstatus}
                                </td>
                                <td>
                                    ${value.create_date}
                                </td>
                                <td></td>
                            </tr>`
                // new Switchery(cat_td.find('input')[0], cat_td.find('input').data());
            })
            
            $('#basic-1 tbody').empty().append(tr);
            $('#basic-1 tbody tr').each(function(index, tr) { 
                new Switchery($(this).find('input')[0], $(this).find('input').data());
            })

            $('#basic-1').DataTable().destroy();
             $("#basic-1").DataTable({
                columnDefs: [{ width: 20, targets: 0 },{ width: 80, targets: 1 },{ width: 60, targets: 3 }],
                order: [[0, 'desc'],[8, 'desc']]
             })
            
           
        }
    });
    
})


//update status
$(document).on('change','#status_change',function(){
    var status = $(this).data('status');
    var update_id = $(this).closest('tr').data('id');
    var cat_td = $(this).parent();
    cat_td.empty().append(`<i class="fa fa-refresh fa-spin"></i>`);

     swal({
        title: "Are you sure?",
        text: "If you change status it will effects user purchase status",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                    type: "get",
                    url: 'purchase-history/purchase-status/change/'+update_id+"/"+status,
                    success: function (data) {
                        cat_td.empty().append(`<span class="mx-2">${data.payment_status==1?'Paid':'Unpaid'}</span><input data-status="${data.payment_status==1?0:1}" id="status_change" type="checkbox" data-toggle="switchery" data-color="green"  data-secondary-color="red" data-size="small" ${data.payment_status==1?'checked':''} />`);
                        new Switchery(cat_td.find('input')[0], cat_td.find('input').data());
                    },
                    error: function (err) {
                        var err_message = err.responseJSON.message.split("(");
                        swal({
                            icon: "warning",
                            title: "Warning !",
                            text: err_message[0],
                            confirmButtonText: "Ok",
                        });
                    }
            });
        }else{
             cat_td.empty().append(`<span class="mx-2">${status==0?'Paid':'Unpaid'}</span><input data-status="${status==1?1:0}" id="status_change" type="checkbox" data-toggle="switchery" data-color="green"  data-secondary-color="red" data-size="small" ${status==0?'checked':''} />`);
             new Switchery(cat_td.find('input')[0], cat_td.find('input').data());
        }
    });
   
});

$(document).on('click','#view_course',function(){
     var update_id = $(this).closest('tr').data('id');
    $.ajax({
            type: "get",
            url: 'purchase-history/'+update_id,
            success: function (data) {
                $('#append_purchased_courses').empty();
                $.each(data,function(key,val){
                    $('#append_purchased_courses').append(`<tr>
                                    <td>${val.course_id}</td>
                                    <td>${val.course.course_name}</td>
                                    <td>${val.batch_id?'':`N/A`}</td>
                                    <td>${val.course_type}</td>
                                </tr>`);
                })
            },
            error: function (err) {
                var err_message = err.responseJSON.message.split("(");
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                });
            }
    });
});

$(document).on('click','#delete_button',function(){
    swal({
        title: "Are you sure?",
        text: "Want to delete purchase history",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {

        }else{
            
        }
    })
});