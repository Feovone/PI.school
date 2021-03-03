<?php

namespace database;
include_once "DataBase.php";

class QueryBuilder
{
    public static $instanse = [];
    public string  $query = "";
    private static $from = "";
    private $db;

    public function __construct()
    {
        $this->db = DataBase::getInstance();
    }

    public static function getInstance()
    {
        if (!self::$instanse instanceof self) {
            self::$instanse = new self;
        }
        return self::$instanse;
    }

    public function select($columns)
    {
        $this->query = "";
        if (gettype($columns) == "array") {
            $this->query .= "SELECT ";
            foreach ($columns as $item) {
                $this->query .= $item . ", ";
            }
            $this->query = mb_substr($this->query, 0, -2) . " ";
            return self::getInstance();
        }
        $this->query .= "SELECT " . $columns . " ";
        return self::getInstance();
    }

    public function insert($table, $columns = "")
    {
        $this->query = "";
        if (gettype($columns) == "array") {
            $this->query .= "INSERT INTO $table (";
            foreach ($columns as $elem) {
                $this->query .= $elem . ", ";
            }
            $this->query = mb_substr($this->query, 0, -2) . ") ";
            return self::getInstance();
        }
        $this->query .= "INSERT INTO $table ";
        return self::getInstance();
    }

    public function values($columns)
    {
        if (gettype($columns) == "array") {
            $this->query .= "VALUES (";
            foreach ($columns as $column) {
                if (gettype($column) == "array") {
                    foreach ($column as $elem) {
                        $this->query .= "'$elem', ";
                    }
                    $this->query .= "), ";
                } else {
                    $this->query .="'$column', ";
                }
            }
            $this->query = mb_substr($this->query, 0, -2) . ") ";
        }
        return self::getInstance();
    }

    public function from($table)
    {
        $this->query .= "FROM " . $table . " ";
        self::$from = $table;
        return self::getInstance();
    }

    public function where($col, $sign, $value)
    {
        $this->query .= "WHERE " . $col . " " . $sign . " '$value' ";

        return self::getInstance();
    }

    public function andWhere($col, $sign, $value)
    {
        $this->query .= "and " . $col . $sign . "'$value' ";

        return self::getInstance();
    }

    public function orWhere($col, $sign, $value)
    {
        $this->query .= "or " . $col . $sign . "'$value' ";

        return self::getInstance();
    }

    public function groupBy($columns)
    {
        if (gettype($columns) == "array") {
            $this->query .= "GROUP BY ";
            foreach ($columns as $item) {
                $this->query .= $item . ", ";
            }
            $this->query = mb_substr($this->query, 0, -2) . " ";
            return self::getInstance();
        }
        $this->query .= "GROUP BY  " . $columns . " ";
        return self::getInstance();
    }

    public function exec()
    {
        $result = $this->db->query($this->query);
        if ($this->db->lastError == null && (stristr($this->query, "SELECT"))) {
            $i = 1;
            $outputArray = array();
            while (null !== ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))) {
                $outputArray[$i] = $row;
                ++$i;
            }
            return $outputArray;
        }else{
            return $this->db->lastError;
        }
    }
}