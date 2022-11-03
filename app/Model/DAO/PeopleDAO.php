<?php

namespace App\Model\DAO;

use App\DatabaseManager\Database;
use App\Model\Entity\PeopleEntity;
use PDO;

class PeopleDAO
{

    public static function getPessoas($where = null, $order = null, $limit = null)
    {
        $dataSet = (new Database('pessoa'))->select($where, $order, $limit)
                                            ->fecthAll();
        
        if($dataSet){

            $listaPessoas = [];
            foreach ($dataSet as $dataSetPessoa){
                $pessoa = new PeopleEntity();
                $pessoa->setId($dataSetPessoa['id']);
                $pessoa->setNome($dataSetPessoa['nome']);
                $pessoa->setCpf($dataSetPessoa['cpf']);
    
                $listaPessoas = $pessoa;
            }

            return $listaPessoas;

        }else {

            return false;

        }
        

    }

}