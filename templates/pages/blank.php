<?php
use Folk\FormFactory;

$entity = $app->getEntity($entityName);
$title = p__('insert', '%s - New | %s', $entity->getTitle(), $app->title);

$this->layout('html', compact('title'));
$this->insert('nav', compact('entityName'));
?>

<main>
	<?php
    $row = $row ?? $entity->getScheme();
    $form = FormFactory::insert($row, $entityName);
    $form->action = $app->getRoute('create', compact('entityName'));

    echo $form->getOpeningTag();
    echo $form['entityName'];
    echo $form['method-override'];
    echo $row->renderInput($form['data']);
    echo $form[''];
    echo $form->getClosingTag();
    ?>
</main>
