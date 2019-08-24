<form method="<?php echo $method ?? 'GET'; ?>" action="<?php echo $url; ?>" target="<?php echo $target ?? ''; ?>">
	<?php if (!empty($data)): ?>
	<?php foreach ($data as $name => $value): ?>
	<input type="hidden" name="<?php echo $name; ?>" value="<?php echo $this->e($value); ?>">
	<?php endforeach; ?>
	<?php endif; ?>
	<button class="button button-link">
		<?php if (isset($icon)): ?>
		<?php echo $this->icon($icon); ?>
		<?php endif; ?>
		<?php echo $label; ?>
	</button>
</form>
