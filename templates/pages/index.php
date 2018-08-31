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
			<?php foreach ($app->getAllEntities() as list($entity, $id)): ?>
			<li>
				<?php if (isset($id)): ?>
				<a href="<?= $app->getRoute('read', ['entity' => $entity->getName(), 'id' => $id]) ?>">
				<?php else: ?>
				<a href="<?= $app->getRoute('search', ['entity' => $entity->getName()]) ?>">
				<?php endif ?>
					<h3><?= $entity->title; ?></h3>

					<?php if ($entity->description): ?>
		    		<p><?= $entity->description; ?></p>
					<?php endif ?>
				</a>
			</li>
			<?php endforeach ?>
		</ul>
	</main>
</div>
