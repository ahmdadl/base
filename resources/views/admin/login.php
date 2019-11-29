<?php $this->layout('layouts/base', [
    'title' => 'Sign In',
    'mainClass' => 'main blog',
]) ?>

<div class="my-5 mx-auto">
    <div class="card pt-5">
        <div class="card-header text-center bg-primary text-light">
            <h4>LogIn</h4>
        </div>
        <div class="card-body">
            <form action="/root" method="post" class="form">
                <?= $this->_method('post') ?>
                <?= $this->csrf() ?>
                <div class="form-group row">
                    <label for="email" class="form-label col-sm-2">Email</label>
                    <input type="text" name="email" id="email" class="form-control col-sm-10" placeholder="email" aria-describedby="helpId">
                    <small id="helpId" class="text-muted offset-sm-2">please enter a valid email</small>
                </div>
                <div class="form-group row">
                    <label for="password" class="form-label col-sm-2">password</label>
                    <input type="text" name="password" id="password" class="form-control col-sm-10" placeholder="your password" aria-describedby="passwordHelpId">
                    <small id="passwordHelpId" class="text-muted offset-sm-2">please enter your password</small>
                </div>
                <div class="form-group row">
                    <button type='submit' class="btn btn-primary offset-sm-2 btn-block">LogIn</button>
                </div>
            </form>
        </div>
    </div>
</div>