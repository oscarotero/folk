export default function init(container) {
    const links = container.querySelectorAll(':scope > a');
	const containers = container.querySelectorAll(':scope > div');
    const linksContainer = document.createElement('nav');
    linksContainer.classList.add('tabs');
    container.prepend(linksContainer);
    links.forEach(el => linksContainer.append(el));

    links.forEach(el => {
        el.addEventListener('click', ev => {
            links.forEach(el => el.classList.remove('is-selected'));
            el.classList.add('is-selected');
            const id = el.getAttribute('href').replace('#', '');
            containers.forEach(el => el.hidden = (el.id !== id));
            ev.preventDefault();
        })
    });

    const event = document.createEvent('HTMLEvents');
    event.initEvent('click', true, false);
    links[0].dispatchEvent(event);
}