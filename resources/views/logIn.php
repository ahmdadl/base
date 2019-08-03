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
        <input type='text' name="name" placeholder="enter our name" value="<?=$userName ?? ''?>" />
        <?php if (isset($nameReq) && $nameReq) echo 'name is required';?>
        <input type="password" name="pass" placeholder="enter your password" />
        <?php if (isset($passReq) && $passReq) echo 'password is required';?>
        <?=$this->csrf($this->uri())?>
        <?=$this->_method('post')?>
        <button type='submit' name='submit' class="pure pure-button pure-button-primary">LogIn</button>
    </fieldset>
</form>