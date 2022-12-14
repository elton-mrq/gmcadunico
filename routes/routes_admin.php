<?php

use App\Http\Response;
use App\Controller\Admin;
use App\Controller\Admin\LoginController;

//ROTA DA HOME ADMIN
$obRouter->get('/admin', [
    function(){
        return new Response(200,'Admin :)');
    }
]);

//ROTA DE LOGIN
$obRouter->get('/admin/login', [
    function($request){
        return new Response(200, LoginController::getLogin($request));
    }
]);

//ROTA DE LOGIN (POST)
$obRouter->post('/admin/login', [
    function($request){
       // echo password_hash('123456', PASSWORD_DEFAULT); exit;       
        return new Response(200, LoginController::setLogin($request));
    }
]);