<?php $assetsVersion = 'v=1.1'; ?>

<!DOCTYPE html>

<html data-baseurl="<?= $app->getUrl() ?>" lang="<?= $language ?>">
    <head>
        <meta charset="utf-8">

        <title><?= $title ?></title>

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" type="text/css" href="<?= $app->getUrl('css/styles.min.css?'.$assetsVersion); ?>">

        <script type="text/javascript">
            var require = {
                baseUrl: "<?= $app->getUrl('js') ?>",
                urlArgs: '<?= $assetsVersion ?>'
            };
        </script>
        <script type="text/javascript" src="<?= $app->getUrl('js/modernizr.js?'.$assetsVersion); ?>"></script>
        <script type="text/javascript" data-main="<?= $app->getUrl('js/main.js?'.$assetsVersion); ?>" src="<?= $app->getUrl('js/vendor/requirejs/require.js?'.$assetsVersion); ?>"></script>
    </head>

    <body class="has-menu">
        <?= $this->section('content'); ?>
    </body>
</html>
