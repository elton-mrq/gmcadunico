<?php

namespace App\Controller\Admin;

use App\Utils\View;

class AlertController
{

    /**
     * Metódo que renderiza mensagem de sucesso
     * @param string $message
     * @return string
     */
    public static function getSuccess($message)
    {
        return View::render('admin/alert/status', [
            'tipo'      => 'success',
            'mensagem'  => $message
        ]);
    }

     /**
     * Metódo que renderiza mensagem de sucesso
     * @param string $message
     * @return string
     */
    public static function getError($message)
    {
        return View::render('admin/alert/status', [
            'tipo'      => 'danger',
            'mensagem'  => $message
        ]);
    }
}