<?php $this->layout('layout', ['title' => 'Add new Joke'])?>
<h1>
    <hr>
</h1>
<?php if ($fine):?>
    <div class="pure-alert" style='padding:15px 30px;background: teal;color: #fff;'>
        <b>Joke Saved</b>
    </div>
<?php endif ?>
<form action="/ft/public<?=$this->es($this->uri())?>" method="post" class="form pure-form pure-form-stacked">
    <fieldset>
        <legend>Add new Joke</legend>
        <input id="text" type='text' name="text" placeholder="Write Joke ..." value="<?=$joke->text ?? ''?>" />
        <select name="authorID">
            <optgroup label="Select Joke Author">
            <?php foreach ($users as $user): ?>
                <option value="<?=$hashid->encode($user->id)?>" 
                <?php if (isset($joke) && $joke->authorID === $user->id) echo 'selected';?>>
                    <?=$this->es($user->name)?>
                </option>
            <?php endforeach; ?>
            </optgroup>
        </select>
        <?=$this->csrf()?>
        <?=$this->_method()?>
        <button type="submit" name="submit" class="pure-button pure-button-primary">Save</button>
    </fieldset>
</form>

