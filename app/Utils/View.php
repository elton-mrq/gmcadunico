<?php

namespace App\Utils;

class View
{

    /**
     * Variáveis padrões
     * @var array
     */
    private static $vars = [];

    public static function init($vars = [])
    {
        
        self::$vars = $vars;
    }

    /**
     * Método que retorna o conteudo de uma view
     * 
     *@param string $view
     * @return string
     */
    private static function getContentView($view)
    {
        $file = __DIR__ . '/../../resources/view/' . $view . '.html';
        return file_exists($file) ? file_get_contents($file) : '';
    }

    /**
     * Método responsável por renderizar uma view
     *
     * @param string $view
     * @param array $vars (string/numeric)
     * @return string
     */
    public static function render($view, $vars = [])   {
        
        //CONTEUDO DA VIEW
        $contentView = self::getContentView($view);
        
        //MERGE OU JUNÇÃO DE VARIAVEIS DA VIEW
        $vars = array_merge(self::$vars, $vars);

        //CHAVES DO ARRAY DE VARIAVEIS
        $keys = array_keys($vars);        

        $keys = array_map(function($item){
            return '{{'.$item.'}}';    
        }, $keys);

        //RETORNA CONTEÚDO RENDERIZADO
        return str_replace($keys, array_values($vars), $contentView);

    }
}
