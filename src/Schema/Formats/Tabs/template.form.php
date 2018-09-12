<h3 class="editForm-head"><?= $this->getTitle() ?></h3>

<div class="editForm module-tabs">
    <?php
    foreach ($this->tabs as $name => $tab) {
        echo $tab->render('form');
    }
    ?>
</div>
