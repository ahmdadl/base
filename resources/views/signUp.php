<?php $this->layout('layout', ['title' => 'sign Up']) ?>

<div class="shadow-lg card text-dark bg-light mb-3 mx-auto" style="width: 80%;">
    <div class="card-header">Sign Up</div>
    <div class="card-body">
        <fieldset class="card-text p-3">
            <form>
                <div class="form-group row input-group">
                    <div class="input-group-prepend">
                        <label for="userName" class="input-group-text">Name</label>
                    </div>
                    <input type="text" class="form-control" id="userName" placeholder="Name" name='userName' required>
                </div>
                <div class="form-group row input-group">
                    <div class="input-group-prepend">
                        <label for="userEmail" class="input-group-text">Email</label>
                        <span class='input-group-text'>@</span>
                    </div>
                    <input type="email" class="form-control" id="userEmail" placeholder="Email" name='userEmail' required>
                </div>
                <div class="form-group row input-group">
                    <div class="input-group-prepend">
                        <span class='input-group-text'>@</span>
                    </div>
                    <input type="text" class="form-control" id="userSn" placeholder="login name" name='userSn'>
                </div>
                <div class="form-group row input-group">
                    <div class="input-group-prepend">
                        <label for="password" class="input-group-text ">Password</label>
                    </div>
                    <input type="password" class="form-control" id="password" placeholder="Password" aria-describedby="showPass">
                    <div class="input-group-prepend">
                        <button type='button' class="btn btn-primary" id='showPass' name="userPass">
                            Show
                        </button>
                    </div>
                </div>
                <div class="form-group row input-group">
                    <div class="input-group-prepend">
                        <label for="password" class="input-group-text ">Confirm Password</label>
                    </div>
                    <input type="password" class="form-control" id="confPassword" placeholder="Confirm Password" aria-describedby="showPass2" name="confPass">
                    <div class="input-group-prepend">
                        <button type='button' class="btn btn-primary" id='showPass2' name="userConfPass">
                            Show
                        </button>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <div class="form-check custom-control custom-switch">
                            <input class="form-check-input custom-control-input" type="checkbox" id="remmberMe" name='remmber'>
                            <label class="custom-control-label" for="remmberMe">
                                Remmber Me <span class="text-muted">(for 72 hours)</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" name="submit" class="btn btn-primary">Sign in</button>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10">
                        <span class="text-secondary">
                            Or Create an accout from
                            <a class="shadow btn btn-outline-info" href='signUp'>Here</a>
                        </span>
                    </div>
                </div>
            </form>
        </fieldset>
    </div>
</div>