<?php
$entity = $app->getEntity($entityName);
$title = p__('search', '%s | %s', $entity->getTitle(), $app->title);

$this->layout('html', compact('title'));
$this->insert('nav', compact('entityName', 'search'));

$sort = $search->getSort();
?>

<main>
	<a href="<?= $app->getRoute('blank', compact('entityName')) ?>">
		New
	</a>

	<?php if ($rows): ?>
	<table>
		<thead>
			<th></th>
			<?php foreach (reset($rows) as $name => $column): ?>
			<th>
				<?= $column->getTitle(); ?>
			</th>
			<?php endforeach; ?>
		</thead>

		<tbody>
			<?php foreach ($rows as $id => $row): ?>
			<tr>
				<th>
					<a href="<?= $app->getRoute('read', compact('id', 'entityName')) ?>">
						<?= $id ?>
					</a>
				</th>

				<?php foreach ($row as $column): ?>
				<td>
					<?= $column->renderHtml() ?>
				</td>
				<?php endforeach; ?>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<?php else: ?>
	<div>
		<p><?= p__('search', 'No items found') ?></p>
	</div>
	<?php endif; ?>
</main>
