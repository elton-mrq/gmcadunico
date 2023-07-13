<?php

require __DIR__ . '/includes/app.php';

use App\Http\Router;

//INICIA O ROUTER
$obRouter = new Router(getenv('URL'));

//INCLUI AS ROTAS DE PAGINAS
include __DIR__.'/routes/routes.php';

//INCLUI AS ROTAS DO PAINEL
include __DIR__.'/routes/routes_admin.php';

//INCLUI AS ROTAS DE API
include __DIR__ .'/routes/routes_api.php';

$obRouter->run()->sendResponse();



