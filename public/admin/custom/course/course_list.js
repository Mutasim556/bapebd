function getCoursedetails(id){
    $.ajax({
        type: 'GET',
        url: 'course/'+id,
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success : function(data){
            $('#batch_details_append tbody').empty();
            // $('#batch_details_append tbody').empty();
            $('#selected_video_course_id').val(id);
            if(data.type=='Live'){
                $('#modal_body_2').hide();
                $('#modal_body_1').show();
                
                var trdata = ``;
                $("#batch_details_append").DataTable().destroy();
                $('#batch_details_append tbody').empty();
                $.each(data.batches,function(key,val){
                    let update_status_btn = `<span class="badge badge-danger">${no_permission_mgs}</span>`;
                    if(data.hasEditPermission){
                        update_status_btn = `<span class="mx-2">${val.batch_status==0?'Inactive':'Active'}</span><input
                        data-status="${val.batch_status==0?1:0}"
                        id="live_status_change" type="checkbox" data-toggle="switchery"
                        data-color="green" data-secondary-color="red" data-size="small" ${val.batch_status==1?'checked':''} />`;
                    }
                    let action_option = `<span class="badge badge-danger">${no_permission_mgs}</span>` ;
                    if(data.hasAnyPermission){
                        action_option = `<div class="dropdown"><button class="btn btn-info text-white px-2 py-1 dropbtn">Action <i class="fa fa-angle-down"></i></button> <div class="dropdown-content">`;
                        if(data.hasEditPermission){
                            action_option = action_option + `<a data-bs-toggle="modal" style="cursor: pointer;" data-bs-target="#edit-live-modal" class="text-primary" id="live_edit_button"><i class=" fa fa-edit mx-1"></i>Edit</a>`;
                        }
                        if(data.hasDeletePermission){
                            action_option = action_option + `<a class="text-danger" id="live_delete_button" style="cursor: pointer;"><i class="fa fa-trash mx-1"></i> Delete</a>`;
                        }

                        action_option = action_option + `</div></div>`;
                    }
                    trdata = `
                        <tr id="ltrid-${val.id}" data-id="${val.id}">
                            <td>${val.batch_name}</td>
                            <td>${val.batch_code}</td>
                            <td>${val.instructor.name+'-'+val.instructor.phone}</td>
                            <td>${val.batch_start_date}</td>
                            <td>${val.batch_end_date}</td>
                            <td>${val.batch_time}</td>
                            <td>${val.enroll_limit}</td>
                            <td>${val.enrolled_count}</td>
                            <td>${val.live_in}</td>
                            <td>${val.link_or_address}</td>
                            <td style="width:170px;">${update_status_btn}</td>
                            <td style="width:150px;">${action_option}</td>
                        </tr>
                    `;

                    $('#batch_details_append tbody').append(trdata);
                    new Switchery($('#ltrid-'+val.id).find('input')[0], $('#ltrid-'+val.id).find('input').data());
                })


                $("#batch_details_append").DataTable().destroy();

                $("#batch_details_append").DataTable({
                    dom: 'Blfrtip',
                    select: true,
                    dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                    buttons: [
                        {
                            "extend": 'excel',
                            "text": '<i class="fa fa-file-excel-o" style="font-size:18px;"></i>',
                            title : '',
                            'className': 'btn btn-success btn-square py-1 px-3',
                                exportOptions: {
                                columns: [0, 1, 2, 5]
                            }
                        },{
                            "extend": 'pdf',
                            "text": '<i class="fa fa-file-pdf-o" style="font-size:18px;"></i>',
                            'className': 'btn btn-danger btn-square py-1 px-3'
                        },{
                            "extend": 'print',
                            "text": '<i class="fa fa-print" style="font-size:18px;"></i>',
                            'className': 'btn btn-info btn-square py-1 px-3'
                        }
                    ],
                });
                
            }else{
                $('#modal_body_1').hide();
                $('#modal_body_2').show();

                
                
                var trdata = ``;
                $("#batch_details_append2").DataTable().destroy();
                $('#batch_details_append2 tbody').empty();
               
                $.each(data.videos,function(key,val){
                    console.log(val.video_status);
                    
                    let update_status_btn = `<span class="badge badge-danger">${no_permission_mgs}</span>`;
                    if(data.hasEditPermission){
                        update_status_btn = `<span class="mx-2">${val.video_status==0?'Inactive':'Active'}</span><input
                        data-status="${val.video_status==0?1:0}"
                        id="recorded_status_change" type="checkbox" data-toggle="switchery"
                        data-color="green" data-secondary-color="red" data-size="small" ${val.video_status==1?'checked':''} />`;
                    }
                    let action_option = `<span class="badge badge-danger">${no_permission_mgs}</span>` ;
                    if(data.hasAnyPermission){
                        action_option = `<div class="dropdown"><button class="btn btn-info text-white px-2 py-1 dropbtn">Action <i class="fa fa-angle-down"></i></button> <div class="dropdown-content">`;
                        if(data.hasEditPermission){
                            action_option = action_option + `<a data-bs-toggle="modal" style="cursor: pointer;" data-bs-target="#edit-recorded-modal" class="text-primary" id="recorded_edit_button"><i class=" fa fa-edit mx-1"></i>Edit</a>`;
                        }
                        if(data.hasDeletePermission){
                            action_option = action_option + `<a class="text-danger" id="recorded_delete_button" style="cursor: pointer;"><i class="fa fa-trash mx-1"></i> Delete</a>`;
                        }

                        action_option = action_option + `</div></div>`;
                    }
                    let vid_file = val.videos_file?'<a class="badge badge-info" target="__blank" href="'+base_url+'/'+val.videos_file+'">'+click_here+'</a>':no_file;
                    trdata = `
                        <tr id="vtrid-${val.id}" data-id="${val.id}">
                            <td>${val.video_no}</td>
                            <td>${val.video_group}</td>
                            <td>${val.video_title}</td>
                            <td>${vid_file}</td>
                            <td>${val.video_link}</td>
                            <td>${val.video_duration} Min</td>
                            <td>${val.video_type}</td>
                            <td style="width:170px;">${update_status_btn}</td>
                            <td style="width:150px;">${action_option}</td>
                        </tr>
                    `;
                    $('#batch_details_append2 tbody').append(trdata);
                    new Switchery($('#vtrid-'+val.id).find('input')[0], $('#vtrid-'+val.id).find('input').data());
                })
                
                

               

                $("#batch_details_append2").DataTable({
                    dom: 'Blfrtip',
                    select: true,
                    dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                    buttons: [
                        {
                            "extend": 'excel',
                            "text": '<i class="fa fa-file-excel-o" style="font-size:18px;"></i>',
                            title : '',
                            'className': 'btn btn-success btn-square py-1 px-3',
                                exportOptions: {
                                columns: [0, 1, 2, 5]
                            }
                        },{
                            "extend": 'pdf',
                            "text": '<i class="fa fa-file-pdf-o" style="font-size:18px;"></i>',
                            'className': 'btn btn-danger btn-square py-1 px-3'
                        },{
                            "extend": 'print',
                            "text": '<i class="fa fa-print" style="font-size:18px;"></i>',
                            'className': 'btn btn-info btn-square py-1 px-3'
                        }
                    ],
                });
            }
        },
        error : function(resp){

        }
    })
}


//update status
$(document).on('change','#status_change',function(){
    var status = $(this).data('status');
    var update_id = $(this).closest('tr').data('id');
    var cat_td = $(this).parent();
    cat_td.empty().append(`<i class="fa fa-refresh fa-spin"></i>`);
    $.ajax({
        type: "get",
        url: 'course/update/status/'+update_id+"/"+status,
        success: function (data) {
            cat_td.empty().append(`<span class="mx-2">${data.course_status==0?'Inactive':'Active'}</span><input data-status="${data.course_status==1?0:1}" id="status_change" type="checkbox" data-toggle="switchery" data-color="green"  data-secondary-color="red" data-size="small" ${data.course_status==1?'checked':''} />`);
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

$(document).on('change','#live_status_change',function(){
    var status = $(this).data('status');
    var update_id = $(this).closest('tr').data('id');
    var cat_td = $(this).parent();
    cat_td.empty().append(`<i class="fa fa-refresh fa-spin"></i>`);
    $.ajax({
        type: "get",
        url: 'course/live/batch/status/'+update_id+"/"+status,
        success: function (data) {
            cat_td.empty().append(`<span class="mx-2">${data.batch_status==0?'Inactive':'Active'}</span><input data-status="${data.batch_status==1?0:1}" id="live_status_change" type="checkbox" data-toggle="switchery" data-color="green"  data-secondary-color="red" data-size="small" ${data.batch_status==1?'checked':''} />`);
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

$(document).on('change','#recorded_status_change',function(){
    var status = $(this).data('status');
    var update_id = $(this).closest('tr').data('id');
    var cat_td = $(this).parent();
    cat_td.empty().append(`<i class="fa fa-refresh fa-spin"></i>`);
    $.ajax({
        type: "get",
        url: 'course/recorded/status/update/'+update_id+"/"+status,
        success: function (data) {
            cat_td.empty().append(`<span class="mx-2">${data.video_status==0?'Inactive':'Active'}</span><input data-status="${data.video_status==1?0:1}" id="recorded_status_change" type="checkbox" data-toggle="switchery" data-color="green"  data-secondary-color="red" data-size="small" ${data.video_status==1?'checked':''} />`);
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
                url: 'course/'+delete_id,
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

//delete live data
$(document).on('click','#live_delete_button',function(){
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
                url: 'course/live/delete/'+delete_id,
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
                        $('#batch_details_append #ltrid-'+delete_id).hide();
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


//delete live data
$(document).on('click','#recorded_delete_button',function(){
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
                url: 'course/recorded/delete/'+delete_id,
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
                        $('#modal_body_2 #vtrid-'+delete_id).remove();
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


$(document).on('click', '#recorded_edit_button', function () {
    $('#edit_video_form').trigger('reset');
    $('#edit_video_form .err-mgs').each(function(id,val){
        $(this).prev('input').removeClass('border-danger is-invalid')
        $(this).prev('textarea').removeClass('border-danger is-invalid')
        $(this).empty();
    })
    let cat = $(this).closest('tr').data('id');
    $.ajax({
        type: "get",
        url: 'course/recorded/data/' + cat + "/edit",
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $('#video_id', '#edit_video_form').val(data.id);
            $('#video_no', '#edit_video_form').val(data.video_no);
            $('#video_group', '#edit_video_form').val(data.video_group);
            $('#video_title', '#edit_video_form').val(data.video_title);
            $('#video_link', '#edit_video_form').val(data.video_link);
            $('#video_duration', '#edit_video_form').val(data.video_duration);
            $('#video_type', '#edit_video_form').val(data.video_type);
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
                    $('button[type=button]', '#edit_video_form').click();
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
$('#edit_video_form').submit(function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html(submit_btn_after+'....');
    $('button[type=submit]', this).addClass('disabled');
    var trid = '#vtrid-'+$('#video_id', this).val();
    var formData = new FormData(this);
    formData.append("_method","PUT");
    $.ajax({
        type: "post",
        url: 'course/recorded/data/update/' + $('#video_id','#edit_video_form').val(),
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
            $('button[type=submit]', '#edit_video_form').html(submit_btn_before);
            $('button[type=submit]', '#edit_video_form').removeClass('disabled');
            $('td:nth-child(1)',trid).html(data.course.video_no);
            $('td:nth-child(2)',trid).html(data.course.video_group);
            $('td:nth-child(3)',trid).html(data.course.video_title);
            let vid_file = data.course.videos_file?'<a class="badge badge-info" target="__blank" href="'+base_url+'/'+data.course.videos_file+'">'+click_here+'</a>':no_file;
            $('td:nth-child(4)',trid).html(vid_file);
            $('td:nth-child(5)',trid).html(data.course.video_link);
            $('td:nth-child(6)',trid).html(data.course.video_duration+" Min");
            $('td:nth-child(7)',trid).html(data.course.video_type);
            swal({
                icon: "success",
                title: data.title,
                text: data.text,
                confirmButtonText: data.confirmButtonText,
            }).then(function () {
                $('#edit_video_form .err-mgs').each(function(id,val){
                    $(this).prev('input').removeClass('border-danger is-invalid')
                    $(this).prev('textarea').removeClass('border-danger is-invalid')
                    $(this).empty();
                })
                $('#edit_video_form').trigger('reset');
                $('button[type=button]', '#edit_video_form').click();
            });
        },
        error: function (err) {
            $('button[type=submit]', '#edit_video_form').html('Submit');
            $('button[type=submit]', '#edit_video_form').removeClass('disabled');
            $('#edit_video_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                $('#edit_video_form #'+idx).next('.err-mgs').empty().append(val);
                $('#edit_video_form #'+idx).addClass('border-danger is-invalid')
            });
        }
    });
});

$(document).on('click', '#live_edit_button', function () {
    $('#edit_batch_form').trigger('reset');
    $('#edit_batch_form .err-mgs').each(function(id,val){
        $(this).prev('input').removeClass('border-danger is-invalid')
        $(this).prev('textarea').removeClass('border-danger is-invalid')
        $(this).empty();
    })
    let cat = $(this).closest('tr').data('id');
    $.ajax({
        type: "get",
        url: 'course/live/data/' + cat + "/edit",
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $('#batch_id', '#edit_batch_form').val(data.id);
            $('#batch_name', '#edit_batch_form').val(data.batch_name);
            $('#batch_code', '#edit_batch_form').val(data.batch_code);
            $('#batch_instructor', '#edit_batch_form').val(data.batch_instructor).trigger('change');
            $('#batch_start_date', '#edit_batch_form').val(data.batch_start_date);
            $('#batch_end_date', '#edit_batch_form').val(data.batch_end_date);
            $('#batch_time', '#edit_batch_form').val(data.batch_time);
            $('#enroll_limit', '#edit_batch_form').val(data.enroll_limit);
            $('#live_in', '#edit_batch_form').val(data.live_in);
            $('#link_or_address', '#edit_batch_form').val(data.link_or_address);
            var batch_day_arr = data.batch_day.split(',');
            $.each(batch_day_arr,function(kk,vv){
                $("#batch_day option[value='" + vv + "']",'#edit_batch_form').prop("selected", true);
                // $('#batch_day', '#edit_batch_form').val(vv);
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
                    $('button[type=button]', '#edit_batch_form').click();
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
$('#edit_batch_form').submit(function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html(submit_btn_after+'....');
    $('button[type=submit]', this).addClass('disabled');
    var trid = '#ltrid-'+$('#batch_id', this).val();
    var formData = new FormData(this);
    formData.append("_method","PUT");
    $.ajax({
        type: "post",
        url: 'course/live/data/update/' + $('#batch_id','#edit_batch_form').val(),
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
            $('button[type=submit]', '#edit_batch_form').html(submit_btn_before);
            $('button[type=submit]', '#edit_batch_form').removeClass('disabled');
            $('td:nth-child(1)',trid).html(data.batch.batch_name);
            $('td:nth-child(2)',trid).html(data.batch.batch_code);
            $('td:nth-child(3)',trid).html(data.batch.instructor.name+"-"+data.batch.instructor.phone);
            $('td:nth-child(4)',trid).html(data.batch.batch_start_date);
            $('td:nth-child(5)',trid).html(data.batch.batch_end_date);
            $('td:nth-child(6)',trid).html(data.batch.batch_time);
            $('td:nth-child(7)',trid).html(data.batch.enroll_limit);
            $('td:nth-child(9)',trid).html(data.batch.live_in);
            $('td:nth-child(10)',trid).html(data.batch.link_or_address);
            swal({
                icon: "success",
                title: data.title,
                text: data.text,
                confirmButtonText: data.confirmButtonText,
            }).then(function () {
                $('#edit_batch_form .err-mgs').each(function(id,val){
                    $(this).prev('input').removeClass('border-danger is-invalid')
                    $(this).prev('textarea').removeClass('border-danger is-invalid')
                    $(this).empty();
                })
                $('#edit_batch_form').trigger('reset');
                $('button[type=button]', '#edit_batch_form').click();
            });
        },
        error: function (err) {
            $('button[type=submit]', '#edit_batch_form').html('Submit');
            $('button[type=submit]', '#edit_batch_form').removeClass('disabled');
            $('#edit_batch_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                $('#edit_batch_form #'+idx).next('.err-mgs').empty().append(val);
                $('#edit_batch_form #'+idx).addClass('border-danger is-invalid')
            });
        }
    });
});


$('#add_video_form').submit(function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html(submit_btn_after+'....');
    $('button[type=submit]', this).addClass('disabled');
    var formData = new FormData(this);
    $.ajax({
        type: "POST",
        url: 'course/video/upload',
        data: formData,
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
        },
        success: function (rdata) {
            $('button[type=submit]', '#add_video_form').html(submit_btn_before);
            $('button[type=submit]', '#add_video_form').removeClass('disabled');
            swal({
                icon: "success",
                title: rdata.title,
                text: rdata.text,
                confirmButtonText: rdata.confirmButtonText,
            }).then(function(){
                let data = rdata.video;
                let update_status_btn = `<span class="badge badge-danger">${no_permission_mgs}</span>`;
                if(rdata.hasEditPermission){
                    update_status_btn = `<span class="mx-2">${data.video_status==0?'Inactive':'Active'}</span><input
                    data-status="${data.video_status==0?1:0}"
                    id="recorded_status_change" type="checkbox" data-toggle="switchery"
                    data-color="green" data-secondary-color="red" data-size="small" checked />`;
                }
                let action_option = `<span class="badge badge-danger">${no_permission_mgs}</span>` ;
                if(rdata.hasAnyPermission){
                    action_option = `<div class="dropdown"><button class="btn btn-info text-white px-2 py-1 dropbtn">Action <i class="fa fa-angle-down"></i></button> <div class="dropdown-content">`;
                    if(rdata.hasEditPermission){
                        action_option = action_option + `<a data-bs-toggle="modal" style="cursor: pointer;" data-bs-target="#edit-recorded-modal" class="text-primary" id="recorded_edit_button"><i class=" fa fa-edit mx-1"></i>Edit</a>`;
                    }
                    if(rdata.hasDeletePermission){
                        action_option = action_option + `<a class="text-danger" id="recorded_delete_button" style="cursor: pointer;"><i class="fa fa-trash mx-1"></i> Delete</a>`;
                    }

                    action_option = action_option + `</div></div>`;
                }


                let vid_file = data.videos_file?'<a class="badge badge-info" target="__blank" href="'+base_url+'/'+data.videos_file+'">'+click_here+'</a>':no_file;
                trdata = `
                    <tr id="vtrid-${data.id}" data-id="${data.id}">
                        <td>${data.video_no}</td>
                        <td>${data.video_group}</td>
                        <td>${data.video_title}</td>
                        <td>${vid_file}</td>
                        <td>${data.video_link}</td>
                        <td>${data.video_duration} Min</td>
                        <td>${data.video_type}</td>
                        <td style="width:170px;">${update_status_btn}</td>
                        <td style="width:150px;">${action_option}</td>
                    </tr>
                `;
                $('#batch_details_append2 tbody').append(trdata);

                new Switchery($('#vtrid-'+data.id).find('input')[0], $('#vtrid-'+data.id).find('input').data());

                $('#add_video_form .err-mgs').each(function(id,val){
                    $(this).prev('input').removeClass('border-danger is-invalid')
                    $(this).prev('textarea').removeClass('border-danger is-invalid')
                    $(this).empty();
                })
                $('#add_video_form').trigger('reset');
                $('button[type=button]','#add_video_form').click();
            });
        },
        error: function (err) {
            $('button[type=submit]', '#add_video_form').html(submit_btn_before);
            $('button[type=submit]', '#add_video_form').removeClass('disabled');
            if(err.status===403){
                var err_message = err.responseJSON.message.split("(");
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                }).then(function(){
                    $('button[type=button]', '#add_video_form').click();
                });
                
            }

            $('#add_video_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                $('#add_video_form #'+idx).addClass('border-danger is-invalid')
                $('#add_video_form #'+idx).next('.err-mgs').empty().append(val);
            })
        }
    });
});


$('#add_batch_form').submit(function (e) {
    e.preventDefault();
    $('button[type=submit]', this).html(submit_btn_after+'....');
    $('button[type=submit]', this).addClass('disabled');
    var formData = new FormData(this);
    $.ajax({
        type: "POST",
        url: 'course/batch/upload',
        data: formData,
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
        },
        success: function (rdata) {
            $('button[type=submit]', '#add_batch_form').html(submit_btn_before);
            $('button[type=submit]', '#add_batch_form').removeClass('disabled');
            swal({
                icon: "success",
                title: rdata.title,
                text: rdata.text,
                confirmButtonText: rdata.confirmButtonText,
            }).then(function(){
                let data = rdata.batch;
                let update_status_btn = `<span class="badge badge-danger">${no_permission_mgs}</span>`;
                if(rdata.hasEditPermission){
                    update_status_btn = `<span class="mx-2">${data.batch_status==0?'Inactive':'Active'}</span><input
                    data-status="${data.batch_status==0?1:0}"
                    id="live_status_change" type="checkbox" data-toggle="switchery"
                    data-color="green" data-secondary-color="red" data-size="small" checked />`;
                }
                let action_option = `<span class="badge badge-danger">${no_permission_mgs}</span>` ;
                if(rdata.hasAnyPermission){
                    action_option = `<div class="dropdown"><button class="btn btn-info text-white px-2 py-1 dropbtn">Action <i class="fa fa-angle-down"></i></button> <div class="dropdown-content">`;
                    if(rdata.hasEditPermission){
                        action_option = action_option + `<a data-bs-toggle="modal" style="cursor: pointer;" data-bs-target="#edit-live-modal" class="text-primary" id="live_edit_button"><i class=" fa fa-edit mx-1"></i>Edit</a>`;
                    }
                    if(rdata.hasDeletePermission){
                        action_option = action_option + `<a class="text-danger" id="live_delete_button" style="cursor: pointer;"><i class="fa fa-trash mx-1"></i> Delete</a>`;
                    }

                    action_option = action_option + `</div></div>`;
                }


                trdata = `
                    <tr id="ltrid-${data.id}" data-id="${data.id}">
                        <td>${data.batch_name}</td>
                        <td>${data.batch_code}</td>
                        <td>${data.instructor.name+'-'+data.instructor.phone}</td>
                        <td>${data.batch_start_date}</td>
                        <td>${data.batch_end_date}</td>
                        <td>${data.batch_time}</td>
                        <td>${data.enroll_limit}</td>
                        <td>${data.enrolled_count}</td>
                        <td>${data.live_in}</td>
                        <td>${data.link_or_address}</td>
                        <td style="width:170px;">${update_status_btn}</td>
                        <td style="width:150px;">${action_option}</td>
                    </tr>
                `;

                $('#batch_details_append tbody').append(trdata);

                new Switchery($('#ltrid-'+data.id).find('input')[0], $('#ltrid-'+data.id).find('input').data());

                $('#add_batch_form .err-mgs').each(function(id,val){
                    $(this).prev('input').removeClass('border-danger is-invalid')
                    $(this).prev('textarea').removeClass('border-danger is-invalid')
                    $(this).empty();
                })
                $('#add_batch_form').trigger('reset');
                $('button[type=button]','#add_batch_form').click();
            });
        },
        error: function (err) {
            $('button[type=submit]', '#add_batch_form').html(submit_btn_before);
            $('button[type=submit]', '#add_batch_form').removeClass('disabled');
            if(err.status===403){
                var err_message = err.responseJSON.message.split("(");
                swal({
                    icon: "warning",
                    title: "Warning !",
                    text: err_message[0],
                    confirmButtonText: "Ok",
                }).then(function(){
                    $('button[type=button]', '#add_batch_form').click();
                });
                
            }

            $('#add_batch_form .err-mgs').each(function(id,val){
                $(this).prev('input').removeClass('border-danger is-invalid')
                $(this).prev('textarea').removeClass('border-danger is-invalid')
                $(this).empty();
            })
            $.each(err.responseJSON.errors,function(idx,val){
                $('#add_batch_form #'+idx).addClass('border-danger is-invalid')
                $('#add_batch_form #'+idx).next('.err-mgs').empty().append(val);
            })
        }
    });
});
