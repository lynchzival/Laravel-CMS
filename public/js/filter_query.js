$(document).ready(function() {
    $('form.filter').submit(function(e) {
        e.preventDefault();
        let req = $(this).serialize();
        let url = window.location.href.split('?')[0];
        window.location.href = url + '?' + req;
    });
});