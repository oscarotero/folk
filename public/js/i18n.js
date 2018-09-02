var lang = document.documentElement.getAttribute('lang') || 'en';

define([
    'gettext-translator',
    'json!./locales/' + lang + '.json'
], function (Translator, translations) {
	var i18n = new Translator(translations);

	return i18n;
});