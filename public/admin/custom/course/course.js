$(document).on('keyup','#course_name',function(){
    var slug = ($(this).val().toLowerCase()).replace(/ /g,'-');
    $("#course_name_slug").val(slug);
})
$(document).on('keyup','#course_name_slug',function(){
    var slug = ($(this).val().toLowerCase()).replace(/ /g,'-');
    $("#course_name_slug").val(slug);
})
function calDiscount(course_discount,course_price){
    if($('#course_discount_type').val()=='Flat'){
        if(course_discount>course_price){
            swal({
                icon: "warning",
                title: "Warning !",
                text: discount_warning,
                confirmButtonText: comfirm_btn,
            }).then(function(){
                $('#course_discount_price').val(''); 
                $('#course_discount').val(''); 
            });
        }else{
            $('#course_discount_price').val(Math.ceil(course_price-course_discount));
        }
    }else{
        var discount_price = parseFloat((course_discount*course_price)/100);
        if(discount_price>course_price){
            swal({
                icon: "warning",
                title: "Warning !",
                text: discount_warning,
                confirmButtonText: comfirm_btn,
            }).then(function(){
                $('#course_discount_price').val(''); 
                $('#course_discount').val(''); 
            });
        }else{
            $('#course_discount_price').val(Math.ceil(course_price-discount_price));
        }
    }
}
$(document).on('keyup','#course_discount',function(){
    if($(this).val() && $('#course_price').val()){
        var course_discount = parseFloat($(this).val());
        var course_price = parseFloat($('#course_price').val());
        calDiscount(course_discount,course_price);
    }
});

$(document).on('change','#course_discount_type',function(){
    if($('#course_discount').val() && $('#course_price').val()){
        var course_discount = parseFloat($('#course_discount').val());
        var course_price = parseFloat($('#course_price').val());
        calDiscount(course_discount,course_price);
    }
});

$(document).on('blur','#course_price',function(){
    if($('#course_price').val()){
        var course_discount = parseFloat($('#course_discount').val()?$('#course_discount').val():0);
        var course_price = parseFloat($('#course_price').val());
        calDiscount(course_discount,course_price);
    }
});

$(document).on("change",'#course_type',function(){
    if($(this).val()=='Live'){
        $('#live_field_append').show(300);
        $('#pre_recorded_field_append').hide(300);
    }else if($(this).val()=='Pre-recorded'){
        $('#pre_recorded_field_append').show(300);
        $('#live_field_append').hide(300);
    }else{
        $('#live_field_append').hide(300);
        $('#pre_recorded_field_append').hide(300);
    }
})

$(document).on("change",'#course_category',function(){
    $.ajax({
        type: 'GET',
        url: 'get/subcategory',
        data: {'category_id':$(this).val()},
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success : function(data){

            option = `<option value="">${select_please}</option>`;

            $.each(data,function(key,val){
                option = option + `<option value="${val.id}">${val.sub_category_name}</option>`;
            });
            
            $('#course_sub_category').empty().append(option).trigger('change');
        },
        error : function(resp){

        }
    })
})


Dropzone.autoDiscover = false;
let token = $('meta[name="csrf-token"]').attr('content');
var myDropzone = new Dropzone("div#dropzoneDragArea", {
    addRemoveLinks: true,
    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 100,
    dictRemoveFile: 'Remove',
    maxFilesize: 12,
    paramName: 'image',
    clickable: true,
    method: 'POST',
    url: form_url,
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    renameFile: function (file) {
        var dt = new Date();
        var time = dt.getTime();
        var file_ext = file.name.split('.');
        return 'COURSE-'+time+'.'+file_ext[file_ext.length-1];
    },
    acceptedFiles: ".jpeg,.jpg,.png,.gif",
    init: function (file) {
        var myDropzone = this;
        $('#add_course_form').on("submit", function (e) {
            e.preventDefault();
            // e.stopPropagation();
            // console.log(myDropzone.getQueuedFiles().length);
            if (myDropzone.getQueuedFiles().length > 0)
            {
                myDropzone.processQueue();
            } else {
                    let fData =  new FormData(this);
                    $('button[type=submit]', '#add_course_form').html(submit_btn_after);
                    $('button[type=submit]', '#add_course_form').addClass('disabled');
                    fData.append('_token',$('#csrf_token').val());
                    fData.append('course_details',CKEDITOR.instances['course_details'].getData());  
                    $.each(langCode,function(k,v){
                        fData.append('course_details_'+v,CKEDITOR.instances['course_details_'+v].getData());  
                    })
                    $.ajax({
                        type: 'POST',
                        url: form_url,
                        data: fData,
                        dataType: 'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            swal({
                                icon: "success",
                                title: data.title,
                                text: data.text,
                                confirmButtonText: data.confirmButtonText,
                            }).then(function(){
                                // this.removeAllFiles(true);
                                window.location.reload()
                            })
                        },
                        error: function (err) {
                            $('button[type=submit]', '#add_course_form').html(submit_btn_before);
                            $('button[type=submit]', '#add_course_form').removeClass('disabled');
                            if(err.status===403){
                                var err_message = err.responseJSON.message.split("(");
                                swal({
                                    icon: "warning",
                                    title: "Warning !",
                                    text: err_message[0],
                                    confirmButtonText: "Ok",
                                }).then(function(){
                                    $('button[type=button]', '##add_course_form').click();
                                });
                
                            }
                
                            $('#add_course_form .err-mgs').each(function(id,val){
                                $(this).prev('input').removeClass('border-danger is-invalid')
                                $(this).prev('textarea').removeClass('border-danger is-invalid')
                                $(this).prev('span').find('.select2-selection--single').attr('id','')
                                $(this).empty();
                            })
                            $.each(err.responseJSON.errors,function(idx,val){
                                // console.log('#add_course_form #'+idx);
                                var exp = idx.replace('.','_');
                                var exp2 = exp.replace('_0','');
                                
                                $('#add_course_form #'+exp).addClass('border-danger is-invalid')
                                $('#add_course_form #'+exp2).addClass('border-danger is-invalid')
                                $('#add_course_form #'+exp).next('span').find('.select2-selection--single').attr('id','invalid-selec2')
                                $('#add_course_form #'+exp).next('.err-mgs').empty().append(val);
                
                                $('#add_course_form #'+exp+"_err").empty().append(val);
                            })
                        },
                    });
            }
        });
        this.on('sending', function (file, xhr, formData) {
            // Append all form inputs to the formData Dropzone will POST
            var data = $("#add_course_form").serializeArray();
            // ardata = [];
            
            if($('#add_course_form #course_type').val()=='Pre-recorded'){
                for(i=0;i<=count_div;i++){
                    data.push({name:'video_file[]',value:document.getElementById("video_file_"+i).files[0]})
                }
            }
            $.each(data, function (key, el) {
                formData.append(el.name, el.value);
            });
        });
    },
    error: function (file, err) {
        this.removeAllFiles(true);

        $('#add_course_form').find(" :input").each(function(){
            $(this).removeClass('border-danger is-invalid')
        })
        $('#add_course_form .text-danger').each(function(id,val){
            $(this).empty();
        })

        $.each(err.errors,function(idx,val){
            $('#add_course_form #'+idx).addClass('border-danger is-invalid')
            $('#add_course_form .err-mgs-'+idx).empty().append(val);
        })
    },
    successmultiple: function (file, response) {
        // console.log(response);
        this.removeAllFiles(true);
        swal({
            icon: "success",
            title: response.title,
            text: response.text,
            confirmButtonText: response.confirmButtonText,
        }).then(function(){
            window.location.reload()
        })

    },
    completemultiple: function (file, response) {
        console.log(file, response, "completemultiple");
    },
    reset: function () {
        console.log("resetFiles");
        this.removeAllFiles(true);
    }
});


