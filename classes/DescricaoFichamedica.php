<?php

    Class DescricaoFichamedica{
        private $texto;
        private $id_fichamedica;


        public function getDescricao(){
            return $this->texto;
        }

        public function getIdFichamedica(){
            return $this->id_fichamedica;
        }

        public function setDescricao($texto){
            $this->texto = $texto;
        }
        
        public function setIdFichamedica($id_fichamedica){
            $this->id_fichamedica = $id_fichamedica;
        }
    }

?>