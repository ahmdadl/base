<?php declare(strict_types=1);

namespace App\Models;

use App\DbConfig\MySqli;

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

    public function __construct (MySqli $db)
    {
        $this->con = $db->getConnection();
    }

    public function __set($name, $value)
    {
        $this->{$name} = Filter::filterStr($value);
    }

    public function readAll () : array
    {
        $stmt = 'SELECT id, name, email, body, created_at FROM '. $this->tbName . ' WHERE postId = :pid';

        $sql = $this->con->prepare($stmt);

        $sql->execute(['pid' => $this->postId]);

        return $sql->fetchAll();
    }

    public function save ()
    {
        $stmt = 'INSERT INTO ' . $this->tbName . ' (postId, name, email, body) VALUES (:pid, :name, :email, :body)';

        $sql = $this->con->prepare($stmt);

        $params = [
            ':pid' => $this->postId,
            ':name' => $this->name,
            ':email' => $this->email,
            ':body' => $this->body
        ];

        $sql->execute($params);

        return $this->con->lastInsertId();
    }
}