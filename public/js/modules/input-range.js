export default function init(container) {
	const input = container.querySelector('input[type="range"]');
	const output = container.querySelector('output');

	output.innerText = input.value;

	input.addEventListener('input', event => output.innerText = input.value);
}