<?php

class Modulo
{
    private $id_modulo;
    private $id_recurso;
    private $visibilidade;
    
    
    public function getId_modulo()
    {
        return $this->id_modulo;
    }

    public function getId_recurso()
    {
        return $this->id_recurso;
    }
    public function getVisibilidade()
    {
        return $this->visibilidade;
    }

    public function setId_modulo($id_modulo)
    {
        $this->id_modulo = $id_modulo;
    }
    public function setId_recurso($id_recurso)
    {
        $this->id_recurso = $id_recurso;
    }
    public function setVisibilidade($visibilidade)
    {
        $this->visibilidade = $visibilidade;
    }
}
