<?php declare (strict_types=1);

namespace DB\Model;

use App\DbConfig\MySqli;
use PDO;
use PDOStatement;

use App\Util\Password;

class UserModel
{
    /**
     * PDO instance
     *
     * @var PDO
     */
    private $con;

    private $tbName = 'users';

    /**
     * Entity properties
     *
     * @var tableRows
     */
    public $id;
    public $name;
    public $pass;
    public $admin;
    public $lastModified;

    public function __construct(MySqli $con)
    {
        $this->con = $con->getConnection();
    }

    public function readAll() : PDOStatement
    {
        $sql = 'SELECT id, `name`, `admin`, lastModified FROM '. $this->tbName;
        
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() : array
    {
        $sql = 'SELECT id, `name`, `admin`, lastModified FROM ' . $this->tbName .
        ' WHERE id = :id';

        $stmt = $this->con->prepare($sql);
        $params = [
            ':id' => $this->id
        ];
        $stmt->execute($params);

        return $stmt->fetch();
    }

    public function checkUser() : bool
    {
        $sql = "SELECT id, `name`, pass, `admin`, lastModified FROM ". $this->tbName .
        ' WHERE name = :name';

        $stmt = $this->con->prepare($sql);
        $stmt->execute([
            ':name' => $this->name,
        ]);
        $row = $stmt->fetch();

        // check if there is no match
        if (!$row) return false;

        // check if password matched with entered on
        if (Password::verify($this->pass, $row->pass)) {
            return true;
        }



        return false;
    }
}