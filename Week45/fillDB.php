<?php

namespace Week4;

include "lib/FirstLayerWriter.php";
include "lib/SecondLayerWriter.php";
include "lib/ThirdLayerWriter.php";

class WriterJsonToDB
{
    public function __construct()
    {
        $this->writerLinesToDB();
    }

    private function writerLinesToDB()
    {
        $this->description();
        $writer = new FirstLayerWriter();
        $writer = new SecondLayerWriter();
        $writer = new ThirdLayerWriter();
    }

    private function description()
    {
        echo "\033[1;32mCLASSES WORK DESCRIPTION:
\033[0;33mreaderJson();
writerLinesToDB(){
    FirstWriter create users,shops, products, categories tables
    SecondWriter create orders table
    ThirdWriter create order_product, product_category, order_category tables
}
    Writer consist of:
        variables
        getTable(optional)();
        dataCollector or foreign...Collector();
        queryExec();
\033[0;35mTable generating...
\033[0;36m";
    }


}

$w = new WriterJsonToDB();
