<?php

namespace Week4;
require_once "DataBase.php";

class TableWriter
{
    protected $db;
    protected array $dbLines;
    protected int $len;

    public function __construct()
    {
        $this->db = DataBase::getInstance();
        $this->readerJson();
        $this->len = count($this->dbLines);
    }

    private function readerJson()
    {
        $this->dbLines = file('purchase_log.json');
    }

    protected function getTable($numberOfRowQuery, $query, &$outputArray)
    {
        $numberOfRow = mysqli_num_rows($this->db->query($numberOfRowQuery));
        $i = 1;
        while ($i <= $numberOfRow) {
            $row = mysqli_fetch_assoc($this->db->query($query . $i));
            array_push($outputArray, $row);
            ++$i;
        }
    }

    protected function dataCollector($tempObj, $writer, &$query, &$temp, $template, $product = null)
    {
        switch ($writer) {
            case "users":
                $email = $tempObj->user_email;
                if (!in_array($email, $temp)) {
                    array_push($temp, $email);
                    $first_name = addslashes($tempObj->user_first_name);
                    $last_name = addslashes($tempObj->user_last_name);
                    $query = $query . "('$first_name'," . "'$last_name'," . "'$email'),";
                    $this->sendingRestriction($temp, $query, $template);
                }
                break;
            case "shops":
                $name = $tempObj->shop_name;
                if (!in_array($name, $temp)) {
                    array_push($temp, $name);
                    $domain = $tempObj->shop_domain;
                    $query = $query . "('$name'," . "'$domain'),";
                    $this->sendingRestriction($temp, $query, $template);
                }
                break;
            case "categories":
                $categories = explode(',', $product->product_categories);
                foreach ($categories as $category) {
                    if (!in_array($category, $temp)) {
                        array_push($temp, $category);
                        $query = $query . "('$category'),";
                    }
                }
                break;
            case "products":
                $name = addslashes($product->name);
                if (!in_array($name, $temp)) {
                    array_push($temp, $name);
                    $query = $query . "('$name'),";
                    $this->sendingRestriction($temp, $query, $template);
                }
                break;
            case "orders":
                $sum = $tempObj->sum;
                $email = $tempObj->user_email;
                $date = $tempObj->date;
                $shopName = $tempObj->shop_name;
                $userId = mysqli_fetch_assoc($this->db->query("SELECT user_id FROM users WHERE users.email='$email'"));
                $shopId = mysqli_fetch_assoc($this->db->query("SELECT shop_id FROM shops WHERE shops.name='$shopName'"));
                $query = $query . "('$sum'," . "'$date'," . "'$userId[user_id]'," . "'$shopId[shop_id]'),";

        }
    }

    protected function sendingRestriction(&$temp, &$query, $template, $i = null,$count=3000)
    {
        if ($i != null && ($i + 1) % $count == 0) {
            $this->queryExec($query);
            $query = $template;
        } elseif (count($temp) % 8000 == 0 &&$count==3000) {
            $this->queryExec($query);
            $query = $template;
        }
    }

    protected function queryExec($query)
    {
        $query = mb_substr($query, 0, -1);
        $this->db->query($query);
    }
}