<?php $this->layout('layout', ['title' => $post->title])?>

<div class="row">
<div class="card col-sm-11 col-md-9 shadow-lg bg-light p-0">
  <img src="assets/img/1.jpeg" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title"><?=$post->title?></h5>
    <p class="card-text"><?=$post->content?></p>
    <?php if ($session->has('logIn')
    && $session->get('userId') === $post->userId) : ?>
        <a href="p/<?=$hashid->encode($post->postId)?>/edit" class="btn btn-info btn-r mb-3">Edit</a>
        <form action="p/<?=$hashid->encode($post->postId)?>/delete" method='post'>
            <input type="hidden" name="postId" value="<?=$hashid->encode($post->postId)?>" />
            <button type='submit' class="btn btn-danger btn-r">Delete</button>
            <?=$this->_method('delete')?>
            <?=$this->csrf()?>
        </form>
    <?php endif?>
  </div>
</div>
</div>

