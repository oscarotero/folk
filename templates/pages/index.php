<?php $this->layout('html', ['title' => p__('home', '%s | %s', $app->title, $app->description)]); ?>

<div class="page page-home">
	<header class="page-header">
		<h1><?= $app->title ?></h1>

		<?php if ($app->has('url')): ?>

		<?php
			$url = urlencode($app->get('url'));
			$bookmarklet = <<<BOOKMARKLET
(function () {
	if (document.location.href.indexOf('{$app->get('url')}') !== 0 || document.location.href.indexOf('{$app->getUri()}') === 0) {
		alert('This bookmarklet is only valid for \'{$url}\'');
	}

	var buttons = document.querySelectorAll('.folk-button');

	if (buttons.length) {
		Array.prototype.forEach.call(buttons, function (element) {
			element.parentNode.removeChild(element);
		});

		return;
	}

	Array.prototype.forEach.call(document.querySelectorAll('[data-folk]'), function (element) {
		var parts = element.dataset.folk.split(',');
		var link = document.createElement('a');

		if (parts.length === 1) {
			link.innerHTML = 'List ' + parts[0];
			link.setAttribute('href', '{$app->getUri()}/' + parts[0]);
		} else {
			link.innerHTML = 'Edit ' + parts[0] + ' #' + parts[1];
			link.setAttribute('href', '{$app->getUri()}/' + parts[0] + '/' + parts[1]);
		}

		link.setAttribute('class', 'folk-button');
		link.setAttribute('target', '_blank');
		link.setAttribute('style', [
				'text-decoration: none',
				'position: absolute',
				'font-size: 16px',
				'padding: 10px',
				'border: solid 1px black',
				'background: white',
				'z-index: 999999',
				'color: black',
				'box-shadow: 0 0 5px rgba(0,0,0,0.3)',
			].join(';'));

		element.insertBefore(link, element.firstChild);
	});
})();
BOOKMARKLET;

        $bookmarklet = preg_replace('/\s+/m', ' ', $bookmarklet);
        $bookmarklet = preg_replace('/\s*([\(\)=\{\};||])\s*/m', '\\1', $bookmarklet);
        ?>

			<p>
				<?= $app->description ?>
				| <a href="<?= $app->get('url') ?>" target="_blank"><?= p__('home', 'View web') ?></a>
			</p>
			<p>
				<a class="button button-bookmarklet" href="javascript:<?= $bookmarklet ?>"><?= p__('home', 'Bookmarklet') ?></a>
			</p>

		<?php else: ?>
			<p>
				<?= $app->description ?>
			</p>
		<?php endif ?>
	</header>

	<div class="page-content">
		<ul class="page-home-list menu-primary-options">
			<?php foreach ($app->getAllEntities() as $name => $entity): ?>
			<li>
				<a href="<?= $app->getRoute('search', ['entity' => $name]) ?>">
					<?= $this->icon($entity->icon ?: 'file/folder_open') ?>

					<div>
						<h2><?= $entity->title; ?></h2>

						<?php if ($entity->description): ?>
			    		<p><?= $entity->description; ?></p>
						<?php endif ?>
					</div>
				</a>
			</li>
			<?php endforeach ?>
		</nav>
	</div>
</div>
