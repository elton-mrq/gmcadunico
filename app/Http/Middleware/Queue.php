<?php

namespace App\Http\Middleware;
use \Exception;

class Queue
{
    /**
     * Mapeamento de middlewares
     * @var array
     */
    private static $map = [];

    /**
     * Mapeamento de middlewares que será carregado em todas as rotas
     * @var array
     */
    private static $default = [];

    /**
     * Fila de middlewares a serem executados
     * @var array
     */
    private $middlewares = [];

    /**
     * Função de ececução do Controlador
     * @var mixed
     */
    private $controller;

    /**
     * Argumentos da função do controlador
     * @var array
     */
    private $controllerArgs = [];

    /**
     * Método que constrói a classe de fila de middlewares
     * @param array $middleware
     * @param Closure $controller
     * @param array $controllerArgs
     */
    public function __construct($middlewares, $controller, $controllerArgs)
    {   
        $this->middlewares = array_merge(self::$default, $middlewares);
        $this->controller       = $controller;
        $this->controllerArgs   = $controllerArgs;        
    }

    /**
     * Método que define o mapeamento de Middlewares
     * @param array $map
     */
    public static function setMap($map)
    {
        self::$map = $map;
        
    }

    /**
     * Método que define o mapeamento de middlewares padrões
     * @param [type] $default
     */
    public static function setDefault($default)
    {
        self::$default = $default;        
    }

    /**
     * Método que executa o próximo nivel da fila de middlewares
     * @param Request $request
     * @return Response
     */
    public function next($request)
    {
        //VERIFICA SE A FILA ESTA VAZIA
        if(empty($this->middlewares)) return call_user_func_array($this->controller, $this->controllerArgs);

        //MIDDLEWARE
        $middleware = array_shift($this->middlewares);

        
        //VERIFICA O MAPEAMENTO
        if(!isset(self::$map[$middleware])){
            throw new Exception ('Problemas ao processar o Middleware da requisição.', 500);
        }

        //NEXT
        $queue = $this;
        $next = function($request) use ($queue){
            return $queue->next($request);
        };

        //EXECUTA O MIDDLEWARE
        return (new self::$map[$middleware])->handle($request, $next);
    }
}