<?php declare (strict_types=1);

namespace App\Models;

use App\DbConfig\MySqli;

class HomeModel
{
    /**
     * PDO instance
     *
     * @var PDO
     */
    private $con;

    private $tbName = 'emails';

    public $id;
    public $text;
    public $createdAt;
    public $updatedAt;
    public $authorID;

    public function __construct(MySqli $con)
    {
        $this->con = $con->getConnection();
    }

    public function create(object $email) : bool
    {
        $stmt = 'INSERT INTO ' . $this->tbName . ' (name, email, message) VALUES (:na, :em, :mess)';

        $sql = $this->con->prepare($stmt);

        $params = [
            ':na' => $email->name,
            ':em' => $email->email,
            ':mess' => $email->message 
        ];

        return $sql->execute($params) ? true : false;
    }

}

/**
 * CREATE TABLE IF NOT EXISTS `emails`
(
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(120) NOT NULL,
    `email` VARCHAR(255) NOT NUlL,
    `message` TEXT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)DEFAULT CHARSET='utf8mb4'
 */