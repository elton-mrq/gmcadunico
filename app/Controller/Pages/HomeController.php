<?php

namespace App\Controller\Pages;

use App\Utils\View;
use App\Model\Entity\Organization;

class HomeController extends PageController
{
    /**
     * Método responsável por retornar o conteúda (view) da Home
     *
     * @return string
     */
    public static function getHome()
    {
        $obOrganization = new Organization;

        $content = View::render('pages/home', [
            'name'          => $obOrganization->name
        ]);

        //RETORNA A VIEW DA HOME
        return parent::getPage('Home > Cadun', $content);
    }
}
