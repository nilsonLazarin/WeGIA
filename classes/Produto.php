<?php

class Produto
{
   private $id_produto;
   private $id_categoria_produto;
   private $id_unidade;
   private $descricao;
   private $preco;
   private $codigo;
   
public function __construct($descricao,$codigo,$preco)
    {
        $this->preco=$preco;
        $this->descricao=$descricao;
        $this->codigo=$codigo;

    }

public function getId_produto()
    {
        return $this->id_produto;
    }

public function get_categoria_produto()
    {
        return $this->id_categoria_produto;
    }

public function get_unidade()
    {
        return $this->id_unidade;
    }

public function getPreco()
    {
        return $this->preco;
    }

public function getDescricao()
    {
        return $this->descricao;
    }

public function getCodigo()
    {
        return $this->codigo;
    }

public function setId_produto($id_produto)
    {
        $this->id_produto = $id_produto;
    }

public function set_categoria_produto($id_categoria_produto)
    {
        $this->id_categoria_produto = $id_categoria_produto;
    }

public function set_unidade($id_unidade)
    {
        $this->id_unidade = $id_unidade;
    }

public function setPreco($preco)
    {
        $this->preco = $preco;
    }

public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

   
   
}