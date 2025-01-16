// Show data on edit modal
$(document).on('click', '#edit_button', function () {
    $('#edit_instructor_form').trigger('reset');
    let instructor_id = $(this).closest('tr').data('id');
    $.ajax({
        type: "get",
        url: 'instructor/' + instructor_id + "/edit",
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $('#edit_instructor_form #instructor_id').val(data.instructor.id);
            $('#edit_instructor_form #instructor_name').val(data.instructor.name);
            $('#edit_instructor_form #instructorname').val(data.instructor.username);
            $('#edit_instructor_form #instructor_role').val(data.role);
            $('#edit_instructor_form #instructor_email').val(data.instructor.email);
            $('#edit_instructor_form #instructor_phone').val(data.instructor.phone);
        },
        error: function (err) {
            // console.log('Hello');
            var err_message = err.responseJSON.message.split("(");
            if(err.status===403){
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                }).then(function(){
                    $('button[type=button]', '#edit_instructor_form').click();
                });
                
            }else{
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                });
            }
            
            
            
        }
    });

})

//update data
$('#edit_instructor_form').submit(function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html('Submitting....');
    $('button[type=submit]', this).addClass('disabled');
    var trid = '#tr-'+$('#instructor_id', this).val();
    $.ajax({
        type: "put",
        url: 'instructor/' + $('#instructor_id', this).val(),
        data: $(this).serialize(),
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $('button[type=submit]', '#edit_instructor_form').html('Submit');
            $('button[type=submit]', '#edit_instructor_form').removeClass('disabled');
            $('td:nth-child(1)',trid).html(data.instructor.name);
            $('td:nth-child(2)',trid).html(data.instructor.email);
            $('td:nth-child(3)',trid).html(data.instructor.phone);
            $('td:nth-child(4)',trid).html(data.instructor.instructorname);
            $('td:nth-child(5)',trid).html(data.role);
            swal({
                icon: "success",
                title: data.title,
                text: data.text,
                confirmButtonText: data.confirmButtonText,
            }).then(function () {
                $('#edit_instructor_form').trigger('reset');
                $('button[type=button]', '#edit_instructor_form').click();


            });
        },
        error: function (err) {
            $('button[type=submit]', '#edit_instructor_form').html('Submit');
            $('button[type=submit]', '#edit_instructor_form').removeClass('disabled');
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

//update status
$(document).on('change','#status_change',function(){
    var status = $(this).data('status');
    var update_id = $(this).closest('tr').data('id');
    var parent_td = $(this).parent();
    // console.log(update_id);
    // console.log(status);
    parent_td.empty().append(`<div class="loader-box"><div class="loader-35"></div></div>`);
    $.ajax({
        type: "GET",
        url: 'instructor/update/status/'+update_id+"/"+status,
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            console.log(update_id);
            parent_td.empty().append(`<span class="mx-2">${data.status==1?'Active':'Inactive'}</span><input data-status="${data.status==1?0:1}" id="status_change" type="checkbox" data-toggle="switchery" data-color="green"  data-secondary-color="red" data-size="small" ${data.status==1?'checked':''} />`);
            new Switchery(parent_td.find('input')[0], parent_td.find('input').data());
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
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this instructor",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "delete",
                url: 'instructor/'+delete_id,
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
                        $('#tr-'+delete_id).remove();
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
            swal("Delete request canceld successfully");
        }
    })
});


