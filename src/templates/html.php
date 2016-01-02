<!DOCTYPE html>

<html data-baseurl="<?= $this->asset() ?>" <?= isset($html_class) ? ' class="'.$html_class.'"' : '' ?>>
    <head>
        <meta charset="utf-8">

        <title><?= $app->title ?> | FOLK</title>

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" type="text/css" href="<?= $this->asset('css/styles.min.css'); ?>">

        <script type="text/javascript" data-main="<?= $this->asset('js/main'); ?>" src="<?= $this->asset('bower_components/requirejs/require.js') ?>"></script>
    </head>

    <body class="has-menu">
        <?= $this->section('content'); ?>
    </body>
</html>
