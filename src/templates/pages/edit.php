<?php $this->layout('html', ['title' => $entity->title.' #'.$form['id']->val()." | {$app->title}"]); ?>

<?php $this->insert('nav', ['entity' => $entity, 'placeholder' => "#{$id}"]) ?>

<div class="page page-form">
	<div class="page-content">
		<?php
        echo $form->openHtml();

        $form['data']->addClass('page-form-content');
        echo $form->html();
        ?>

		<div class="footer-primary is-floating">
			<button type="submit" class="button button-call">Save</button>
			<button type="submit" data-confirm="You will save this data as a new row. Are you sure?" formaction="<?= $app->getRouteUrl('create', ['entity' => $entity->getName()]); ?>" class="button button-link">Duplicate</button>
			<button type="submit" data-confirm="This action cannot be undo. Are you sure?" formaction="<?= $app->getRouteUrl('delete', ['entity' => $entity->getName(), 'id' => $id]); ?>" class="button button-link">Delete</button>
		</div>
		<?= $form->closeHtml(); ?>
	</div>
</div>
