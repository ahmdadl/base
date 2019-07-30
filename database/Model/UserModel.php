<?php declare (strict_types=1);

namespace DB\Model;

use App\DbConfig\MySqli;
use PDO;
use PDOStatement;

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
}