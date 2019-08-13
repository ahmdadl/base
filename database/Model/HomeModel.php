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

    public function createOne() : bool
    {
        $sql = 'INSERT INTO '. $this->tbName . '(text, authorID)
        VALUES (:text, :aid)';

        $stmt = $this->con->prepare($sql);
        $params = [
            ':text' => $this->text,
            ':aid' => $this->authorID,
        ];
        
        return ($stmt->execute($params)) ? true : false;
    }

    public function readAll() : array
    {
        $sql = 'SELECT j.id, u.name AS userName, j.text, CONCAT(DATEDIFF(NOW(), j.updatedAt), \' days\') AS lastUpdate FROM jokes AS j 
        JOIN users AS u ON u.id = j.authorID';
        $stmt = $this->con->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function readOne() : object
    {
        $sql = 'SELECT id, `text`, authorID FROM ' . $this->tbName .' 
        WHERE id = :id';

        $stmt = $this->con->prepare($sql);
        $stmt->execute([':id' => $this->id]);

        return $stmt->fetch();
    }

    public function update() : bool
    {
        $sql = 'UPDATE ' . $this->tbName . ' 
        SET `text` = :te, authorID = :aid 
        WHERE id = :jid';
        
        $stmt = $this->con->prepare($sql);
        $params = [
            ':te' => $this->text,
            ':aid' => $this->authorID,
            ':jid' => $this->id,
        ];

        return $stmt->execute($params);
    }

    public function delete() : bool
    {
        $sql = 'DELETE FROM ' . $this->tbName .
        ' WHERE id = :id';

        $stmt = $this->con->prepare($sql);
        
        return ($stmt->execute([':id' => $this->id]));
    }

}