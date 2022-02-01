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
    $query = new Conexao();
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    $funcionario = $_POST["id_funcionario"];
    
    try {
        $pdo = Conexao::connect();

        $aa = "SELECT * FROM funcionario WHERE id_funcionario = '$funcionario'";
        $resultado_select_id_funcionario = $mysqli->query($aa);
        $registro_select_id_funcionario = mysqli_fetch_row($resultado_select_id_funcionario);
        $id_funcionario = $registro_select_id_funcionario[0];
        var_dump($id_funcionario);
        $nome_funcionario = $registro_select_id_funcionario[1];

        $prep = $pdo->prepare("INSERT INTO saude_atendimento(id_fichamedica, id_funcionario, data_atendimento, descricao) VALUES (:id_fichamedica, :id_funcionario, :data_atendimento, :descricao)");

        $prep->bindValue(":id_fichamedica", $id_fichamedica);
        $prep->bindValue(":id_funcionario", $id_funcionario);
        $prep->bindValue(":data_atendimento", $data_atendimento);
        $prep->bindValue(":descricao", $texto);

        $prep->execute();

        // medicacao 
        
        $comando_select_id_atendimento = "select * from saude_atendimento where id_fichamedica = '$id_fichamedica' and id_funcionario = '$id_funcionario' and data_atendimento = '$data_atendimento' and descricao = '$texto'";
        $resultado_select_id_atendimento = $mysqli->query($comando_select_id_atendimento);
        $registro_select_id_atendimento = mysqli_fetch_row($resultado_select_id_atendimento);
        $id_atendimento = $registro_select_id_atendimento[0];

        $obj_post = $_POST['acervo'];
        $obj = json_decode($obj_post, true);
        $total = count($obj);

        for($i=0;$i<$total;$i++)
        { 
            $medicamento = $obj[$i]["nome_medicacao"];
            $dosagem = $obj[$i]["dosagem"];
            $horario_medicacao = $obj[$i]["horario"];
            $duracao_medicacao = $obj[$i]["tempo"];

            $comando_insert_medicacao = "insert into saude_medicacao (id_atendimento,medicamento, dosagem,horario,duracao) values ('$id_atendimento','$medicamento','$dosagem','$horario_medicacao','$duracao_medicacao')";
            $resultado_insert_medicacao = $mysqli->query($comando_insert_medicacao);
        }

        
        header("Location: profile_paciente.php?id_fichamedica=$id_fichamedica");
        
    } catch (PDOException $e) {
        echo("Houve um erro ao realizar o cadastro do atendimento medico e medicação:<br><br>$e");
    }


}else {
    header("Location: profile_paciente.php");
}
