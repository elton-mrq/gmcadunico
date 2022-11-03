<?php

namespace App\Model\Entity;

use DateTime;

class PeopleEntity
{
    private $id;
    private $nome;
    private $dt_nasc;
    private $cpf;
    private $rg;
    private $nis;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getDtNasc()
    {
        return new DateTime($this->dt_nasc);
    }

    public function setDtNasc($dtNasc)
    {
        $this->dt_nasc = $dtNasc;
    }

    public function getCpf()
    {
        return $this->cpf;
    }

    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    public function getRg()
    {
        return $this->rg;
    }

    public function setRg($rg)
    {
        $this->rg = $rg;
    }

    public function getNis()
    {
        return $this->nis;
    }

    public function setNis($nis)
    {
        $this->nis = $nis;
    }
}