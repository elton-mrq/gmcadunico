
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

