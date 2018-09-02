<article>
	<a href="<?= $app->getRoute('search', compact('entityName')) ?>">
		<h3><?= $entity->title; ?></h3>

		<?php if ($entity->description): ?>
		<p><?= $entity->description; ?></p>
		<?php endif ?>
	</a>
</article>
