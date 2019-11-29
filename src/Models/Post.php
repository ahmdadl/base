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

    public function __set($name, $value)
    {
        $this->{$name} = Filter::filterStr($value);
    }

    /**
     * create new post
     *
     * @return boolean
     */
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

    public function readAll() : array
    {
        $stmt = 'SELECT id, type, title, slug, body, img, created_at, updated_at FROM ' . $this->tbName .' ORDER BY id DESC';

        $sql = $this->con->prepare($stmt);

        $sql->execute();

        return $sql->fetchAll();
    }

    public function readBySlug()
    {
        $stmt = 'SELECT * FROM ' . $this->tbName . ' WHERE slug = :sg';

        $sql = $this->con->prepare($stmt);

        $sql->execute([':sg' => $this->slug]);

        return $sql->fetch();
    }

    public function categories(int $postId) : array
    {
        $stmt = 'SELECT id, title FROM categories WHERE id IN (SELECT catId FROM post_categoires WHERE postId = :pid)';

        $sql = $this->con->prepare($stmt);

        $sql->execute([':pid' => $postId]);

        return $sql->fetchAll();
    }

    public function findPosts(string $slug) : array
    {
        $stmt = 'SELECT * FROM '.$this->tbName.' WHERE slug LIKE :slug ORDER BY id DESC LIMIT 7';

        $sql = $this->con->prepare($stmt);

        $sql->execute([':slug' => '%'.$slug.'%']);

        return $sql->fetchAll();
    }

    public function pinnedPosts () : array
    {
        $stmt = 'SELECT * FROM ' . $this->tbName . ' WHERE pin = 0 ORDER BY id DESC LIMIT 4';

        $sql = $this->con->prepare($stmt);

        $sql->execute();

        return $sql->fetchAll();
    }

    public function getCommentCount(int $pid)
    {
        $stmt = 'SELECT COUNT(*) as c FROM comments WHERE postId = :pid';

        $sql = $this->con->prepare($stmt);

        $sql->execute([':pid' => $pid]);

        return ($sql->fetch())->c;
    }

    public function readOne(string $slug) : object
    {
        $stmt = 'SELECT * FROM ' . $this->tbName. ' WHERE slug = :sp';

        $sql = $this->con->prepare($stmt);

        $sql->execute([':sp' => $slug]);

        return $sql->fetch();
    }
}