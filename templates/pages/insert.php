<?php $entity = $app->getEntity($entityName); ?>

<?php $this->layout('html', ['title' => p__('insert', '%s - New | %s', $entity->title, $app->title)]); ?>

<?php $this->insert('nav', ['entityName' => $entityName]) ?>

<div class="page page-form">
	<div class="page-content">
		<?php
        echo $form->action($app->getRoute('create', ['entity' => $entityName]))->openHtml();

        $form['data']->addClass('page-form-content');
        echo $form->html();
        ?>

		<div class="footer-primary">
			<button type="submit" class="button button-call"><?= p__('insert', 'Create') ?></button>
		</div>

        <input type="hidden" name="method-override" value="put">

		<?= $form->closeHtml(); ?>
	</div>
</div>
