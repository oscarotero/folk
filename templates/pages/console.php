<?php
$this->layout('html');
?>

<div class="page page-console">
	<form class="console" method="post" action="<?= $app->getRoute('console') ?>" data-module="console">
		<pre class="console-output"></pre>

		<input type="text" name="command" class="console-input" placeholder="Put here your command..." autocomplete="off" autofocus>
	</form>
</div>
