<?php $this->layout('layouts/blog', [
    'title' => $this->__('cpost.title'),
    'component' => 'all-posts'
]) ?>

<div class='mt-3 row'>
    <div class='col-12 col-md-8'>
        <div class="row">
            <?php foreach ($posts as $p) : ?>
                <card cls='post text-left' title='<?= $p->title ?>' img="/posts/img/<?= $p->img ?? '1.png' ?>" href="<?=$p->slug?>">
                    <template v-slot:info>
                        <div class='py-2 my-1 text-muted d-block'>
                            <span class="mr-3" title='<?= $this->__('home.sec.blog.date') ?>'>
                                <i class="fas fa-clock"></i>
                                <?= $p->created_at ?>
                            </span>
                            <span class='' title='<?= $this->__('home.sec.blog.c_count') ?>'>
                                <i class="fas fa-comment-alt"></i>
                                <?= rand(0, 40) ?>
                            </span>
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
    <div class="col-12 col-md-4">
        asd
    </div>
</div>