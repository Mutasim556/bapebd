$('#content_for').change(function(){
    if($(this).val()=='admin'){
        $('#position').empty();
        $('#position').append('<option value="" selected disabled>Please Select</option><option value="admin_top">Admin Top</option><option value="admin_bottom">Admin Bottom</option><option value="admin_title_image">Admin Title Image</option>')
    }else if($(this).val()=='spark'){
        $('#position').empty();
        $('#position').append('<option value="" selected disabled>Please Select</option><option value="spark_top">Spark It Top</option><option value="spark_bottom">Spark It Bottom</option>')
    }
});
$('#position').change(function(){
    if($(this).val()=='admin_title_image' || $(this).val()=='spark_top' || $(this).val()=='spark_bottom'){
        $('#type').empty();
        $('#type').append('<option value="" selected disabled>Please Select</option><option value="image">Image</option>')
    }else{
        $('#type').empty();
        $('#type').append('<option value="" selected disabled>Please Select</option><option value="image">Image</option><option value="text">Text</option>')
    }
})

$('#type').change(function(){
    if($(this).val()=='image'){
        $('#upload_type').empty();
        $('#upload_type').append('<label class="labelcolor" for="">Upload Image</label><input type="file" class="dropify" data-height="100" width="100%" name="image" id="image" accept="image/png, image/jpeg,image/jpeg"/>')
        $('.dropify').dropify({
            messages: {
                'default': 'Drag and drop a file here or click',
                'replace': 'Drag and drop or click to replace',
                'remove': 'Remove',
                'error': 'Ooops, something wrong appended.'
            },
            error: {
                'fileSize': 'The file size is too big (1M max).'
            }
        });
    }else{
        $('#upload_type').empty();
        $('#upload_type').append('<label class="labelcolor" for="">Enter Text</label><textarea name="text" id="text" class="form-control" rows="6"></textarea>')
    }
})

$('#content_for_serach').change(function(){
    if($(this).val()=='admin'){
        $('#position_serach').empty();
        $('#position_serach').append('<option value="">Please Select</option><option value="admin_top">Admin Top</option><option value="admin_bottom">Admin Bottom</option><option value="admin_title_image">Admin Title Image</option>')
    }else if($(this).val()=='spark'){
        $('#position_serach').empty();
        $('#position_serach').append('<option value="">Please Select</option><option value="spark_top">Spark It Top</option><option value="spark_bottom">Spark It Bottom</option>')
    }
});

$('#position_serach').change(function(){
    if($(this).val()=='admin_title_image' || $(this).val()=='spark_top' || $(this).val()=='spark_bottom'){
        $('#type_serach').empty();
        $('#type_serach').append('<option value="">Please Select</option><option value="image">Image</option>')
    }else{
        $('#type_serach').empty();
        $('#type_serach').append('<option value="">Please Select</option><option value="image">Image</option><option value="text">Text</option>')
    }
})