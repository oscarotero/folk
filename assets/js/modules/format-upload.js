define([
    'jquery',
    '../i18n',
    'magnific-popup'
], function ($, i18n) {
    var baseUrl = $('html').data('baseurl');
    var defaults = {
        limit: 100
    };

    return {
        init: function ($element) {
            var config = $.extend({}, defaults, $element.data('config') || {});
            var $file = $element.find('input[type="file"]');
            var $hidden = $element.find('input[type="hidden"]');
            var $extra = $('<p class="ui-extra"></p>').insertAfter($file);

            var $editLink = $('<span class="button button-normal ui-edit">' + i18n.__('Insert value as text') + '</span>')
                .appendTo($extra)
                .click(function () {
                    var value = window.prompt(i18n.__('New value (empty to remove)'), $hidden.val());
                    
                    if (value !== null) {
                        $hidden.val(value);

                        updateUI(config);
                    }
                });

            if (config.thumb) {
                config.limit = parseInt(config.limit);

                var $history = $('<span class="button button-normal">' + i18n.__('Previously uploaded...', config.limit) + '</span>')
                    .appendTo($extra)
                    .click(function () {
                        $.getJSON(baseUrl, {
                            thumbs: config.thumb,
                            pattern: config.pattern,
                            limit: config.limit
                        }, function (files) {
                            $thumbs = $('<ul class="thumbs">' + htmlImages(config, files) + '</ul>');

                            $.magnificPopup.open({
                                type: 'inline',
                                mainClass: 'popup-thumbs',
                                closeOnBgClick: false,
                                items: {
                                    src: $('<div></div>').html($thumbs)
                                }
                            });

                            if ($thumbs.children().length === config.limit) {
                                $('<span class="button button-normal">' + i18n.__('Load %d more...', config.limit) + '</span>')
                                    .insertAfter($thumbs)
                                    .on('click', function (e) {
                                        var $this = $(this);

                                        $.getJSON(baseUrl, {
                                            thumbs: config.thumb,
                                            pattern: config.pattern,
                                            limit: config.limit,
                                            offset: $thumbs.children().length
                                        }, function (files) {
                                            $thumbs.append(htmlImages(config, files));

                                            if (files.length < config.limit) {
                                                $this.remove();
                                            }
                                        });
                                    });
                            }

                            $thumbs.on('click', 'img', function () {
                                $hidden.val($(this).attr('alt'));
                                updateUI(config);
                                $.magnificPopup.close();
                            });
                        });
                    });
            }

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

                    $editLink.html('<img src="' + src + '" alt="' + value + '">');
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

            function htmlImages (config, files) {
                return files
                    .map(function (file) {
                        var src = baseUrl + '?thumb=' + encodeURIComponent(config.thumb + file);

                        return '<li><img src="' + src + '" alt="' + file + '"></li>';
                    })
                    .join('');
            }
        },
        destroy: function ($element) {
            $element.find('.ui-extra').remove();
        }
    };
});