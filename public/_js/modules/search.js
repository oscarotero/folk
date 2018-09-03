define([
	'jquery',
	'typeahead'
], function ($) {
	return {
		init: function ($element) {
			var $search = $element.find('input[type="search"]'),
				action = $element.attr('action');

			$search.typeahead({
				hint: true,
				highlight: false,
				minLength: 1
			},{
				name: 'search',
				source: function (query, callback) {
					$.ajax({
						url: action,
						data: $element.serialize(),
						dataType: 'json',
						success: function (response) {
							var items = [];

							for (var id in response) {
								items.push({
									value: '#' + id,
									label: response[id]
								});
							}

							callback(items);
						}
					});
				},
				templates: {
					suggestion: function (item) {
						return '<div>' + item.label + '</div>';
					}
				}
			})
			.on('typeahead:selected', function () {
				$element.submit();
			})
			.on('focus', function () {
				$element.addClass('is-focused');
			})
			.on('blur', function () {
				$element.removeClass('is-focused');
			});
		}
	};
});