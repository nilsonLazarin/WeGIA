<?php

class almoxarifado
{
   private $id_almoxarifado;
   private $descricao_almoxarifado;
   
    public function __construct($descricao_almoxarifado)
    {

        $this->descricao_almoxarifado=$descricao_almoxarifado;

    }

   public function getId_almoxarifado()
    {
        return $this->id_almoxarifado;
    }

    public function getDescricao_almoxarifado()
    {
        return $this->descricao_almoxarifado;
    }

    public function setId_almoxarifado($id_almoxarifado)
    {
        $this->id_almoxarifado = $id_almoxarifado;
    }

    public function setDescricao_almoxarifado($descricao_almoxarifado)
    {
        $this->descricao_almoxarifado = $descricao_almoxarifado;
    }
}