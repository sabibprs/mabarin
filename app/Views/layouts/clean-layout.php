<!doctype html>
<html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= (!empty($metadata->title) ? "{$metadata->title} | " : '') . env('app.name', 'MabarIn') ?></title>
        <link href="<?= base_url('/css/main.css') ?>" rel="stylesheet">
        <link href="https://fonts.googleapis.com" rel="preconnect">
        <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
              rel="stylesheet">
        <script src="<?= base_url('/js/main.js') ?>" defer></script>
        <script src="https://kit.fontawesome.com/ded8f6b2bd.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <main><?= $this->renderSection('content') ?></main>

        <div class="fixed top-0 -z-10 h-full min-h-screen w-full bg-vulcan-800 bg-opacity-40 bg-clip-padding backdrop-blur-xl backdrop-filter"></div>
        <div class="bg-glass fixed top-0 -z-20 h-full min-h-screen w-full"></div>

        <?= view_cell('ToastCell') ?>
    </body>

</html>
