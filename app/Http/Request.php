<?php

namespace App\Http;

class Request
{
    /**
     * Instância da classe Router
     *
     * @var Router
     */
    private $router;

    /**
     * Recebe o método HTTP da página
     *
     * @var string
     */
    private $httpMethod;

    /**
     * URI da página
     *
     * @var string
     */
    private $uri;

    /**
     * Paramêtros da URL - $_GET
     *
     * @var array
     */
    private $queryParams = [];

    /**
     * Variáveis recebidas via POST - $_POST
     *
     * @var array
     */
    private $postVars = [];

    /**
     * Cabeçalho da requisição
     *
     * @var array
     */
    private $headers = [];

    /**
     * Construtor da classe
     */
    public function __construct($router)
    {
        $this->router      = $router;
        $this->queryParams = $_GET ?? [];
        $this->postVars    = $_POST ?? [];
        $this->headers     = getallheaders();
        $this->httpMethod  = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->setUri();
        
    }

    /**
     * Método que define a URI
     *
     * @return void
     */
    private function setUri()
    {
        //URI COMPLETA (COM GETS)
        $this->uri         = $_SERVER['REQUEST_URI'] ?? '';

        //REMOVE OS GETS DA URI
        $xUri = explode("?", $this->uri);
        $this->uri = $xUri[0];
    }

    /**
     * Método que retorna a Instância de Router
     * @return Router
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * Retorna o método Http da requisição
     *
     * @return void
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * Retorna a URI da requisição
     *
     * @return void
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Retorna os Headers da requisição
     *
     * @return void
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Responsável por retornar os parametros da URL da requisição
     *
     * @return array
     */
    public function getQueryParams()
    {
        return $this->queryParams;
    }

    /**
     * Responsável por retornar as variáveis POST da requisição
     *
     * @return array
     */
    public function getPostVars()
    {
        return $this->postVars;
    }

}