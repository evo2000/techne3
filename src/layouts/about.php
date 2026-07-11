<!doctype html>

<!--

   __            __                            ___          
  / /____  _____/ /_  ____  ___   ____  ____  / (_)___  ___ 
 / __/ _ \/ ___/ __ \/ __ \/ _ \ / __ \/ __ \/ / / __ \/ _ \
/ /_/  __/ /__/ / / / / / /  __// /_/ / / / / / / / / /  __/
\__/\___/\___/_/ /_/_/ /_/\___(_)____/_/ /_/_/_/_/ /_/\___/ 

-->

<html lang="en-US">

    <head>
        <meta charset="utf-8" name="viewport" content="width = 680px">
        <title>techne.</title>
        <script src="/assets/processing/processing.js"></script>
        <link rel="stylesheet" href="/assets/css/main.css">
        <link rel="stylesheet" href="/assets/css/about.css">
        <link rel="stylesheet" href="/assets/css/flex-menu.css">
        <link rel="stylesheet" href="/assets/css/dropdown.css">
        <link rel="icon" type="image/png" href="/assets/icons/fav32.png">
        <link href="/assets/lightbox2/lightbox.css" rel="stylesheet">
        <link href="/assets/famfamfam-silk/famfamfam-silk.css" rel="stylesheet">
    </head>

    <body>

        <div class="main-contain">

            <?php include __DIR__ . '/../partials/header.php'; ?>

            <?php echo $content ?>

            <?php include __DIR__ . '/../partials/footer.php'; ?>

        </div>

        <script src="/assets/lightbox2/lightbox-plus-jquery.js"></script>
    </body>

</html>