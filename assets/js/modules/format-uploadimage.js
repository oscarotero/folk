define([
    'jquery',
    '../i18n',
    './format-upload',
    'magnific-popup'
], function ($, i18n, formatUpload) {
    var baseUrl = $('html').data('baseurl');
    var defaults = {
        limit: 100
    };

    return {
        init: function ($element) {
            formatUpload.checkSize($element);
            formatUpload.createUI($element, updateUI);

            var config = $.extend({}, defaults, $element.data('config') || {});
            var $file = $element.find('input[type="file"]');
            var $hidden = $element.find('input[type="hidden"]');
            var $extra = $element.find('.ui-extra');
            var $editLink = $extra.find('.ui-edit');
            var $preview = $extra.find('.ui-preview');

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
                                updateUI();
                                $.magnificPopup.close();
                            });
                        });
                    });
            }

            function updateUI () {
                var value = $hidden.val();

                if (config.thumb && value) {
                    var src = baseUrl + '?thumb=' + encodeURIComponent(config.thumb + value);

                    $preview.html('<img src="' + src + '" alt="' + value + '">');
                } else {
                    $preview.empty();
                }

                if (value) {
                    $editLink.html('<small>' + value + '</small>');
                } else {
                    $editLink.html(i18n.__('Edit as text'));
                }
            }

            function htmlImages (config, files) {
                return files
                    .map(function (file) {
                        var src = baseUrl + '?thumb=' + encodeURIComponent(config.thumb + file);

                        return '<li><img src="' + src + '" alt="' + file + '"></li>';
                    })
                    .join('');
            }

            updateUI();
        },
        destroy: function ($element) {
            $element.find('.ui-extra').remove();
        }
    };
});