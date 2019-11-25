<?php $this->layout('layouts/blog', [
    'title' => $this->__('cpost.title'),
    'component' => 'all-posts'
]) ?>

<div class='mt-3 row'>
    <div class='col-12 col-sm-8'>
        <div class="row">
            <?php foreach ($posts as $p) : ?>
                <card cls='post text-left' title='<?= $p->title ?>' img="/posts/img/<?= $p->img ?? '1.png' ?>" href="<?= $p->slug ?>">
                    <template v-slot:info>
                        <div class='py-2 my-1 text-muted d-block'>
                            <span class="mr-3" data-toggle="tooltip" data-placement="top" title='<?= $this->__('home.sec.blog.date') ?>'>
                                <i class="fas fa-clock"></i>
                                <?= $p->created_at ?>
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
                        <div class='card-footer text-center'>
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
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <h5 class="card-header bg-primary text-light">change layout</h5>
            <div class="card-body">
                <div class="d-inline">
                    <button type='button' class='btn btn-outline-primary mx-1' data-toggle="tooltip" data-placement="top" title="Grid View">
                        <i class='fas fa-grip-vertical'></i>
                    </button>
                    <button type='button' class='btn btn-outline-primary mx-1' data-toggle="tooltip" data-placement="top" title="List View">
                        <i class='fas fa-bars'></i>
                    </button>
                    <button type='button' class='btn btn-outline-primary mx-1' data-toggle="tooltip" data-placement="top" title="Classical View">
                        <i class='fas fa-square'></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="card my-4">
            <h5 class="card-header bg-primary text-light">Popular Posts</h5>
            <div class="card-body">

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