<?php

class Estoque
{
   private $id_produto;
   private $id_almoxarifado;
   private $qtd;
   
    public function __construct($qtd)
    {
        $this->qtd=$qtd;
    }

    public function getId_produto()
    {
        return $this->id_produto;
    }

    public function getId_almoxarifado()
    {
        return $this->id_almoxarifado;
    }

    public function getQtd()
    {
        return $this->qtd;
    }

    public function setId_produto($id_produto)
    {
        $this->id_produto = $id_produto;
    }

    public function setId_almoxarifado($id_almoxarifado)
    {
        $this->id_almoxarifado = $id_almoxarifado;
    }

    public function setQtd($qtd)
    {
        $this->qtd = $qtd;
    }

    
}