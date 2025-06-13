$('#reply_type').change(function(){
    if($(this).val()=='Email'){
        $('#mail_subject_div').show('slow');
    }else{
        $('#mail_subject_div').hide('slow');
    }
})

$(document).on('click', '#edit_button', function () {
    $('#reply_message_form').trigger('reset');
    $('#reply_message_form .err-mgs').each(function(id,val){
        $(this).prev('input').removeClass('border-danger is-invalid')
        $(this).prev('textarea').removeClass('border-danger is-invalid')
        $(this).empty();
    })
    let cat = $(this).closest('tr').data('id');
    $.ajax({
        type: "get",
        url: 'get-messages-data/' + cat,
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            if(data.reply_status==0){
                $('#reply_message_form #message_id').val(data.id);
                $('#reply_message_form #mail_subject').prop('readonly',false);
                $('#reply_message_form #reply_message').prop('readonly',false);
                $('#reply_message_form #reply_type').prop('disabled',false);
                $('#reply_message_form #submit_btn').show('slow');
            }else{
                $('#reply_message_form #reply_message').val(data.reply_message);
                $('#reply_message_form #reply_type').val(data.reply_type);
                if(data.reply_type=='Email'){
                    $('#mail_subject_div').show('slow')
                    $('#reply_message_form #mail_subject').val(data.reply_subject);
                    $('#reply_message_form #mail_subject').prop('readonly',true);
                }else{
                    $('#mail_subject_div').hide('slow')
                }

                $('#reply_message_form #reply_message').prop('readonly',true);
                $('#reply_message_form #reply_type').prop('disabled',true);
                $('#reply_message_form #submit_btn').hide('slow');
            }

            $('#reply_message_form #message').val(data.message);

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
                    $('button[type=button]', '#reply_message_form').click();
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

$('#reply_message_form').submit(function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html(submit_btn_after+'....');
    $('button[type=submit]', this).addClass('disabled');
    var trid = '#trid-'+$('#message_id', this).val();
    var formData = new FormData(this);
    formData.append("_method","PUT");
    $.ajax({
        type: "post",
        url: 'save-reply-message/' + $('#message_id','#reply_message_form').val(),
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
            $('button[type=submit]', '#reply_message_form').html(submit_btn_before);
            $('button[type=submit]', '#reply_message_form').removeClass('disabled');
            $('td:nth-child(6)',trid).html(data.message.reply_status);
            $('td:nth-child(7)',trid).html(data.message.replied_by.name);
            // $('td:nth-child(3)',trid).html(data.message.admin.name);
            swal({
                icon: "success",
                title: data.title,
                text: data.text,
                confirmButtonText: data.confirmButtonText,
            }).then(function () {
                $('#reply_message_form .err-mgs').each(function(id,val){
                    $(this).prev('input').removeClass('border-danger is-invalid')
                    $(this).prev('textarea').removeClass('border-danger is-invalid')
                    $(this).empty();
                })
                $('#reply_message_form').trigger('reset');
                $('button[type=button]', '#reply_message_form').click();
            });
        },
        error: function (err) {
            $('button[type=submit]', '#reply_message_form').html(submit_btn_before);
            $('button[type=submit]', '#reply_message_form').removeClass('disabled');
            if(err.status===403){
                var err_message = err.responseJSON.message.split("(");
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                }).then(function(){
                    $('button[type=button]', '#reply_message_form').click();
                });

            }

            $('#reply_message_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).empty();
            })

            $.each(err.responseJSON.errors,function(idx,val){

                $('#reply_message_form #'+idx).addClass('border-danger is-invalid')
                $('#reply_message_form #'+idx).next('.err-mgs').empty().append(val);
            })
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
                url: 'delete-message/'+delete_id,
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

