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
    <h2 class="border-bottom">
        About
        <hr width="40%" class='mx-auto bg-dark pt-1 rounded' />
    </h2>
    <div class="row">
        <div class="pros col-6 col-md-4 col-lg-3 shadow">
            <div class="content p-1">
                <div class="rounded fa-3x bg-primary text-light  w-50 mx-auto">
                    <i class="fas fa-desktop"></i>
                </div>
                <h3 class="d-block">Responsive</h3>
                <span class="text-muted">
                    with some thing around here to happen some how
                </span>
            </div>
        </div>
        <div class="pros col-6 col-md-4 col-lg-3 shadow">
            <div class="content p-1">
                <div class="rounded fa-3x bg-primary text-light  w-50 mx-auto">
                    <i class="fas fa-rocket"></i>
                </div>
                <h3 class="d-block">Fast</h3>
                <span class="text-muted">
                    with some thing around here to happen some how
                </span>
            </div>
        </div>
    </div>
</section>