define([
    'jquery',
    'datetimepicker'
], function ($) {
    var defaults = {
        common: {
            lazyInit: true,
            lang: $('html').attr('lang') || 'en',
            scrollInput: false,
            scrollMonth: false,
            scrollTime: false
        },
        types: {
            datetime: {
                //format: "Y-m-d\\TH:i:sP"
                format: "Y-m-d H:i:sP"
            },
            "datetime-local": {
                //format: "Y-m-d\\TH:i:s"
                format: "Y-m-d H:i:s"
            },
            "time": {
                datepicker: false,
                format: 'H:i'
            },
            "date": {
                timepicker: false,
                format: 'Y-m-d'
            },
            "month": {
                timepicker: false,
                format: 'Y-m'
            },
            "week": {
                timepicker: false,
                format: 'Y-W'
            }
        }
    };

	return {
		init: function ($element) {
            var type = $element.attr('type');

            if (!window.Modernizr.inputtypes[type]) {
                var config = $.extend({}, defaults.common, defaults.types[type] || {}, $element.data('config') || {});
                $element.datetimepicker(config);
            }
		}
	};
});