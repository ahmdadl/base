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

<section id='about' class='about bg-light text-dark text-center mt-3'>
    <h2>
        About
        <hr width="40%" class='mx-auto bg-dark pt-1 rounded ' />
    </h2>
    <div class="row">
        <?php foreach ($pros as $p) : ?>
        <div class="pros col-6 col-md-4 shadow mt-4">
            <div class="content p-1">
                <div class="fa-3x d-inline-block bg-primary p-2 text-light w-25 h-25 mx-auto hexagon hexagon1">
                    <i class="fas fa-<?=$p->icon?>"></i>
                </div>
                <h3 class="d-block mt-3"><?=$p->title?></h3>
                <span class="text-muted"><?=$p->txt?></span>
            </div>
        </div>
        <?php endforeach ?>
    </div>
</section>