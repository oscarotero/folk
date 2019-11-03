define([
    'jquery',
    'magnific-popup'
], function ($) {
    var baseUrl = $('html').data('baseurl');
    var defaults = {};
    var previews = {
        mp3: function (src) {
            return '<audio src="' + src + '" controls></audio>';
        },
        mp4: function (src) {
            return '<video src="' + src + '" controls></video>';
        }
    };

    var module = {
        init: function ($element) {
            var config = $.extend({}, defaults, $element.data('config') || {});

            module.checkSize($element);
            module.createUI($element, updateUI);

            var $hidden = $element.find('input[type="hidden"]');
            var $editLink = $element.find('.ui-edit');
            var $preview = $element.find('.ui-preview');

            function updateUI () {
                var value = $hidden.val();
                var ext = value.toLowerCase().split('.').pop();

                if (config.directory && previews[ext]) {
                    var src = baseUrl + '?file=' + encodeURIComponent(config.directory + value);
                    $preview.html(previews[ext](src));
                } else {
                    $preview.empty();
                }

                if (value) {
                    $editLink.html(value);
                } else {
                    $editLink.html(i18n.__('Edit as text'));
                }
            }

            updateUI();
        },
        checkSize: function ($element) {
            if ($element.data('max-size')) {
                var $file = $element.find('input[type="file"]');

                $file.on('change', function () {
                    var max = $element.data('max-size');

                    if (this.files) {
                        $.each(this.files, function (index, file) {
                            if (file.size > max) {
                                alert(i18n.__('Too big file: %s (%s max allowed)', formatBytes(file.size), formatBytes(max)));
                                $file.get(0).value = null;
                            }
                        });
                    }
                });
            }

            function formatBytes (bytes) {
                if (bytes == 0) {
                    return '0 Byte';
                }

                var k = 1000;
                var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
                var i = Math.floor(Math.log(bytes) / Math.log(k));

                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }
        },
        createUI: function ($element, onUpdate) {
            var $file = $element.find('input[type="file"]');
            var $hidden = $element.find('input[type="hidden"]');
            var $extra = $('<div class="ui-extra"></div>').insertAfter($file);

            $('<figure class="media ui-preview"></figure>').appendTo($extra);

            $('<span class="button button-normal ui-edit">' + i18n.__('Insert value as text') + '</span>')
                .appendTo($extra)
                .click(function () {
                    var value = window.prompt(i18n.__('New value (empty to remove)'), $hidden.val());
                    
                    if (value !== null) {
                        $hidden.val(value);

                        onUpdate();
                    }
                });
        },
        destroy: function ($element) {
            $element.find('.ui-extra').remove();
        }
    };

    return module;
});