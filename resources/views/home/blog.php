<section id='blog' class="skills bg-light text-dark text-center mt-3">
    <h2>
        <?=$this->__('home.title.blog')?>
        <hr class='mx-auto bg-dark pt-1 rounded w-25 px-5' />
    </h2>
    <div class="text-center mt-5">
        <div class="row">
            <?php foreach ($posts as $p) : ?>
                <card cls='post text-left col-lg-4' title='<?= $p->title ?>'  href="<?= $p->slug ?>" 
                 img="/posts/img/<?=$p->img ?? '1.png'?>">
                    <template v-slot:info>
                    <div class='py-2 my-1 text-muted d-block' dir='ltr'>
                            <span class="mr-3" data-toggle="tooltip" data-placement="top" title='<?= $this->__('home.sec.blog.date') ?>'>
                                <i class="fas fa-clock"></i>
                                <?= date_format(date_create($p->updated_at), 'd M Y') ?>
                            </span>
                            <a href='/blog/posts/<?= $p->slug ?>/#comments' class='mx-3' data-toggle="tooltip" data-placement="top" title='<?= $this->__('home.sec.blog.c_count') ?>'>
                                <span class=''>
                                    <i class="fas fa-comment-alt"></i>
                                    <?= $model->getCommentCount($p->id) ?>
                                </span>
                            </a>
                        </div>
                        </div>
                        <hr class="w-50 pt-1 rounded bg-primary text-left ml-0 mt-n2 mb-3" />
                        <span class="card-text">
                            <?= substr($p->body, 0, 250) ?>
                        </span>
                    </template>
                </card>
            <?php endforeach ?>
        </div>
    </div>
</section>