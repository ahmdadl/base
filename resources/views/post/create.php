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
    <form ref='createPostForm' class="form needs-validation" :class="{'was-validated': h.d.titleErr || h.d.bodyErr}" action='/blog/post/' method="post" @submit.stop.prevent="h.d.beforeSubmit" novalidate>
        <?= $this->csrf() ?>
        <div class="form-group row">
            <label for="title" class="col-sm-2 col-form-label">Title</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="title" placeholder="post title" v-model='h.d.title' :class="{'is-invalid': h.d.titleErr, 'is-valid': false === h.d.titleErr}" minlength="5" required />
                <div class="invalid-feedback">
                    title must be withen 25 and 255 chars
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="img" class="col-sm-2 col-form-label">Image</label>
            <div class="col-sm-10">
                <div class="custom-file">
                    <input type="file" @change="h.d.handleFile" class="custom-file-input" id="customFile" accept="image/*" ref="img">
                    <label class="custom-file-label" for="customFile">Choose file</label>
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
                <textarea class="form-control" :class="{'is-invalid': h.d.bodyErr, 'is-valid': false === h.d.bodyErr}" id="body" placeholder="write in markdown" v-model='h.d.body' rows="15" minlength='25' required></textarea>
                <div class="invalid-feedback">
                    must be required
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-10 offset-sm-2">
                <button type="submit" class='btn btn-primary btn-block text-capitalize'>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    save post
                </button>
            </div>
        </div>
    </form>
</div>