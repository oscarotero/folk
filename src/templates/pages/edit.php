<?php $this->layout('html'); ?>

<?php $this->insert('nav', ['entity' => $entity, 'placeholder' => "#{$id}"]) ?>

<div class="page page-form">
	<div class="page-content">
		<?php if ($actions): ?>
		<div class="page-form-actions">
			<div class="button-toolbar">
				<?php foreach ($actions as $action): ?>
				<form method="post" target="_blank" action="<?= $app->getRouteUrl('action', ['entity' => $entity->name, 'id' => $id]) ?>">
					<input type="hidden" name="id" value="<?= $id ?>">
					<input type="submit" class="button" name="action" value="<?= $action ?>">
				</form>
				<?php endforeach; ?>
			</div>
		</div>
		<?php endif; ?>

		<?php
        echo $form->openHtml();

        $form['data']->addClass('page-form-content');
        echo $form->html();
        ?>

		<div class="footer-primary is-floating">
			<button type="submit" class="button button-call">Save</button>
			<button type="submit" data-confirm="You will save this data as a new row. Are you sure?" formaction="<?= $app->getRouteUrl('create', ['entity' => $entity->name]); ?>" class="button button-link">Duplicate</button>
			<button type="submit" data-confirm="This action cannot be undo. Are you sure?" formaction="<?= $app->getRouteUrl('delete', ['entity' => $entity->name, 'id' => $id]); ?>" class="button button-link">Delete</button>
		</div>
		<?= $form->closeHtml(); ?>
	</div>
</div>
