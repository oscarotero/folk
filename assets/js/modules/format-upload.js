define([
    '../i18n'
], function (i18n) {
    var baseUrl = $('html').data('baseurl');
    var defaults = {
        url: null
    };

    return {
        init: function ($element) {
            var config = $.extend({}, defaults, $element.data('config') || {});
            var $file = $element.find('input[type="file"]');
            var $hidden = $element.find('input[type="hidden"]');
            var $extra = $('<p>').insertAfter($file);

            var $editLink = $('<span class="button button-normal ui-edit">' + i18n.__('Insert value as text') + '</span>')
                .appendTo($extra)
                .click(function () {
                    var value = window.prompt(i18n.__('New value (empty to remove)'), $hidden.val());
                    
                    if (value !== null) {
                        $hidden.val(value);

                        updateUI(config);
                    }
                });

            updateUI(config);

            if ($element.data('max-size')) {
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

            function updateUI (config) {
                var value = $hidden.val();

                if (config.thumb && value) {
                    var src = baseUrl + '?thumb=' + encodeURIComponent(config.thumb + value);

                    $editLink.html('<img src="' + src + '">');
                } else if (value) {
                    $editLink.html('<small>' + value + '</small>');
                } else {
                    $editLink.html(i18n.__('Edit as text'));
                }
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
        destroy: function ($element) {
            $element.find('.ui-edit').remove();
            $element.find('.ui-value').remove();
        }
    };
});