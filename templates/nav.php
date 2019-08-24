<?php $entity = $app->getEntity($entityName); ?>

<nav role="navigation" class="menu-primary" id="main-menu">
	<ul class="menu-primary-options">
		<li>
			<a href="<?php echo $app->getRoute('index'); ?>" class="menu-primary-logo">
				<div>
					<?php echo $this->icon('chevron-left'); ?>
					<?php echo $app->title; ?>
					<small><?php echo $app->description; ?></small>
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
			<a href="<?php echo $url; ?>" title="<?php echo $e->description; ?>"<?php echo ($entityName === $e->getName()) ? ' class="is-active"' : ''; ?>>
				<?php echo $this->icon($e->icon ?: 'folder-open'); ?>
				<strong><?php echo $e->title; ?></strong>
			</a>
		</li>
		<?php endforeach; ?>
	</ul>
</nav>

<nav role="navigation" class="menu-secondary">
	<span class="menu-btn" id="menu-btn">
		<?php echo $this->icon('menu'); ?>
	</span>

	<form action="<?php echo $app->getRoute('search', ['entity' => $entityName]); ?>" class="menu-secondary-search" data-module="search" method="get" tabindex="-1">
		<?php
        if ($app->getEntityId($entityName) === null) {
            $url = $app->getRoute('search', ['entity' => $entityName]);
        } else {
            $url = $app->getRoute('read', ['entity' => $entityName, 'id' => $id]);
        }
        ?>

		<a href="<?php echo $url; ?>" title="<?php echo $entity->description; ?>">
			<?php echo $entity->title; ?>
		</a>

		<input id="search-entity" name="query" type="search" placeholder="<?php echo $placeholder ?? p__('search', 'Search %s...', strtolower($entity->title)); ?>" value="<?php echo isset($search) ? $search->buildQuery() : ''; ?>">
		<input type="hidden" name="page" value="1">
		<button type="submit">
			<?php echo $this->icon('magnify'); ?>
		</button>
	</form>

	<ul class="menu-secondary-options">
		<li>
			<a href="<?php echo $app->getRoute('insert', ['entity' => $entityName]); ?>">
				<?php echo $this->icon('plus'); ?>
			</a>
		</li>
	</ul>
</nav>
