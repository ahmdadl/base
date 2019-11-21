<?php declare(strict_types=1);

namespace App\Models;

use App\DbConfig\MySqli;
use App\Util\Filter;

class Post
{
    private $con;
    
    private $tbName = 'posts';

    public $id;
    public $type;
    public $title;
    public $slug;
    public $body;
    public $img;
    public $created_at;
    public $updated_at;

    public function __construct(MySqli $db)
    {
        $this->con = $db->getConnection();
    }

    public function create () : bool
    {
        $stmt = 'INSERT INTO '. $this->tbName . ' (type, title, slug, body, img) VALUES (:t, :title, :s, :body, :i)';

        $sql = $this->con->prepare($stmt);

        $params = [
            ':t' => $this->type ?? false,
            ':title' => $this->title,
            ':s' => $this->slug,
            ':body' => $this->body,
            ':i' => $this->img
        ];

        return $sql->execute($params);
    }

    public function __set($name, $value)
    {
        $this->{$name} = Filter::filterStr($value);
    }
}