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
        echo '<pre>'; print_r($request->getPostVars()); echo '<pre>'; exit;
        return new Response(200, LoginController::getLogin($request));
    }
]);