require.config({
	paths: {
		"jquery": "vendor/jquery/jquery",
		"jquery-lazyscript": "vendor/jquery-lazyscript/jquery.lazyscript",
		"magnific-popup": "vendor/magnific-popup/jquery.magnific-popup",
		"sifter": "vendor/sifter/sifter",
		"microplugin": "vendor/microplugin/microplugin",
		"selectize": "vendor/selectize/selectize",
		"typeahead": "vendor/typeahead.js/typeahead.jquery",
		"ckeditor": "vendor/ckeditor/ckeditor",
		"handsontable": "vendor/handsontable/handsontable.full",
		"datetimepicker": "vendor/datetimepicker/jquery.datetimepicker.full",
		"jquery-mousewheel": "vendor/jquery-mousewheel/jquery.mousewheel",
		"notify": "vendor/notifyjs/notify"
	},
	shim: {
		'ckeditor': {
			exports: 'CKEDITOR'
		},
		'handsontable': {
			exports: 'Handsontable'
		}
	},
	packages: [{
		name: "codemirror",
		location: "vendor/codemirror",
		main: "lib/codemirror"
	}]
});

require([
	"jquery",
	"./loader",
], function ($, loader) {

	//Generic interactions
	var $body = $('body');

	$body.on('click', '[data-confirm]', function (e) {
		if (!confirm($(this).data('confirm'))) {
			e.preventDefault();
		}
	});

	$('#menu-btn').on('click', function (e) {
		e.preventDefault();

		var $svg = $(this).find('.ia-12');

		if ($body.hasClass('menu-is-opened')) {
			$body.removeClass('menu-is-opened');
		} else {
			$body.addClass('menu-is-opened');
		}
	});

	//Load modules on demand
	loader.init($('html'));
});