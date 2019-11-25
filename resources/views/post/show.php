<?php $this->layout('layouts/blog', [
    'title' => $this->__('cpost.title'),
    'component' => 'all-posts'
]) ?>

<div class='mt-3 row'>
    <header id='top' class="bg-secondary text-dark">
    </header>

    <div class='col-12 col-sm-8'>
        <div class=''>
            <div class='breadcrump-head position-absolute'>
                <ol class="breadcrumb rounded-0 bg-dark text-light">
                    <li class="breadcrumb-item">
                        <a href="/blog">Home</a>
                    </li>
                    <li class="breadcrumb-item active text-light text-break"><?=$post->slug?></li>
                </ol>
            </div>
            <img src='/posts/img/<?= $post->img ?>' class='img img-responsive w-100'>
        </div>

        <h4><?= $post->title ?></h4>

        <p>
            <?= $post->body ?>
        </p>
    </div>
</div>