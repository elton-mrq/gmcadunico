
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
    function(){
        return new Response(200, Pages\PeopleController::getPeoples());
    }
]);

$obRouter->get('/pagina/{idPagina}/{acao}', [
    function($idPagina, $acao){
        return new Response(200, 'Página ' . $idPagina . ' - ' . $acao);
    }
]);