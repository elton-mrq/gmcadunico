<?php

namespace App\Common;

class Environment
{
    /**
     * Responsável por carregar as variaveis de ambiente
     *
     * @param string $dir Caminho absoluto da pasta onde se encontra o arquivo .env
     */
    public static function load($dir)
    {
        //VERIFICA SE ARQUIVO .ENV EXISTE
        if(!file_exists($dir . '/.env')){
            return false;
        }

        //DEFINE AS VARIAVEIS DE AMBIENTE
        $lines = file($dir .'/.env');
        foreach($lines as $line){
            $line = trim($line);
            putenv($line);
        }
        //echo '<pre>'; print_r($lines); echo '<pre>'; exit;
    }

}