<?php

namespace App\Controller\Pages;

use App\Utils\View;

class PeopleController extends PageController
{

    /**
     * Reponsável por retornar lista de pessoas cadastradas
     * @return string
     */
    public static function getPeoples()
    {
        $content = View::render('pages/peoples', [

        ]);

        return parent::getPage('Pessoas Cadastradas ', $content);
    }

}