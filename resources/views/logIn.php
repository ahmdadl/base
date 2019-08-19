<?php $this->layout('layout', ['title' => 'logIn']) ?>

<div class="shadow-lg card text-dark bg-light mb-3 mx-auto logIn">
    <div class="card-header bg-primary text-white font-weight-bolder">Sign In</div>
    <div class="card-body">
        <fieldset class="card-text p-3">
            <form action="/fc/public<?=$this->e($this->uri())?>" method='POST' class="form needs-validation" novalidate>
                <div class="form-group row input-group">
                    <div class="input-group-prepend">
                        <label for="userEmail" class="input-group-text">Email</label>
                        <span class='input-group-text'>@</span>
                    </div>
                    <input type="email" class="form-control" id="userEmail" placeholder="Email" name='userEmail' required>
                </div>
                <div class="form-group row input-group">
                    <div class="input-group-prepend">
                        <label for="password" class="input-group-text ">Password</label>
                    </div>
                    <input type="password" class="form-control password" id="password" placeholder="Password" aria-describedby="showPass">
                    <div class="input-group-prepend">
                        <button type='button' class="btn btn-primary" id='showPass' name="userPass">
                            &Omega;
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
                <?= $this->_method('post') ?>
                <?= $this->csrf() ?>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" name="submit" class="btn btn-primary btn-r">Sign in</button>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <span class="text-secondary">
                            Or Create an accout from
                            <a class="shadow btn btn-outline-info btn-r" href='signUp'>Here</a>
                        </span>
                    </div>
                </div>
                <div class="form-group row">
                    <pre>
                        sn: abo3adel<br />
                        email: abo3adel35@gmail.com<br />
                        pass: asdsadsad<br />
                    </pre>
                </div>
            </form>
        </fieldset>
    </div>
</div>