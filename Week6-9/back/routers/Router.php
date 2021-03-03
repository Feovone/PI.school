<?php

namespace routers;

require_once "autoload.php";

class Router
{
    static function start()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $url = substr($_SERVER['REQUEST_URI'], 1);
        $routes = require 'routes.php';
        $urlData = getFormData($method);
        $actionName = actionSpreader($method, $urlData);
        foreach ($routes as $route) {
            if ($route->url == $url && $route->action == $actionName && $route->method == $method) {
                $controllerName = "app\Controllers\\" . $route->controller;
                if (class_exists($controllerName)) {
                    $controller = new $controllerName;
                    if (method_exists($controller, $actionName)) {
                        $controller->$actionName($urlData);
                    } else {
                        Router::ErrorRequest("This action not found");
                    }
                }else {
                    Router::ErrorRequest("This controller not found");
                }
            }
        }
    }

    static function ErrorRequest($error)
    {
        echo json_encode(array(
            'Error 404' => $error));
        //http_response_code(404);
        die();
    }
}

function actionSpreader($method, $urlData)
{
    if ($method == "POST") {
        if (count($urlData) == 1 && isset($urlData["number"])) {
            return 'phoneLoginCheck';
        }
        if (count($urlData) == 2 && isset($urlData["number"]) && isset($urlData["code"])) {
            return 'phoneLogin';
        }
        if (count($urlData) == 2 && isset($urlData["email"]) && isset($urlData["pass"])) {
            return 'login';
        }
        if (count($urlData) == 4 && isset($urlData["first_name"]) && isset($urlData["last_name"])
            && isset($urlData["email"]) && isset($urlData["pass"])) {
            return 'signIn';
        }
    }
    if ($method == "GET") {
        Router::ErrorRequest("This API doesn't support GET requests yet");
    }
    Router::ErrorRequest("This action not found");
}

function getFormData($method)
{
    $data = json_decode(file_get_contents('php://input'), true);
    return $data;
}


