define(['jquery', 'selectize'], function ($) {
	return {
		init: function ($element) {
			var $select = $element.find('select').empty();

			var url = $('html').data('baseurl') + $select.data('source');

			$select.selectize({
				valueField: 'value',
				labelField: 'label',
				searchField: 'search',
				highlight: false,
				load: function (query, callback) {
					$.ajax({
						url: url,
						type: 'GET',
						dataType: 'json',
						data: {
							query: query
						},
						error: function () {
							console.error('Error');
							callback();
						},
						success: function (response) {
							loadOnSuccess(response, callback);
						}
					});
				}
			});

			var selectize = $select[0].selectize;

			var $form = $($select[0].form);
			var query = $form.find('.field-data-entity').val() + ':' + $form.find('.field-data-id').val();

			selectize.load(function (callback) {
				$.ajax({
						url: url,
						type: 'GET',
						dataType: 'json',
						data: {
							query: query
						},
						error: function () {
							console.error('Error');
							callback();
						},
						success: function (response) {
							loadOnSuccess(response, callback);

							for (var id in response) {
								selectize.addItem(id, true);
							}
						}
					})
			});
		}
	};

	function loadOnSuccess (response, callback) {
		var result = [];

		for (var id in response) {
			result.push({
				value: id,
				label: response[id],
				search: response[id]
			});
		}

		callback(result);
	}
});