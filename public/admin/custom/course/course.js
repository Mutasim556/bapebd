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
    if($('#course_discount').val() && $('#course_price').val()){
        var course_discount = parseFloat($('#course_discount').val());
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
        return 'PRODUCT-'+time+'.'+file_ext[file_ext.length-1];
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
                    fData.append('_token',$('#csrf_token').val());
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
                            $('#add_course_form').find(" :input").each(function(){
                                $(this).removeClass('border-danger is-invalid')
                            })
                            $('#add_course_form .text-danger').each(function(id,val){
                                $(this).empty();
                            })

                            $.each(err.responseJSON.errors,function(idx,val){
                                let splitVal = idx.split('.');
                                if(splitVal.length>1 ){
                                    if(splitVal[0]='variant_option'){
                                        $('#add_course_form #variant_error').removeClass('d-none');
                                    }else if(splitVal[0]='variant_value'){
                                        $('#add_course_form #variant_error').removeClass('d-none');
                                    }else{
                                        $('#add_course_form #variant_error').addClass('d-none');
                                    }
                                }else{
                                    $('#add_course_form #variant_error').addClass('d-none');
                                }
                                $('#add_course_form #'+idx).addClass('border-danger is-invalid')
                                $('#add_course_form .err-mgs-'+idx).empty().append(val);
                            })
                        },
                    });
            }
        });
        this.on('sending', function (file, xhr, formData) {
            // Append all form inputs to the formData Dropzone will POST
            var data = $("#add_course_form").serializeArray();
            if($('#add_course_form #product_type').val()=='digital'){
                data.push({name:'attatch_file',value:document.getElementById("attatched_file").files[0]})
            }
            console.log(data);
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