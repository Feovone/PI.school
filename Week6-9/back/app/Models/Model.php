<?php


namespace App\Models;

use database\DataBase as DB;
use database\QueryBuilder as QB;

require_once "autoload.php";

class Model
{
    protected $db = null;
    public $qb = null;

    public function __construct()
    {
        $this->db = DB::getInstance();
        $this->qb = QB::getInstance();
    }

    public function getData($query)
    {
    }
}