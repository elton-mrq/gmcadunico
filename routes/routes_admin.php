<?php

use App\Http\Response;
use App\Controller\Admin;
use App\Controller\Admin\LoginController;

//ROTA DA HOME ADMIN
$obRouter->get('/admin', [
    'middlewares'    => [
        'require-admin-login'
    ],
    function(){
        return new Response(200,'Admin :)');
    }
]);

//ROTA DE LOGIN
$obRouter->get('/admin/login', [
    'middlewares'    => [
        'require-admin-logout'
    ],
    function($request){
        return new Response(200, LoginController::getLogin($request));
    }
]);

//ROTA DE LOGIN (POST)
$obRouter->post('/admin/login', [
    'middlewares'    => [
        'require-admin-logout'
    ],
    function($request){
       // echo password_hash('123456', PASSWORD_DEFAULT); exit;       
        return new Response(200, LoginController::setLogin($request));
    }
]);


//ROTA DE LOGOUT
$obRouter->get('/admin/logout', [
    'middlewares'    => [
        'require-admin-login'
    ],
    function($request){
        return new Response(200, Admin\LoginController::setLogout($request));
    }
]);