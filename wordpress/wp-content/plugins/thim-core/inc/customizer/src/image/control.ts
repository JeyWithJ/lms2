
function ImageControl(control) {
    let value, saveAs, preview, previewImage, removeButton, defaultButton;

    control = control || this;

    value = control.setting._value;

    saveAs = (!_.isUndefined(control.params.choices) && !_.isUndefined(control.params.choices.save_as)) ? control.params.choices.save_as : 'url';

    preview = control.container.find('.placeholder, .thumbnail');

    previewImage = ('array' === saveAs) ? value.url : value;

    removeButton = control.container.find('.image-upload-remove-button');

    defaultButton = control.container.find('.image-default-button');

    value = ('array' === saveAs && _.isString(value)) ? { url: value } : value;

    if (('id' === saveAs || 'ID' === saveAs) && '' !== value) {
        wp.media.attachment(value).fetch().then(function () {
            setTimeout(function () {
                var url = wp.media.attachment(value).get('url');
                preview.removeClass().addClass('thumbnail thumbnail-image').html('<img src="' + url + '" alt="" />');
            }, 700);
        });
    }

    if (('url' === saveAs && '' !== value) || ('array' === saveAs && !_.isUndefined(value.url) && '' !== value.url)) {
        control.container.find('image-default-button').hide();
    }

    if (('url' === saveAs && '' === value) || ('array' === saveAs && (_.isUndefined(value.url) || '' === value.url))) {
        removeButton.hide();
    }

    if (value === control.params.default) {
        control.container.find('image-default-button').hide();
    }

    if ('' !== previewImage) {
        preview.removeClass().addClass('thumbnail thumbnail-image').html('<img src="' + previewImage + '" alt="" />');
    }

    control.container.on('click', '.image-upload-button', function (e) {
        var image = wp.media({ multiple: false }).open().on('select', function () {
            var uploadedImage = image.state().get('selection').first(),
                jsonImg = uploadedImage.toJSON();

            previewImage = jsonImg.url;

            if (!_.isUndefined(jsonImg.sizes)) {
                previewImage = jsonImg.sizes.full.url;
                if (!_.isUndefined(jsonImg.sizes.medium)) {
                    previewImage = jsonImg.sizes.medium.url;
                } else if (!_.isUndefined(jsonImg.sizes.thumbnail)) {
                    previewImage = jsonImg.sizes.thumbnail.url;
                }
            }

            if ('array' === saveAs) {
                control.setting.set({
                    id: jsonImg.id,
                    url: !_.isUndefined(jsonImg.sizes)
                        ? jsonImg.sizes.full.url
                        : jsonImg.url,
                    width: jsonImg.width,
                    height: jsonImg.height,
                });
            } else if ('id' === saveAs) {
                control.setting.set(jsonImg.id);
            } else {
                control.setting.set((!_.isUndefined(jsonImg.sizes)) ? jsonImg.sizes.full.url : jsonImg.url);
            }

            if (preview.length) {
                preview.removeClass().addClass('thumbnail thumbnail-image').html('<img src="' + previewImage + '" alt="" />');
            }
            if (removeButton.length) {
                removeButton.show();
                defaultButton.hide();
            }
        });

        e.preventDefault();
    });

    control.container.on('click', '.image-upload-remove-button', function (e) {
        e.preventDefault();

        control.setting.set('');

        preview = control.container.find('.placeholder, .thumbnail');
        removeButton = control.container.find('.image-upload-remove-button');
        defaultButton = control.container.find('.image-default-button');

        if (preview.length) {
            preview.removeClass().addClass('placeholder').html('No image selected');
        }
        if (removeButton.length) {
            removeButton.hide();
            if (jQuery(defaultButton).hasClass('button')) {
                defaultButton.show();
            }
        }
    });

    control.container.on('click', '.image-default-button', function (e) {
        e.preventDefault();

        control.setting.set(control.params.default);

        preview = control.container.find('.placeholder, .thumbnail');
        removeButton = control.container.find('.image-upload-remove-button');
        defaultButton = control.container.find('.image-default-button');

        if (preview.length) {
            preview.removeClass().addClass('thumbnail thumbnail-image').html('<img src="' + control.params.default + '" alt="" />');
        }
        if (removeButton.length) {
            removeButton.show();
            defaultButton.hide();
        }
    });
}

export default ImageControl;