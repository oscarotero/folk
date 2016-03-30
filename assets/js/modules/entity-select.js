define(['jquery', 'selectize'], function ($) {
	return {
		init: function ($element) {
			var $select = $element.find('select').selectize();
		}
	};
});