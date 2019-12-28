<?php declare(strict_types=1);

namespace App\Models;

use App\DbConfig\MySqli;

class Category
{
    private $con;
    
    private $tbName = 'categories';

    public $id;
    public $title;
    public $created_at;
    public $updated_at;

    public function __construct(MySqli $db)
    {
        $this->con = $db->getConnection();
    }

    public function create(string $title) : bool
    {
        $stmt = 'INSERT INTO ' . $this->tbName . ' (title) 
        VALUES (:t)';

        $sql = $this->con->prepare($stmt);

        return $sql->execute([':t' => $title]);
    }

    public function readAll() : array
    {
        $stmt = 'SELECT id, title FROM '. $this->tbName;

        $sql = $this->con->prepare($stmt);

        $sql->execute();

        return $sql->fetchAll();
    }

    public function countPosts(int $cid) : int
    {
        $stmt = 'SELECT COUNT(*) AS c FROM post_categoires WHERE catId = :cid';

        $sql = $this->con->prepare($stmt);

        $sql->execute(['cid' => $cid]);

        return ($sql->fetch())->c;
    }

    public function loadPosts(int $id) : array
    {
        $stmt = 'SELECT * FROM posts AS p 
        JOIN post_categoires AS pc ON pc.catId = 2 AND pc.postId = p.id';

        $sql = $this->con->prepare($stmt);

        $sql->execute();

        return $sql->fetchAll();
    }

    public function insertCategories($postId, array $cats)
    {
        $values = '';
        $params = [];

        foreach ($cats as $c) {
            $values .= '(?, ?), ';
            $params[] = $postId;
            $params[] = $c;
        }

        $values = rtrim($values, ", ");

        $stmt = 'INSERT INTO post_categoires (postId, catId) 
        VALUES ' . $values . '';

        $sql = $this->con->prepare($stmt);

        return $sql->execute($params);
    }
}