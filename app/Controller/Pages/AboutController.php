<?php

namespace App\Controller\Pages;

use App\Utils\View;
use App\Model\Entity\Organization;

class AboutController extends PageController
{
    /**
     * Método responsável por retornar o conteúda (view) da Sobre
     *
     * @return string
     */
    public static function getAbout()
    {
        $obOrganization = new Organization;

        $content = View::render('pages/about', [
            'name'          => $obOrganization->name,
            'description'   => $obOrganization->description,
            'site'          => $obOrganization->site
        ]);

        //RETORNA A VIEW DA HOME
        return parent::getPage('Sobre > CadÚnico', $content);
    }
}
