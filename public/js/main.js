import inputRange from './modules/input-range.js';

function start(context = document) {
	context.querySelectorAll('.module-input-range').forEach(inputRange);
}

start();