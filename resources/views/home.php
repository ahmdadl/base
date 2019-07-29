<?php $this->layout('layout', ['title' => 'Home Page']);?>

<h1><?=$this->es($name)?></h1>
<?php $this->start('list') ?>
    <ul>
        <li>at</li>
        <li>section</li>
    </ul>
<?php $this->stop('list') ?>