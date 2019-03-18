<?php

class Cargo
{
   private $id_cargo;
   private $cargo;
   
    public function __construct($cargo)
    {

        $this->cargo=$cargo;

    }

   public function getId_cargo()
    {
        return $this->id_cargo;
    }

    public function getCargo()
    {
        return $this->cargo;
    }

    public function setId_cargo($id_cargo)
    {
        $this->id_cargo = $id_cargo;
    }

    public function setCargo($cargo)
    {
        $this->cargo = $cargo;
    }
}