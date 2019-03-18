<?php

class Calca
{
    
   private $id_calca;
   private $tamanhos;
   
    public function __construct($tamanhos)
    {

        $this->tamanhos=$tamanhos;

    }

   public function getId_calca()
    {
        return $this->id_calca;
    }

    public function getTamanhos()
    {
        return $this->tamanhos;
    }

    public function setId_calca($id_calca)
    {
        $this->id_calca = $id_calca;
    }

    public function setTamanhos($tamanhos)
    {
        $this->tamanhos = $tamanhos;
    }
}