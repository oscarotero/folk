<?php $entity = $app->getEntity($entityName); ?>

<nav>
    <ul>
        <li>
            <a href="<?= $app->getRoute('index'); ?>">
                <strong><?= $app->title ?></strong>
                <?= $app->description ?>
            </a>
        </li>

        <?php foreach ($app->getAllEntities() as list($e, $id)): ?>
        <li>
            <?php 
            if ($id === null) {
                $url = $app->getRoute('search', ['entityName' => $e->getName()]);
            } else {
                $url = $app->getRoute('read', ['entityName' => $e->getName(), 'id' => $id]);
            }
            ?>
            <a href="<?= $url ?>" title="<?= $e->description ?>">
                <strong><?= $e->title ?></strong>
            </a>
        </li>
        <?php endforeach ?>
    </ul>
</nav>

<form action="<?= $app->getRoute('search', ['entity' => $entityName]) ?>">
    <?php 
    if ($app->getEntityId($entityName) === null) {
        $url = $app->getRoute('search', compact('entityName'));
    } else {
        $url = $app->getRoute('read', compact('entityName', 'id'));
    }
    ?>

    <a href="<?= $url ?>" title="<?= $entity->description ?>">
        <?= $entity->title ?>
    </a>

    <input name="query" type="search" placeholder="<?= $placeholder ?? p__('search', 'Search %s...', strtolower($entity->title)) ?>" value="<?= isset($search) ? $search->buildQuery() : ''; ?>">
    <input type="hidden" name="page" value="1">
    <button type="submit">Search</button>
</form>
