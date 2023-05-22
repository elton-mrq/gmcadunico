<?php

namespace App\Controller\Admin;

use App\Utils\View;

class HomeAdminController extends PageAdminController
{

    /**
     * Metodo que renderiza a view de Home do Painel de Controle
     * @param Request $request
     * @return string
     */
    public static function getHomeAdmin($request)
    {

        //CONTEUDO DA HOME
        $content = View::render('admin/modules/home/index', []);

        //RETORNA A PAGINA COMPLETA
        return parent::getPanel("Painel Administrativo", $content, 'home');

    }

}