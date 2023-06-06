<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>KIWSPART</title>
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/aos.min.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/animate.min.min.css') ?>">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">

</head>

<body>

    <main>
        <section style="min-height: 70vh;">
            <?= $this->renderSection('content') ?>
        </section>
    </main>

    <script src="<?= base_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/script.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/aos.min.min.js') ?>"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="<?= base_url('assets/js/script.js') ?>"></script>
</body>

</html>