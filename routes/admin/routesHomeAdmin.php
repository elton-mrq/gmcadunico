<?php

use App\Http\Response;
use App\Controller\Admin\HomeAdminController;

//ROTA DA HOME ADMIN
$obRouter->get('/admin', [
    'middlewares'    => [
        'require-admin-login'
    ],
    function($request){
        return new Response(200, HomeAdminController::getHomeAdmin($request));
    }
]);