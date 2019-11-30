<?php $this->layout('layouts/blog', [
    'title' => $this->__('cpost.title'),
    'component' => 'create-post'
]) ?>

<header class="masthead bg-dark text-light p-3 py-5 rounded">
    <div class="container">
        <h1 class="display-4"><?= $this->__('cpost.title') ?></h1>
    </div>
</header>

<div class='createPost mt-5'>
    <form ref='createPostForm' class="form needs-validation <?= $errors->any() ? 'was-validated' : '' ?>" :class="{'was-validated': h.d.titleErr || h.d.bodyErr}" action='/blog/posts' method="post" @submit.stop.prevent="h.d.beforeSubmit" enctype="multipart/form-data" novalidate>
        <?= $this->csrf() ?>
        <div class="form-group row">
            <label for="title" class="col-sm-2 col-form-label"><?= $this->__('cpost.inp.title') ?></label>
            <div class="col-sm-10">
                <input type="text" class="form-control <?= $errors->has('title') ? 'is-invalid' : '' ?>" id="title" placeholder="<?= $this->__('cpost.ph.enter') . $this->__('cpost.inp.title') ?>" v-model.trim='h.d.title' name='title' :class="{'is-invalid': h.d.titleErr, 'is-valid': false === h.d.titleErr}" v-init:title="'<?= !$errors->has('title') ? $errors->getOld('title') : '' ?>'" minlength="15" required />
                <div class="invalid-feedback">
                    <?= $this->__('cpost.vaild.titleReq') ?>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="title" class="col-sm-2 col-form-label">Category</label>
            <div class="col-sm-10">
                <?php foreach ($cats as $c) : ?>
                    <span class="p-1 bg-dark text-light rounded m-1">
                        <div class="custom-control custom-checkbox bg-dark d-inline-block m-2">
                            <input @change="h.d.setCategory" type="checkbox" class="custom-control-input" id="customCheck<?=$c->id?>" v-model="h.d.catModel" value="<?= $c->id ?>">
                            <label class="custom-control-label" for="customCheck<?=$c->id?>"><?= $c->title ?></label>
                        </div>
                    </span>
                <?php endforeach ?>
                <input type='hidden' name="category" :value="h.d.realCat" />
            </div>
        </div>
        <div class="form-group row">
            <label for="img" class="col-sm-2 col-form-label"><?= $this->__('cpost.inp.img') ?></label>
            <div class="col-sm-10">
                <div class="custom-file">
                    <input type="file" name='img' @change="h.d.handleFile" class="custom-file-input <?= ($errors->has('file') or $errors->has('files')) ? 'is-invalid' : '' ?>" :class="{'is-invalid': h.d.imgErr}" id="customFile" accept="image/*" required />
                    <label class="custom-file-label" for="customFile"><?= $this->__('cpost.ph.file') ?></label>
                    <div class="invalid-feedback">
                        <?php
                        if ($errors->get('files')) {
                            foreach ($errors->get('files') as $m => $v) {
                                echo $m === 'size' ? $this->__('cpost.vaild.imgType') : $this->__('cpost.vaild.imgSize');
                                break;
                            }
                        } else {
                            echo $this->__('cpost.vaild.imgSize');
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class='form-group row'>
            <div class='col-12 text-center'>
                <transition name="slide-fade">
                    <img :src="h.d.imagePrev" v-if="h.d.showPrev" class='imagePrev w-75 border border-primary p-1 rounded' />
                </transition>
            </div>
        </div>
        <div class="form-group row">
            <label for="body" class="col-sm-2 col-form-label"><?= $this->__('cpost.inp.body') ?></label>
            <div class="col-sm-10">
                <textarea class="form-control <?= $errors->has('body') ? 'is-invalid' : '' ?>" :class="{'is-invalid': h.d.bodyErr, 'is-valid': false === h.d.bodyErr}" id="body" placeholder="<?= $this->__('cpost.ph.enter') . $this->__('cpost.inp.body') ?>" v-model.trim='h.d.body' name='body' rows="15" minlength='150' required></textarea>
                <div class="invalid-feedback">
                    <?= $this->__('cpost.vaild.bodyReq') ?>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-10 offset-sm-2">
                <button type="submit" class='btn btn-primary btn-block text-capitalize'>
                    <span v-if='h.d.loader' class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <?= $this->__('cpost.inp.btn') ?>
                </button>
            </div>
        </div>
    </form>
</div>


<!-- 
<form action='/blog/posts' method="post">
<input type='text' name='www' />
<button type='submit' >asdw</button>
</form> -->