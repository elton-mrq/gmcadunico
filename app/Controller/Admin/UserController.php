<?php

namespace App\Controller\Admin;

use App\Utils\View;
use App\DatabaseManager\Pagination;
use App\Model\DAO\UserDAO;
use App\Http\Request;
use App\Model\Entity\UserEntity;

Class UserController extends PageAdminController
{

    /**
     * Método que obtém os registros dos usuários do BD
     *
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    private static function getUsersItems($request, &$obPagination)
    {
        $itens = '';

        //QUANTIDADE TOTAL DE REGISTROS
        $quantidadeTotal = UserDAO::getUsers(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;
       
        //PAGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;
        
        //INSTANCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 4);

        //RESULTADO DO SELECT DOS DADOS DE USUARIOS CADASTRADOS
        $result = UserDAO::getUsers(null, 'id ASC', $obPagination->getLimit());

        //RENDERIZA O ITEM
        while($obUser = $result->fetchObject(UserEntity::class)){
            $itens .= View::render('admin/modules/user/userItem', [
                'id'         => $obUser->getId(),
                'nome'       => $obUser->getNome(),
                'email'      => $obUser->getEmail(),
                'statusUser' => $obUser->getStatus()
            ]);
        } 
        
        //RETORNA OS DADOS DOS USUARIOS CADASTRADOS
        return $itens;
    }

    /**
     * Método que retorna os usuários cadastrados no BD
     *
     * @param Request request
     * @return string
     */
    public static function getUsers($request)
    {

        $content = View::render('admin/modules/user/index', [
            'items'         => self::getUsersItems($request, $obPagination),
            'pagination'    => '',
            'status'        => ''
        ]);

        return parent::getPanel('Usuários Cadastrados', $content, 'users');

    }

    /**
     * Método que renderiza a página de cadastramento de novos usuários
     *
     * @return string
     */
    public static function getNewUser($request)
    {
        $content = View::render('admin/modules/user/formUser', [
            'title'         => 'Cadastrar Usuário',
            'nome'          => '',
            'cpf'           => '',
            'email'         => '',
            'senha'         => '',
            'statusUser'    => '',
            'checkAtivo'    => 'checked',
            'status'        => self::getStatus($request)
        ]);

        return PageAdminController::getPanel('Cadastrar Usuário', $content, 'users');
    }

    /**
     * Método que cadastra os dados do usuário no Banco de Dados
     *
     * @param Request $request
     * @return void
     */
    public static function setNewUser($request)
    {
        //DADOS DO POST
        $postVars = $request->getPostVars();
        $nome       = $postVars['nome'] ?? '';
        $email      = $postVars['email'] ?? '';
        $cpf        = $postVars['cpf'] ?? '';
        $senha      = $postVars['senha'] ?? '';
        $statusUser = $postVars['statusUser'];

        
        //VALIDA A INSTANCIA DE USUARIO
        $obUserEmail = UserDAO::getUserByEmail($email);
        if($obUserEmail instanceof UserEntity){
            //REDIRECIONA O USUARIO
            $request->getRouter()->redirect('/admin/usuario/new?status=emailduplicated');
        }

        //NOVA INSTANCIA DE USUARIO
        $obUser = new UserEntity;
        $obUser->setNome($nome);
        $obUser->setEmail($email);
        $obUser->setCpf($cpf);
        $obUser->setSenha(password_hash($senha, PASSWORD_DEFAULT));
        $obUser->setStatus($statusUser);

        UserDAO::cadastrar($obUser);

        $request->getRouter()->redirect('/admin/usuario/' .$obUser->getId() .'/edit?status=created');
    }

    
    /**
     * Método que retorna o formulário de edição de um usuário cadastrado
     *@param integer $id
     *@param Request $request
     * @return string
     */
    public static function getEditUser($request, $id)
    {
        //OBTEM OS DADOS DO USUARIO
        $obUser = UserDAO::getUserById($id);

        //VALIDA A INSTANCIA
        if(!$obUser instanceof UserEntity){
            $request->getRouter()->redirect('/admin/usuarios');
        }

        //CONTEUDO DA VIEW
        $content = View::render('admin/modules/user/formUser', [
            'title'             => 'Editar dados do usuário',
            'nome'              => $obUser->getNome(),
            'cpf'               => $obUser->getCpf(),
            'email'             => $obUser->getEmail(),
            'checkAtivo'        => ($obUser->getStatus() == 'ATIVO' ? 'checked' : ''),
            'checkInativo'      => ($obUser->getStatus() == 'INATIVO' ? 'checked' : ''),
            'status'            => self::getStatus($request)
        ]);

        //RETORNA A PÁGINA COMPLETA
        return parent::getPanel('Editar dados do usuário', $content, 'users');
    }

    /**
     * Método que grava a atualização de um usuário no BD
     *
     * @param Request $request
     * @param Integer $id
     * @return string
     */
    public static function setEditUser($request, $id)
    {
        //OBTEM O USUARIO DO BD
        $obUser = UserDAO::getUserById($id);

        //VALIDA A INSTANCIA
        if(!$obUser instanceof UserEntity){
            $request->getRouter()->redirect('/admin/users');
        }

        //DADOS DO POST
        $postVars = $request->getPostVars();
        $nome       = $postVars['nome'] ?? '';
        $email      = $postVars['email'] ?? '';
        $cpf        = $postVars['cpf'] ?? '';
        $senha      = $postVars['senha'] ?? '';
        $statusUser = $postVars['statusUser'];

        //VALIDA A INSTANCIA DE USUARIO
        $obUserEmail = UserDAO::getUserByEmail($email);
        if($obUserEmail instanceof UserEntity && $obUserEmail->getId() != $id){
            //REDIRECIONA O USUARIO
            $request->getRouter()->redirect('/admin/usuario/'. $id . '/edit?status=emailduplicated');
        }

        //VALIDA A INSTANCIA DE USUARIO
        $obUserCpf = UserDAO::getUserByCpf($cpf);
        if($obUserCpf instanceof UserEntity && $obUserCpf->getId() != $id){
            //REDIRECIONA O USUARIO
            $request->getRouter()->redirect('/admin/usuario/'. $id . '/edit?status=cpfduplicated');
        }

        //ATUALIZA A INSTANCIA
        $obUser->setNome($nome);
        $obUser->setCpf($cpf);
        $obUser->setEmail($email);
        $obUser->setSenha(password_hash($senha, PASSWORD_DEFAULT));
        $obUser->setStatus($statusUser);
        
        //GRAVA OS DADOS
        UserDAO::atualizar($obUser);

        //REDIRECIONA O USUÁRIO PARA PAGINA DE EDICAO
        $request->getRouter()->redirect('/admin/usuario/' . $obUser->getId() . '/edit?status=updated');
    }

     /**
     * Método que retorna o formulário de exclusão de um usuário cadastrado
     *@param integer $id
     *@param Request $request
     * @return string
     */
    public static function getDeleteUser($request, $id)
    {
         //OBTEM OS DADOS DO USUARIO
         $obUser = UserDAO::getUserById($id);

         //VALIDA A INSTANCIA
         if(!$obUser instanceof UserEntity){
             $request->getRouter()->redirect('/admin/usuarios');
         }

         $content = View::render('admin/modules/user/delete', [
            'nome'      => $obUser->getNome(),
            'cpf'       => $obUser->getCpf(),
            'email'     => $obUser->getEmail(),
            'status'    => self::getStatus($request)
         ]);

         //RETORNA A PAGINA COMPLETA
         return parent::getPanel('Excluir dados do usuário:', $content, 'users');

    }

    public static function setDeleteUser($request, $id)
    {
        //OBTEM DADOS DO USUARIO
        $obUser = UserDAO::getUserById($id);

        //VALIDA A INSTANCIA
        if(!$obUser instanceof UserEntity){
            $request->getRouter()->redirect('/admin/usuarios');
        }

        UserDAO::excluir($obUser);

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/usuarios/?status=deleted');

    }

    private static function getStatus($request)
    {
        //VERIFICA SE EXISTE QUERY PARAMS
        $queryParams = $request->getQueryParams();

        //VERIFICA SE EXISTE QUERY PARAMS STATUS
        if(!isset($queryParams['status'])) return '';

        //MENSAGENS DE STATUS
        switch ($queryParams['status']){
            case 'created':
                return AlertController::getSuccess('Dados do usuário registrados com sucesso!');
                break;
            case 'updated':
                return AlertController::getSuccess('Dados do usuário atualizados com sucesso!');
                break;
            case 'deleted':
                return AlertController::getSuccess('Dados do usuário excluídos com sucesso!');
                break;
            case 'emailduplicated':
                return AlertController::getError('O E-mail digitado já esta sendo utilizado por outro usuário!');
                break;
            case 'cpfduplicated':
                return AlertController::getError('O CPF digitado já esta sendo utilizado por outro usuário!');
                break;
        }
    }


    //echo '<pre>'; print_r($obUser); echo '<pre>'; exit;
}