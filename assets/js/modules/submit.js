define([
    'jquery'
], function ($) {
    return {
        init: function ($form) {
            var enabled = true;
            var $progress = $form.next('.progress');

            $form.on('click', 'button[name="method-override"]', function () {
                enabled = false;
            });

            $form.on('submit', function (e) {
                if (!enabled) {
                    return;
                }

                e.preventDefault();

                setTimeout(function () {
                    var data = new FormData($form[0]);

                    $.ajax({
                        url: $form.attr('action'),
                        type: $form.attr('method'),
                        processData: false,
                        contentType: false,
                        data: data,
                        success: function () {
                            alert('Ok!');
                            $progress.hide();
                        },
                        xhr: function () {
                            var myXhr = $.ajaxSettings.xhr();
                            var progress = $progress.show().get(0);

                            if (myXhr.upload && progress) {
                                myXhr.upload.addEventListener('progress', function (e) {
                                    if (e.lengthComputable) {
                                        progress.max = e.total;
                                        progress.value = e.loaded;
                                        console.log(e.loaded);
                                    }
                                }, false);
                            }

                            return myXhr;
                        }
                    });
                });
            });
        }
    };
});