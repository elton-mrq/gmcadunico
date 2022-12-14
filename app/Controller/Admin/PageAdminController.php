<?php

namespace App\Controller\Admin;

use App\Utils\View;

class PageAdminController
{

    /**
     * Retorna o conteúdo (View) da estrutura genérica de página do panel administrativo
     *
     * @param string $title
     * @param string $content
     * @return string
     */
    public static function getPage($title, $content)
    {
        return View::render('admin/page', [
            'title'     => $title,
            'content'   => $content
        ]);
    }

}