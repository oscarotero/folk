<?php $selected = $selected ?? '' ?>

<ul class="menu-primary-options">
	<?php foreach ($app->getAllEntities() as list($entity, $id)): ?>
	<li>
		<?php
		if (isset($id)) {
			$url = $app->getRoute('read', ['entity' => $entity->getName(), 'id' => $id]);
		} else {
			$url = $app->getRoute('search', ['entity' => $entity->getName()]);
		}
		?>
		<a href="<?= $url ?>" class="button <?= ($selected === $entity->getName()) ? 'is-active' : '' ?>">
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
</ul>