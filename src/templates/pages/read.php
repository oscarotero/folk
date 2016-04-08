<?php $this->layout('html', ['title' => $entity->title.' #'.$id." | {$app->title}"]); ?>

<?php $this->insert('nav', ['entity' => $entity, 'placeholder' => "#{$id}"]) ?>

<div class="page page-form">
	<div class="page-content">
		<?php
        echo $form->action($app->getRoute('update', ['entity' => $entity->getName(), 'id' => $id]))->openHtml();

        $form['data']->addClass('page-form-content');
        echo $form->html();
        ?>

        <input type="hidden" name="method-override" value="post">

		<div class="footer-primary is-floating">
			<button type="submit" data-method-override="post" class="button button-call">Save</button>
			<button type="submit" data-method-override="put" data-confirm="You will save this data as a new row. Are you sure?" formaction="<?= $app->getRoute('create', ['entity' => $entity->getName()]); ?>" class="button button-link">Duplicate</button>
			<button type="submit" data-method-override="delete" data-confirm="This action cannot be undo. Are you sure?" formaction="<?= $app->getRoute('delete', ['entity' => $entity->getName(), 'id' => $id]); ?>" class="button button-link">Delete</button>
		</div>
		<?= $form->closeHtml(); ?>
	</div>
</div>
