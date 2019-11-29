<?php declare(strict_types=1);

namespace App\Models;

use App\DbConfig\MySqli;

class Admin
{
    private $con;
    
    private $tbName = 'users';

    public $id;
    public $name;
    public $email;
    public $password;
    public $rememberToken;

    public function __construct(MySqli $db)
    {
        $this->con = $db->getConnection();
    }

    public function __set($name, $value)
    {
        $this->{$name} = Filter::filterStr($value);
    }

    public function checkUser()
    {
        $stmt = 'SELECT * FROM ' . $this->tbName . ' WHERE email = :email';

        $sql = $this->con->prepare($stmt);

        $sql->execute([':email' => $this->email]);

        return $sql->fetch();
    }

    
}