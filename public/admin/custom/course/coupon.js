$('#add_coupon_form').submit(function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html(submit_btn_after + '....');
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
        success: function (rdata) {
            $('button[type=submit]', '#add_coupon_form').html(submit_btn_before);
            $('button[type=submit]', '#add_coupon_form').removeClass('disabled');
            swal({
                icon: "success",
                title: rdata.title,
                text: rdata.text,
                confirmButtonText: rdata.confirmButtonText,
            }).then(function () {
                let data = rdata.coupon;
                let update_status_btn = `<span class="badge badge-danger">${no_permission_mgs}</span>`;
                if (rdata.hasEditPermission) {
                    update_status_btn = `<span class="mx-2">${data.coupon_status == 0 ? 'Inactive' : 'Active'}</span><input
                    data-status="${data.coupon_status == 0 ? 1 : 0}"
                    id="status_change" type="checkbox" data-toggle="switchery"
                    data-color="green" data-secondary-color="red" data-size="small" checked />`;
                }
                let action_option = `<span class="badge badge-danger">${no_permission_mgs}</span>`;
                if (rdata.hasAnyPermission) {
                    action_option = `<div class="dropdown"><button class="btn btn-info text-white px-2 py-1 dropbtn">Action <i class="fa fa-angle-down"></i></button> <div class="dropdown-content">`;
                    if (rdata.hasEditPermission) {
                        action_option = action_option + `<a data-bs-toggle="modal" style="cursor: pointer;" data-bs-target="#edit-category-modal" class="text-primary" id="edit_button"><i class=" fa fa-edit mx-1"></i>Edit</a>`;
                    }
                    if (rdata.hasDeletePermission) {
                        action_option = action_option + `<a class="text-danger" id="delete_button" style="cursor: pointer;"><i class="fa fa-trash mx-1"></i> Delete</a>`;
                    }

                    action_option = action_option + `</div></div>`;
                }


                $('#basic-1 tbody').append(`<tr id="trid-${data.id}" data-id="${data.id}"><td>${data.id}</td><td>${data.coupon}</td><td>${data.coupon_discount}</td><td>${data.coupon_discount_type}</td><td>${data.coupon_details}</td><td><button type="button" id="coupon_details_view" data-bs-toggle="modal" style="cursor: pointer;"
                                                data-bs-target="#view-course-coupon-modal" class="btn btn-sm btn-info px-1 py-1">Click Here</button></td><td>${data.apply_type}</td><td>${data.has_minimum_price_for_apply?data.minimum_price_for_apply:'N/A'}</td><td>${data.has_maximum_discount?data.maximum_discount:'N/A'}</td><td>${data.can_apply>=1?data.can_apply+' Times':'N/A'}</td><td>${data.coupon_start_date}</td><td>${data.coupon_end_date}</td><td>${data.validity}</td>
                <td class="text-center">${update_status_btn}</td>
                <td>${action_option}</td></tr>`);

                new Switchery($('#trid-' + data.id).find('input')[0], $('#trid-' + data.id).find('input').data());

                $('#add_coupon_form .err-mgs').each(function (id, val) {
                    $(this).prev('input').removeClass('border-danger is-invalid')
                    $(this).prev('textarea').removeClass('border-danger is-invalid')
                    $(this).empty();
                })
                $('#add_coupon_form').trigger('reset');
                $('button[type=button]', '#add_coupon_form').click();
            });
        },
        error: function (err) {
            $('button[type=submit]', '#add_coupon_form').html(submit_btn_before);
            $('button[type=submit]', '#add_coupon_form').removeClass('disabled');
            if (err.status === 403) {
                var err_message = err.responseJSON.message.split("(");
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                }).then(function () {
                    $('button[type=button]', '##add_coupon_form').click();
                });

            }

            $('#add_coupon_form .err-mgs').each(function (id, val) {
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).prev('span').find('.select2-selection--single').attr('id', '')
                $(this).empty();
            })
            $.each(err.responseJSON.errors, function (idx, val) {
                // console.log('#add_coupon_form #'+idx);
                var exp = idx.replace('.', '_');
                var exp2 = exp.replace('_0', '');

                $('#add_coupon_form #' + exp).addClass('border-danger is-invalid')
                $('#add_coupon_form #' + exp2).addClass('border-danger is-invalid')
                $('#add_coupon_form #' + exp).next('span').find('.select2-selection--single').attr('id', 'invalid-selec2')
                $('#add_coupon_form #' + exp).next('.err-mgs').empty().append(val);

                $('#add_coupon_form #' + exp + "_err").empty().append(val);
            })
        }
    });
});

// Show data on edit modal
$(document).on('click', '#coupon_details_view', function () {
    $('#edit_coupon_form').trigger('reset');
    $('#edit_coupon_form .err-mgs').each(function(id,val){
        $(this).prev('input').removeClass('border-danger is-invalid')
        $(this).prev('textarea').removeClass('border-danger is-invalid')
        $(this).empty();
    })
    let cat = $(this).closest('tr').data('id');
    $.ajax({
        type: "get",
        url: 'coupon/' + cat,
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
           var tr = ``;
           $.each(data,function(key,val){
            console.log(val);
            
            tr += `<tr>
                <td>${val.coupon_code}</td>
                <td>${val.course.course_name}</td>
                <td>${val.coupon.coupon_discount}</td>
                <td>${val.coupon.coupon_discount_type}-${val.coupon.apply_type}</td>
                <td>${val.course.course_price}</td>
                <td>${val.course.course_discount_price}</td>
                <td>${val.coupon_applied_price}</td>
            </tr>`
           })
        //    console.log(tr);
           
           $('#coupon_details_table').empty().append(tr);
        },
        error: function (err) {
            if(err.status===403){
                let err_message = err.responseJSON.message.split("(");
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                }).then(function(){
                    $('button[type=button]', '#edit_coupon_form').click();
                });
                
            }else{
                let err_message = err.responseJSON.message.split("(");
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                });
            }
        }
    });

});

$(document).on('change','#status_change',function(){
    var status = $(this).data('status');
    var update_id = $(this).closest('tr').data('id');
    var cat_td = $(this).parent();
    cat_td.empty().append(`<i class="fa fa-refresh fa-spin"></i>`);
    $.ajax({
        type: "get",
        url: 'coupon/update/status/'+update_id+"/"+status,
        success: function (data) {
            cat_td.empty().append(`<span class="mx-2">${data.coupon_status==0?'Inactive':'Active'}</span><input data-status="${data.coupon_status==1?0:1}" id="status_change" type="checkbox" data-toggle="switchery" data-color="green"  data-secondary-color="red" data-size="small" ${data.coupon_status==1?'checked':''} />`);
            // parent_td.children('input').each(function (idx, obj) {
            //     new Switchery($(this)[0], $(this).data());
            // });
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
});
//delete data
$(document).on('click','#delete_button',function(){
    var delete_id = $(this).closest('tr').data('id');
    swal({
        title: delete_swal_title,
        text: delete_swal_text,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "delete",
                url: 'coupon/'+delete_id,
                data: {
                    _token : $("input[name=_token]").val(),
                },
                success: function (data) {
                    swal({
                        icon: "success",
                        title: data.title,
                        text: data.text,
                        confirmButtonText: data.confirmButtonText,
                    }).then(function () {
                        $('#trid-'+delete_id).hide();
                    });
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
           
        } else {
            swal(delete_swal_cancel_text);
        }
    })
});


// Show data on edit modal
$(document).on('click', '#edit_button', function () {
    $('#edit_coupon_form').trigger('reset');
    $('#edit_coupon_form .err-mgs').each(function(id,val){
        $(this).prev('input').removeClass('border-danger is-invalid')
        $(this).prev('textarea').removeClass('border-danger is-invalid')
        $(this).empty();
    })
    let cat = $(this).closest('tr').data('id');
    $.ajax({
        type: "get",
        url: 'coupon/' + cat + "/edit",
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $('#edit_coupon_form #coupon_id').val(data.id);
            $('#edit_coupon_form #coupon_code').val(data.coupon);
            $('#edit_coupon_form #coupon_discount').val(data.coupon_discount);
            $('#edit_coupon_form #coupon_discount_type').val(data.coupon_discount_type);
            $('#edit_coupon_form #start_date').val(data.coupon_starts_date);
            $('#edit_coupon_form #end_date').val(data.coupon_ends_date);
            $('#edit_coupon_form #can_apply').val(data.can_apply);
            $('#edit_coupon_form #has_minimum_price').prop('checked',data.has_minimum_price_for_apply==1?true:false);
            if(data.has_minimum_price_for_apply==1){
                $('#edit_coupon_form #minimum_price_div').show();
                $('#edit_coupon_form #minimum_price').val(data.minimum_price_for_apply);
            }else{
                $('#edit_coupon_form #minimum_price_div').hide();
                $('#edit_coupon_form #minimum_price').val('');
            }
            
            $('#edit_coupon_form #has_maximum_discount').prop('checked',data.has_maximum_discount==1?true:false);
            if(data.has_maximum_discount==1){
                $('#edit_coupon_form #maximum_discount_div').show();
                $('#edit_coupon_form #maximum_discount').val(data.maximum_discount);
            }else{
                $('#edit_coupon_form #maximum_discount_div').hide();
                $('#edit_coupon_form #maximum_discount').val('');
            }

            $('#edit_coupon_form #coupon_details').html(data.coupon_details);
            $('#edit_coupon_form #discount_apply_type').val(data.apply_type.replace(/ /g,'_').toLowerCase());
            let value = new Array();
            $.each(data.courses, function(key,val){
                value.push(val.course_id);
                
            });
            $('#edit_coupon_form #course').val(value).trigger('change');
        },
        error: function (err) {
            if(err.status===403){
                let err_message = err.responseJSON.message.split("(");
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                }).then(function(){
                    $('button[type=button]', '#edit_coupon_form').click();
                });
                
            }else{
                let err_message = err.responseJSON.message.split("(");
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                });
            }
        }
    });

});



//update data
$('#edit_coupon_form').submit(function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html(submit_btn_after+'....');
    $('button[type=submit]', this).addClass('disabled');
    var trid = '#trid-'+$('#coupon_id', this).val();
    var formData = new FormData(this);
    formData.append("_method","PUT");
    $.ajax({
        type: "post",
        url: 'coupon/' + $('#coupon_id','#edit_coupon_form').val(),
        data: formData,
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            console.log(data);
            $('button[type=submit]', '#edit_coupon_form').html(submit_btn_before);
            $('button[type=submit]', '#edit_coupon_form').removeClass('disabled');
            // $('td:nth-child(1)',trid).html(data.id);
            if(data.coupon.applicable_for){
                var button = `<button type="button" id="coupon_details_view" data-bs-toggle="modal" style="cursor: pointer;"
                                                data-bs-target="#view-course-coupon-modal" class="btn btn-sm btn-info px-1 py-1">Click Here</button>`;
            }else{
                var button = `<button type="button" class="btn btn-sm btn-success px-1 py-1">All</button>`;
            }
            $('td:nth-child(2)',trid).html(data.coupon.coupon);
            $('td:nth-child(3)',trid).html(data.coupon.coupon_discount);
            $('td:nth-child(4)',trid).html(data.coupon.coupon_discount_type);
            $('td:nth-child(5)',trid).html(data.coupon.coupon_details);
            $('td:nth-child(6)',trid).html(button);
            $('td:nth-child(7)',trid).html(data.coupon.apply_type);
            $('td:nth-child(8)',trid).html(data.coupon.has_minimum_price_for_apply==1?data.coupon.minimum_price_for_apply:'N/A');
            $('td:nth-child(9)',trid).html(data.coupon.has_maximum_discount==1?data.coupon.maximum_discount:'N/A');
            $('td:nth-child(10)',trid).html(data.coupon.can_apply+" Times");
            $('td:nth-child(11)',trid).html(data.coupon.coupon_start_date);
            $('td:nth-child(12)',trid).html(data.coupon.coupon_end_date);
            $('td:nth-child(13)',trid).html(data.coupon.validity);
            swal({
                icon: "success",
                title: data.title,
                text: data.text,
                confirmButtonText: data.confirmButtonText,
            }).then(function () {
                $('#edit_coupon_form .err-mgs').each(function(id,val){
                    $(this).prev('input').removeClass('border-danger is-invalid')
                    $(this).prev('textarea').removeClass('border-danger is-invalid')
                    $(this).empty();
                })
                $('#edit_coupon_form').trigger('reset');
                $('button[type=button]', '#edit_coupon_form').click();
            });
        },
        error: function (err) {
            $('button[type=submit]', '#edit_coupon_form').html(submit_btn_before);
            $('button[type=submit]', '#edit_coupon_form').removeClass('disabled');
            if(err.status===403){
                var err_message = err.responseJSON.message.split("(");
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                }).then(function(){
                    $('button[type=button]', '#edit_coupon_form').click();
                });
            }

            $('#edit_coupon_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).empty();
            })
            
            $.each(err.responseJSON.errors,function(idx,val){
                
                $('#edit_coupon_form #'+idx).addClass('border-danger is-invalid')
                $('#edit_coupon_form #'+idx).next('.err-mgs').empty().append(val);
            })
        }
    });
});