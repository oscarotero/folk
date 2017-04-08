<?php
$entity = $app->getEntity($entityName);
$sort = $search->getSort();

$this->layout('html', [
	'title' => p__('search', '%s | %s', $entity->title, $app->title),
	'bodyClass' => 'layout_interior pageSearch'
]);

$this->insert('nav', [
	'entityName' => $entityName,
	'search' => $search
]);
?>

<?php if ($rows): ?>
<div class="pageSearch-list layout-content" data-module="page-loader">
	<table class="pageSearch-table">
		<thead>
			<th></th>
			<?php foreach (reset($rows) as $name => $column): ?>
			<th class="format <?= $column->get('class').(isset($sort[$name]) ? ' is-sorted' : '') ?>">
				<a href="<?= $app->getRoute('search', ['entity' => $entityName], [
                    'query' => isset($search) ? $search->buildQuery() : null,
                    'sort' => (isset($sort[$name]) ? ($sort[$name] === 'ASC' ? '-' : '') : '').$name,
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
					<a class="button" href="<?= $app->getRoute('read', ['entity' => $entityName, 'id' => $id]) ?>">
						<?= $id ?>
					</a>
				</th>

				<?php foreach ($row as $name => $td): ?>
				<td<?= isset($sort[$name]) ? ' class="is-sorted"' : '' ?>>
					<div 
						<?php if ($td->get('editable')): ?>
						class="format <?= $td->get('class') ?> ui-editable is-editable" data-src="<?= $app->getRoute('updateField', ['entity' => $entityName, 'id' => $id, 'field' => $name]) ?>" data-value="<?= $td->val() ?>"
						<?php else: ?>
						class="format <?= $td->get('class') ?>"
						<?php endif ?>
					>
						<?= $td->valToHtml() ?>
					</div>
				</td>
				<?php endforeach; ?>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<?php if ($search->getPage() !== null && count($rows) === $search->getLimit()): ?>
	<footer class="pageSearch-load">
		<a href="<?= $app->getRoute('search', ['entity' => $entityName], [
                'query' => isset($search) ? $search->buildQuery() : null,
                'sort' => isset($search) ? $search->buildSort() : null,
                'page' => (isset($search) ? $search->getPage() : 0) + 1,
            ]) ?>" class="button ui-autoload-btn">
			<?= p__('search', 'More results') ?>
		</a>
	</footer>
	<?php endif; ?>
</div>

<?php else: ?>
<div class="pageSearch-noresults">
	<?= p__('search', 'No items found') ?>
</div>
<?php endif; ?>
