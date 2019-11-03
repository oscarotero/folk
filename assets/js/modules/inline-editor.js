define([
	'jquery',
	'../notifier'
], function ($, notifier) {
	return {
		init: function ($element) {
			$element.on('click', '.ui-editable', function () {
				var $this = $(this);
				var value = window.prompt(i18n.__('Edit this value'), $this.data('value'));

				if (value !== null) {
					$.post({
						url: $this.data('src'),
						data: {
							value: value
						},
						dataType: 'json',
						success: function (response) {
							notifier.success(i18n.__('Data saved successfully'));
							$this.html(response.htmlValue);
							$this.data('value', (response.value === null) ? '' : response.value);
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