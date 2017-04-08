<?php $assetsVersion = 'v=1.3'; ?>

<!DOCTYPE html>

<html data-baseurl="<?= $app->getUri() ?>" lang="<?= $language ?>">
    <head>
        <meta charset="utf-8">

        <title><?= $title ?></title>

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" type="text/css" href="<?= $app->getUri('css/styles.min.css')."?{$assetsVersion}" ?>">

        <script type="text/javascript">
            var require = {
                baseUrl: "<?= $app->getUri('js') ?>",
                urlArgs: '<?= $assetsVersion ?>',
                config: {
                    'modules/format-select': {
                        createUrl: '<?= $app->getUri('/') ?>'
                    }
                }
            };
        </script>
        <script type="text/javascript" src="<?= $app->getUri('js/modernizr.js').'?'."?{$assetsVersion}" ?>"></script>
        <script type="text/javascript" data-main="<?= $app->getUri('js/main.js')."?{$assetsVersion}" ?>" src="<?= $app->getUri('js/vendor/requirejs/require.js')."?{$assetsVersion}" ?>"></script>
    </head>

    <body class="has-menu <?= $bodyClass ?? '' ?>">
        <?= $this->section('content'); ?>
    </body>
</html>
