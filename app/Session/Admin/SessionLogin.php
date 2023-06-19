<?php

namespace App\Session\Admin;

class SessionLogin
{

    /**
     * Método que inicia a sessão
     */
    private static function init()
    {
        //VERIFICA SE A SESSAO NÃO ESTA ATIVA
        if(session_status() != PHP_SESSION_ACTIVE){
            session_start();
        }
    }

    /**
     * Método que cria o login do usuário
     * @param UserEntity $obUser
     * @return boolean
     */
    public static function login($obUser)
    {
        //INICIA A SESSÃO
        self::init();

        //DEFINE A SESSÃO DO USUÁRIO
        $_SESSION['admin']['usuario'] = [
            'id'        => $obUser->getId(),
            'nome'      => $obUser->getNome(),
            'email'     => $obUser->getEmail()
        ];

        //SUCESSO
        return true;
        //echo '<pre>'; print_r($obUser); exit;
    }

    /**
     * Método que verifica se o usuário esta logado
     * @return boolean
     */
    public static function isLogged()
    {
        //INICIA A SESSÃO
        self::init();

        //RETORNA A VERIFICAÇÃO
        return isset($_SESSION['admin']['usuario']['id']);
    }

    /**
     * Método que executa logout do usuário
     * @return true
     */
    public static function logout()
    {
        //INICIA A SESSAO
        self::init();

        //FINALIZA A SESSÃO DO USUÁRIO
        unset($_SESSION['admin']['usuario']);

        //SUCESSO
        return true;
    }

}