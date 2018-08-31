<?php
$entity = $app->getEntity($entityName);
$title = p__('edit', '%s #%s | %s', $entity->title, $id, $app->title);

$this->layout('html', compact('title'));
$this->insert('nav', compact('entityName') + ['placeholder' => "#{$id}"]);
?>

<main>
	<?= $row->renderForm($entityName, $id) ?>
</main>
