<?php

namespace Week4;

include_once("TableWriter.php");

class FirstLayerWriter extends TableWriter
{
    private array $queries = array("Insert into users (first_name,last_name,email) values",
        "Insert into shops (name,domain) values",
        "Insert into products (name) values",
        "Insert into categories (name) values");
    private array $templates;
    private array $temp = array(array(), array(), array(), array());

    public function __construct()
    {
        parent::__construct();
        $this->templates = $this->queries;
        $this->writeDataToDB();
    }

    public function writeDataToDB()
    {
        $startTime = microtime(true);
        for ($i = 0; $i < $this->len; $i++) {
            $tempObj = json_decode($this->dbLines[$i]);
            $this->dataCollector($tempObj, "users", $this->queries[0], $this->temp[0], $this->templates[0]);
            $this->dataCollector($tempObj, "shops", $this->queries[1], $this->temp[1], $this->templates[1]);
            foreach ($tempObj->products as $product) {
                $this->dataCollector($tempObj, "products", $this->queries[2], $this->temp[2], $this->templates[2], $product);
                $this->dataCollector($tempObj, "categories", $this->queries[3], $this->temp[3], $this->templates[3], $product);
            }
        }
        foreach ($this->queries as $query) {
            $this->queryExec($query);
        }
        echo "First part: " . (microtime(true) - $startTime) . " sec\r\n";

    }
}