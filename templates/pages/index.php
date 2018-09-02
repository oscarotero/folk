<?php
$title = p__('home', '%s | %s', $app->title, $app->description);

$this->layout('html', compact('title'));
?>

<div>
	<header class="page-header">
		<h1><?= $app->title ?></h1>
		<p><?= $app->description ?></p>
	</header>

	<?php if ($app->has('url')): ?>
	<nav>
		<a href="<?= $app->get('url') ?>" target="_blank"><?= p__('home', 'View web') ?></a>
	</nav>
	<?php endif ?>

	<main>
		<ul>
			<?php foreach ($app->getAllEntities() as $entityName => $entity): ?>
			<li>
				<?php $this->insert('partials/entity.list', compact('entityName', 'entity')) ?>
			</li>
			<?php endforeach ?>
		</ul>
	</main>
</div>
