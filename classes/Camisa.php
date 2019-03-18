<?php

class Camisa
{
   private $id_camisa;
   private $tamanhos;
   
    public function __construct($tamanhos)
    {

        $this->tamanhos=$tamanhos;

    }

   public function getId_camisa()
    {
        return $this->id_camisa;
    }

    public function getTamanhos()
    {
        return $this->tamanhos;
    }

    public function setId_camisa($id_camisa)
    {
        $this->id_camisa = $id_camisa;
    }

    public function setTamanhos($tamanhos)
    {
        $this->tamanhos = $tamanhos;
    }
}