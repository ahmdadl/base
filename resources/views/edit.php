<?php $this->layout('layout', ['title' => 'edit '])?>

<?php foreach ($session->getAllFlash() as $type => $messages) : ?>
    <?php foreach ($messages as $mess) : ?>
        <div class="alert alert-<?=$type?>">
            <?=$mess?>
        </div>
    <?php endforeach ?>
<?php endforeach ?>

<fieldset>
    <legend>Edit Form</legend>
    <form class="form form-horizontal needs-validation <?=$wasValid?>" action="/fc/public<?=$this->uri()?>" method='POST' novalidate>
        <div class="form-group row">
            <label for='title' class="col-sm-2 col-form-label">
                Name
            </label>
            <div class="col-sm-10">
                <input type='text' name="title" id='title' class="form-control" placeholder="Post Title" value="<?=$post->title?>" maxlength="25" required />
            </div>
        </div>
        <div class="form-group row">
            <label for='content' class="col-sm-2 col-form-label">
                Content
            </label>
            <div class="col-sm-10">
                <textarea name="content" id='content' class="form-control" placeholder="Post content" maxlength="250" required>
                    <?=$post->content?>
                </textarea>
            </div>
        </div>
        <?=$this->_method('PUT')?>
        <?=$this->csrf()?>
        <div class="form-group">
            <button type='submit' class="btn btn-primary btn-r btn-lg" name="submitEdit">Save</button>
        </div>
    </form>
</fieldset>