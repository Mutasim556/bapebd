
$(document).on('change','#add_comment_form #translate_autometic',function(){
    if($(this).is(':checked') && $('#add_comment_form #comment').val()){
        $('#append_loader').empty().append(`Please wait....`);
        $.ajax({
            type: "get",
            url: translate_url,
            dataType: 'JSON',
            data : {'tdata':$('#add_comment_form #comment').val()},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $('#append_loader').empty()
               $.each(data.langs,function(key,val){
                    $('#add_comment_form #comment_'+val.lang).val(data.tdata[key]);
               })
            },
            error: function (err) {
                $('#append_loader').empty()
                if(err.status===403){
                    let err_message = err.responseJSON.message.split("(");
                    swal({
                        icon: "warning",
                        title: "Warning !",
                        text: err_message[0],
                        confirmButtonText: "Ok",
                    }).then(function(){
                        $('button[type=button]', '#add_comment_form').click();
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
    }

});

$(document).on('change','#edit_comment_form #translate_autometic',function(){
    if($(this).is(':checked') && $('#edit_comment_form #comment_name').val()){
        $.ajax({
            type: "get",
            url: translate_url,
            dataType: 'JSON',
            data : {'tdata':$('#edit_comment_form #comment_name').val()},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {

               $.each(data.langs,function(key,val){
                    $('#edit_comment_form #comment_name_'+val.lang).val(data.tdata[key]);
               })
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
                        $('button[type=button]', '#add_comment_form').click();
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
    }

});



$('#add_comment_form').submit(function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html(submit_btn_after+'....');
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
            $('button[type=submit]', '#add_comment_form').html(submit_btn_before);
            $('button[type=submit]', '#add_comment_form').removeClass('disabled');
            swal({
                icon: "success",
                title: rdata.title,
                text: rdata.text,
                confirmButtonText: rdata.confirmButtonText,
            }).then(function(){
                let data = rdata.comment;
                console.log(data);
                let update_status_btn = `<span class="badge badge-danger">${no_permission_mgs}</span>`;
                if(rdata.hasEditPermission){
                    update_status_btn = `<span class="mx-2">${data.status==0?'Inactive':'Active'}</span><input
                    data-status="${data.status==0?1:0}"
                    id="status_change" type="checkbox" data-toggle="switchery"
                    data-color="green" data-secondary-color="red" data-size="small" checked />`;
                }
                let action_option = `<span class="badge badge-danger">${no_permission_mgs}</span>` ;
                if(rdata.hasAnyPermission){
                    action_option = `<div class="dropdown"><button class="btn btn-info text-white px-2 py-1 dropbtn">Action <i class="fa fa-angle-down"></i></button> <div class="dropdown-content">`;
                    if(rdata.hasEditPermission){
                        action_option = action_option + `<a data-bs-toggle="modal" style="cursor: pointer;" data-bs-target="#edit-comment-modal" class="text-primary" id="edit_button"><i class=" fa fa-edit mx-1"></i>Edit</a>`;
                    }
                    if(rdata.hasDeletePermission){
                        action_option = action_option + `<a class="text-danger" id="delete_button" style="cursor: pointer;"><i class="fa fa-trash mx-1"></i> Delete</a>`;
                    }

                    action_option = action_option + `</div></div>`;
                }


                let cat_image = data.student_image?'<img style="height: 50px;width:50px;" src="'+base_url+'/public/'+data.student_image+'">':no_file;
                $('#basic-1 tbody').append(`<tr id="trid-${data.id}" data-id="${data.id}"><td>${data.student_name}</td><td>${data.student_department}</td><td>${cat_image}</td><td>${data.student_rating}</td><td>${data.comment}</td>
                <td class="text-center">${update_status_btn}</td>
                <td>${action_option}</td></tr>`);

                new Switchery($('#trid-'+data.id).find('input')[0], $('#trid-'+data.id).find('input').data());

                $('#add_comment_form .err-mgs').each(function(id,val){
                    $(this).prev('input').removeClass('border-danger is-invalid')
                    $(this).prev('textarea').removeClass('border-danger is-invalid')
                    $(this).empty();
                })
                $('#add_comment_form').trigger('reset');
                $('button[type=button]','#add_comment_form').click();
            });
        },
        error: function (err) {
            $('button[type=submit]', '#add_comment_form').html(submit_btn_before);
            $('button[type=submit]', '#add_comment_form').removeClass('disabled');
            if(err.status===403){
                var err_message = err.responseJSON.message.split("(");
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                }).then(function(){
                    $('button[type=button]', '#add_comment_form').click();
                });

            }

            $('#add_comment_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                $('#add_comment_form #'+idx).addClass('border-danger is-invalid')
                $('#add_comment_form #'+idx).next('.err-mgs').empty().append(val);
            })
        }
    });
});

// Show data on edit modal
$(document).on('click', '#edit_button', function () {
    $('#edit_comment_form').trigger('reset');
    $('#edit_comment_form .err-mgs').each(function(id,val){
        $(this).prev('input').removeClass('border-danger is-invalid')
        $(this).prev('textarea').removeClass('border-danger is-invalid')
        $(this).empty();
    })
    let cat = $(this).closest('tr').data('id');
    $.ajax({
        type: "get",
        url: 'comments/' + cat + "/edit",
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $('#edit_comment_form #comment_id').val(data.id);
            $('#edit_comment_form #student_name').val(data.student_name);
            $('#edit_comment_form #student_department').val(data.student_department);
            $('#edit_comment_form #student_rating').val(data.student_rating);

            $.each(data.translations,function(key,val){
                if(val.locale=='en'){
                    $('#edit_comment_form #comment').val(data.comment);
                }else{
                    $('#edit_comment_form #comment_'+val.locale).val(val.value);
                }
            });
           
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
                    $('button[type=button]', '#edit_comment_form').click();
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
$('#edit_comment_form').submit(function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html(submit_btn_after+'....');
    $('button[type=submit]', this).addClass('disabled');
    var trid = '#trid-'+$('#comment_id', this).val();
    var formData = new FormData(this);
    formData.append("_method","PUT");
    $.ajax({
        type: "post",
        url: 'comments/' + $('#comment_id','#edit_comment_form').val(),
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
            $('button[type=submit]', '#edit_comment_form').html(submit_btn_before);
            $('button[type=submit]', '#edit_comment_form').removeClass('disabled');
            $('td:nth-child(1)',trid).html(data.comment.student_name);
            $('td:nth-child(2)',trid).html(data.comment.student_department);
            $('td:nth-child(3)',trid).html(data.comment.student_image?`<img style="height: 70px;width:70px;" src="${base_url+'/public/'+data.comment.student_image}">`:no_file);
            $('td:nth-child(4)',trid).html(data.comment.student_rating);
            $('td:nth-child(5)',trid).html(data.comment.comment);
            swal({
                icon: "success",
                title: data.title,
                text: data.text,
                confirmButtonText: data.confirmButtonText,
            }).then(function () {
                $('#edit_comment_form .err-mgs').each(function(id,val){
                    $(this).prev('input').removeClass('border-danger is-invalid')
                    $(this).prev('textarea').removeClass('border-danger is-invalid')
                    $(this).empty();
                })
                $('#edit_comment_form').trigger('reset');
                $('button[type=button]', '#edit_comment_form').click();
            });
        },
        error: function (err) {
            $('button[type=submit]', '#edit_comment_form').html(submit_btn_before);
            $('button[type=submit]', '#edit_comment_form').removeClass('disabled');
            if(err.status===403){
                var err_message = err.responseJSON.message.split("(");
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                }).then(function(){
                    $('button[type=button]', '#edit_comment_form').click();
                });

            }

            $('#edit_comment_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).empty();
            })

            $.each(err.responseJSON.errors,function(idx,val){

                $('#edit_comment_form #'+idx).addClass('border-danger is-invalid')
                $('#edit_comment_form #'+idx).next('.err-mgs').empty().append(val);
            })
        }
    });
});

//update status
$(document).on('change','#status_change',function(){
    var status = $(this).data('status');
    var update_id = $(this).closest('tr').data('id');
    var cat_td = $(this).parent();
    cat_td.empty().append(`<i class="fa fa-refresh fa-spin"></i>`);
    $.ajax({
        type: "get",
        url: 'comments/update/status/'+update_id+"/"+status,
        success: function (data) {
            cat_td.empty().append(`<span class="mx-2">${data.status==0?'Inactive':'Active'}</span><input data-status="${data.status==1?0:1}" id="status_change" type="checkbox" data-toggle="switchery" data-color="green"  data-secondary-color="red" data-size="small" ${data.status==1?'checked':''} />`);
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
                url: 'comments/'+delete_id,
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
