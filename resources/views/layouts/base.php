<!DOCTYPE html>
<html lang="<?= $session->get('lang') ?? 'en' ?>" dir="<?= $session->get('lang') === 'ar' ? 'rtl' : 'ltr'?>">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $this->e($title) ?></title>
    <?php if ($session->get('lang') === 'ar') : ?>
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css" integrity="sha384-vus3nQHTD+5mpDiZ4rkEPlnkcyTP+49BhJ4wJeJunw06ZAp+wzzeBPUXr42fi8If" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Tajawal&display=swap" rel="stylesheet">
    <?php else : ?>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <?php endif ?>
    <link href="<?= $this->asset('/assets/css/app.css') ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="icon" href="">
</head>

<body class='line-numbers bg-light text-dark'>
    <?= $this->insert('partials/nav', ['navClass' => $navClass ?? '']) ?>
    <main class="<?= $mainClass ?? 'blog' ?>" id="<?= $id ?? 'body' ?>">
        <div class="<?=isset($mainClass) && $mainClass === 'landing-page' ?: 'container-fluid'?> actual-page bg-light text-dark pb-5">
            <?= $this->section('content') ?>
        </div>

        <input type="hidden" ref='csrf_token' id='csrf_token' class="d-none" name='csrf_token' value="<?= $session->get('X_CSRF_TOKEN') ?>">


        <footer class="bg-dark text-light p-5 border-top border-secondary">
            <div class="container">
                <div class="row text-center py-4">
                    <div class="mx-auto w-75">
                        <a href='https://github.com/abo3adel' target="_blank" class="btn btn-outline-primary btn-brand transition mr-2 mt-2">
                            <i class='fab fa-github'></i>
                        </a>
                        <a href='https://codepen.io/abo3adel' target="_blank" class="btn btn-outline-danger btn-brand transition mr-2 mt-2">

                            <i class='fab fa-codepen'></i>
                        </a>
                        <a href='https://www.linkedin.com/in/ahmed-adel-30a932119/' target="_blank" class="btn btn-outline-info btn-brand transition mr-2 mt-2">
                            <i class='fab fa-linkedin-in'></i>
                        </a>
                        <a href='https://fb.com/a7md200' target="_blank" class="btn btn-outline-primary btn-brand transition mr-2 mt-2">
                            <i class='fab fa-facebook-f'></i>
                        </a>
                        <a href='https://wa.me/201143647417' target="_blank" class="btn btn-outline-success btn-brand transition mr-2 mt-2">
                            <i class='fab fa-whatsapp'></i>
                        </a>
                    </div>
                </div>
                <div class='row'>
                    <div class="col-12 col-sm-6 mb-2 text-center">
                        Copyright © ninjaCoder 2019
                    </div>
                    <div class="col-12 col-sm-6 text-center">
                        <span class="text-muted">Theme: </span>
                        <color-changer type='primary' target='danger'></color-changer>
                        <color-changer type='danger' target='primary'></color-changer>
                        <color-changer type='light' target='dark'></color-changer>
                        <color-changer type='dark' target='light'></color-changer>
                    </div>
                </div>
            </div>
        </footer>
    </main>
    <script src='<?= $this->asset('/assets/js/prism.js') ?>'></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.17.1/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.17.1/plugins/autoloader/prism-autoloader.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.17.1/plugins/line-numbers/prism-line-numbers.min.js"></script> -->
    

    <script src="<?= $this->asset('/assets/js/app.js') ?>"></script>
</body>

</html>