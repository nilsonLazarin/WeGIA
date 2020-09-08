<?php

class Almoxarife {

    // Atributes
    
    private $id_almoxarife;
    private $id_almoxarifado;
    private $id_funcionario;
    private $descricao_funcionario;
    private $descricao_almoxarifado;

    // Constructor

    public function __construct($id_almoxarife, $id_almoxarifado, $id_funcionario, $descricao_funcionario, $descricao_almoxarifado){
        $this
            ->setId_almoxarife($id_almoxarife)
            ->setId_almoxarifado($id_almoxarifado)
            ->setId_funcionario($id_funcionario)
            ->setDescricao_funcionario($descricao_funcionario)
            ->setDescricao_almoxarifado($descricao_almoxarifado)
        ;
    }

    // Getters & Setters

    public function getId_almoxarife()
    {
        return $this->id_almoxarife;
    }

    public function setId_almoxarife($id_almoxarife)
    {
        $this->id_almoxarife = $id_almoxarife;

        return $this;
    }

    public function getId_almoxarifado()
    {
        return $this->id_almoxarifado;
    }

    public function setId_almoxarifado($id_almoxarifado)
    {
        $this->id_almoxarifado = $id_almoxarifado;

        return $this;
    }

    public function getId_funcionario()
    {
        return $this->id_funcionario;
    }

    public function setId_funcionario($id_funcionario)
    {
        $this->id_funcionario = $id_funcionario;

        return $this;
    }

    public function getDescricao_funcionario()
    {
        return $this->descricao_funcionario;
    }

    public function setDescricao_funcionario($descricao_funcionario)
    {
        $this->descricao_funcionario = $descricao_funcionario;

        return $this;
    }

    public function getDescricao_almoxarifado()
    {
        return $this->descricao_almoxarifado;
    }

    public function setDescricao_almoxarifado($descricao_almoxarifado)
    {
        $this->descricao_almoxarifado = $descricao_almoxarifado;

        return $this;
    }
}