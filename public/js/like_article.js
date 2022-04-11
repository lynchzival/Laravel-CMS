$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        }
    });

    $('#article_data').on("click", ".fi-rr-thumbs-up", function(){
        // let id = $(this).parents(".card").data('id');
        let id = $(this).data('like');
        let c = $('#'+this.id+'-bs3').text();
        let cObjId = this.id;
        let cObj = $(this);

        $.ajax({
            type: "POST",
            url: "/article/like",
            data: { 
                id: id
            },
            success: function (data) {
                if (data.success === true) {
                    $('#'+cObjId+'-bs3').text(data.likes);
                    $(cObj).removeClass("text-success");
                } else {
                    $('#'+cObjId+'-bs3').text(data.likes);
                    $(cObj).addClass("text-success");
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });

    });

});