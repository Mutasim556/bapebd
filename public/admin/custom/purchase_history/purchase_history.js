


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
    var delete_id = $(this).closest('tr').data('id');
    var tr = $(this).closest('tr')
    swal({
        title: "Are you sure?",
        text: "Want to delete purchase history",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "delete",
                url: 'purchase-history/'+delete_id,
                data: {
                    _token : $("input[name=_token]").val(),
                },
                success: function (data) {
                    tr.remove();
                },
                error : function(err){
                    console.log(err);
                    if(err.status==401){
                         swal({
                            icon: "warning",
                            title: "Warning !",
                            text: err.responseJSON.message,
                            confirmButtonText: "Ok",
                        })
                    }
                }
            })
        }else{

        }
    })
});

$('#course_id').on('change',function(){
     $.ajax({
        type: "get",
        url: 'purchase-history/'+$(this).val()+"/edit",
        success: function (data) {
            if(data.course.course_type=='Live' && data.batches!=null){
                $('#batch_div').removeClass('d-none');
                $('#course_batch').empty();
                $.each(data.batches,function(key,val){
                    $('#course_batch').append(`<option value="${val.id}">${val.batch_name+' - '+val.batch_code}</option>`);
                    $('#batch_div #course_batch').prop('required',true)
                })
            }else{
                $('#batch_div').addClass('d-none');
                $('#batch_div #course_batch').prop('required',false)
            }
        },
        error : function(err){
            console.log(err);
            if(err.status==401){
                    swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err.responseJSON.message,
                    confirmButtonText: "Ok",
                })
            }
        }
    })
});

$(document).on('submit','#gift_course_form',function(e){
    e.preventDefault();
    $('button[type=submit]', this).html('Gifting....');
    $('button[type=submit]', this).addClass('disabled');
    var formData = new FormData(this);
    $.ajax({
        type: "POST",
        url: form_url,
        data: formData,
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $('button[type=submit]', '#gift_course_form').html('Submit');
            $('button[type=submit]', '#gift_course_form').removeClass('disabled');
           
            swal({
                icon: "success",
                title: "Congratulations !",
                text: 'Course gifted successfully',
                confirmButtonText: "Ok",
            }).then(function(){
                $('#search_btn').click();
            })
        },
        error : function(err){
            $('button[type=submit]', '#gift_course_form').html('Submit');
            $('button[type=submit]', '#gift_course_form').removeClass('disabled');
            if(err.status==401){
                    swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err.responseJSON.message,
                    confirmButtonText: "Ok",
                })
            }
        }
    });
})