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
 
    $descricao = " aaa ";


    
    try {
        $pdo = Conexao::connect();
        $prep = $pdo->prepare("INSERT INTO saude_atendimento (id_fichamedica,id_funcionario,data_atendimento, descricao) VALUES (:id_fichamedica, :id_enfermeiro, :data_atendimento_enf , :descricao)");
        
        $prep->bindValue(":id_fichamedica", $id_fichamedica);
        $prep->bindValue(":id_funcionario", $id_enfermeiro);
        $prep->bindValue(":data_atendimento", $data_atendimento_enf);
        $prep->bindValue(":descricao", $descricao);

        $prep->execute();

        // aplicar medicacao

        $selec_enfermeiro = "SELECT max(id) FROM saude_atendimento";
        $resultado = $mysqli->query($select_enfermeiro);
        $registro = mysqli_fetch_row($resultado);
        $id_atendimento = $registro[0];

        $obj_post = $_POST['acervo_post']; 
        $obj = json_decode($obj_post, true); 
        var_dump($obj);
        $total = count($obj);

        for($i=0;$i<$total;$i++)
        {        
            $horario_aplicacao = $obj[$i]['horario_aplicacao'];
            $nome_medicamento = $obj[$i]['med'];           

            $select_medicacao = "SELECT * FROM saude_medicacao";
            $resultado_select_id_medicacao = $mysqli->query($select_medicacao);
            $registro_select_id_medicacao = mysqli_fetch_row($resultado_select_id_medicacao);

            $id_medicacao = $registro_select_id_medicacao[0];
            $comando_at = "insert into atendimento_enfermeiro_medicacao (atendimento_enfermeiro_id,medicacao_id,horario_aplicacao) values ('$id_atendimento','$id_medicacao','$horario_aplicacao')";
            $resultado_insert_atendimento_enfermeiro_medicacao = mysqli_query($conexao,$comando_at);
               
        }


        
        header("Location: profile_paciente.php?id_fichamedica=$id_fichamedica");
    } catch (PDOException $e) {
        echo("Houve um erro ao realizar o upload do exame:<br><br>$e");
    }


}else {
    header("Location: profile_paciente.php");
}


