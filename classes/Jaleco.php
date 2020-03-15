<?php

class Jaleco
{
   private $id_jaleco;
   private $tamanhos;
   
    public function __construct($tamanhos)
    {

        $this->tamanhos=$tamanhos;

    }

   public function getId_jaleco()
    {
        return $this->id_jaleco;
    }

    public function getTamanhos()
    {
        return $this->tamanhos;
    }

    public function setId_jaleco($id_jaleco)
    {
        $this->id_jaleco = $id_jaleco;
    }

    public function setTamanhos($tamanhos)
    {
        $this->tamanhos = $tamanhos;
    }
}