<?php
session_start();
$data = json_decode(file_get_contents("php://input"));
if ($data->action === "getSession") {
    $_SESSION['first_name'] = $data->first_name;
    $_SESSION['last_name'] = $data->last_name;
} else {
    Setcookie(COOKIE_NAME, "", time() - 3600, "/");
    session_unset();
    session_destroy();
}
