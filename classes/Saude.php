<?php
require_once 'Atendido.php';
// require_once 'Pessoa.php';

class Saude extends Atendido
{
    // private $pessoa_id_pessoa;
    // private $nome;
    private $texto;
    private $enfermidade;
    private $data_diagnostico;
    // private $tipoSanguineo;

    // public function getPessoa_id_pessoa()
    // {
    //     return $this->pessoa_id_pessoa;
    // }
    // public function getNome()
    // {
    //     return $this->nome;
    // }
    public function getTexto()
    {
        return $this->texto;
    }
    public function getEnfermidade()
    {
        return $this->enfermidade;
    }
    public function getData_diagnostico()
    {
        return $this->data_diagnostico;
    }
    // public function getTipoSanguineo()
    // {
    //     return $this->tipoSanguineo;
    // }
    // public function setPessoa_id_pessoa($pessoa_id_pessoa)
    // {
    //     $this->pessoa_id_pessoa = $pessoa_id_pessoa;
    // }

    // public function setNome($nome)
    // {
    //     $this->nome = $nome;
    // }
    public function setTexto($texto)
    {
        $this->texto = $texto;
    }
    public function setEnfermidade($enfermidade)
    {
        $this->enfermidade = $enfermidade;
    }
    public function setData_diagnostico($data_diagnostico)
    {
        $this->data_diagnostico = $data_diagnostico;
    }
    // public function setTipoSanguineo($tipoSanguineo)
    // {
    //     $this->tipoSanguineo = $tipoSanguineo;
    // }

}



?>