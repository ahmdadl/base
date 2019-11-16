<?php $this->layout('layouts/base', [
    'title' => $title ?? '',
    'id' => $id ?? '',
    'navClass' => 'position-sticky'
]) ?>

<div class="mt-3">
    <?= $this->section('content') ?>
</div>