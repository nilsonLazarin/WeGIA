<?php

class TipoSaida
{
   private $id_tipo;
   private $descricao;
   
    public function __construct($descricao)
    {

        $this->descricao=$descricao;

    }

    public function getId_tipo()
    {
        return $this->id_tipo;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setId_tipo($id_tipo)
    {
        $this->id_tipo = $id_tipo;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }
}