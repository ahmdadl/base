<?php declare(strict_types=1);

namespace App\Models;

use App\DbConfig\MySqli;

class Category
{
    private $con;
    
    private $tbName = 'categories';

    public $id;
    public $title;
    public $created_at;
    public $updated_at;

    public function __construct(MySqli $db)
    {
        $this->con = $db->getConnection();
    }
}