<?php declare (strict_types=1);

namespace App\DbConfig;

use PDO;
use PDOException;

class MySqli extends MainFn
{

    public function __construct(string $db_name = 'test')
    {
        parent::__construct($db_name);
    }

    protected function connect() : void
    {
        $dsn = 'mysql:host='. $this->host .';dbname='. $this->db_name .
        ';charset=utf8mb4';

        $opts = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_PERSISTENT => false,
        ];

        try {
            $this->con = new PDO($dsn, $this->user, $this->pass, $opts);
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            exit;
        }
    }
}