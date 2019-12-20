<?php $this->layout('layouts/blog', [
    'title' => $posts->title ?? '',
    'component' => 'show-post'
]) ?>

<div class='mt-3 row'>
    <header id='top' class="bg-secondary text-dark">
    </header>

    <div class='col-12 col-md-8'>
        <div class='pb-1'>
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

        <ul class="list-group list-group-horizontal py-3">
            <li class="list-group-item border-0 bg-dark text-light">
                <div class="py-2">
                    <div class="" data-toggle="tooltip" data-placement="top" title='<?= $this->__('home.sec.blog.date') ?>'>
                        <i class="fas fa-clock"></i>
                        <?= date_format(date_create($posts->updated_at), 'd M Y') ?>
                    </div>
                </div>
            </li>
            <li class="list-group-item border border-primary bg-transparent">
                <div class="dropdown">
                    <a class="btn btn-outline-primary  dropdown-toggle" href="#" role="button" id="dropdownMenuLinkLangSelect" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class='fas fa-language'></i>
                        <?= $this->__('nav.lang') ?>
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLinkLangSelect">
                        <a class="dropdown-item <?=$this->uri('/blog/posts/' . $posts->slug . '/ar') ? 'active' : ''?>" href="<?=$this->uri('/blog/posts/' . $posts->slug . '/ar') ? '#' : '/blog/posts/'.$posts->slug .'/ar'?>">العربية</a>
                        <a class="dropdown-item <?=$this->uri('/blog/posts/' . $posts->slug .'/ar' ) ?: 'active'?>" href="<?=$this->uri('/blog/posts/' . $posts->slug) ? '#' : '/blog/posts/'.$posts->slug?>">English</a>
                    </div>
                </div>
            </li>
        </ul>

        <h2 class='mt-4'><?= $posts->title ?></h2>

        <p class='lead'>
            <div id='post-body' v-pre>
                <?= $this->re($this->uri('/blog/posts/' . $posts->slug . '/ar') ?
                    $posts->body_ar : $posts->body) ?>
            </div>
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