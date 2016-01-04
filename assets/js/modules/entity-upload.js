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
		},
		destroy: function ($element) {
			$element.find('.ui-edit').remove();
			$element.find('.ui-value').remove();
		}
	};
});