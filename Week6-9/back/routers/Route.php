<?php


namespace routers;


class Route
{
    private $method;
    private $url;
    private $controller;
    private $action;


    public function __construct($method,$url,$controller, $action )
    {
        $this->method = $method;
        $this->url = $url;
        $this->controller = $controller;
        $this->action = $action;
    }

    public function __get($property)
    {
        return $this->$property;
    }
}