$(document).on('submit','#search_form',function(e){
    e.preventDefault();
    var formData = $(this).serialize();
    // $('#search_btn').empty().append(submit_btn_after);
    $.ajax({
        method : 'post',
        data : formData,
        url : index_url,
        success : function(data){
            
            $('#basic-1 tbody').empty()
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
            
            $('#basic-1 tbody').append(tr);
            $('#basic-1 tbody tr').each(function(index, tr) { 
                new Switchery($(this).find('input')[0], $(this).find('input').data());
            })

            // $('#basic-1').DataTable().destroy();
            //  $("#basic-1").DataTable({
            //     columnDefs: [{ width: 20, targets: 0 },{ width: 80, targets: 1 },{ width: 60, targets: 3 }],
            //     order: [[0, 'desc'],[8, 'desc']]
            //  })
            
           
        }
    });
    
})