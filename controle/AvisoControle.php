<?php

session_start();

$config_path = "config.php";
if (file_exists($config_path)) {
    require_once($config_path);
} else {
    while (true) {
        $config_path = "../" . $config_path;
        if (file_exists($config_path)) break;
    }
    require_once($config_path);
}


//require_once ROOT . '/dao/Conexao.php';
require_once ROOT . '/classes/Aviso.php';
require_once ROOT . '/controle/AvisoNotificacaoControle.php';
require_once ROOT . '/dao/AvisoDAO.php';

class AvisoControle
{
    public function incluir()
    {

        //print_r($_SESSION);

        //print_r($_POST);

        //$idFuncionario = $_SESSION['id_pessoa'];
        $idFuncionario = $_POST['idfuncionario'];
        $idPessoaAtendida = $_POST['idpaciente'];
        $descricao = $_POST['descricao_emergencia'];

        $aviso = new Aviso($idFuncionario, $idPessoaAtendida, $descricao);

        //echo $aviso->getIdFuncionario() . '<br>';
        /*echo $aviso->getIdPessoaAtendida() . '<br>';
        echo $aviso->getDescricao() . '<br>';*/

        $avisoDAO = new AvisoDAO();
        $avisoNotificacaoControle = new AvisoNotificacaoControle();

        try{
            $ultimaInsercao = $avisoDAO->cadastrar($aviso);
            if(!$ultimaInsercao){
                throw new PDOException();
            }else{
                //echo $ultimaInsercao;
                $aviso->setIdAviso($ultimaInsercao);
                $avisoNotificacaoControle->incluir($aviso);
            }
        }catch(PDOException $e){

        }
    }
}
