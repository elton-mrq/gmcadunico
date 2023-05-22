<?php

use App\Http\Response;
use App\Controller\Admin;

//ROTA DAS PESSOAS CADASTRADAS
$obRouter->get('/admin/pessoas', [
    'middlewares'       => [
        'require-admin-login'
    ],
    function($request){        
        return new Response(200, Admin\PeopleController::getPeoples($request));
    }
]);


//ROTA PARA RENDERIZAR PÁGINA DE CADASTRO DE PESSOAS
$obRouter->get('/admin/pessoa/new', [
    'middlewares'       => [
        'require-admin-login'
    ],
    function(){
        return new Response(200, Admin\PeopleController::getNewPeople());
    }
]);

//ROTA PARA RENDERIZAR PÁGINA DE CADASTRO DE PESSOAS (POST)
$obRouter->post('/admin/pessoa/new', [
    'middlewares'       => [
        'require-admin-login'
    ],
    function($request){
        return new Response(200, Admin\PeopleController::setNewPeople($request));       
    }
]);

//ROTA DE EDICAO DOS DADOS DA PESSOA CADASTRADA
$obRouter->get('/admin/pessoa/{id}/edit', [
    'middlewares'       => [
        'require-admin-login'
    ],
    function($request, $id){
        return new Response(200, Admin\PeopleController::getEditPeople($request, $id));
    }
]);

//ROTA DE EDICAO DOS DADOS DA PESSOA CADASTRADA (POST) 
$obRouter->post('/admin/pessoa/{id}/edit', [
    'middlewares'       => [
        'require-admin-login'
    ],
    function($request, $id){
        return new Response(200, Admin\PeopleController::setEditPeople($request, $id));
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