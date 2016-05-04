define([
	'jquery',
	'require',
	'ckeditor'
], function ($, require, ckeditor) {
	var defaults = {
		entities: false,
		entities_latin: false,
		toolbar: [
			['Bold', 'Italic', 'Strike', 'Subscript', 'Superscript', '-', 'Link', 'Unlink'],
			['NumberedList', 'BulletedList', '-', '-', 'Outdent', 'Indent', '-', 'Blockquote'],
			['Format'],
			['Source', 'Maximize']
		],
		format_tags: 'p;h1;h2;h3;h4;h5;h6;pre',
		uiColor: '#FFFFFF',
		height: 120,
		autoGrow_onStartup: true,
		//autoGrow_maxHeight: 600,
		autoGrow_minHeight: 120,
		contentsCss: require.toUrl('./../../css/modules/wysiwyg-content.css'),
		extraPlugins: 'autogrow',
		removePlugins: 'resize'
	};

	var module = {
		init: function ($element) {
			var config = $.extend({}, defaults, $element.data('config') || {});
			var instance = ckeditor.replace($element[0], config);
			$element.data('ckeditor', instance);
		},
		destroy: function ($element) {
			var editor = $element.data('ckeditor');
			$element.removeData('ckeditor');

			editor.updateElement();
			$(editor.container.$).remove();
			CKEDITOR.remove(editor);
		}
	};

	return module;
});