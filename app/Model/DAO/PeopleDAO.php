<?php

namespace App\Model\DAO;

use App\DatabaseManager\Database;
use App\Model\Entity\PeopleEntity;
use DateTime;
use PDO;

class PeopleDAO
{

    /**
     * Método que retorna os dados de pessoas do BD
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

     /**
     * Método que retorna os dados de uma pessoa com base id
     *
     * @param integer $id
     * @return PessoaEntity
     */
    public static function getPeopleById($id)
    {
        return self::getPessoas('id = ' . $id)->fetchObject(PeopleEntity::class);
    }

    /**
     * Método que cadastra os dados de uma pessoa no BD
     *
     * @param PessoaEntity $people
     * @return boolean
     */
    public static function cadastrar($people)
    {
        if (isset($people)) {
          
            $people->setId((new Database('pessoa'))->insert([
                'nome'    => $people->getNome(),
                'dt_nasc' => date_format($people->getDtNasc(), 'Y-m-d'),
                'cpf'     => $people->getCpf(),
                'rg'      => $people->getRg(),
                'nis'     => $people->getNis()
            ]));
            
            return true;
        }
    }

    /**
     * Método que atualiza os dados de Pessoa no BD
     *
     * @param PeopleEntity $people
     * @return boolean
     */
    public static function atualizar($people)
    {
        if(!isset($people)){
            return false;
        }

        return (new Database('pessoa'))->update('id = ' . $people->getId(), [
            'nome'      => $people->getNome(),
            'dt_nasc'   => date_format($people->getDtNasc(), 'Y-m-d'),
            'cpf'       => $people->getCpf(),
            'rg'        => $people->getRg(),
            'nis'       => $people->getNis()
        ]);
            
    }

    /**
     * Método que realiza exclusão de Pessoa do BD
     *
     * @param PeopleEntity $people
     * @return boolean
     */
    public static function excluir($people)
    {
        //VERIFICA SE EXISTE A PESSOA
        if(!isset($people)){
            return false;
        }

        return (new Database('pessoa'))->delete('id = ' . $people->getId());
    }

   
}
