<?php

namespace App\Controller\Admin;

use App\Utils\View;

class PageAdminController
{
   
    /**
     * Modulos disponíveis no painel
     * @var array
     */
    private static $modules = [
        'home'      => [
            'label'     => 'Home',
            'link'      => 'http://localhost/gmcadun/admin'
        ],
        'pessoas'      => [
            'label'     => 'Pessoas',
            'link'      => 'http://localhost/gmcadun/admin/pessoas'
        ],
        'agenda'      => [
            'label'     => 'Agendamento',
            'link'      => 'http://localhost/gmcadun/admin/agenda'
        ],
        'users'      => [
            'label'     => 'Usuários',
            'link'      => 'http://localhost/gmcadun/admin/usuarios'
        ],
    ];

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


    /**
     * Metodo que renderiza a view do menu
     * @param string $currentModule
     * @return string
     */
    private static function getMenu($currentModule)
    {
        //LINKS DO MENU
        $links = '';
        
        //ITERA OS MODULOS
        foreach(self::$modules as $hash=>$module){

            $links .= View::render('admin/menu/linkS', [
                'label'     => $module['label'],
                'link'      => $module['link'],
                'current'   => $hash == $currentModule ? 'active' : ''
            ]);
        }

        //RETORNA A RENDERIZAÇÃO DO MENU
        return View::render('admin/menu/box', [
            'links'     => $links
        ]);
    }

    /**
     * Método que retorna renderiza a viw do painel com conteúdos dinâmicos
     * @param string $title
     * @param string $content
     * @param string $currentModule
     * @return string
     */
    public static function getPanel($title, $content, $currentModule)
    {

        //RENDERIZA A VIEW DO PAINEL
        $contentPanel = View::render('admin/panel', [
            'menu'      => self::getMenu($currentModule),
            'content'   => $content
        ]);

        //RETORNA A PAGINA RENDERIZADA
        return self::getPage($title, $contentPanel);
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
            $links .= View::render('admin/pagination/links', [
                'page'   => $page['page'],
                'link'   => $link,
                'active' => $page['current'] ? 'active' : ''
            ]);
        }

        //RENDERIZA A VIEW BOX DE PAGINACAO
        return View::render('admin/pagination/box', [
            'links'     => $links
        ]);
        
    }

}