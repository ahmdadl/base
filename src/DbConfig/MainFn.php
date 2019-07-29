<?php declare (strict_types=1);

namespace App\DbConfig;

use PDO;

abstract class MainFn
{
    protected $con;

    protected $db_name;

    protected $host = 'localhost';
    protected $user = 'root';
    protected $pass = '123';

    public function __construct(string $db_name = 'test')
    {
        $this->db_name = $db_name;
    }

    public function isLive() : bool
    {
        return ($this->con instanceof PDO);
    }

    public function getConnection()
    {
        if ($this->con === null) {
            $this->connect();
        }
        return $this->con;
    }

    abstract protected function connect() : void;

}