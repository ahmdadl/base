<?php $this->layout('layout', ['title' => 'logIn'])?>
<h1>
    <hr />
</h1>
<?php foreach ($session->getFlashBag()->all() as $type => $messages) : ?>   <?php foreach ($messages as $mess) : ?>
            <div class="alert alert-<?=$type?>">
                <?=$mess?>
            </div>
        <?php endforeach?>
<?php endforeach?>
<form action='/ft/public<?=$this->uri()?>' method='post' class='form pure-form pure-form-stacked'>
    <fieldset>
        <legend>LogIn</legend>
        <div class="pure-form-group <?=$nameReq ? 'error' : ''?>">
            <input type='text' name="name" placeholder="enter our name" value="<?=$userName ?? ''?>" />
            <span>
                <b><?=$nameReq ? 'name is required' : ''?></b>
            </span>
        </div>
        <div class="pure-form-group <?=$passReq ? 'error' : ''?>">
            <input type="password" name="pass" placeholder="enter your password" />
            <span>
                <b><?=$passReq ? 'password is required' : ''?></b>
            </span>
        </div>
        <?=$this->csrf()?>
        <?=$this->_method('post')?>
        <button type='submit' name='submit' class="pure pure-button pure-button-primary">LogIn</button>
    </fieldset>
</form>