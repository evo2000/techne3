<!doctype html>
<html lang="en-US">

    <head>
        <meta charset="utf-8" name="viewport" content="width=device-width">
        <title><?= $title ?></title>
        <link rel="stylesheet" href="/dist/assets/main.css">
    </head>

    <body>

        <?php include __DIR__ . '/header.php'; ?>

        <?php echo $content ?>

        <?php include __DIR__ . '/footer.php'; ?>

    </body>

</html>