<?php $this->layout('layouts/base', [
    'title' => $title ?? '',
    'id' => $id ?? '',
    'navClass' => 'position-sticky',
    'component' => $component ?? ''
]) ?>

<div class="mt-3">
    <<?= $component ?>>
        <template v-slot:default="h">
            <?= $this->section('content') ?>
        </template>
    </<?= $component ?>>
</div>