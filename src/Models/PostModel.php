<?php declare(strict_types = 1);

namespace App\Models;

use App\DbConfig\MySqli;

class PostModel extends BaseModel
{
    /**
     * PDO instance
     *
     * @var PDO
     */
    private $con;

    private $tbName = 'posts';

    public $postId;
    public $authorId;
    public $title;
    public $content;
    public $createdAt;
    public $updatedAt;

    public function __construct(MySqli $db)
    {
        $this->con = $db->getConnection();
    }

    public function readAll() : array
    {
        $sql = 'SELECT p.postId, a.userId, a.userName, p.title, 
        (
            SELECT GROUP_CONCAT(c.content) FROM category AS c WHERE c.catID IN (
            SELECT pc.catID FROM postcats AS pc WHERE pc.postID = p.postId 
            )
        ) AS allCats,
                SUBSTR(p.content, 1, 150) AS postContent, 
                TIME_FORMAT(TIMEDIFF(NOW(), updatedAt), "%H Hrs %i Min") AS updatedAt 
                FROM '. $this->tbName .' AS p 
                JOIN author AS a ON p.authorId = a.userId';

        $stmt = $this->con->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function readOne() : object
    {
        $sql = 'SELECT p.postId, a.userId, a.userName, p.title, p.content, p.createdAt, p.updatedAt FROM '.$this->tbName . ' AS p JOIN author AS a ON p.authorId = a.userId WHERE p.postId = :pid';

        $stmt = $this->con->prepare($sql);

        $stmt->execute([':pid' => $this->postId]);

        return $stmt->fetch();
    }

    public function updatePost() : bool
    {
        $sql = 'UPDATE '. $this->tbName . ' SET 
        title = :title, content = :cont, updatedAt = NOW() 
        WHERE postId = :pid';

        $stmt = $this->con->prepare($sql);

        $param = [
            ':title' => $this->title,
            ':cont' => $this->content,
            ':pid' => $this->postId
        ];

        return ($stmt->execute($param));
    }

    public function deleteOne()  : bool
    {
        $sql = 'DELETE FROM ' . $this->tbName . ' WHERE postId = :pid';

        $stmt = $this->con->prepare($sql);

        return ($stmt->execute(['pid' => $this->postId]));
    }
}
