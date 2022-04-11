$(document).ready(function() {

    let csrf = $('meta[name="_token"]').attr('content');

    tinymce.init({
        selector: 'textarea',

        image_class_list: [
        {title: 'img-responsive', value: 'img-responsive'},
        ],
        height: 500,
        setup: function (editor) {
            editor.on('init change', function () {
                editor.save();
                $('textarea').prev().hide();
                $('textarea').removeClass('d-none');
            });
        },
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste imagetools"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image ",

        image_title: true,
        automatic_uploads: true,
        file_picker_types: 'image',
        branding: false,
        relative_urls: false,
        remove_script_host: false,
        images_upload_handler: function (blobInfo, success, failure) {
            var xhr, formData;
        
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', "/article/upload");
        
            xhr.onload = function() {
                var json;
            
                if (xhr.status != 200) {

                    json = JSON.parse(xhr.responseText);
                    if (!json || typeof json.error != 'string') {
                        failure('Invalid JSON: ' + xhr.responseText);
                        return;
                    }

                    failure('HTTP Error: ' + xhr.status + "<br>" + json.error);
                    return;
                }
            
                json = JSON.parse(xhr.responseText);
            
                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }
            
                success(json.location);
            };
        
            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            formData.append('_token', csrf);
        
            xhr.send(formData);
        },
    });
    
});