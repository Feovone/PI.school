<?php
spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    $fn = $class . '.php';
    if (file_exists($fn)) require $fn;

});
spl_autoload_register(function ($class) {
    $fn = 'app/Controllers/' . $class . '.php';
    if (file_exists($fn)) require $fn;

});