<?php

namespace database;

include "config.php";

class DataBase
{
    private static $instance = null;
    private $mysqli;

    public $lastError = null;

    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    protected function __construct()
    {
        $config = require "config.php";
        $this->mysqli = mysqli_connect($config['host'], $config['user'], $config['pass'], $config['name']);
        $this->mysqli->query("SET lc_time_names = 'ru_UA'");
        $this->mysqli->query("SET NAMES 'utf8'");
    }

    public function query($query)
    {
        $this->lastError=null;
        $temp = mysqli_query($this->mysqli, $query);
        if ($this->mysqli->error != null) {
            $this->lastError = $this->mysqli->error;
        } elseif (stristr($query, "SELECT")){
            return $temp;
        }
    }

    public function __clone()
    {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    public function __wakeup()
    {
        trigger_error('Deserializing is not allowed.', E_USER_ERROR);
    }

    public function __destruct()
    {
        if ($this->mysqli) $this->mysqli->close();
    }
}


