import inputRange from './modules/input-range.js';
import Tab from './vendor/@oom/tab/tab.js';

try {
	customElements.define('folk-tab', Tab);
} catch (err) {
	console.error(err.message);
}

function start(context = document) {
    context.querySelectorAll('.module-input-range').forEach(inputRange);
}

start();