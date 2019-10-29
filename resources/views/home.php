<?php $this->layout('layout', [
    'title' => 'Home Page',
    'name' => $session->get('userName', 'stranger'),
    'hashid' => $hashid
]); ?>

<div class="jumbotron mt-5 bg-light shadow-lg">
    <h1 class="display-4">Hello, <?= $session->get('userName', 'stranger') ?></h1>
    <p class="lead">Welcome to my blog</p>
    <hr class="my-4">
    <p>this just an test</p>
    <a class="btn btn-primary" href="#" role="button">Learn more</a>
</div>

<div class="row">
    <?php foreach ($posts as $post) : ?>
        <div class="col-sm-6 col-md-4 col-lg-3 mb-4 p-2 ">
            <!-- explode(',', $post->allCats) -->
            
            <div class="card border-primary bg-light shadow-lg">
                <a href="p/<?= $hashid->encode($post->postId) ?>">
                    <img src="assets/img/1.jpeg" class="card-img-top" alt="guko">
                </a>
                <div class="card-body">
                    <?php foreach(explode(',', $post->allCats) as $cat) : ?>
                    <a href="cat/<?=$cat?>" class="badge badge-info mr-1">
                        <?=$cat?>
                    </a>
                    <?php endforeach?>
                    <h5 class="card-title">
                        <a href="p/<?= $hashid->encode($post->postId) ?>"><?= $post->title ?></a>
                    </h5>
                    <small class="card-subtitle text-muted">
                        by <a class="text-info" href="user/<?= $hashid->encode($post->userId) ?>"><?= $post->userName ?></a>
                        updated At <?= $post->updatedAt ?> ago
                    </small>
                    <p class="card-text text-center">
                        <?= $post->postContent ?>
                    </p>
                    <!-- footer start -->
                    <a href="p/<?= $hashid->encode($post->postId) ?>" class="btn btn-outline-primary btn-r">
                        Continue Reading ->
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>