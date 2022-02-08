<pre>
<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

session_start();
extract($_REQUEST);
if (!isset($_SESSION["usuario"])){
    header("Location: ../../index.php");
}

if ($_POST){
    require_once "../../dao/Conexao.php";	 
    
    $aplicacao = date('Y-m-d H:i:s'); // a aplicação é a data e o horario
    
    try {
        $pdo = Conexao::connect();
        $prep = $pdo->prepare("INSERT INTO saude_medicamento_administracao(aplicação, saude_medicacao_id_medicacao, pessoa_id_pessoa, funcionario_id_funcionario) VALUES (:aplicação, :saude_medicacao_id_medicacao, :pessoa_id_pessoa, :funcionario_id_funcionario)");

        $prep->bindValue(":aplicação", $aplicacao);
        $prep->bindValue(":saude_medicacao_id_medicacao", $id_medicacao);
        $prep->bindValue(":pessoa_id_pessoa", $pessoa_id_pessoa);
        $prep->bindValue(":funcionario_id_funcionario", $funcionario_id_funcionario);

        $prep->execute();
        
        header("Location: profile_paciente.php?id_fichamedica=$id_fichamedica");
    } catch (PDOException $e) {
        echo("Houve um erro ao realizar o upload das aplicações:<br><br>$e");
    }


}else {
    header("Location: profile_paciente.php");
}


