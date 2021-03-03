<?php

use routers\Route;

return [
    new Route('POST','users', 'UserController', 'login'),
    new Route('POST','users', 'UserController', 'phoneLogin'),
    new Route('POST','users', 'UserController', 'phoneLoginCheck'),
    new Route('POST','users', 'UserController', 'signIn'),
    new Route('POST','users', 'UserController', 'index')
];