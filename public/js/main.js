import inputRange from './modules/input-range.js';
import tabs from './modules/tabs.js';

function start(context = document) {
    context.querySelectorAll('.module-input-range').forEach(inputRange);
	context.querySelectorAll('.module-tabs').forEach(tabs);
}

start();