<?php $this->layout('html'); ?>

<div class="page">
	<header class="page-header">
        <h1><?= $error->getMessage() ?></h1>
        <pre><?= $error->getTraceAsString() ?></pre>
	</header>
</div>
