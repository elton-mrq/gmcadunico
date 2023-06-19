<?php

namespace App\Model\Entity;

use App\DatabaseManager\Database;

class UserEntity
{

    /**
     * id do usuário
     * @var integer
     */
    private $id;

    /**
     * Nome do Usuário
     * @var string
     */
    private $nome;

    /**
     * CPF do Usuário
     * @var string
     */
    private $cpf;

    /**
     * E-mail do Usuário
     * @var string
     */
    private $email;

    /**
     * Senha do Usuário
     * @var string
     */
    private $senha;   

    /**
     * Status do Usuário
     *
     * @var string
     */
    private $status;


    /**
     * Get id do usuário
     *
     * @return  integer
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id do usuário
     *
     * @param  integer  $id  id do usuário
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
    

    /**
     * Get nome do Usuário
     *
     * @return  string
     */ 
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set nome do Usuário
     *
     * @param  string  $nome  Nome do Usuário
     *
     * @return  self
     */ 
    public function setNome(string $nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get cPF do Usuário
     *
     * @return  string
     */ 
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * Set cPF do Usuário
     *
     * @param  string  $cpf  CPF do Usuário
     *
     * @return  self
     */ 
    public function setCpf(string $cpf)
    {
        $this->cpf = $cpf;

        return $this;
    }

    /**
     * Get e-mail do Usuário
     *
     * @return  string
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set e-mail do Usuário
     *
     * @param  string  $email  E-mail do Usuário
     *
     * @return  self
     */ 
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get senha do Usuário
     *
     * @return  string
     */ 
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * Set senha do Usuário
     *
     * @param  string  $senha  Senha do Usuário
     *
     * @return  self
     */ 
    public function setSenha(string $senha)
    {
        $this->senha = $senha;

        return $this;
    }

  

    /**
     * Get status do Usuário
     *
     * @return  string
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status do Usuário
     *
     * @param  string  $status  Status do Usuário
     *
     * @return  self
     */ 
    public function setStatus(string $status)
    {
        $this->status = $status;

        return $this;
    }
}