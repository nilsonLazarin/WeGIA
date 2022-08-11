<?php


class SaudePet{
    private $nome;
    private $texto;
    private $castrado;

    public function getNome(){
        return $this->nome;
    }

    public function getTexto(){
        return $this->texto;
    }

    public function getCastrado(){
        return $this->castrado;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setTexto($texto)
    {
        $this->texto = $texto;
    }

    public function setCastrado($castrado)
    {
        $this->castrado = $castrado;
    }
}
?>
