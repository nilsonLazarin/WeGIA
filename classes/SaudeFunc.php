<?php
require_once 'Funcionario.php';

class SaudeFunc extends Funcionario
{
    private $pessoa_id_pessoa;
    private $nomePacienteFunc;
    private $texto;
    
    public function getPessoa_id_pessoa()
    {
        return $this->pessoa_id_pessoa;
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