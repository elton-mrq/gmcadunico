<?php

namespace App\Controller\Admin;

use App\Utils\View;
use App\Session\Admin\SessionLogin;
use App\Model\Entity\UserEntity as User;
use App\Controller\Admin\AlertController;

class LoginController extends PageAdminController
{
    

    /**
     * Método que retorna uma instância de Login
     * @param Request $request
     * @param strign $errorMessage
     * @return string
     */
    public static function getLogin($request, $errorMessage = null)
    {
        //RENDERIZA A MENSAGEM DE STATUS        
        $status = !is_null($errorMessage) ? AlertController::getError($errorMessage) : '';

        //CONTEUDO DA PAGINA DE LOGIN
        $content = View::render('admin/login', [
            'status' => $status
        ]);

        //RETORNA A PAGINA DE LOGIN
        return parent::getPage('Login CadÚnico', $content);
    }

    /**
     * Método que define o login do usuário
     * @param Request $request
     * @return void
     */
    public static function setLogin($request)
    {
        //POSTVARS
        $postVars = $request->getPostVars();
        $email = $postVars['email'] ?? '';
        $senha = $postVars['senha'] ?? '';

        //BUSCA USUARIO PELO EMAIL
        $user = User::getUserByEmail($email);

        //VERIFICA SE NAO EXISTE USUARIO
        if(!$user instanceof User){
            return self::getLogin($request, 'E-mail ou senha inválidos!');
        }

        //VERIFICA A SENHA DO USUARIO
        if(!password_verify($senha, $user->senha)){
            return self::getLogin($request, 'E-mail ou senha inválidos!');
        }
        
        //CRIA A SESSAO DE LOGIN
        SessionLogin::login($user);
        
        //REDIRECIONA O USUARIO PARA HOME ADMIN
        $request->getRouter()->redirect('/admin');

    }

    /**
     * Método que executa o logout do usuário
     * @param Request $request
     * @return void
     */
    public static function setLogout($request)
    {
        //DESTROI A SESSÃO DE LOGIN
        SessionLogin::logout();

        //REDIRECIONA O USUÁRIO PARA TELA DE LOGIN
        $request->getRouter()->redirect('/admin/login');
    }

}