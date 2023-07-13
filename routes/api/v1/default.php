<?php

use App\Http\Response;
use App\Controller\Api;
use App\Controller\Api\ApiController;

//ROTA RAIZ API
$obRouter->get('/api/v1', [
    function($request){
        return new Response(200, ApiController::getDetails($request), 'application/json');
    }
]);