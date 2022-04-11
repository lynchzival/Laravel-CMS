$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        }
    });

    $('#article_data').on("click", ".fi-rr-bookmark", function(){
        // let id = $(this).parents(".card").data('id');
        let id = $(this).data('favorite');
        let c = $('#'+this.id+'-bs3').text();
        let cObjId = this.id;
        let cObj = $(this);

        $.ajax({
            type: "POST",
            url: "/article/favorite",
            data: { 
                id: id
            },
            success: function (data) {
                if (data.status === true) {
                    $(cObj).addClass("text-success");
                } else {
                    $(cObj).removeClass("text-success");                    
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });

    });

});