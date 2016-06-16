define([
	'jquery',
	'handsontable'
], function ($, handsontable) {
	var defaults = {
		stretchH: 'all',
		rowHeaders: true,
		colHeaders: true,
		contextMenu: true
	};

	var module = {
		init: function ($element) {
			var $container = $('<div></div>').insertAfter($element);
			var data = $element.hide().val().trim();

			var config = $.extend({}, defaults, $element.data('config') || {}, {
				data: data ? JSON.parse(data) : [
					['', ''],['', '']
				]
			});

			var editor = new handsontable($container[0], config);
			$element.data('handsontable', editor);

			$element.parents('form').on('submit.format-table', function (e) {
				var data = editor.getData();
				$element.val(JSON.stringify(data));
			});
		},
		destroy: function ($element) {
			$element.parents('form').off('.format-table');

			var editor = $element.data('handsontable');

			editor.destroy();

			$element.show();
			$element.next('.handsontable').remove();
		}
	};

	return module;
});