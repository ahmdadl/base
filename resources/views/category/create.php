<?php $this->layout('layouts/base', [
    'title' => 'new Category'
]) ?>

<header class="masthead bg-dark text-light p-3 py-5 rounded">
    <div class="container">
        <h1 class="display-4">Create Category</h1>
    </div>
</header>

<div class='createCat mt-5'>
    <div class="card mx-auto">
        <h5 class="card-header bg-primary text-light">Name Category</h5>
        <div class="card-body">
            <form action="/cat" method="post">
                <div class="form-group row">
                    <label for="cat" class="col-sm-2">Title</label>
                    <input type="text" name="title" id="cat" class="form-control col-sm-10" placeholder="category" aria-describedby="helpId">
                </div>
                <div class="form-group row">
                    <button type="submit" class="offset-sm-2 btn btn-primary btn-block">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>