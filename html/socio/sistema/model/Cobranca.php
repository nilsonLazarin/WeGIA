<?php
    class Cobranca{

        private $id;
        private $idSocio;
        private $localRecepcao;
        private $receptor;
        private $valorPagemento;
        private $formaPagamento;
        private $dataPagamento;

        public function setIdSocio($idSocio){
            $this->idSocio = $idSocio;
        }

        public function getIdSocio(){
            return $this->idSocio;
        }

        public function setLocalRecepcao($localRecepcao){
            $this->localRecepcao = $localRecepcao;
        }

        public function getLocalRecepcao(){
            return $this->localRecepcao;
        }

        public function setReceptor($receptor){
            $this->receptor = $receptor;
        }

        public function getReceptor(){
            return $this->receptor;
        }

        public function setValorPagamento($valorPagemento){
            $this->valorPagemento = $valorPagemento;
        }

        public function getValorPagamento(){
            return $this->valorPagemento;
        }

        public function setFormaPagamento($formaPagamento){
            $this->formaPagamento = $formaPagamento;
        }

        public function getFormaPagamento(){
            return $this->formaPagamento;
        }

        /**
         * Get the value of dataPagamento
         */ 
        public function getDataPagamento()
        {
                return $this->dataPagamento;
        }

        /**
         * Set the value of dataPagamento
         *
         * @return  self
         */ 
        public function setDataPagamento($dataPagamento)
        {
                $this->dataPagamento = $dataPagamento;
        }

        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;
        }
    }
?>