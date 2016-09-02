<?php $entity = $app->getEntity($entityName); ?>

<?php $this->layout('html', ['title' => p__('search', '%s | %s', $entity->title, $app->title)]); ?>

<?php $this->insert('nav', ['entityName' => $entityName, 'search' => $search]); ?>

<?php $sort = $search->getSort() ?>

<article class="page page-list">
	<div class="page-content" data-module="page-loader">

		<?php if ($rows): ?>
		<table class="page-list-table">
			<thead>
				<th></th>
				<?php foreach (reset($rows) as $name => $column): ?>
				<th class="format <?= $column->get('class').($sort === $name ? ' is-sorted' : '') ?>">
					<a href="<?= $app->getRoute('search', ['entity' => $entityName], [
                        'query' => isset($search) ? $search->getQuery() : null,
                        'sort' => $name,
                        'direction' => ($sort === $name) ? ($search->getDirection() === 'ASC' ? 'DESC' : 'ASC') : 'ASC',
                    ]) ?>">
						<?= $column->label(); ?>
					</a>
				</th>
				<?php endforeach; ?>
			</thead>

			<tbody class="ui-autoload-container" data-module="inline-editor">
				<?php foreach ($rows as $id => $row): ?>
				<tr>
					<th>
						<a class="button button-call" href="<?= $app->getRoute('read', ['entity' => $entityName, 'id' => $id]) ?>">
							<?= $id ?>
						</a>
					</th>

					<?php foreach ($row as $name => $td): ?>
					<td<?= $sort === $name ? ' class="is-sorted"' : '' ?>>
						<?php if ($td->get('editable')): ?>
						<div class="format <?= $td->get('class') ?> ui-editable is-editable" data-src="<?= $app->getRoute('updateField', ['entity' => $entityName, 'id' => $id, 'field' => $name]) ?>"><?= $td->valToHtml() ?></div>
						<?php else: ?>
						<div class="format <?= $td->get('class') ?>"><?= $td->valToHtml() ?></div>
						<?php endif ?>
					</td>
					<?php endforeach; ?>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<?php if ($search->getPage() !== null && count($rows) === $search->getLimit()): ?>
		<footer class="footer-primary">
			<a href="<?= $app->getRoute('search', ['entity' => $entityName], [
                    'query' => isset($search) ? $search->getQuery() : null,
                    'page' => (isset($search) ? $search->getPage() : 0) + 1,
                ]) ?>" class="button button-call ui-autoload-btn">
				<?= p__('search', 'More results') ?>
			</a>
		</footer>
		<?php endif; ?>

		<?php else: ?>
		<div class="page-list-noresults">
			<p><?= p__('search', 'No items found') ?></p>
		</div>
		<?php endif; ?>
	</div>
</article>
