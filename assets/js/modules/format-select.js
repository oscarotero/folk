define([
    'jquery',
    '../notifier',
    'module',
    'selectize'
], function ($, notifier, module) {
	var defaults = {};

	return {
		init: function ($element) {
			var config = $.extend({}, defaults, $element.data('config') || {});
			var settings = {};

			if (config.create && $element.data('related')) {
				settings.create = function (value, callback) {
					if (confirm(i18n.__('Creating "%s", are you sure?', value))) {
						$.post({
							url: module.config().createUrl + $element.data('related') + '/' + config.create,
							data: {
								'method-override': 'put',
								value: value,
							},
							dataType: 'json',
							success: function (response) {
								callback({
									value: response.id,
									text: response.label
								});
							},
							error: function (response) {
								if (response.status == 500) {
		                            notifier.error('Server error: ' + (response.responseText || response.statusText));
		                        } else {
		                            notifier.error('Error saving data');
		                        }
							}
						});
					}
				};
			}
			var $select = $element.selectize(settings);
		}
	};
});