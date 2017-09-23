<?php $entity = $app->getEntity($entityName); ?>

<nav role="navigation" class="menu-primary" id="main-menu">
	<ul class="menu-primary-options">
		<li>
			<a href="<?= $app->getRoute('index'); ?>" class="menu-primary-logo">
				<div>
					<?= $this->icon('chevron-left'); ?>
					<?= $app->title ?>
					<small><?= $app->description ?></small>
				</div>
			</a>
		</li>

		<?php foreach ($app->getAllEntities() as list($e, $id)): ?>
		<li>
			<?php 
			if ($id === null) {
				$url = $app->getRoute('search', ['entity' => $e->getName()]);
			} else {
				$url = $app->getRoute('read', ['entity' => $e->getName(), 'id' => $id]);
			}
			?>
			<a href="<?= $url ?>" title="<?= $e->description ?>"<?= ($entityName === $e->getName()) ? ' class="is-active"' : '' ?>>
				<?= $this->icon($e->icon ?: 'folder-open') ?>
				<strong><?= $e->title ?></strong>
			</a>
		</li>
		<?php endforeach ?>
	</ul>
</nav>

<nav role="navigation" class="menu-secondary">
	<span class="menu-btn" id="menu-btn">
		<?= $this->icon('menu'); ?>
	</span>

	<form action="<?= $app->getRoute('search', ['entity' => $entityName]) ?>" class="menu-secondary-search" data-module="search" method="get" tabindex="-1">
		<?php 
		if ($app->getEntityId($entityName) === null) {
			$url = $app->getRoute('search', ['entity' => $entityName]);
		} else {
			$url = $app->getRoute('read', ['entity' => $entityName, 'id' => $id]);
		}
		?>

		<a href="<?= $url ?>" title="<?= $entity->description ?>">
			<?= $entity->title ?>
		</a>

		<input id="search-entity" name="query" type="search" placeholder="<?= $placeholder ?? p__('search', 'Search %s...', strtolower($entity->title)) ?>" value="<?= isset($search) ? $search->buildQuery() : ''; ?>">
		<input type="hidden" name="page" value="1">
		<button type="submit">
			<?= $this->icon('magnify'); ?>
		</button>
	</form>

	<ul class="menu-secondary-options">
		<li>
			<a href="<?= $app->getRoute('insert', ['entity' => $entityName]) ?>">
				<?= $this->icon('plus'); ?>
			</a>
		</li>
	</ul>
</nav>
