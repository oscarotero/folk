<!DOCTYPE html>

<html data-baseurl="<?= $app->getUrl() ?>" <?= isset($html_class) ? ' class="'.$html_class.'"' : '' ?>>
    <head>
        <meta charset="utf-8">

        <title><?= $app->title ?> | FOLK</title>

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" type="text/css" href="<?= $app->getUrl('css/styles.min.css'); ?>">

        <script type="text/javascript" data-main="<?= $app->getUrl('js/main'); ?>" src="<?= $app->getUrl('bower_components/requirejs/require.js') ?>"></script>
    </head>

    <body class="has-menu">
        <?= $this->section('content'); ?>
    </body>
</html>
