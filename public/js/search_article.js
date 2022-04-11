$(document).ready(function() {

    $('#article_search').keypress(function(e) {
        let url = $(this).data('route');
        if(e.which == 13) {
            e.preventDefault();
            let keyword = $(this).val();
            url += '/' + keyword;
            window.location.href = url;
        }
    });
    
});