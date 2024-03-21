<?php 
    class Aviso{

        //Propriedades
        private $idAviso;
        private $idFuncionario;
        private $idPessoaAtendida;
        private $descricao;
        private $data;

        /**
         * Recebe dois parâmetros do tipo inteiro ($idFuncionario, $idPessoaAtendida) e uma String ($descricao) para instanciar um objeto do tipo Aviso.
         */
        public function __construct($idFuncionario, $idPessoaAtendida, $descricao)
        {
            $this->setIdFuncionario($idFuncionario);
            $this->setIdPessoaAtendida($idPessoaAtendida);
            $this->setDescricao($descricao);
        }

        //Métodos Acessores

        public function getIdAviso(){
            return $this->idAviso;
        }

        public function setIdAviso($idAviso){
            $this->idAviso = $idAviso;
        }

        public function getIdFuncionario(){
            return $this->idFuncionario;
        }

        public function setIdFuncionario($idFuncionario){
            $this->idFuncionario = $idFuncionario;
        }

        public function getIdPessoaAtendida(){
            return $this->idPessoaAtendida;
        }

        public function setIdPessoaAtendida($idPessoaAtendia){
            $this->idPessoaAtendida = $idPessoaAtendia;
        }

        public function getDescricao(){
            return $this->descricao;
        }

        public function setDescricao($descricao){
            $this->descricao = $descricao;
        }

        public function getData(){
            return $this->data;
        }

        public function setData($data){
            $this->data = $data;
        }
    }
?>