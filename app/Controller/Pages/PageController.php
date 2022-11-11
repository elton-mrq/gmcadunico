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
     * Método que rendireza o layout de paginação
     *
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    public static function getPagination($request, $obPagination)
    {
        //OBTER NUMERO DE PAGINAS
        $pages = $obPagination->getPages();
        
        //VERIFICA A QUANTIDADE DE PAGINAS
        if(count($pages) <= 1) return '';

        //LINKS
        $links = '';

        //OBTER A URL ATUAL DA ROTA SEM GETS
        $url = $request->getRouter()->getCurrentUrl();
        
        //GETS
        $queryParams = $request->getQueryParams();

        //RENDERIZA OS LINKS
        foreach($pages as $page){
            //ALTERA PÁGINAS
            $queryParams['page'] = $page['page'];

            //LINK
            $link = $url . '?' .http_build_query($queryParams);

            //RENDERIZA VIEW
            $links .= View::render('pages/pagination/links', [
                'page'   => $page['page'],
                'link'   => $link,
                'active' => $page['current'] ? 'active' : ''
            ]);
        }

        //RENDERIZA A VIEW BOX DE PAGINACAO
        return View::render('pages/pagination/box', [
            'links'     => $links
        ]);
        
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
