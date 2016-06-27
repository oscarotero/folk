<?php $entity = $app->getEntity($entityName); ?>

<nav role="navigation" class="menu-primary" id="main-menu">
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

		<?php foreach ($app->getAllEntities() as $n => $e): ?>
		<li>
			<a href="<?= $app->getRoute('search', ['entity' => $n]) ?>" title="<?= $e->description ?>"<?= ($entityName === $n) ? ' class="is-active"' : '' ?>>
				<?= $this->icon($e->icon ?: 'file/folder_open') ?>
				<strong><?= $e->title ?></strong>
			</a>
		</li>
		<?php endforeach ?>
	</ul>
</nav>

<nav role="navigation" class="menu-secondary">
	<span class="menu-btn" id="menu-btn">
		<?= $this->icon('navigation/menu'); ?>
	</span>

	<form action="<?= $app->getRoute('search', ['entity' => $entityName]) ?>" class="menu-secondary-search" data-module="search" method="get" tabindex="-1">
		<a href="<?= $app->getRoute('search', ['entity' => $entityName]) ?>" title="<?= $entity->description ?>">
			<?= $entity->title ?>
		</a>

		<input id="search-entity" name="query" type="search" placeholder="<?= isset($placeholder) ? $placeholder : p__('search', 'Search %s...', strtolower($entity->title)) ?>" value="<?= isset($search) ? $search->getQuery() : ''; ?>">
		<input type="hidden" name="page" value="1">
		<button type="submit">
			<?= $this->icon('action/search'); ?>
		</button>
	</form>

	<ul class="menu-secondary-options">
		<li>
			<a href="<?= $app->getRoute('insert', ['entity' => $entityName]) ?>">
				<?= $this->icon('content/add'); ?>
			</a>
		</li>
	</ul>
</nav>
