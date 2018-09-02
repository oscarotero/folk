define([
	'jquery',
	'notify'
], function ($) {

	$.notify.addStyle("folk", {
	    html: '<div>\n<span data-notify-text></span>\n</div>',
		classes: {
			error: {
			},
			success: {
			}
		}
	});

	$.notify.defaults({
		style: 'folk',
		position: 'top center'
	});

	return {
		error: function (message, callback) {
			$.notify(message, 'error');
		},
		success: function (message, callback) {
			$.notify(message, 'success');
		}
	}
});