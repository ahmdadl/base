<?php declare (strict_types=1);

namespace DB\Model;

use App\DbConfig\MySqli;

class HomeModel
{
    /**
     * PDO instance
     *
     * @var PDO
     */
    private $con;

    private $tbName = 'jokes';

    public $id;
    public $text;
    public $createdAt;
    public $updatedAt;
    public $authorID;

    public function __construct(MySqli $con)
    {
        $this->con = $con->getConnection();
    }

    public function readAll() : object
    {
        $sql = 'SELECT * FROM '. $this->tbName;
        $stmt = $this->con->prepare($sql);
        $stmt->execute();

        return $stmt;
    }

    public function creatOne() : bool
    {
        $sql = 'INSERT INTO '. $this->tbName . '(text, authorID)
        VALUES (:text, :aid)';

        $stmt = $this->con->prepare($sql);
        $params = [
            ':text' => $this->text,
            ':aid' => $this->authorID,
        ];
        
        return ($stmt->execute()) ? true : false;
    }

}