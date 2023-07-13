<?php

namespace App\Model\DAO;

use App\DatabaseManager\Database;
use App\Model\Entity\UserEntity;

Class UserDAO
{

    /**
     * Método que retorna um usuário pelo seu ID
     *
     * @param Integer $id
     * @return UserEntity
     */
    public static function getUserById($id)
    {
        return self::getUsers('id = ' . $id)->fetchObject(UserEntity::class);
    }
    
    /**
     * Método que retorna um usuário por e-mail
     * @param string $email
     * @return UserEntity
     */
    public static function getUserByEmail($email)
    {
        return self::getUsers("email = '" . $email . "'")->fetchObject(UserEntity::class);
        //return (new Database('usuarios'))->select("email = '". $email ."'")->fetchObject(UserEntity::class);
    }

    /**
     * Método que retorna usuaário por CPF
     *
     * @param string $cpf
     * @return UserEntity
     */
    public static function getUserByCpf($cpf)
    {
        return self::getUsers("cpf = '" . $cpf ."'")->fetchObject(UserEntity::class);
    }

    /**
     * Método que retorna usuários do BD
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatment
     */
    public static function getUsers($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('usuarios'))->select($where, $order, $limit, $fields);
    }

    /**
     * Método que cadastra novo usuário no BD
     *
     * @param UserEntity $usuario
     * @return boolean
     */
    public static function cadastrar($usuario)
    {
        if(!isset($usuario)){
            return false;
        }

        //INSERE A INSTANCIA NO BANCO DE DADOS
        $usuario->setId((new Database('usuarios'))->insert([
            'nome'      => $usuario->getNome(),
            'cpf'       => $usuario->getCpf(),
            'email'     => $usuario->getEmail(),
            'senha'     => $usuario->getSenha(),
            'status'    => $usuario->getStatus()    
        ]));
        
        //SUCESSO
        return true;
    }

    /**
     * Método que atualiza dados do usuário no BD
     *@param UserEntity $usuario
     * @return boolean
     */
    public static function atualizar($usuario)
    {
        if(!isset($usuario)){
            return false;
        }

        return (new Database('usuarios'))->update('id = ' . $usuario->getId(), [
            'nome'      => $usuario->getNome(),
            'cpf'       => $usuario->getCpf(),
            'email'     => $usuario->getEmail(),
            'senha'     => $usuario->getSenha(),
            'status'    => $usuario->getStatus()
        ]);

    }

    /**
     * Método que exclui dados do usuário no BD
     *
     * @param UserEntity $usuario
     * @return void
     */
    public static function excluir($usuario)
    {
        if(!isset($usuario)){
            return false;
        }

        return (new Database('usuarios'))->delete('id = ' . $usuario->getId());
    }

}