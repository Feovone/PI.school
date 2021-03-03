<?php


namespace App\Controllers;


use App\Models\User;
use routers\Router;

class UserController extends Controller
{
    public function login($urlData)
    {
        try {
            $email = $urlData["email"];
            $user = new User();
            $response = $user->getData($email);
            if (empty($response)) {
                throw new \Exception("This Email not defined");
            }
            $pass = $urlData["pass"];
            if (password_verify($pass, $response[1]["password"]) != 1) {
                throw new \Exception("Incorrect password");
            }
            echo json_encode(array(
                'first_name' => $response[1]["first_name"],
                'last_name' => $response[1]["last_name"],
                'status' => 'ok'
            ));
        } catch (\Exception $e) {
            Router::ErrorRequest($e->getMessage());
        }
    }

    public function phoneLogin($urlData)
    {
        $user = new User();
        $response = $user->getData(null, $urlData['number']);
        if ($urlData["code"] == "123456") {
            echo json_encode(array(
                'first_name' => $response[1]["first_name"],
                'last_name' =>$response[1]["last_name"],
                'status' => 'ok'
            ));
        } else {
            Router::ErrorRequest("Incorrect code");
        }
    }

    public function phoneLoginCheck($urlData)
    {
        $user = new User();
        $response=$user->getData(null, $urlData['number']);
        if (empty($response)) {
            Router::ErrorRequest("This is an unknown number ");
        }
        echo json_encode(array(
            'status' => 'ok'
        ));
    }

    public function signIn($urlData)
    {
        $user = new User();
        $number = rand(1000000001, 9999999999);
        $response=$user->setData($urlData["first_name"], $urlData["last_name"], $urlData["email"], password_hash($urlData["pass"]
            , PASSWORD_DEFAULT), $number);
        if ($response != null) {
            Router::ErrorRequest($response);
        } else {
            echo json_encode(array(
                'status' => 'ok'
            ));
        }
    }

    public function index()
    {
        echo "INDEX page";
    }
}