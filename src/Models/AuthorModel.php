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
    public $userSn;
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
        ' (userName, screenName, email, userPass) 
        VALUES (:uname, :sname, :email, :pass)';

        $stmt = $this->con->prepare($sql);

        $params = [
            ':uname' => $this->userName,
            ':sname' => $this->userSn,
            ':email' => $this->email,
            ':pass' => $this->userPass
        ];

        return ($stmt->execute($params));
    }

    public function readOne() : object
    {
        $sql = 'SELECT userId, userName, screenName, email, userPass 
        FROM '. $this->tbName . ' WHERE screenName = :sn';

        $stmt = $this->con->prepare($sql);

        $stmt->execute([':sn' => $this->userSn]);

        if ($stmt->rowCount() === 0) {
            return (object)['size' => 0];
        }

        return $stmt->fetch();
    }
}