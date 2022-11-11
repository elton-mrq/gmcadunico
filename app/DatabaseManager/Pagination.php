<?php

namespace App\DatabaseManager;

class Pagination
{
    /**
     * Número máximo por página
     * @var integer
     */
    private $limit;

    /**
     * Quantidade de resultados de registros do BD
     * @var integer
     */
    private $results;

    /**
     * Número de Páginas
     * @var integer
     */
    private $page;

    /**
     * Página Atual
     * @var integer
     */
    private $currentPage;

    public function __construct($result, $currentPage = 1, $limit = 1)
    {
        $this->results = $result;
        $this->currentPage = (is_numeric($currentPage) and $currentPage > 0) ? $currentPage : 1;
        $this->limit = $limit;
        $this->calculate();
    }

    /**
     * Método que calcula a paginação
     */
    public function calculate()
    {
        //CALCULA O NÚMERO DE TOTAL DE PÁGINAS
        $this->page = $this->results > 0 ? ceil($this->results / $this->limit) : 1;

        //VERIFICA SE A PÁGINA ATUAL NÃO EXCEDE O LIMITE DE PÁGINAS]
        $this->currentPage = $this->currentPage <= $this->page ? $this->currentPage : $this->page;
    }

    /**
     * Método responsável pela clausula limit
     * @return string
     */
    public function getLimit()
    {
        $offSet = ($this->limit * ($this->currentPage - 1));
        return $offSet . ',' . $this->limit;
    }

    public function getPages()
    {
        //NÃO RETORA AS PÁGINAS
        if($this->page == 1)    return [];

        $paginas = [];
        for($i = 1; $i <= $this->page; $i++){
            $paginas[] = [
                'page' => $i,
                'current'  => $i == $this->currentPage
            ];
        }

        return $paginas;
    }
}