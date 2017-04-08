<?php $entity = $app->getEntity($entityName); ?>

<nav role="navigation" class="menu-primary layout-menu" id="main-menu">
	<ul class="menu-primary-options">
		<li>
			<a href="<?= $app->getRoute('index'); ?>" class="menu-primary-logo">
				<div>
					<?= $this->icon('navigation/chevron_left'); ?>
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
			<a href="<?= $url ?>" title="<?= $e->description ?>" class="button <?= ($entityName === $e->getName()) ? 'is-active' : '' ?>">
				<?= $this->icon($e->icon ?: 'file/folder_open') ?>
				<strong><?= $e->title ?></strong>
			</a>
		</li>
		<?php endforeach ?>
	</ul>
</nav>

<nav role="navigation" class="menu-secondary layout-actions">
	<span class="button menu-btn" id="menu-btn">
		<?= $this->icon('navigation/menu'); ?>
	</span>

	<form action="<?= $app->getRoute('search', ['entity' => $entityName]) ?>" class="menu-secondary-search" data-module="search" method="get" tabindex="-1">
		<?php 
		if ($app->getEntityId($entityName) === null) {
			$url = $app->getRoute('search', ['entity' => $entityName]);
		} else {
			$url = $app->getRoute('read', ['entity' => $entityName, 'id' => $id]);
		}
		?>

		<label for="search-entity">
			<a href="<?= $url ?>" title="<?= $entity->description ?>">
				<?= $entity->title ?>
			</a>
		</label>

		<input id="search-entity" name="query" type="search" placeholder="<?= $placeholder ?? p__('search', 'Search %s...', strtolower($entity->title)) ?>" value="<?= isset($search) ? $search->buildQuery() : ''; ?>">
		<input type="hidden" name="page" value="1">
		<button type="submit" class="button">
			<?= $this->icon('action/search'); ?>
		</button>
	</form>

	<ul class="menu-secondary-options">
		<li>
			<a href="<?= $app->getRoute('insert', ['entity' => $entityName]) ?>" class="button">
				<?= $this->icon('content/add'); ?>
			</a>
		</li>
	</ul>
</nav>
