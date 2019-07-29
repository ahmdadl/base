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

    public function __construct(MySqli $con)
    {
        $this->con = $con->getConnection();
    }

    public function readAll()
    {
        $sql = 'SELECT * FROM '. $this->tbName;
        $stmt = $this->con->prepare($sql);
        $stmt->execute();

        return $stmt;
    }

}