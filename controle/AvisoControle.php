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

require_once ROOT . '/classes/Aviso.php';
require_once ROOT . '/controle/AvisoNotificacaoControle.php';
require_once ROOT . '/dao/AvisoDAO.php';

class AvisoControle
{
    public function incluir()
    {

        $idFuncionario = $_POST['idfuncionario'];
        $idPessoaAtendida = $_POST['idpaciente'];
        $descricao = $_POST['descricao_emergencia'];
        $idfichamedica = $_POST['idfichamedica'];

        $aviso = new Aviso($idFuncionario, $idPessoaAtendida, $descricao);

        $avisoNotificacaoControle = new AvisoNotificacaoControle();

        try{
            $avisoDAO = new AvisoDAO();
            $ultimaInsercao = $avisoDAO->cadastrar($aviso);
            if(!$ultimaInsercao){
                throw new PDOException();
            }else{
                $aviso->setIdAviso($ultimaInsercao);
                $avisoNotificacaoControle->incluir($aviso);
                header("Location: ../html/saude/historico_paciente.php?id_fichamedica=$idfichamedica");
            }
        }catch(PDOException $e){
            $e->getMessage();
        }
    }
}
