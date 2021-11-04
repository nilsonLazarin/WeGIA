<?php
require_once 'Atendido.php';

class Saude extends Atendido
{
    private $pessoa_id_pessoa;
    private $nomePacienteAtend;
    private $nomePacienteFunc;
    private $texto;

    public function getPessoa_id_pessoa()
    {
        return $this->pessoa_id_pessoa;
    }
    public function getNomePacienteAtend()
    {
        return $this->nomePacienteAtend;
    }
    public function getNomePacienteFunc()
    {
        return $this->nomePacienteFunc;
    }
    public function getTexto()
    {
        return $this->texto;
    }

    public function setPessoa_id_pessoa($pessoa_id_pessoa)
    {
        $this->pessoa_id_pessoa = $pessoa_id_pessoa;
    }

    public function setNomePacienteAtend($nomePacienteAtend)
    {
        $this->nomePacienteAtend = $nomePacienteAtend;
    }
    public function setNomePacienteFunc($nomePacienteFunc)
    {
        $this->nomePacienteFunc = $nomePacienteFunc;
    }
    public function setTexto($texto)
    {
        $this->texto = $texto;
    }

}

?>