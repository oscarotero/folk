<?php
$entity = $app->getEntity($entityName);

$this->layout('html', [
	'title' => p__('edit', '%s #%s | %s', $entity->title, $id, $app->title),
	'bodyClass' => 'layout_interior pageForm'
]);

$this->insert('nav', [
	'entityName' => $entityName,
	'placeholder' => "#{$id}"
]);
?>

<div class="pageForm-content layout-content">
	<?php if (($actions = $entity->getActions($id)) !== null): ?>
	<div class="footer-primary">
	<?php foreach ($actions as $action): ?>
		<?php $this->insert('action', $action) ?>
	<?php endforeach ?>
	</div>
	<?php endif ?>

	<?php
    echo $form
        ->data('module', 'submit')
        ->action($app->getRoute('update', ['entity' => $entityName, 'id' => $id]))
        ->openHtml();

    $form['data']->class('page-form-content');
    echo $form->html();
    ?>

	<div class="footer-primary is-floating">
		<button type="submit" class="button button-call"><?= p__('edit', 'Save') ?></button>
		<?php if ($app->getEntityId($entityName) === null): ?>
		<button type="submit" name="method-override" value="PUT" data-confirm="<?= p__('edit', 'You will save this data as a new row. Are you sure?') ?>" formaction="<?= $app->getRoute('create', ['entity' => $entityName]); ?>" class="button button-link"><?= p__('edit', 'Duplicate') ?></button>
		<button type="submit" name="method-override" value="DELETE" data-confirm="<?= p__('edit', 'This action cannot be undo. Are you sure?') ?>" formaction="<?= $app->getRoute('delete', ['entity' => $entityName, 'id' => $id]); ?>" class="button button-link"><?= p__('edit', 'Delete') ?></button>
		<?php endif ?>
	</div>
	<?= $form->closeHtml(); ?>
</div>

<progress class="progress"></progress>
