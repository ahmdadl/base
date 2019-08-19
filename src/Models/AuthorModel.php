<?php declare(strict_types = 1);

namespace App\Models;

use App\DbConfig\MySqli;

class AuthorModel extends BaseModel
{
    /**
     * PDO Instance
     *
     * @var PDO
     */
    private $con;

    private $tbName = 'author';

    /**
     * model entitis
     */
    public $userID;
    public $userName;
    public $screenName;
    public $email;
    public $userPass;
    public $permission;

    public function __construct(MySqli $db)
    {
        $this->con = $db->getConnection();
    }

    public function createOne() : bool
    {
        $sql = 'INSERT INTO ' . $this->tbName .
        ' (userName, screenName, email, userPass, permission) 
        VALUES (:uname, :sname, :email, :pass, :perm)';

        $stmt = $this->con->prepare($sql);

        $params = [
            ':uname' => $this->userName,
            ':sname' => $this->screenName,
            ':email' => $this->email,
            ':pass' => $this->userPass,
            ':perm' => $this->permission
        ];

        return ($stmt->execute($params));
    }
}