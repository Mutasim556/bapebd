$(document).on('click','#get_video_details',function(){
    $.ajax({
        type: "get",
        url: 'video/details/'+$(this).data('video'),
        dataType: 'JSON',
        data : {'tdata':$('#add_category_form #category_name').val()},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            var videoID = data.video_link;
            var iframe = `<iframe width="560" id="youtube_player" height="426" src="https://www.youtube.com/embed/${videoID}" frameborder="0" allowfullscreen></iframe>`;
            $("#youtube_player_body").empty().html(iframe);
        }
    })
})