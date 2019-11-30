<!DOCTYPE html>
<html lang="<?= $session->get('lang') ?? '' ?>">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $this->e($title) ?></title>
    <link href="<?= $this->asset('/assets/css/app.css') ?>" rel="stylesheet" type="text/css">
    <link rel="icon" href="">
</head>

<body class='line-numbers'>
    <?= $this->insert('partials/nav', ['navClass' => $navClass ?? '']) ?>
    <main class="<?= $mainClass ?? 'blog' ?>" id="<?= $id ?? 'body' ?>">
        <div class="<?=isset($mainClass) && $mainClass === 'landing-page' ?: 'container-fluid'?>">
            <?= $this->section('content') ?>
        </div>

        <input type="hidden" ref='csrf_token' id='csrf_token' class="d-none" name='csrf_token' value="<?= $session->get('X_CSRF_TOKEN') ?>">


        <footer class="bg-dark text-light p-5">
            <div class="container">
                <div class="row text-center py-4">
                    <div class="mx-auto w-75">
                        <a href='fb.com/a7md200' class="btn btn-outline-primary btn-brand transition mr-2">
                            <i class='fab fa-github'></i>
                        </a>
                        <a href='fb.com/a7md200' class="btn btn-outline-danger btn-brand transition mr-2">

                            <i class='fab fa-codepen'></i>
                        </a>
                        <a href='fb.com/a7md200' class="btn btn-outline-info btn-brand transition mr-2">
                            <i class='fab fa-linkedin-in'></i>
                        </a>
                        <a href='fb.com/a7md200' class="btn btn-outline-primary btn-brand transition mr-2">
                            <i class='fab fa-facebook-f'></i>
                        </a>
                        <a href='fb.com/a7md200' class="btn btn-outline-success btn-brand transition mr-2">
                            <i class='fab fa-whatsapp'></i>
                        </a>
                    </div>
                </div>
                <div class='row'>
                    <div class="mx-auto w-75 text-center">
                        Copyright © ninjaCoder 2019
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