<?php $this->layout('layouts/blog', [
    'title' => 'create post',
    'component' => 'create-post'
]) ?>

<header class="masthead bg-dark text-light p-3 py-5 rounded">
    <div class="container">
        <h1 class="display-4">Create Post</h1>
    </div>
</header>

<div class='createPost mt-5'>
    <?=json_encode($session->getFlashBag()->peekAll())?>
    <form ref='createPostForm' class="form needs-validation <?= $errors->any() ? 'was-validated' : '' ?>" :class="{'was-validated': h.d.titleErr || h.d.bodyErr}" action='/blog/posts' method="post" @submit.stop.prevent="h.d.beforeSubmit" enctype="multipart/form-data" novalidate>
        <?= $this->csrf() ?>
        <div class="form-group row">
            <label for="title" class="col-sm-2 col-form-label">Title</label>
            <div class="col-sm-10">
                <input type="text" class="form-control <?= $errors->has('title') ? 'is-invalid' : '' ?>" id="title" placeholder="post title" v-model.trim='h.d.title' name='title' :class="{'is-invalid': h.d.titleErr, 'is-valid': false === h.d.titleErr}" v-init:title="'<?= !$errors->has('title') ? $errors->getOld('title') : '' ?>'" minlength="15" required />
                <div class="invalid-feedback">
                    The Title must be greater than 15 characters.
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="img" class="col-sm-2 col-form-label">Image</label>
            <div class="col-sm-10">
                <div class="custom-file">
                    <input type="file" name='img' @change="h.d.handleFile" class="custom-file-input <?= ($errors->has('file') or $errors->has('files')) ? 'is-invalid' : '' ?>" id="customFile" accept="image/*" required />
                    <label class="custom-file-label" for="customFile">Choose file</label>
                    <div class="invalid-feedback">
                        <?php
                        if ($errors->get('files')) {
                            foreach ($errors->get('files') as $m => $v) {
                                echo $m === 'size' ? 'The Image must be a file of type: png, jpg, jpeg.' : 'The Image must be less than 750 kilobytes.';
                                break;
                            }
                        } else {
                            echo "The Image field is required.";
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
            <label for="body" class="col-sm-2 col-form-label">Body</label>
            <div class="col-sm-10">
                <textarea class="form-control <?= $errors->has('body') ? 'is-invalid' : '' ?>" :class="{'is-invalid': h.d.bodyErr, 'is-valid': false === h.d.bodyErr}" id="body" placeholder="write in markdown" v-model.trim='h.d.body' name='body' rows="15" minlength='150' required></textarea>
                <div class="invalid-feedback">
                    The Body must be greater than 150 characters.
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-10 offset-sm-2">
                <button type="submit" class='btn btn-primary btn-block text-capitalize'>
                    <span v-if='h.d.loader' class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    save post
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