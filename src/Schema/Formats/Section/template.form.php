<h3 class="editForm-head"><?= $this->getTitle() ?></h3>

<div class="editForm">
    <?php
    foreach ($this->children as $name => $child) {
        echo $child->render('form');
    }
    ?>
</div>
