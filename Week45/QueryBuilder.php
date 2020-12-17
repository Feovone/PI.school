<?php

namespace week4;
include_once "DataBase.php";
class ss
{
    public static $instanse = [];
    static string  $query  ="";
    private static $from = "";
    private static $db;
    public function __construct()
    {
        self::$db = DataBase::getInstance();
    }

    public static function getInstance()
    {
        if (!self::$instanse instanceof self) {
            self::$instanse = new self;
        }
        return self::$instanse;
    }

    public static function select($columns)
    {
        self::$query="";
        if( gettype($columns)=="array")
        {
            self::$query .= "SELECT ";
            foreach ($columns as $item){
                self::$query .= $item.", ";
            }
            self::$query =mb_substr(self::$query, 0, -2)." ";
            return self::getInstance();
        }
        self::$query .= "SELECT " . $columns. " ";
        return self::getInstance();
    }

    public function from($table)
    {
        self::$query .= "FROM ".$table. " ";
        self::$from = $table;
        return self::getInstance();
    }
    public function where($col,$sign,$value)
    {
        self::$query .= "WHERE ".$col.$sign."'$value' ";

        return self::getInstance();
    }
    public function andWhere($col,$sign,$value)
    {
        self::$query .= "and ".$col.$sign."'$value' ";

        return self::getInstance();
    }
    public function orWhere($col,$sign,$value)
    {
        self::$query .= "or ".$col.$sign."'$value' ";

        return self::getInstance();
    }
    public function groupBy($columns){
        if( gettype($columns)=="array")
        {
            self::$query .= "GROUP BY ";
            foreach ($columns as $item){
                self::$query .= $item.", ";
            }
            self::$query =mb_substr(self::$query, 0, -2)." ";
            return self::getInstance();
        }
        self::$query .= "GROUP BY  " . $columns. " ";
        return self::getInstance();
    }

    public function exec(){
        $link = mysqli_connect("localhost", "root", "", "shops_db");
        $result = mysqli_query($link, self::$query);
        $i = 1;
        $outputArray=array();
        while (null !== ( $row=mysqli_fetch_array($result, MYSQLI_ASSOC))) {
            $outputArray[$i]=$row;
            ++$i;
        }
        return $outputArray;
    }
}


$query1 =ss::select(array('user_id','count(email)'))->from('users')->where('user_id','<','5')->groupBy('user_id')->exec();
$query2 = ss::select($query1);
ss::create();
$w = new ss();