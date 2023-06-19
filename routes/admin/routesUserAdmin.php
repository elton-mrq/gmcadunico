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

//ROTA DE EXCLUSAO DE PESSOA
$obRouter->get('/admin/pessoa/{id}/delete', [
    'middlewares'       => [
        'require-admin-login'
    ],
    function($request, $id){
        return new Response(200, Admin\PeopleController::getDeletePeople($request, $id));
    }
]);

//ROTA DE EXCLUSAO DE PESSOA (POST)
$obRouter->post('/admin/pessoa/{id}/delete', [
    'middlewares'       => [
        'require-admin-login'
    ],
    function($request, $id){
        return new Response(200, Admin\PeopleController::setDeletePeople($request, $id));
    }
]);