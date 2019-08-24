<?php $entity = $app->getEntity($entityName); ?>

<?php $this->layout('html', ['title' => p__('edit', '%s #%s | %s', $entity->title, $id, $app->title)]); ?>

<?php $this->insert('nav', ['entityName' => $entityName, 'placeholder' => "#{$id}"]); ?>

<div class="page page-form">
	<div class="page-content">

		<?php if (($actions = $entity->getActions($id)) !== null): ?>
		<div class="footer-primary">
		<?php foreach ($actions as $action): ?>
			<?php $this->insert('action', $action); ?>
		<?php endforeach; ?>
		</div>
		<?php endif; ?>

		<?php
        echo $form
            ->data('module', 'submit')
            ->action($app->getRoute('update', ['entity' => $entityName, 'id' => $id]))
            ->openHtml();

        $form['data']->addClass('page-form-content');
        echo $form->html();
        ?>

		<div class="footer-primary is-floating">
			<button type="submit" class="button button-call"><?php echo p__('edit', 'Save'); ?></button>
			<?php if ($app->getEntityId($entityName) === null): ?>
			<button type="submit" name="method-override" value="PUT" data-confirm="<?php echo p__('edit', 'You will save this data as a new row. Are you sure?'); ?>" formaction="<?php echo $app->getRoute('create', ['entity' => $entityName]); ?>" class="button button-link"><?php echo p__('edit', 'Duplicate'); ?></button>
			<button type="submit" name="method-override" value="DELETE" data-confirm="<?php echo p__('edit', 'This action cannot be undo. Are you sure?'); ?>" formaction="<?php echo $app->getRoute('delete', ['entity' => $entityName, 'id' => $id]); ?>" class="button button-link"><?php echo p__('edit', 'Delete'); ?></button>
			<?php endif; ?>
		</div>
		<?php echo $form->closeHtml(); ?>

    </div>
</div>

<progress class="progress"></progress>
