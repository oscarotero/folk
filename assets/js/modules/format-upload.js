define([], function () {
    var defaults = {
        url: null
    };

    return {
        init: function ($element) {
            var config = $.extend({}, defaults, $element.data('config') || {});
            var $file = $element.find('input[type="file"]');
            var $hidden = $element.find('input[type="hidden"]');
            var $extra = $('<p>');
            
            updateUI();

            if ($element.data('max-size')) {
                $file.on('change', function () {
                    var max = $element.data('max-size');

                    if (this.files) {
                        $.each(this.files, function (index, file) {
                            if (file.size > max) {
                                alert('Too big file: ' + formatBytes(file.size) + ' (' + formatBytes(max) + ' max allowed)');
                            }
                        });
                    }
                });
            }

            $('<a class="button button-link ui-edit">Edit as text</a>')
                .appendTo($extra)
                .click(function () {
                    var value = window.prompt('New value (empty to remove)', $hidden.val());
                    
                    if (value !== null) {
                        $hidden.val(value);

                        updateUI();
                    }
                })

            $extra.insertAfter($file);

            function updateUI (value) {
                var value = $hidden.val();

                $extra.find('.ui-value').remove();

                if (config.url && value) {
                    var path = value.split('/');
                    var filename = path.pop();

                    var url = config.url
                        .replace('{path}', path.join('/'))
                        .replace('{filename}', filename);

                    $extra.prepend('<a class="button button-link ui-view ui-value" href="' + url + '">' + value + '</a>');
                } else {
                    $extra.prepend('<small class="ui-value">' + value + '</small>');
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