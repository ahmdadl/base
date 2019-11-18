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
    <form class="form needs-validation" action='/blog/post/' method="post">
        <?= $this->csrf() ?>
        <div class="form-group row">
            <label for="title" class="col-sm-2 col-form-label">Title</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="title" placeholder="post title" v-model='h.d.title'>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="img" class="col-sm-2 col-form-label">Image</label>
            <div class="col-sm-10">
                <div class="custom-file">
                    <!-- <input type="file" v-model='h.d.img' class="custom-file-input" id="customFile"> -->
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="body" class="col-sm-2 col-form-label">Body</label>
            <div class="col-sm-10">
                <textarea class="form-control" id="body" placeholder="write in markdown" v-model='h.d.body' rows="15"></textarea>
                <div class="valid-feedback">
                    Looks good!
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