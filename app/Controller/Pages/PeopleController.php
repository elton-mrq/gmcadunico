<?php

namespace App\Controller\Pages;

use App\Utils\View;
use App\Model\Entity\PeopleEntity;
use App\Model\DAO\PeopleDAO;
use App\DatabaseManager\Pagination;
use App\Http\Request;

class PeopleController extends PageController
{

    /**
     * Método que obtém os registros de pessoas do BD
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    private static function getPersonItems($request, &$obPagination)
    {
        $itens = '';

        //QUANTIDADE TOTAL DE REGISTROS
        $quantidadeTotal = PeopleDAO::getPessoas(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //PAGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //INSTANCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 2);

        //RESULTADOS DO SELECT DOS DADOS DE PESSOAS CADASTRADAS
        $results = PeopleDAO::getPessoas(null, 'id DESC', $obPagination->getLimit());
        
       // echo '<pre>'; print_r($results); echo '<pre>'; exit;
        //RENDERIZA O ITEM
        while($obPerson = $results->fetchObject(PeopleEntity::class)){
            $itens .= View::render('people/personItem', [
                'id'      => $obPerson->getId(),
                'nome'    => $obPerson->getNome(),
                'dt_nasc' => date_format($obPerson->getDtNasc(), 'd/m/Y'),
                'cpf'     => $obPerson->getCpf(),
                'rg'      => $obPerson->getRg(),
                'nis'     => $obPerson->getNis()
            ]);
        }
        
        //RETORNA OS DADOS DAS PESSOAS CADASTRADAS
        return $itens;
        
    }

    /**
     * Reponsável por retornar lista de pessoas cadastradas
     * @param Request $request
     * @return string
     */
    public static function getPeoples($request)
    {
       
        $content = View::render('people/index', [
          'items'       => self::getPersonItems($request, $obPagination),
          'pagination'  => parent::getPagination($request, $obPagination)
        ]);

        return parent::getPage('Pessoas Cadastradas ', $content);
    }

    /**
     * Metodo que renderiza a página de cadastramento de novas pessoas
     *
     * @return void
     */
    public static function create()
    {
        $content = View::render('people/create');
        return PageController::getPage('Cadastrar Pessoas', $content);
    }


    /**
     * Método que cadastra os dados de pessoa no Banco de Dados
     *
     * @param Request $request
     * @return string
     */
    public static function insertPeople($request)
    {
        //DADOS DO POST
        $postVars = $request->getPostVars();
        $obPeople = new PeopleEntity();
        $obPeople->setNome($postVars['nome']);
        $obPeople->setDtNasc($postVars['dt_nasc']);
        $obPeople->setCpf($postVars['cpf']);
        $obPeople->setRg($postVars['rg']);
        $obPeople->setNis($postVars['nis']);

        $obPeopleDAO = new PeopleDAO();
        $id = $obPeopleDAO->insert($obPeople);

        //RETORNA A PARGINA DE LISTAGEM DE PESSOAS
        return self::getPeoples($request);
    }
    

}