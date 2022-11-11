<?php

namespace App\Http;

use \Closure;
use \Exception;
use \ReflectionFunction;

class Router
{

    /**
     * URL completa do sistema (raiz)
     * @var string
     */
    private $url = '';

    /**
     * Prefixo de todas as rotas
     * @var string
     */
    private $prefix = '';

    /**
     * Indice das rotas
     * @var array
     */
    private $routes = [];

    /**
     * Instancia da classe Request
     * @var Request
     */
    private $request;

    /**
     * Responsável por iniciar a classe
     *
     * @param string $url
     */
    public function __construct($url)
    {
       $this->request = new Request($this);
       $this->url     = $url; 
       $this->setPrefix();
    }

    /**
     * Responsável por definir o prefixo das rotas
     */
    private function setPrefix()
    {
        //INFORMAÇÕES DA URL ATUAL
        $parseUrl = parse_url($this->url);

        //DEFINI O PREFIXO
        $this->prefix = $parseUrl['path'] ?? '';
    }

    /**
     * Responsável por adicionar uma rota na classe
     *
     * @param string $method
     * @param string $route
     * @param array $params
     * @return void
     */
    private function addRoute($method, $route, $params = [])
    {
        
        //VALIDAÇÃO DOS PARAMETROS
        foreach($params as $key=>$value){
            if($value instanceof Closure){
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }

        //VARIAVEIS DA ROTA
        $params['variables'] = [];

        //PADRAO DE VALIDAÇÃO DAS VARIAVES DAS ROTAS
        $patternVariable = '/{(.*?)}/';
        if(preg_match_all($patternVariable, $route, $matches)){
           $route = preg_replace($patternVariable, '(.*?)', $route); 
           $params['variables'] = $matches[1];
        }

        //PADRAO DE VALIDACAO DA URL
        $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';

        //ADICIONA A ROTA DENTRO DA CLASSE
        $this->routes[$patternRoute][$method] = $params;
        
    }

    /**
     * Responsável por retornar a URI sem o prefixo
     * @return string
     */
    private function getUri()
    {
        
        //URI da REQUEST
        $uri = $this->request->getUri();

        //FATIA A URI COM PREFIXO
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri): [$uri];

        //RETORNA A URI SEM PREFIX
        return end($xUri);
    }

    /**
     * Método responsável por retornar os dados da rota atual
     * @return array
     */
    private function getRoute()
    {
        //URI
        $uri = $this->getUri();

        //METHOD
        $httpMethod = $this->request->getHttpMethod();

        //VALIDA AS ROTAS
        foreach ($this->routes as $patternRoute => $methods) {
            
            //VERIFICA SE A URI CONDIZ COM O PADRÃO
            if(preg_match($patternRoute, $uri, $matches)){

                //REMOVE A PRIMEITA POSIÇÃO DE MATCHES
                unset($matches[0]);

                //VARIAVES PROCESSADAS
                $keys = $methods[$httpMethod]['variables'];
                $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
                $methods[$httpMethod]['variables']['request'] = $this->request;
                
                //VERIFICA O MÉTODO
                if(isset($methods[$httpMethod])){
                   //RETORNA OS PARAMETROS DA ROTA
                   return $methods[$httpMethod];
                }

                throw new Exception("O método não é permitido", 405);
            }
        }

        throw new Exception('URL não encontrada', 404);
    }

    /**
     * Executa a rota atual
     * @return Response
     */
    public function run()
    {
        
        try {

            //OBTEM A ROTA ATUAL            
            $route = $this->getRoute();
            
            //VERIFICA O CONTROLADOR
            if(!isset($route['controller'])){
                throw new Exception('A URL não pode ser processada.', 500);
            }

            //ARGUMENTOS DA FUNÇÃO
            $args = [];

            //REFLECTION
            $reflection = new ReflectionFunction($route['controller']);
            foreach ($reflection->getParameters() as $parameter){
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';
            }            

            //RETORNA A EXECUÇÃO DA FUNÇÃO
            return call_user_func_array($route['controller'], $args);

        } catch (Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }

    }

    /**
     * Método que retorna a URL atual
     * @return string
     */
    public function getCurrentUrl()
    {
        return $this->url . $this->getUri();
    }

    /**
     * Responsável por definir as rotas de GET
     * @param string $route
     * @param array $params
     */
    public function get($route, $params = [])
    {
        return $this->addRoute('GET', $route, $params);
    }

    /**
     * Responsável por definir as rotas de POST
     * @param string $route
     * @param array $params
     */
    public function post($route, $params = [])
    {
        return $this->addRoute('POST', $route, $params);
    }

    /**
     * Responsável por definir as rotas de PUT
     * @param string $route
     * @param array $params
     */
    public function put($route, $params = [])
    {
        return $this->addRoute('PUT',  $route, $params);
    }

    /**
     * Responsável por definir as rotas de DELETE
     * @param string $route
     * @param array $params
     */
    public function delete($route, $params)
    {
        return $this->addRoute('DELETE', $route, $params);
    }

}