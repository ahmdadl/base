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

    // public function __set($name, $value)
    // {
    //     $this->{$name} = Filter::filterStr($value);
    // }

    public function save ()
    {
        $stmt = 'INSERT INTO ' . $this->tbName . ' (postId, name, email, body) VALUES (:pid, :name, :email, :body)';

        $sql = $this->con->prepare($stmt);

        $params = [
            ':pid' => 1,
            ':name' => $this->name,
            ':email' => $this->email,
            ':body' => $this->body
        ];

        return ($sql->execute($params));
    }
}