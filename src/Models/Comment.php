<?php declare(strict_types=1);

namespace App\Models;

class Comment
{
    private $con;

    private $tbName = 'comments';

    public $id;
    public $postId;
    public $name;
    public $email;
    public $body;
    public $created_at;
}