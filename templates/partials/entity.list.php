<article>
	<a href="<?= $app->getRoute('search', compact('entityName')) ?>">
		<h3><?= $entity->getTitle(); ?></h3>

		<?php if ($entity->getDescription()): ?>
		<p><?= $entity->getDescription(); ?></p>
		<?php endif ?>
	</a>
</article>
