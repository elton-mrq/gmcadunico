<?php

require __DIR__ . '/includes/app.php';

use App\Http\Router;

//INICIA O ROUTER
$obRouter = new Router(getenv('URL'));

//INCLUI AS ROTAS DE PAGINAS
include __DIR__.'/routes/routes.php';

$obRouter->run()->sendResponse();


