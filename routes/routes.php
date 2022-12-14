
<?php

use App\Http\Response;
use App\Controller\Pages;

//ROTA DA HOME
$obRouter->get('/', [
    function(){
        return new Response(200, Pages\HomeController::getHome());
    }
]);

//ROTA DA SOBRE
$obRouter->get('/sobre', [
    function(){
        return new Response(200, Pages\AboutController::getAbout());
    }
]);

//ROTA DA Pessoas Cadastradas
$obRouter->get('/pessoas', [
    function($request){        
        return new Response(200, Pages\PeopleController::getPeoples($request));
    }
]);


//ROTA PARA RENDERIZAR PÁGINA DE CADASTRO DE PESSOAS
$obRouter->get('/pessoas/cadastrar', [
    function(){
        return new Response(200, Pages\PeopleController::create());
    }
]);

//ROTA DE PESSOAS (INSERT)
$obRouter->post('/pessoas/cadastrar', [
    function($request){
        return new Response(200, Pages\PeopleController::insertPeople($request));
        //echo '<pre>'; print_r($request); echo '<pre>'; exit;
    }
]);


$obRouter->get('/pagina/{idPagina}/{acao}', [
    function($idPagina, $acao){
        return new Response(200, 'Página ' . $idPagina . ' - ' . $acao);
    }
]);