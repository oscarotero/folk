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
			var $container = $('<div></div>').appendTo($element.children('div'));
			var data = $element.find('textarea').hide().val().trim();

			var config = $.extend({}, defaults, $element.data('config') || {}, {
				data: data ? JSON.parse(data) : [
					['', ''],['', '']
				]
			});

			var editor = new handsontable($container[0], config);
			$element.data('handsontable', editor);

			$element.parents('form').on('submit.entity-table', function (e) {
				var data = editor.getData();
				$element.find('textarea').val(JSON.stringify(data));
			});
		},
		destroy: function ($element) {
			$element.parents('form').off('.entity-table');

			var editor = $element.data('handsontable');

			editor.destroy();

			$element.find('textarea').show();
			$element.find('.handsontable').remove();
		}
	};

	return module;
});