<?php
use Folk\FormFactory;

$entity = $app->getEntity($entityName);
$title = p__('edit', '%s #%s | %s', $entity->title, $id, $app->title);

$this->layout('html', compact('title'));
$this->insert('nav', compact('entityName') + ['placeholder' => "#{$id}"]);
?>

<main>
    <?php
    $form = FormFactory::update($row, $entityName, $id);
    $form->action = $app->getRoute('update', compact('entityName', 'id'));

    echo $form->getOpeningTag();
    echo $form['id'];
    echo $form['entityName'];
    echo $row->renderInput($form['data']);
    echo $form['method-override'];
    echo $form->getClosingTag();
    ?>
</main>
