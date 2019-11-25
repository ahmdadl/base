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

<?php if (!isset($layoutClass)) : ?>
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
<?php endif?>

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
                                    <?= $model->getCommentCount($p->id) ?>
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
            <ul class="list-unstyled mb-0">
                <li>
                    <?php foreach ($cats as $c) : ?>
                        <a href="#" class='btn btn-primary m-2'>
                            <?=$c->title?>
                            <span class='badge badge-light'>
                                <?=$catModel->countPosts($c->id)?>
                            </span>
                        </a>
                    <?php endforeach ?>
                </li>
            </ul>
        </div>
    </div>
</div>