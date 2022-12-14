<?php

namespace App\Model\Entity;

use App\DatabaseManager\Database;

class UserEntity
{

    /**
     * id do usuário
     * @var integer
     */
    public $id;

    /**
     * Nome do Usuário
     * @var string
     */
    public $nome;

    /**
     * CPF do Usuário
     * @var string
     */
    public $cpf;

    /**
     * E-mail do Usuário
     * @var string
     */
    public $email;

    /**
     * Senha do Usuário
     * @var string
     */
    public $senha;


    /**
     * Método que retorna um usuário por e-mail
     * @param string $email
     * @return UserEntity
     */
    public static function getUserByEmail($email)
    {
        return (new Database('usuarios'))->select("email = '". $email ."'")->fetchObject(self::class);
    }


}