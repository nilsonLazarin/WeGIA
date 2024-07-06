<?php

require_once 'Beneficiados.php';

class Beneficios extends Beneficiados
{

    private $id_beneficios;
    private $descricao_beneficios;

    public function getId_beneficios()
    {
        return $this->id_beneficios;
    }

    public function getDescricao_beneficios()
    {
        return $this->descricao_beneficios;
    }

    public function setId_beneficios($id_beneficios)
    {
        if (!$id_beneficios || !is_numeric($id_beneficios) || $id_beneficios < 1) {
            throw new InvalidArgumentException('O valor do id de um benefício deve ser um inteiro maior ou igual a 1.');
        }
        $this->id_beneficios = $id_beneficios;
    }

    public function setDescricao_beneficios($descricao_beneficios)
    {
        if (!$descricao_beneficios || empty($descricao_beneficios)) {
            throw new InvalidArgumentException('A descrição de um benefício não pode ser vazia.');
        }
        $this->descricao_beneficios = $descricao_beneficios;
    }
}
