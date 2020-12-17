<?php


namespace Week4;

include_once("TableWriter.php");

class SecondLayerWriter extends TableWriter
{
    private string $query = "Insert into orders (sum,date,user_id,shop_id) values";
    private string $template;
    private array $temp = array();

    public function __construct()
    {
        parent::__construct();
        $this->template = $this->query;
        $this->writeDataToDB();
    }

    public function writeDataToDB()
    {
        $startTime = microtime(true);
        for ($i = 0; $i < $this->len; $i++) {
            $tempObj = json_decode($this->dbLines[$i]);
            $this->dataCollector($tempObj, "orders", $this->query, $this->temp, $this->template);
            $this->sendingRestriction($this->temp, $this->query, $this->template,$i,5000);
        }
        $this->queryExec($this->query);
        echo "Second part: " . (microtime(true) - $startTime) . " sec\r\n";
    }
}