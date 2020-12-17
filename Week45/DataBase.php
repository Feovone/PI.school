<?php
namespace Week4;

include "config.php";
class DataBase
{
    private static $instance = null;
    private $mysqli;
    private $user = DBUSER;
    private $pass = DBPWD;
    private $dbName = DBNAME;
    private $dbHost = DBHOST;

    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }
    protected function __construct()
    {
        $this->mysqli = new \mysqli($this->dbHost, $this->user, $this->pass,$this->dbName );
        $this->mysqli->query("SET lc_time_names = 'ru_UA'");
        $this->mysqli->query("SET NAMES 'utf8'");
    }
    public function query($query){
        $temp = mysqli_query($this->mysqli,$query);
        echo $this->mysqli->error;
        if(stristr($query,"SELECT")){return $temp;}
    }
        public function __clone() {
            trigger_error('Clone is not allowed.', E_USER_ERROR);
        }
        public function __wakeup() {
            trigger_error('Deserializing is not allowed.', E_USER_ERROR);
        }

    public function __destruct()
    {
        if ($this->mysqli) $this->mysqli->close();
    }
}


