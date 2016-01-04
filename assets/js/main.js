require.config({
	//urlArgs: "bust=" +  (new Date()).getTime(), //avoid cache
	paths: {
		"delegato": "../vendor/delegato/dist/delegato",
		"jquery": "../vendor/jquery/dist/jquery",
		"jquery-lazyscript": "../vendor/jquery-lazyscript/jquery.lazyscript",
		"magnific-popup": "../vendor/magnific-popup/dist/jquery.magnific-popup",
		"sifter": "../vendor/sifter/sifter",
		"microplugin": "../vendor/microplugin/src/microplugin",
		"selectize": "../vendor/selectize/dist/js/selectize",
		"typeahead": "../vendor/typeahead.js/dist/typeahead.jquery",
		"ckeditor": "../vendor/ckeditor/ckeditor",
		"handsontable": "../vendor/handsontable/dist/handsontable"
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
		location: "../vendor/codemirror",
		main: "lib/codemirror"
	}]
});

require([
	"jquery",
	"./loader",
	"delegato",
], function ($, loader) {

	//Generic interactions
	var $body = $('body');

	$body.delegato({
		includeJquery: true
	});

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
			$svg.attr('class', 'ia-12 ia-menu');
		} else {
			$body.addClass('menu-is-opened');
			$svg.attr('class', 'ia-12 ia-cross');
		}
	});

	//Load modules on demand
	loader.init($('html'));
});