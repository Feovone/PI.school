<?php


namespace Week4;

include_once("TableWriter.php");

class ThirdLayerWriter extends TableWriter
{

    private array $temp = array(array(), array(), array());
    private array $queries = array("Insert into order_product (order_id, product_id) values",
        "Insert into product_category (product_id, category_id) values",
        "Insert into order_category (order_id, category_id) values");
    private array $templates;

    public function __construct()
    {
        parent::__construct();
        $this->templates = $this->queries;
        $this->writeDataToDB();
    }

    public function writeDataToDB()
    {
        $startTime = microtime(true);
        $productId = array();
        $categories = array();
        $this->getTable("SELECT category_id FROM categories",
            "SELECT category_id,name FROM categories WHERE category_id=",
            $categories);
        $this->getTable("SELECT product_id FROM products",
            "SELECT product_id,name FROM products WHERE product_id=", $productId);

        for ($i = 0; $i < $this->len; $i++) {
            $tempObj = json_decode($this->dbLines[$i]);
            foreach ($tempObj->products as $product) {
                $this->foreignProductCollector($product, $this->temp[0], $productId, $this->queries[0], $i, $this->templates[0]);
                $this->foreignCategoryCollector($product, $this->temp[1], $categories,
                    $this->queries[1], $i, $this->templates[1], $this->queries[2], $this->temp[2]);
            }
            $this->sendingRestriction($this->temp, $this->queries[2], $this->templates[2], $i);
        }

        foreach ($this->queries as $key => $query) {
            $this->queryExec($query);
        }
        echo "Third part: " . (microtime(true) - $startTime) . " sec\r\n";
    }


    private function foreignCategoryCollector($product, &$temp, $categoryId, &$query, $i, $template, &$queryDuo, &$tempDuo)
    {
        $categories = explode(',', $product->product_categories);
        $productName = addslashes($product->name);
        $pos = 0;
        if (!isset($temp[$productName])) {
            $temp[$productName] = array();
        }
        if (!isset($tempDuo[$i])) {
            $tempDuo[$i] = array();
        }
        foreach ($categories as $keyC => $category) {
            foreach ($categoryId as $key => $item) {
                if ($category == $item["name"]) {
                    $pos = $item["category_id"];
                    break;
                }
            }
            if (!in_array($category, $tempDuo[$i])) {
                $orderID = $i + 1;
                array_push($tempDuo[$i], $category);
                $queryDuo = $queryDuo . "('$orderID','$pos'),";
            }

            if (!in_array($category, $temp[$productName])) {

                $productId = mysqli_fetch_assoc($this->db->query("SELECT product_id FROM products WHERE products.name='$productName'"))["product_id"];
                $temp[$productName][$pos] = $category;
                $query = $query . "('$productId','$pos'),";

            }
        }
        $this->sendingRestriction($temp, $query, $template);

    }

    private function foreignProductCollector($product, &$temp, $productId, &$query, $i, $template)
    {
        $productName = addslashes($product->name);
        $pos = 0;
        if (!isset($temp[$i])) {
            $temp[$i] = array();
        }
        if (!in_array($productName, $temp[$i])) {
            foreach ($productId as $key => $item) {
                if ($productName == addslashes($item["name"])) {
                    $pos = $item["product_id"];
                    break;
                }
            }
            $temp[$i][$pos] = $productName;
            $orderID = $i + 1;
            $query = $query . "('$orderID'," . "'$pos'),";
            $this->sendingRestriction($temp, $query, $template);
        }

    }
}