require.config({
	urlArgs: "bust=" +  (new Date()).getTime(), //evitar cache
	paths: {
		"delegato": "../bower_components/delegato/dist/delegato",
		"jquery": "../bower_components/jquery/dist/jquery",
		"jquery-lazyscript": "../bower_components/jquery-lazyscript/jquery.lazyscript",
		"magnific-popup": "../bower_components/magnific-popup/dist/jquery.magnific-popup",
		"sifter": "../bower_components/sifter/sifter",
		"microplugin": "../bower_components/microplugin/src/microplugin",
		"selectize": "../bower_components/selectize/dist/js/selectize",
		"typeahead": "../bower_components/typeahead.js/dist/typeahead.jquery",
		"ckeditor": "../bower_components/ckeditor/ckeditor",
		"handsontable": "../bower_components/handsontable/dist/handsontable"
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
		location: "../bower_components/codemirror",
		main: "lib/codemirror"
	}]
});

require([
	"jquery",
	"loader",
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