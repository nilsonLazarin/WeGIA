<?php
require_once ('acesso.php');
require_once ('Funcionario.php');

class Cargo
{

    private $id_cargo;

    private $descricao;

    public function getId_cargo()
    {
        return $this->id_cargo;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setId_cargo($id_cargo)
    {
        $this->id_cargo = $id_cargo;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }
}

