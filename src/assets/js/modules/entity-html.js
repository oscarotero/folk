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
			var $textarea = $element.find('textarea');
			var textarea = $element.find('textarea')[0];

			var instance = ckeditor.replace($textarea[0], config);
			$textarea.data('ckeditor', instance);
		},
		destroy: function ($element) {
			var $textarea = $element.find('textarea');
			var editor = $textarea.data('ckeditor');
			$textarea.removeData('ckeditor');

			editor.updateElement();
			$(editor.container.$).remove();
			CKEDITOR.remove(editor);
		}
	};

	return module;
});