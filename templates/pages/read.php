<?php
use Folk\FormFactory;

$entity = $app->getEntity($entityName);
$title = p__('edit', '%s #%s | %s', $entity->getTitle(), $id, $app->title);

$this->layout('html', compact('title'));
$this->insert('nav', compact('entityName') + ['placeholder' => "#{$id}"]);
?>

<main class="page-read">
    <?php
    $form = FormFactory::update($row, $entityName, $id);
    $form->action = $app->getRoute('update', compact('entityName', 'id'));

    echo $form->getOpeningTag();

    echo '<div class="editForm">';
    echo $form['id'];
    echo $form['entityName'];
    echo $row->renderInput($form['data']);
    echo '</div>';

    echo '<div class="editForm-footer">';
    echo $form['method-override'];
    echo '</div>';
    echo $form->getClosingTag();
    ?>
</main>
