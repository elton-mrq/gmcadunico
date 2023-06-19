<?php

namespace App\Controller\Admin;

use App\Utils\View;
use App\Model\Entity\PeopleEntity;
use App\Model\DAO\PeopleDAO;
use App\DatabaseManager\Pagination;
use App\Http\Request;

class PeopleController extends PageAdminController
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
        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 4);

        //RESULTADOS DO SELECT DOS DADOS DE PESSOAS CADASTRADAS
        $results = PeopleDAO::getPessoas(null, 'id ASC', $obPagination->getLimit());
        
        //RENDERIZA O ITEM
        while($obPerson = $results->fetchObject(PeopleEntity::class)){
            $itens .= View::render('admin/modules/people/peopleItem', [
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
       
        $content = View::render('admin/modules/people/index', [
          'items'       => self::getPersonItems($request, $obPagination),
          'pagination'  => parent::getPagination($request, $obPagination),
          'status'      => self::getStatus($request)
        ]);

        return parent::getPanel('Pessoas Cadastradas ', $content, 'pessoas');
    }

    /**
     * Metodo que renderiza a página de cadastramento de novas pessoas
     * @return string
     */
    public static function getNewPeople()
    {
        $content = View::render('admin/modules/people/formPeople',[
            'title'     => "Cadastrar Pessoa",
            'nome'      => '',
            'dt_nasc'   => '',
            'cpf'       => '',
            'rg'        => '',
            'nis'       => '',
            'status'    => ''
        ]
    );
        return PageAdminController::getPanel('Cadastrar Pessoa', $content, 'pessoas');
    }


    /**
     * Método que cadastra os dados de pessoa no Banco de Dados
     *
     * @param Request $request
     * @return string
     */
    public static function setNewPeople($request)
    {
        //DADOS DO POST
        $postVars = $request->getPostVars();

        $obPeople = new PeopleEntity();
        $obPeople->setNome($postVars['nome']);
        $obPeople->setDtNasc($postVars['dt_nasc']);
        $obPeople->setCpf($postVars['cpf']);
        $obPeople->setRg($postVars['rg']);
        $obPeople->setNis($postVars['nis']);

        PeopleDAO::cadastrar($obPeople);

        //REDIRECIONA O USUÁRIO PARA PAGINA DE EDICAO
        $request->getRouter()->redirect('/admin/pessoa/' . $obPeople->getId() . '/edit?status=created');
    }
   

    /**
     * Método que retorna o formulário de edição de uma nova pessoa cadastrada
     *
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getEditPeople($request, $id)
    {
        //OBTEM OS DADOS DA PESSOA DO BD
        $obPeople = PeopleDAO::getPeopleById($id);
        
        //VALIDA A INSTANCIA
        if(!$obPeople instanceof PeopleEntity){
           $request->getRouter()->redirect('/admin/pessoas');
        }
        
        //CONTEUDO DA VIEW
        $content = View::render('admin/modules/people/formPeople',[
            'title'     => 'Editar dados da pessoa',
            'nome'      => $obPeople->getNome(),
            'dt_nasc'   => date_format($obPeople->getDtNasc(), 'Y-m-d'),
            'cpf'       => $obPeople->getCpf(),
            'rg'        => $obPeople->getRg(),
            'nis'       => $obPeople->getNis(),
            'status'    => self::getStatus($request)    
        ]);


        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Editar dados da pessoa', $content, 'pessoas');
    }

    /**
     * Método que grava a atualização dos dados da pessoa
     *
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setEditPeople($request, $id){
        
        //OBTEM OS DADOS DA PESSOA NO BD
        $obPeople = PeopleDAO::getPeopleById($id);

        //VALIDA A INSTANCIA
        if(!$obPeople instanceof PeopleEntity){
            $request->getRouter()->redirect('/admin/pessoas');
        }

        //POST VARS
        $postVars = $request->getPostVars();
       
        //ATUALIZA A INSTANCIA
        $obPeople->setNome($postVars['nome'] ?? $obPeople->getNome());
        $obPeople->setDtNasc($postVars['dt_nasc'] ?? $obPeople->getDtNasc());
        $obPeople->setCpf($postVars['cpf'] ?? $obPeople->getCpf());
        $obPeople->setNome($postVars['rg'] ?? $obPeople->getRg());
        $obPeople->setNome($postVars['nis'] ?? $obPeople->getNis());
        
        //GRAVA OS DADOS
        PeopleDAO::atualizar($obPeople);

        //REDIRECIONA O USUÁRIO PARA PAGINA DE EDICAO
        $request->getRouter()->redirect('/admin/pessoa/' . $obPeople->getId() . '/edit?status=updated');
    }
 

    /**
     * Método que retorna o formulário de exclusão de pessoa
     *
     * @param [type] $request
     * @param [type] $id
     * @return void
     */
    public static function getDeletePeople($request, $id)
    {
        //OBTEM OS DADOS DA PESSOA
        $obPeople = PeopleDAO::getPeopleById($id);

        //VALIDA A INSTANCIA
        if(!$obPeople instanceof PeopleEntity){
            $request->getRouter()->redirect('/admin/pessoas');
        }

        //CONTEUDO DA VIEW
        $content = View::render('admin/modules/people/delete',[
            'nome'      => $obPeople->getNome(),
            'cpf'       => $obPeople->getCpf()
        ]);

        //RETORNA A PAGINA COMPLETA
        return parent::getPanel('Excluir Pessoa', $content, 'pessoas');

    }

    /**
     * Método responsável por excluir os dados da pessoa
     *
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function setDeletePeople($request, $id)
    {
        //OBTERM OS DADOS DA PESSOA DO BD
        $obPeople = PeopleDAO::getPeopleById($id);

        //VALIDA A INSTANCIA
        if(!$obPeople instanceof PeopleEntity){
            $request->getRouter()->redirect('admin/pessoas');
        }

        //EXCLUIR DADOS DA PESSOA
        PeopleDao::excluir($obPeople);

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/pessoas?status=deleted');
    }


    /**
     * Metodo que retorna a mensagem de status
     *
     * @param Request $request
     * @return string
     */
    private static function getStatus($request)
    {
        //VERIFICA SE EXISTE QUERY PARAMS
        $queryParams = $request->getQueryParams();

        //VERIFICA SE EXISTE QP STATUS
        if(!isset($queryParams['status'])) return '';

        //MENSAGENS DE STATUS
        switch ($queryParams['status']){
            case 'created':
                return AlertController::getSuccess('Dados da pessoa registrados com sucesso!');
                break;
            case 'updated':
                return AlertController::getSuccess('Dados da pessoa atualizados com sucesso!');
                break;
            case 'deleted':
                return AlertController::getSuccess('Dados da pessoa excluídos com sucesso!');
                break;
        }
        //echo '<pre>'; print_r($queryParams); echo '<pre>'; exit;
    }
    

    //echo '<pre>'; print_r($obPeople); echo '<pre>'; exit;
}