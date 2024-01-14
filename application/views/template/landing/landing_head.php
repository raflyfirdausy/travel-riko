<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= env("APP_NAME") ?> | <?= env("APP_ALIAS_NAME") ?></title>

    <link href="<?= getFavicon() ?>" rel="icon">
    <link href="<?= getFavicon() ?>" rel="apple-touch-icon">

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="/assets/landing/apple-touch-icon.png">
    <link rel="stylesheet" href="/assets/landing/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/landing/css/normalize.css">
    <link rel="stylesheet" href="/assets/landing/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/landing/css/icomoon.css">
    <link rel="stylesheet" href="/assets/landing/css/jquery-ui.css">
    <link rel="stylesheet" href="/assets/landing/css/owl.carousel.css">
    <link rel="stylesheet" href="/assets/landing/css/transitions.css">
    <link rel="stylesheet" href="/assets/landing/css/main.css">
    <link rel="stylesheet" href="/assets/landing/css/color.css">
    <link rel="stylesheet" href="/assets/landing/css/responsive.css">
    <script src="/assets/landing/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>

    <?php if (!empty(getSetting("WARNA_WEBSITE"))) : ?>
        <style>
            :root {
                --primary: <?= getSetting("WARNA_WEBSITE") ?>;
            }
        </style>
    <?php endif ?>

</head>