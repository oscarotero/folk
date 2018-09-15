<?php
$id = 'tab-'.(++self::$index);
?>

<h3 class="editForm-head"><?= $this->getTitle() ?></h3>

<folk-tab class="editForm-container" role="region">
    <ul role="tablist" class="tabs-list">
    <?php foreach ($this->tabs as $index => $tab): ?>
        <li role="presentation">
            <a href="#<?= $id.$index ?>"
                role="tab"
                id="label-<?= $id.$index ?>"
                <?= $index === 0 ? 'aria-selected="true"' : '' ?>>
                <?= $tab->getTitle() ?>
            </a>
        </li>
    <?php endforeach ?>
    </ul>

    <?php foreach ($this->tabs as $index => $tab): ?>
    <section role="tabpanel" class="editForm-container tabs-content" id="<?= $id.$index ?>" aria-labelledby="label-<?= $id.$index ?>">
        <?= $tab->render('form') ?>
    </section>
    <?php endforeach ?>
</folk-tab>
