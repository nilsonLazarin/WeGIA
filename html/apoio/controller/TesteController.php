<?php
require_once('../dao/ConexaoDAO.php');
class TesteController{
    public function teste(){
        echo 'Hello World';
        print_r(ConexaoDAO::conectar());
    }
}