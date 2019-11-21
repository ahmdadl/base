<?php declare (strict_types=1);

namespace App\Models;

use App\DbConfig\MySqli;

class Home
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

    public function getPosts() : array
    {
        $stmt = 'SELECT * FROM blog ORDER BY id DESC LIMIT 7';

        $sql = $this->con->prepare($stmt);
        $sql->execute();
        
        return $sql->fetchAll();
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
 
CREATE TABLE IF NOT EXISTS `blog`
(
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `type` BOOLEAN DEFAULT FALSE,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `body` TEXT NOT NULL,
    `img` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX (`slug`)
)DEFAULT CHARSET='utf8mb4'

*/