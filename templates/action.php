<form method="<?= isset($method) ? $method : 'GET' ?>" action="<?= $url ?>" target="<?= isset($target) ? $arget : '' ?>">
	<?php if (!empty($data)): ?>
	<?php foreach ($data as $name => $value): ?>
	<input type="hidden" name="<?= $name ?>" value="<?= $this->e($value) ?>">
	<?php endforeach ?>
	<?php endif ?>
	<button class="button button-link">
		<?php if (isset($icon)): ?>
		<?= $this->icon($icon) ?>
		<?php endif ?>
		<?= $label ?>
	</button>
</form>
