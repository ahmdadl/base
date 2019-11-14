<?php $this->layout(
    'layouts/base',
    [
        'title' => 'ninjaCoder',
        'navClass' => 'landing-nav bg-transparent',
        'mainClass' => 'landing-page'
    ]
) ?>

<header ref='canvasHeader' id='canvasHeader' class="masthead bg-dark text-light bg-transparent">
    <animated-dots :full-height="true"></animated-dots>
    <div class="container d-flex h-100 align-items-center">
        <div class="mx-auto text-center">
            <h1 class="mx-auto my-0 text-capitalize">Hello, I`m <span class='text-danger'>Ahmed Adel</span></h1>
            <h2 class="text-white-50 mx-auto mt-2 mb-5">and I`m</h2>
            <h1 id=''>
                <span id='job-title'></span>
                <animated-job-title></animated-job-title>
                </span>
                <span id='blink' class='blink'>|</span>
            </h1>
            <a href="#about" class="btn btn-primary js-scroll-trigger">Get Started</a>
        </div>
    </div>
</header>
<div class="container-fluid">
    <section id='about' class='about bg-light text-dark text-center mt-3'>
        <h2>
            About
            <hr class='mx-auto bg-dark pt-1 rounded w-25 px-5' />
        </h2>
        <div class="row">
            <?php foreach ($pros as $p) : ?>
                <div class="pros col-6 col-md-4 shadow mt-4">
                    <div class="content p-1">
                        <div class="fa-3x d-inline-block bg-primary p-2 text-light w-25 h-25 mx-auto hexagon hexagon1">
                            <i class="fas fa-<?= $p->icon ?>"></i>
                        </div>
                        <h3 class="d-block mt-3"><?= $p->title ?></h3>
                        <span class="text-muted"><?= $p->txt ?></span>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </section>

    <section id='skills' class="skills bg-light text-dark text-center mt-3">
        <h2>
            Skills
            <hr class='mx-auto bg-dark pt-1 rounded w-25 px-5' />
        </h2>
        <div class="row text-center">
            <div class="col-12 col-md-6">
                <img src="<?= $this->asset('/assets/img/user.png') ?>" class="img w-75 p-1 border border-secondary rounded" />
                <p class="text-secondary mt-2 text-capitalize">
                    I'm a full-stack developer specialised in frontend and backend development for complex scalable web apps. I write about web development on my blog and regularly speak at various web conferences and meetups. Want to know how I may help your project? Check out my project case studies and resume.
                </p>
                <a href='#contact' class="btn btn-primary">Hire Me</a>
            </div>
            <div class="col-12 col-md-6">
                <div class="mt-5">
                    <dync-progress :txt='"html"' :val='90'></dync-progress>
                    <dync-progress :txt='"css"' :val='75'></dync-progress>
                    <dync-progress :txt='"bootstrap"' :val='85'></dync-progress>
                    <dync-progress :txt='"javascipt"' :val='80'></dync-progress>
                    <dync-progress :txt='"jquery"' :val='85'></dync-progress>
                    <dync-progress :txt='"vue"' :val='75'></dync-progress>
                    <dync-progress :txt='"angular 2"' :val='70'></dync-progress>
                    <dync-progress :txt='"php"' :val='90'></dync-progress>
                    <dync-progress :txt='"php oop"' :val='85'></dync-progress>
                    <dync-progress :txt='"python"' :val='60'></dync-progress>
                    <dync-progress :txt='"mysql"' :val='85'></dync-progress>
                    <dync-progress :txt='"laravel"' :val='85'></dync-progress>
                    <dync-progress :txt='"lumen"' :val='80'></dync-progress>
                    <dync-progress :txt='"unit_Testing"' :val='85'></dync-progress>
                </div>
            </div>
        </div>
    </section>

    <section id='projects' class="skills bg-light text-dark text-center mt-3">
        <h2>
            Projects
            <hr class='mx-auto bg-light pt-1 rounded w-25 px-5' />
        </h2>
        <div class="text-center mt-5">
            <div class="row">
                <?php foreach ($projects as $p) : ?>
                    <div class='col-12 col-md-6 col-lg-4 mb-3 px-sm-5'>
                        <div class="project card bg-light text-white shadow border border-dark">
                            <div class='card-body position-relative p-0'>
                                <img src="<?= $this->asset('assets/img/' . $p->img) ?>" class="card-img" alt="title">
                                <div ref='cardOverlay' class="card-img-overlay">
                                    <h5 class="card-title">Client: <?= $p->client ?></h5>
                                    <p class="card-text"><?= $p->info ?></p>
                                </div>
                            </div>
                            <div class="card-footer text-dark">
                                <h5 class="card-title"><?= $p->title ?></h5>
                                <div class="tags d-block text-capitalize">
                                    <?php foreach ($p->tags as $tag) : ?>
                                        <span class="badge badge-primary p-1 mx-2">
                                            <?= $tag ?>
                                        </span>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </section>
</div>