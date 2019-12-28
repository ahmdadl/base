<?php declare(strict_types=1);

namespace App\Controllers;

use App\Models\Category;
use App\Models\Post;

trait ViewData
{
    public function vd($posts, Post $postModel, Category $catModel) : array
    {
        return [
            'posts' => $posts,
            'model' => $postModel,
            'pinned' => $postModel->pinnedPosts(),
            'cats' => $catModel->readAll(),
            'catModel' => $catModel
        ];
    }
}