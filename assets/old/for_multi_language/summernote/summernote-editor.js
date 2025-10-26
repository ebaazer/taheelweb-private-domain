jQuery(function () {
    jQuery('.htmleditor').summernote({
        height: 200,
        width: '100%', // set editor height
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: true, // set focus to editable area after initializing summernote
        dialogsInBody: false,
        
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'undo', 'redo']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['picture', 'link', 'video', 'table', 'hr', 'fullscreen', 'codeview']]
        ]
    });

    jQuery(document).on('click', '#close-summernote-dialog', function () {
        jQuery('.summernote-dialog').modal('hide');
    });

});
