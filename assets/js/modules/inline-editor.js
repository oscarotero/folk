define([
	'jquery',
	'../notifier',
	'../i18n'
], function ($, notifier, i18n) {
	return {
		init: function ($element) {
			$element.on('click', '.ui-editable', function () {
				var $this = $(this);
				var value = window.prompt(i18n.__('Edit this value'), $this.html());

				if (value !== null) {
					$.post({
						url: $this.data('src'),
						data: {
							value: value
						},
						success: function (response) {
							notifier.success(i18n.__('Data saved successfully'));
							$this.html(response);
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
			});
		}
	};
});