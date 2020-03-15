<?php

class Origem
{
   private $id_origem;
   private $nome;
   private $cnpj;
   private $cpf;
   private $telefone;
   
    public function __construct($nome,$cnpj,$cpf,$telefone)
    {

        $this->nome=$nome;
        $this->cnpj=$cnpj;
        $this->cpf=$cpf;
        $this->telefone=$telefone;

    }
    
    public function getId_origem()
    {
        return $this->id_origem;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getCnpj()
    {
        return $this->cnpj;
    }

    public function getCpf()
    {
        return $this->cpf;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }

    public function setId_origem($id_origem)
    {
        $this->id_origem = $id_origem;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
    }

    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }
}