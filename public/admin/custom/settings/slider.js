$('#add_slider_form').submit(function (e) {
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
            $('button[type=submit]', '#add_slider_form').html(submit_btn_before);
            $('button[type=submit]', '#add_slider_form').removeClass('disabled');
            swal({
                icon: "success",
                title: rdata.title,
                text: rdata.text,
                confirmButtonText: rdata.confirmButtonText,
            }).then(function(){
                let data = rdata.slider;
                console.log(data);
                let update_status_btn = `<span class="badge badge-danger">${no_permission_mgs}</span>`;
                if(rdata.hasEditPermission){
                    update_status_btn = `<span class="mx-2">${data.status==0?'Inactive':'Active'}</span><input
                    data-status="${data.slider_status==0?1:0}"
                    id="status_change" type="checkbox" data-toggle="switchery"
                    data-color="green" data-secondary-color="red" data-size="small" checked />`;
                }
                let action_option = `<span class="badge badge-danger">${no_permission_mgs}</span>` ;
                if(rdata.hasAnyPermission){
                    action_option = `<div class="dropdown"><button class="btn btn-info text-white px-2 py-1 dropbtn">Action <i class="fa fa-angle-down"></i></button> <div class="dropdown-content">`;
                    if(rdata.hasEditPermission){
                        action_option = action_option + `<a data-bs-toggle="modal" style="cursor: pointer;" data-bs-target="#edit-slider-modal" class="text-primary" id="edit_button"><i class=" fa fa-edit mx-1"></i>Edit</a>`;
                    }
                    if(rdata.hasDeletePermission){
                        action_option = action_option + `<a class="text-danger" id="delete_button" style="cursor: pointer;"><i class="fa fa-trash mx-1"></i> Delete</a>`;
                    }

                    action_option = action_option + `</div></div>`;
                }


                let cat_image = data.slider_image?'<img style="height:40px" src="'+asset_url+data.slider_image+'">':no_file;
                let cat_image2 = data.slider_image2?'<img style="height:40px" src="'+asset_url+data.slider_image2+'">':no_file;
                $('#basic-1 tbody').append(`<tr id="trid-${data.id}" data-id="${data.id}"><td>${cat_image}</td><td>${cat_image2}</td><td>${data.slider_title?data.slider_title:'N/A'}</td><td>${data.slider_short_description?data.slider_short_description:'N/A'}</td><td>${data.slider_button_text?data.slider_button_text:'N/A'}</td>
                <td class="text-center">${update_status_btn}</td>
                <td>${action_option}</td></tr>`);

                new Switchery($('#trid-'+data.id).find('input')[0], $('#trid-'+data.id).find('input').data());

                $('#add_slider_form .err-mgs').each(function(id,val){
                    $(this).prev('input').removeClass('border-danger is-invalid')
                    $(this).prev('textarea').removeClass('border-danger is-invalid')
                    $(this).empty();
                })
                $('#add_slider_form').trigger('reset');
                $('button[type=button]','#add_slider_form').click();
            });
        },
        error: function (err) {
            $('button[type=submit]', '#add_slider_form').html(submit_btn_before);
            $('button[type=submit]', '#add_slider_form').removeClass('disabled');
            if(err.status===403){
                var err_message = err.responseJSON.message.split("(");
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                }).then(function(){
                    $('button[type=button]', '#add_slider_form').click();
                });

            }

            $('#add_slider_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                $('#add_slider_form #'+idx).addClass('border-danger is-invalid')
                $('#add_slider_form #'+idx).next('.err-mgs').empty().append(val);
            })
        }
    });
});


// Show data on edit modal
$(document).on('click', '#edit_button', function () {
    $('#edit_slider_form').trigger('reset');
    $('#edit_slider_form .err-mgs').each(function(id,val){
        $(this).prev('input').removeClass('border-danger is-invalid')
        $(this).prev('textarea').removeClass('border-danger is-invalid')
        $(this).empty();
    })
    let cat = $(this).closest('tr').data('id');
    $.ajax({
        type: "get",
        url: 'slider/' + cat + "/edit",
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $('#edit_slider_form #slider_id').val(data.id);
            $('#edit_slider_form #slider_title').val(data.slider_title);
            $('#edit_slider_form #slider_short_description').val(data.slider_short_description);
            $('#edit_slider_form #slider_link').val(data.slider_link);
            $('#edit_slider_form #slider_button_text').val(data.slider_button_text);
            if(data.slider_image==''){
                $('#edit_slider_form #preview_image2').attr('src','');
            }else{
                $('#edit_slider_form #preview_image2').attr('src',asset_url+data.slider_image);
            }
            if(data.slider_image2==''){
                $('#edit_slider_form #preview_image4').attr('src','');
            }else{
                $('#edit_slider_form #preview_image4').attr('src',asset_url+data.slider_image2);
            }
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
                    $('button[type=button]', '#edit_slider_form').click();
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
$('#edit_slider_form').submit(function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html(submit_btn_after+'....');
    $('button[type=submit]', this).addClass('disabled');
    var trid = '#trid-'+$('#slider_id', this).val();
    var formData = new FormData(this);
    formData.append("_method","PUT");
    $.ajax({
        type: "post",
        url: 'slider/' + $('#slider_id','#edit_slider_form').val(),
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
            $('button[type=submit]', '#edit_slider_form').html(submit_btn_before);
            $('button[type=submit]', '#edit_slider_form').removeClass('disabled');
            $('td:nth-child(2)',trid).html(data.slider.slider_title);
            $('td:nth-child(3)',trid).html(data.slider.slider_short_description?data.slider.slider_short_description:'N/A');
            $('td:nth-child(1)',trid).html(data.slider.slider_image?`<img style="height:40px" src="${asset_url+data.slider.slider_image}">`:no_file);
            $('td:nth-child(4)',trid).html(data.slider.slider_button_text);
            swal({
                icon: "success",
                title: data.title,
                text: data.text,
                confirmButtonText: data.confirmButtonText,
            }).then(function () {
                $('#edit_slider_form .err-mgs').each(function(id,val){
                    $(this).prev('input').removeClass('border-danger is-invalid')
                    $(this).prev('textarea').removeClass('border-danger is-invalid')
                    $(this).empty();
                })
                $('#edit_slider_form').trigger('reset');
                $('button[type=button]', '#edit_slider_form').click();
            });
        },
        error: function (err) {
            $('button[type=submit]', '#edit_slider_form').html('Submit');
            $('button[type=submit]', '#edit_slider_form').removeClass('disabled');
            $('#edit_slider_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                $('#edit_slider_form #'+idx).next('.err-mgs').empty().append(val);
                $('#edit_slider_form #'+idx).addClass('border-danger is-invalid')
            });
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
        url: 'slider/update/status/'+update_id+"/"+status,
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
                url: 'slider/'+delete_id,
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
