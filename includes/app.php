<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Utils\View;
use App\DatabaseManager\Database;
use App\Common\Environment;
use App\Http\Middleware\Queue as MiddlewareQueue;


Environment::load(__DIR__.'/../');

//DEFINE AS CONFIGURACOES DE BANCO DE DADOS
Database::config(
    getenv('DB_HOST'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_PORT')
);

//DEFINE VALOR PADRAO DAS VARIAVEIS
View::init([
    'URL' => getenv('URL')
]);


MiddlewareQueue::setMap([
    'maintenance'  => App\Http\Middleware\Maintenance::class
]);

//DEFINE O MAPEAMENTO DE MIDDLEWARE PADROES
MiddlewareQueue::setDefault([
    'maintenance'  
]);
