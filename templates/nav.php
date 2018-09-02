<?php $entity = $app->getEntity($entityName); ?>

<nav>
    <ul>
        <li>
            <a href="<?= $app->getRoute('index'); ?>">
                <strong><?= $app->title ?></strong>
                <?= $app->description ?>
            </a>
        </li>

        <?php foreach ($app->getAllEntities() as $name => $ent): ?>
        <li>
            <a href="<?= $app->getRoute('search', ['entityName' => $name]) ?>" title="<?= $ent->getDescription() ?>">
                <strong><?= $ent->getTitle() ?></strong>
            </a>
        </li>
        <?php endforeach ?>
    </ul>
</nav>

<?php $url = $app->getRoute('search', compact('entityName')); ?>

<form action="<?= $url ?>">
    <a href="<?= $url ?>" title="<?= $entity->getDescription() ?>">
        <?= $entity->getTitle() ?>
    </a>

    <input name="query" type="search" placeholder="<?= $placeholder ?? p__('search', 'Search %s...', strtolower($entity->title)) ?>" value="<?= isset($search) ? $search->buildQuery() : ''; ?>">
    <input type="hidden" name="page" value="1">
    <button type="submit">Search</button>
</form>
