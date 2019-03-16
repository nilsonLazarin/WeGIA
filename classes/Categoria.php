<?php

class Categoria
{
    
    private $id_categoria_produto;
    private $descricao_categoria;
    
    public function __construct($descricao_categoria){
        $this->descricao_categoria=$descricao_categoria;
    }
    public function getId_categoria_produto()
    {
        return $this->id_categoria_produto;
    }

    public function getDescricaoCategoria()
    {
        return $this->descricao_categoria;
    }

    public function setId_categoria_produto($id_categoria_produto)
    {
        $this->id_categoria_produto = $id_categoria_produto;
    }

    public function setDescricao_categoria($descricao_categoria)
    {
        $this->descricao_categoria = $descricao_categoria;
    }

}
