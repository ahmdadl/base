<div class="card bg-light text-dark mb-4">
    <h5 class="card-header bg-primary text-light"><?=$this->__('sb.s')?></h5>
    <div class="card-body">
        <form action="/blog/posts/s" method="get" class="form">
            <div class="input-group">
                <input type="text" name='q' class="form-control bg-light text-dark" placeholder="<?=$this->__('sb.s')?> <?=$this->__('sb.for')?>...">
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
<div class="card bg-light text-dark mb-4 d-none d-sm-block">
    <h5 class="card-header bg-primary text-light"><?=$this->__('sb.cl')?></h5>
    <div class="card-body">
        <div class="d-inline">
            <button type='button' class='btn btn-outline-primary mx-1' :class="{'active': h.d.cardLayout === 'grid'}" data-toggle="tooltip" data-placement="top" title="<?=$this->__('sb.gv')?>" @click="h.d.layoutChanger('grid')">
                <i class='fas fa-grip-vertical'></i>
            </button>
            <button type='button' class='btn btn-outline-primary mx-1' :class="{'active': h.d.cardLayout === 'list'}" data-toggle="tooltip" data-placement="top" title="<?=$this->__('sb.lv')?>" @click="h.d.layoutChanger('list')">
                <i class='fas fa-bars'></i>
            </button>
            <button type='button' class='btn btn-outline-primary mx-1' :class="{'active': h.d.cardLayout === 'classic'}" data-toggle="tooltip" data-placement="top" title="<?=$this->__('sb.classic')?>" @click="h.d.layoutChanger('classic')">
                <i class='fas fa-square'></i>
            </button>
        </div>
    </div>
</div>
<?php endif?>

<div class="card bg-light text-dark my-4">
    <h5 class="card-header bg-primary text-light"><?=$this->__('sb.pop')?></h5>
    <div class="card-body">
        <ul class='list-unstyled'>
            <?php foreach ($pinned as $p) : ?>
                <li class="media mt-3 text-break">
                    <img src="/posts/img/<?= $p->img ?>" width="90" height='80' class="mr-3 rounded" alt="<?= $p->title ?>">
                    <div class="media-body">
                        <span class="mt-0" dir='ltr'>
                            <span class="">
                                <?= date_format(date_create($p->updated_at), 'd M Y') ?>
                            </span>
                            |<a href='/blog/posts/<?= $p->slug ?>/#comments' class='mx-2 text-primary' data-toggle="tooltip" data-placement="top" title='<?= $this->__('home.sec.blog.c_count') ?>'>
                                <span class=''>
                                    <i class="fas fa-comment-alt"></i>
                                    <?= $model->getCommentCount($p->id) ?>
                                </span>
                            </a>
                        </span>
                        <h5 class="mt-1 mb-1">
                            <a href="/blog/posts/<?= $p->slug ?>" class="text-primary">
                                <?= $p->title ?>
                            </a>
                        </h5>
                    </div>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
</div>

<div class="card bg-light text-dark my-4">
    <h5 class="card-header bg-primary text-light"><?=$this->__('sb.share.t')?></h5>
    <?php
        $siteUri = 'http://ninjacoder.qa';
        $url = isset($post) ? $siteUri . '/blog/posts/'.$post->slug : $siteUri;
        $text = $post->title ?? $this->__('sb.share.text');
        $hasta = 'programming,php,vueJs,web_development,laravel'
    ?>
    <div class="card-body">
        <a href="http://www.facebook.com/sharer.php?u=<?=$url?>" target="_blank" class="btn btn-outline-primary m-2 noColor">
            <i class="fab fa-facebook-f pr-3"></i>
            <?=$this->__('sb.share.fb')?>
        </a>
        <a href='https://twitter.com/share?url=<?=$url?>&amp;text=<?=$text?>&amp;hashtags=<?=$hasta?>' class="btn btn-outline-info m-2 noColor" target="_blank">
            <i class="fab fa-twitter pr-3"></i>
            <?=$this->__('sb.share.tw')?>
        </a>
        <a href='https://www.linkedin.com/shareArticle?mini=true&url=<?=urlencode($url)?>&title=<?=urlencode($text)?>' class="btn btn-outline-primary m-2 noColor" target="_blank">
            <i class="fab fa-linkedin-in pr-3"></i>
            <?=$this->__('sb.share.ln')?>
        </a>
        <a href='mailto:?Subject=<?=urlencode('post at' . $url)?>&amp;Body=<?=urlencode($text ?? '')?>' class="btn btn-outline-secondary m-2 noColor">
            <i class="fas fa-mail-bulk pr-3"></i>
            <?=$this->__('sb.share.ma')?>
        </a>
    </div>
</div>

<div class="card bg-light text-dark my-4">
    <h5 class="card-header bg-primary text-light"><?=$this->__('sb.cat')?></h5>
    <div class="card-body">
        <div class="row">
            <ul class="list-unstyled mb-0">
                <li>
                    <?php foreach ($cats as $c) : ?>
                        <a href="/blog/cat/<?=$c->id*256?>/<?=$c->title?>" class='btn btn-primary m-2'>
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