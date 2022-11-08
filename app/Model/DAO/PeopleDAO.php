<?php

namespace App\Model\DAO;

use App\DatabaseManager\Database;
use App\Model\Entity\PeopleEntity;
use DateTime;
use PDO;

class PeopleDAO
{

    /**
     * Undocumented function
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatment
     */
    public static function getPessoas($where = null, $order = null, $limit = null, $fields = "*")
    {
        return (new Database('pessoa'))->select($where, $order, $limit, $fields);

    }

    public function insert($people)
    {
        if (isset($people)) {
          
            $people->setId((new Database('pessoa'))->insert([
                'nome'    => $people->getNome(),
                'dt_nasc' => date_format($people->getDtNasc(), 'Y-m-d'),
                'cpf'     => $people->getCpf(),
                'rg'      => $people->getRg(),
                'nis'     => $people->getNis()
            ]));
            
            return $people->getId();
        }
    }
}
