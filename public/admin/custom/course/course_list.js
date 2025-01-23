function getCoursedetails(id){
    $.ajax({
        type: 'GET',
        url: 'course/'+id,
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success : function(data){

        },
        error : function(resp){

        }
    })
}