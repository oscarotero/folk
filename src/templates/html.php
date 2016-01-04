<!DOCTYPE html>

<html data-baseurl="<?= $app->getUrl() ?>" <?= isset($html_class) ? ' class="'.$html_class.'"' : '' ?>>
    <head>
        <meta charset="utf-8">

        <title><?= $app->title ?> | FOLK</title>

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" type="text/css" href="<?= $app->getUrl('css.dist/styles.css'); ?>">

        <script type="text/javascript">
            var require = {
                baseUrl: "<?= $app->getUrl('js.dist') ?>",
            };
        </script>
        <script type="text/javascript" src="<?= $app->getUrl('js.dist/main.js'); ?>"></script>
    </head>

    <body class="has-menu">
        <?= $this->section('content'); ?>
    </body>
</html>
