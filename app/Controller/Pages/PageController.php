<?php

namespace App\Controller\Pages;

use App\Utils\View;

class PageController
{
    /**
     * Método responsável por rederizar header da página
     *
     * @return string
     */
    private static function getHeader()
    {
        return View::render('pages/header');
    }

    /**
     * Método que renderiza o rodapé da página
     *
     * @return string
     */
    private static function getFooter()
    {
        return View::render('pages/footer');
    }

    /**
     * Método responsável por retornar o conteúdo (view) da Página Genérica
     *
     * @return string
     */
    public static function getPage($title, $content)
    {
        //RETORNA A VIEW DA PÁGINA
        return View::render('pages/page', [
            'title'     => $title,
            'header'    => self::getHeader(),
            'content'   => $content,
            'footer'    => self::getFooter()
        ]);
    }
}
