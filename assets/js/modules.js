import Translator from './vendor/gettext-translator/translator.js';

const lang = document.documentElement.getAttribute('lang') || 'en';
const url = new URL(`./locales/${lang}.json`, import.meta.url);

fetch(url)
    .then(res => res.json())
    .then(json => window.i18n = new Translator(json))
