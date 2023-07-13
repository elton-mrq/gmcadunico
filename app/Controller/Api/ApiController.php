<?php

namespace App\Controller\Api;

Class ApiController
{

    /**
     * Método que retorna os detalhes da API
     *
     * @param Request $request
     * @return array
     */
    public static function getDetails($request)
    {
        return [
            'nome'      => 'API CadUnico',
            'versao'    => 'v1.0.0',
            'autor'     => 'Elton Marques',
            'email'     => 'eltonmrq@gmail.com'
        ];
    }

    //echo '<pre>'; print_r($obUser); echo '<pre>'; exit;
}