$(document).ready(function() {

    let page = 1;

    $(window).scroll("scroll",function () {
        let scroll_height = parseFloat($(window).scrollTop() + $(window).height());
        if (Math.ceil(scroll_height) >= $(document).height()) {
            page++;
            load_articles(page);
        }
    });

    function load_articles(page) {

        let query_string = '';

        if (window.location.href.indexOf('?') > -1){
            query_string = window.location.href.split('?')[1];
        }

        $.ajax({
            url: "?page=" + page + "&" + query_string,
            type: "GET",
            beforeSend: function () {
                console.log("?page=" + page + "&" + query_string);
                $(".ajax-load").show();
            },
        })
        .done(function (data) {
            if (data.html == "") {
                $(".ajax-load").children("img").hide();
                $(".ajax-load").children("small").text("No more records to show");
            } else {
                $(".ajax-load").hide();
                $("#article_data").append(data.html);
            }
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            alert("server not responding...");
        });
    }
    
});