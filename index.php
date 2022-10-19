<?php

require __DIR__ . '/bootstrap/app.php';

use App\Http\Router;
use App\Utils\View;

//DEFINE VALOR PADRAO DAS VARIAVEIS
View::init([
    'URL' => getenv('URL')
]);

//INICIA O ROUTER
$obRouter = new Router(getenv('URL'));

//INCLUI AS ROTAS DE PAGINAS
include __DIR__.'/routes/routes.php';

$obRouter->run()->sendResponse();


