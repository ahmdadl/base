<?php $this->layout('layout', [
    'title' => 'Home Page',
    'name' => $name,
    'hashid' => $hashid
    ]);?>

<div class="jumbotron mt-5">
    <h1 class="display-4">Hello, <?=$name?></h1>
    <p class="lead">Welcome to my blog</p>
    <hr class="my-4">
    <p>this just an test</p>
    <a class="btn btn-primary" href="#" role="button">Learn more</a>
</div>

<div class="card-columns">
    <div class="card mb-4 ">
        <img src="..." class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">
                <small class="text-muted">by abo3adel </small>
                <small class="text-muted"> Last updated 3 mins ago</small>
            </p>
            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
        </div>
    </div>
    <div class="card mb-4 ">
        <img src="..." class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">
                <small class="text-muted">by abo3adel </small>
                <small class="text-muted"> Last updated 3 mins ago</small>
            </p>
            <p class="card-text">This is a wider card with supporting text below as a natuonger.</p>
        </div>
    </div>
    <div class="card mb-4 ">
        <img src="..." class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">
                <small class="text-muted">by abo3adel </small>
                <small class="text-muted"> Last updated 3 mins ago</small>
            </p>
            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
        </div>
    </div>
</div>