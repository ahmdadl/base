<section id='blog' class="skills bg-light text-dark text-center mt-3">
    <h2>
        Latest Blog Posts
        <hr class='mx-auto bg-dark pt-1 rounded w-25 px-5' />
    </h2>
    <div class="text-center mt-5">
        <div class="row">
            <?php foreach ($posts as $p) : ?>
                <card cls='post text-left' title='<?= $p->title ?>'
                 img="<?=$this->asset('/assets/img/' . $p->img ?? '1.png')?>">
                    <template v-slot:info>
                        <div class='py-2 my-1 text-muted d-block'>
                            <span class="mr-3">
                                <i class="fas fa-clock"></i>
                                <?= $p->created_at ?>
                            </span>
                            <span class=''>
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
                            <!-- <?php /*foreach ($p->cats as $c) :*/ ?>
                                <span class='badge badge-primary p-1 mx-1'>
                                    <?= /* $c */  55?>
                                </span>
                            <?php /* endforeach */ ?> -->
                        </div>
                    </template>
                </card>
            <?php endforeach ?>
        </div>
    </div>
</section>