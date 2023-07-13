<?php

use App\Http\Response;
use App\Controller\Admin;

//ROTA DOS USUARIOS CADASTRADAS
$obRouter->get('/admin/usuarios', [
    'middlewares'       => [
        'require-admin-login'
    ],
    function($request){        
        return new Response(200, Admin\UserController::getUsers($request));
    }
]);


//ROTA PARA RENDERIZAR PÁGINA DE CADASTRO DE USUARIOS
$obRouter->get('/admin/usuario/new', [
    'middlewares'       => [
        'require-admin-login'
    ],
    function($request){
        return new Response(200, Admin\UserController::getNewUser($request));
    }
]);

//ROTA PARA RENDERIZAR PÁGINA DE CADASTRO DE USUARIOS (POST)
$obRouter->post('/admin/usuario/new', [
    'middlewares'       => [
        'require-admin-login'
    ],
    function($request){
        return new Response(200, Admin\UserController::setNewUser($request));       
    }
]);

//ROTA DE EDICAO DOS DADOS DO USUARIO CADASTRADO
$obRouter->get('/admin/usuario/{id}/edit', [
    'middlewares'       => [
        'require-admin-login'
    ],
    function($request, $id){
        return new Response(200, Admin\UserController::getEditUser($request, $id));
    }
]);

//ROTA DE EDICAO DOS DADOS DO USUARIO CADASTRADO (POST) 
$obRouter->post('/admin/usuario/{id}/edit', [
    'middlewares'       => [
        'require-admin-login'
    ],
    function($request, $id){
        return new Response(200, Admin\UserController::setEditUser($request, $id));
    }
]);

//ROTA DE EXCLUSAO DE USUARIO
$obRouter->get('/admin/usuario/{id}/delete', [
    'middlewares'       => [
        'require-admin-login'
    ],
    function($request, $id){
        return new Response(200, Admin\UserController::getDeleteUser($request, $id));
    }
]);

//ROTA DE EXCLUSAO DE USUARIO (POST)
$obRouter->post('/admin/usuario/{id}/delete', [
    'middlewares'       => [
        'require-admin-login'
    ],
    function($request, $id){
        return new Response(200, Admin\UserController::setDeleteUser($request, $id));
    }
]);