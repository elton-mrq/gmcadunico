<?php

namespace App\Http;

class Response
{

    /**
     * Código status HTTP
     *
     * @var integer
     */
    private $httpCode = 200;

    /**
     * Headers do Response
     *
     * @var array
     */
    private $headers = [];

    /**
     * Tipo de conteúdo que esta sendo retornado
     *
     * @var string
     */
    private $contentType = 'text/html';

    /**
     * Conteúdo do Response
     *
     * @var mixed
     */
    private $content;

    /**
     * Inicia a classe e recebe e define valores dos atributos
     *
     * @param integer $httpCode
     * @param mixed $content
     * @param string $contentType
     */
    public function __construct($httpCode, $content, $contentType = 'text/html')
    {
        $this->httpCode    = $httpCode;
        $this->content     = $content;
        $this->setContentType($contentType);
    }

    /**
     * Método responsável por alterar o Content Type do Response
     *
     * @param string $contentType
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        $this->addHeaders('Content-Type', $contentType);
    }

    /**
     * Responsável por adicionar um novo cabeçalho de response
     *
     * @param string $key
     * @param string $value
     */
    public function addHeaders($key, $value)
    {
        $this->headers[$key] = $value;
    }

    /**
     * Método responsável por enviar os headers para o navegador
     */
    private function sendHeaders()
    {
        //STATUS
        http_response_code($this->httpCode);

        //ENVIAR HEADERS
        foreach($this->headers as $key=>$value)
        {
            header($key .':'.$value);
        }
    }

    /**
     * Envia resposta para o usuário
     */
    public function sendResponse()
    {
        //ENVIA OS HEADERS
        $this->sendHeaders();

        //IMPRIME O VALOR
        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                exit;
        }
    }


}