<?php $this->layout('layout', ['title' => 'Add new Joke'])?>
<h1>
    <hr>
</h1>
<form action="/ft/public/addNew" method="post" class="form pure-form pure-form-stacked">
    <fieldset>
        <legend>Add new Joke</legend>
    
        <!-- <label for="text">Joke Text</label> -->
        <input id="text" type='text' name="text" placeholder="Write Joke ..." />
        <select name="author">
            <option>Select Author</option>
            <option value="0">abo3adel35</option>
            <option value="1">someoneElse</option>
        </select>
        <button type="submit" name="submit" class="pure-button pure-button-primary">Save</button>
    </fieldset>
</form>

