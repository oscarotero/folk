<nav role="navigation" class="menu-primary" id="main-menu">
	<ul class="menu-primary-options">
		<li>
			<a href="<?= $app->getRoute('index'); ?>" class="menu-primary-logo">
				<?= $this->icon('left'); ?>
				<?= $app->title ?>
				<small><?= $app->description ?></small>
			</a>
		</li>

		<?php foreach ($app->getAllEntities() as $e): ?>
		<li>
			<a href="<?= $app->getRoute('search', ['entity' => $e->getName()]) ?>" title="<?= $e->description ?>"<?= ($entity === $e) ? ' class="is-active"' : '' ?>>
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

	<form action="<?= $app->getRoute('search', ['entity' => $entity->getName()]) ?>" class="menu-secondary-search" data-module="search" method="get">
		<a href="<?= $app->getRoute('search', ['entity' => $entity->getName()]) ?>" title="<?= $entity->title ?>">
			<?= $entity->title ?>
		</a>

		<input id="search-entity" name="query" type="search" placeholder="<?= isset($placeholder) ? $placeholder : 'Buscar '.strtolower($entity->title).'...' ?>" value="<?= isset($search) ? $search->getQuery() : ''; ?>">
		<input type="hidden" name="page" value="1">
		<button type="submit">
			<?= $this->icon('search'); ?>
		</button>
	</form>

	<ul class="menu-secondary-options">
		<li>
			<a href="<?= $app->getRoute('insert', ['entity' => $entity->getName()]) ?>">
				<?= $this->icon('plus'); ?>
			</a>
		</li>
	</ul>
</nav>
