<?php $this->layout('layouts/blog', [
    'title' => $this->__('cpost.title'),
    'component' => 'all-posts'
]) ?>

<div class='mt-3 row'>
    <div class='col-12 col-sm-8'>
        <div class="row">
            <?php if (sizeof($posts) < 1) : ?>
                <div class='alert alert-danger mt-5 mx-auto text-capitalize'>
                    <strong>Sorry, </strong> We Can not find what you are seraching for
                </div>
            <?php endif ?>
            <?php foreach ($posts as $p) : ?>
                <card title='<?= $p->title ?>' img="/posts/img/<?= $p->img ?? '1.png' ?>" href="<?= $p->slug ?>" :cls='"post text-left transition " + h.d.cardClass' :row-class="h.d.rowClass">
                    <template v-slot:info>
                        <div class='py-2 my-1 text-muted d-block'>
                            <span class="mr-3" data-toggle="tooltip" data-placement="top" title='<?= $this->__('home.sec.blog.date') ?>'>
                                <i class="fas fa-clock"></i>
                                <?= date_format(date_create($p->updated_at), 'd M Y') ?>
                            </span>
                            <a href='/blog/posts/<?= $p->slug ?>/#comments' data-toggle="tooltip" data-placement="top" title='<?= $this->__('home.sec.blog.c_count') ?>'>
                                <span class=''>
                                    <i class="fas fa-comment-alt"></i>
                                    <?= rand(0, 40) ?>
                                </span>
                            </a>
                        </div>
                        <hr class="w-50 pt-1 rounded bg-primary text-left ml-0 mt-n2 mb-3" />
                        <span class="card-text">
                            <?= substr($p->body, 0, 250) ?>
                        </span>
                    </template>
                    <template v-slot:footer>
                        <div class='card-footer text-center mx-auto'>
                            <?php foreach ($model->categories($p->id) as $cat) : ?>
                                <span class='badge badge-primary p-1 mx-1'>
                                    <?= $cat->title ?>
                                </span>
                            <?php endforeach ?>
                        </div>
                    </template>
                </card>
            <?php endforeach ?>
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="card mb-4">
            <h5 class="card-header bg-primary text-light">Search</h5>
            <div class="card-body">
                <form action="/blog/posts/s" method="get" class="form">
                    <div class="input-group">
                        <input type="text" name='q' class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class='fas fa-search'></i>
                            </button>
                        </span>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mb-4 d-none d-sm-block">
            <h5 class="card-header bg-primary text-light">change layout</h5>
            <div class="card-body">
                <div class="d-inline">
                    <button type='button' class='btn btn-outline-primary mx-1' :class="{'active': h.d.cardLayout === 'grid'}" data-toggle="tooltip" data-placement="top" title="Grid View" @click="h.d.layoutChanger('grid')">
                        <i class='fas fa-grip-vertical'></i>
                    </button>
                    <button type='button' class='btn btn-outline-primary mx-1' :class="{'active': h.d.cardLayout === 'list'}" data-toggle="tooltip" data-placement="top" title="List View" @click="h.d.layoutChanger('list')">
                        <i class='fas fa-bars'></i>
                    </button>
                    <button type='button' class='btn btn-outline-primary mx-1' :class="{'active': h.d.cardLayout === 'classic'}" data-toggle="tooltip" data-placement="top" title="Classical View" @click="h.d.layoutChanger('classic')">
                        <i class='fas fa-square'></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="card my-4">
            <h5 class="card-header bg-primary text-light">Popular Posts</h5>
            <div class="card-body">
                <ul class='list-unstyled'>
                    <?php foreach ($pinned as $p) : ?>
                        <li class="media mt-3 text-break">
                            <img src="/posts/img/<?= $p->img ?>" width="90" height='80' class="mr-3 rounded" alt="<?= $p->title ?>">
                            <div class="media-body">
                                <span class="mt-0">
                                    <span class="">
                                        <?= date_format(date_create($p->updated_at), 'd M Y') ?>
                                    </span>
                                    |<a href='/blog/posts/<?= $p->slug ?>/#comments' class='ml-2' data-toggle="tooltip" data-placement="top" title='<?= $this->__('home.sec.blog.c_count') ?>'>
                                        <span class=''>
                                            <i class="fas fa-comment-alt"></i>
                                            <?= rand(0, 40) ?>
                                        </span>
                                    </a>
                                </span>
                                <h5 class="mt-1 mb-1">
                                    <a href="/blog/posts/<?= $p->slug ?>">
                                        <?= $p->title ?>
                                    </a>
                                </h5>
                            </div>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>

        <div class="card my-4">
            <h5 class="card-header bg-primary text-light">Share this Post</h5>
            <div class="card-body">

            </div>
        </div>

        <div class="card my-4">
            <h5 class="card-header bg-primary text-light">Categories</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="list-unstyled mb-0">
                            <li>
                                <a href="#">Web Design</a>
                            </li>
                            <li>
                                <a href="#">HTML</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>



    </div>
</div>