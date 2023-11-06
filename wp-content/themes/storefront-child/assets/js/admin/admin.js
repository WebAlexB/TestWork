jQuery(function ($) {
    let customUploader;
    $('.upload-image-button').on('click', function (e) {
        e.preventDefault();
        if (customUploader) {
            customUploader.open();
            return;
        }
        customUploader = wp.media.frames.file_frame = wp.media({
            title: 'Выберите изображение',
            button: {
                text: 'Выбрать изображение'
            },
            multiple: false
        });
        customUploader.on('select', function () {
            let attachment = customUploader.state().get('selection').first().toJSON();
            $('#product_custom_image').val(attachment.url);
            $('#product_custom_image_preview').attr('src', attachment.url);
        });
        customUploader.open();
    });

    $('.remove-image-button').on('click', function (e) {
        e.preventDefault();
        $('#product_custom_image').val('');
        $('#product_custom_image_preview').attr('src', '');
    });
    $('.clear-all-fields-button').on('click', function (e) {
        e.preventDefault();
        $('#product_custom_image').val('');
        $('#product_custom_image_preview').attr('src', '');
        $('#product_custom_date').val('');
        $('#product_custom_type').val('');
    });
});