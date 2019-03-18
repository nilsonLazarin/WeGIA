<?php
class Calcado
{
    
   private $id_calcado;
   private $tamanhos;
   
    public function __construct($tamanhos)
    {

        $this->tamanhos=$tamanhos;

    }

   public function getId_calcado()
    {
        return $this->id_calcado;
    }

    public function getTamanhos()
    {
        return $this->tamanhos;
    }

    public function setId_calcado($id_calcado)
    {
        $this->id_calcado = $id_calcado;
    }

    public function setTamanhos($tamanhos)
    {
        $this->tamanhos = $tamanhos;
    }
}