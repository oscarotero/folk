define([
    'gettext-translator',
    'json!./locales/gl.json'
], function (Translator, translations) {
	var i18n = new Translator(translations);

	return i18n;
});