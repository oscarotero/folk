<?php $assetsVersion = 'v=1.3'; ?>

<!DOCTYPE html>

<html data-baseurl="<?php echo $app->getUri(); ?>" lang="<?php echo $language; ?>">
    <head>
        <meta charset="utf-8">

        <title><?php echo $title; ?></title>

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" type="text/css" href="<?php echo $app->getUri('css/styles.min.css')."?{$assetsVersion}"; ?>">

        <script type="text/javascript">
            var require = {
                baseUrl: "<?php echo $app->getUri('js'); ?>",
                urlArgs: '<?php echo $assetsVersion; ?>',
                config: {
                    'modules/format-select': {
                        createUrl: '<?php echo $app->getUri('/'); ?>'
                    }
                }
            };
        </script>
        <script type="text/javascript" src="<?php echo $app->getUri('js/modernizr.js').'?'."?{$assetsVersion}"; ?>"></script>
        <script type="module" src="<?= $app->getUri('js/modules.js') ?>"></script>
        <script type="text/javascript" data-main="<?php echo $app->getUri('js/main.js')."?{$assetsVersion}"; ?>" src="<?php echo $app->getUri('js/vendor/requirejs/require.js')."?{$assetsVersion}"; ?>" defer></script>
    </head>

    <body class="has-menu">
        <?php echo $this->section('content'); ?>
    </body>
</html>
