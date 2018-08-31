<?php
$entity = $app->getEntity($entityName);
$title = p__('search', '%s | %s', $entity->title, $app->title);

$this->layout('html', compact('title'));
$this->insert('nav', compact('entityName', 'search'));

$sort = $search->getSort();
?>

<main>
	<?php if ($rows): ?>
	<table>
		<thead>
			<th></th>
			<?php foreach (reset($rows) as $name => $column): ?>
			<th>
				<?= $column->getLabel(); ?>
			</th>
			<?php endforeach; ?>
		</thead>

		<tbody>
			<?php foreach ($rows as $id => $row): ?>
			<tr>
				<th>
					<a class="button button-call" href="<?= $app->getRoute('read', compact('id', 'entityName')) ?>">
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
