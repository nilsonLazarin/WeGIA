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
    $banco = Conexao::connect();
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // require_once('conexao.php');
	// $banco = new Conexao();
    
    $funcionario = $_POST["id_funcionario"];

    // $obj_post = $_POST['id_fichamedica'];
    // $obj = json_decode($obj_post, true);
    // $total = count($obj);
    // var_dump($total);
    // var_dump($obj);

    /*$comando_select_id_funcionario = "SELECT * FROM funcionario f JOIN pessoa p ON (f.id_pessoa = p.id_pessoa WHERE nome = '$funcionario'";
    $resultado_select_id_funcionario = mysqli_query($mysqli,$comando_select_id_funcionario);
    $registro_select_id_funcionario = mysqli_fetch_row($resultado_select_id_funcionario);
    $id_funcionario = $registro_select_id_funcionario[0];*/

    $banco = $mysqli->querydados("SELECT * FROM funcionario f JOIN pessoa p ON (f.id_pessoa = p.id_pessoa WHERE p.nome = '$funcionario'");

    // $banco->query("SELECT * FROM funcionario f JOIN pessoa p ON (f.id_pessoa = p.id_pessoa WHERE nome = '$funcionario'");
	$dadoInicialCartao = $banco->result();
	$dadosCartao = $banco->arraydados();
	$linhas = $banco->rows();

    $id_funcionario = $dadosCartao[0];
    // $t = mysqli_fetch_row($selectfunc);
    // $id_funcionario = $t[0];*/
    // // $a = $mysqli->query($selectfunc);
    // // $b = mysqli_fetch_row($pdo, $selectfunc);
    // // $id_funcionario = $b[0];
    // // $id_funcionario = $b[0];

    /*while ($row = $selectfunc->fetch_array(MYSQLI_NUM)) {
         echo "<option value=" . $row[0] . ">" . $row[3] . "</option>";
    }*/
    
    try {
        $pdo = Conexao::connect();
        $prep = $pdo->prepare("INSERT INTO saude_atendimento(id_fichamedica, id_funcionario, data_atendimento, descricao) VALUES (:id_fichamedica, :id_funcionario, :data_atendimento, :descricao)");

        $prep->bindValue(":id_fichamedica", $id_fichamedica);
        $prep->bindValue(":id_funcionario", $id_funcionario);
        $prep->bindValue(":data_atendimento", $data_atendimento);
        $prep->bindValue(":descricao", $texto);

        $prep->execute();

        // $selecao = "SELECT * FROM saude_atendimento where id_fichamedica = '$id_fichamedica' and id_funcionario = '$id_funcionario' and data_atendimento = '$data_atendimento' and descricao = '$descricao'";
        // $resultado_select_id_atendimento = mysqli_query($pdo,$comando_select_id_atendimento);
        // $registro_select_id_atendimento = mysqli_fetch_row($resultado_select_id_atendimento);
        // $id_atendimento = $registro_select_id_atendimento[0];
        // $selecao = $selecao->fetchAll(PDO::FETCH_ASSOC);
        // $selecao = json_encode($selecao);
        // var_dump($selecao);

            // for($i = 0; $i<$total; $i++)
            // {

            //     $id_atendimento = $pdo->prepare("SELECT id_atendimento FROM saude_atendimento");

            //     $medicamento = $obj[$i]["nome_medicacao"];
            //     $dosagem = $obj[$i]["dosagem"];
            //     $horario_medicacao = $obj[$i]["horario"];
            //     $duracao_medicacao = $obj[$i]["tempo"];
        
            //     $prep2 = $pdo->prepare("INSERT INTO saude_medicacao (id_atendimento ,medicamento, dosagem, horario, duracao) VALUES (:id_atendimento, :medicamento, :dosagem, :horario, :duracao) ");
    
            //     $prep2->bindValue(":id_atendimento", $selecao);
            //     $prep2->bindValue(":medicamento", $medicamento);
            //     $prep2->bindValue(":dosagem", $dosagem);
            //     $prep2->bindValue(":horario", $horario_medicacao);
            //     $prep2->bindValue(":duracao", $duracao_medicacao);
        
            //     $prep2->execute();
            // } 
        header("Location: profile_paciente.php?id_fichamedica=$id_fichamedica");
        
    } catch (PDOException $e) {
        echo("Houve um erro ao realizar o cadastro do atendimento medico e medicação:<br><br>$e");
    }


}else {
    header("Location: profile_paciente.php");
}
