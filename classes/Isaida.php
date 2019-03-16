<?php

class Isaida
{
   private $id_isaida;
   private $id_saida;
   private $id_produto;
   private $qtd;
   private $valor_unitario;
   
    public function __construct($qtd,$valor_unitario)
    {

        $this->qtd=$qtd;
        $this->valor_unitario=$valor_unitario;

    }

    public function getId_isaida()
    {
        return $this->id_isaida;
    }

    public function getId_saida()
    {
        return $this->id_saida;
    }

    public function getId_produto()
    {
        return $this->id_produto;
    }

    public function getQtd()
    {
        return $this->qtd;
    }

    public function getValor_unitario()
    {
        return $this->valor_unitario;
    }

    public function setId_saida($id_saida)
    {
        $this->id_saida = $id_saida;
    }

    public function setId_produto($id_produto)
    {
        $this->id_produto = $id_produto;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function setQtd($qtd)
    {
        $this->qtd = $qtd;
    }

    public function setValor_unitario($valor_unitario)
    {
        $this->valor_unitario = $valor_unitario;
    }
}