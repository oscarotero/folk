<!DOCTYPE html>

<html data-baseurl="<?= $app->getUrl() ?>" lang="<?= $language ?>">
    <head>
        <meta charset="utf-8">

        <title><?= $title ?></title>

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" type="text/css" href="<?= $app->getUrl('css/styles.min.css'); ?>">

        <script type="text/javascript">
            var require = {
                baseUrl: "<?= $app->getUrl('js') ?>",
            };
        </script>
        <script type="text/javascript" src="<?= $app->getUrl('js/modernizr.js'); ?>"></script>
        <script type="text/javascript" data-main="<?= $app->getUrl('js/main.js'); ?>" src="<?= $app->getUrl('js/vendor/requirejs/require.js'); ?>"></script>
    </head>

    <body class="has-menu">
        <?= $this->section('content'); ?>
    </body>
</html>
