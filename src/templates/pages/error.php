<?php $this->layout('html', ['title' => "Error 500 | {$app->title}"]); ?>

<div class="page-error">
	<header>
        <h1>There was an error!</h1>
    </header>

    <h2><?= $error->getMessage() ?></h2>
    <pre><?= $error->getTraceAsString() ?></pre>
</div>
