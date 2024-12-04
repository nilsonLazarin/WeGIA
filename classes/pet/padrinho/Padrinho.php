<?php
 require_once __DIR__ . '/../../Pessoa.php';

 class Padrinho extends Pessoa
{   
    private $id_padrinho;
    private $id_pessoa;

    //Get e Set Padrinho
    public function getId_padrinho()
    {
        return $this->id_padrinho;
    }
    public function setId_padrinho($id_padrinho)
    {
        $this->id_padrinho = $id_padrinho;
    }

    //Get e Set Pessoa
    public function getId_pessoa()
    {
        return $this->id_pessoa;
    }
    public function setId_pessoa($id_pessoa)
    {
        $this->id_pessoa = $id_pessoa;
    }

    static public function getDataNascimentoMaxima()
    {
        $idadeMinima = 18;
        $data = date('Y-m-d', strtotime("-$idadeMinima years"));
        return $data;
    }

    static public function getDataNascimentoMinima()
    {
        $idadeMaxima = 100;
        $data = date('Y-m-d', strtotime("-$idadeMaxima years"));
        return $data;
    }
}