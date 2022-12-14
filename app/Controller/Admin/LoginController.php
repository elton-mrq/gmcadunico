<?php

namespace App\Controller\Admin;

use App\Utils\View;

class LoginController extends PageAdminController
{
    

    /**
     * Método que retorna uma instância de Login
     * @param Request $request
     * @return string
     */
    public static function getLogin($request)
    {
        //CONTEUDO DA PAGINA DE LOGIN
        $content = View::render('admin/login', []);

        //RETORNA A PAGINA DE LOGIN
        return parent::getPage('Login CadÚnico', $content);
    }

}