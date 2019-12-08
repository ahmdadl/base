<?php $this->layout('layouts/blog', [
    'title' => $posts->title ?? '',
    'component' => 'show-post'
]) ?>

<div class='mt-3 row'>
    <header id='top' class="bg-secondary text-dark">
    </header>

    <div class='col-12 col-md-8'>
        <div class='pb-5'>
            <div class='breadcrump-head position-absolute' style='top: 0;'>
                <ol class="breadcrumb rounded-0 bg-dark text-light">
                    <li class="breadcrumb-item">
                        <a href="/blog"><?= $this->__('shpost.home') ?></a>
                    </li>
                    <li class="breadcrumb-item active text-light text-break"><?= $posts->title ?></li>
                </ol>
            </div>
            <img src='/posts/img/<?= $posts->img ?>' class='img img-responsive w-100'>
        </div>

        <div class="text-left px-5">
            <span class="mr-3" data-toggle="tooltip" data-placement="top" title='<?= $this->__('home.sec.blog.date') ?>'>
                <i class="fas fa-clock"></i>
                <?= date_format(date_create($p->updated_at), 'd M Y') ?>
            </span>
            <div class="drop-down d-inline mx-2">
                <span class='btn btn-outline-primary'>
                    Language
                </span>
            </div>
        </div>

        <h2 class='mt-3'><?= $posts->title ?></h2>

        <p class='lead' v-pre>
            <?= $this->re($posts->body) ?>
        </p>

        <?= $this->insert('post/opr', ['p' => $posts, 'red' => true]) ?>

        <?php $this->insert('post/comments', [
            'pid' => $posts->id
        ]) ?>
    </div>
    <div class="col-12 col-md-4">
        <?php $this->insert('sidebar/index', [
            'layoutClass' => true,
            'model' => $model,
            'pinned' => $pinned,
            'cats' => $cats,
            'catModel' => $catModel,
            'post' => $posts
        ]) ?>
    </div>
</div>