<?php $this->layout('layout', ['title' => 'Add new Joke'])?>
<h1>
    <hr>
</h1>
<?php if ($fine):?>
    <div class="pure-alert">
        <b>Joke Saved</b>
    </div>
<?php endif ?>
<form action="/ft/public/addNew" method="post" class="form pure-form pure-form-stacked">
    <fieldset>
        <legend>Add new Joke</legend>
    
        <!-- <label for="text">Joke Text</label> -->
        <input id="text" type='text' name="text" placeholder="Write Joke ..." />
        <select name="author">
            <optgroup label="Select Joke Author">
            <?php foreach ($users->fetchAll() as $user): ?>
                <option value="<?=$this->e($user->id)?>">
                    <?=$this->es($user->name)?>
                </option>
            <?php endforeach; ?>
            </optgroup>
        </select>
        <button type="submit" name="submit" class="pure-button pure-button-primary">Save</button>
    </fieldset>
</form>

