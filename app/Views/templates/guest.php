<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $judul; ?></title>

    <link rel="icon" type="image/png" href="<?= base_url('logo.png'); ?>" sizes="16x16">

    <link href="<?= base_url(); ?>fontawesome/css/all.css" rel="stylesheet">
    <script src="<?= base_url(); ?>jquery.js"></script>
    <link rel="stylesheet" href="<?= base_url('bootstrap'); ?>/css/bootstrap.min.css">
    <script src="<?= base_url('bootstrap'); ?>/js/bootstrap.bundle.min.js"></script>

    <style>
        .container-center {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>

</head>

<body>
    <div class="container">
        <?= $this->renderSection('content') ?>
    </div>
</body>

</html>