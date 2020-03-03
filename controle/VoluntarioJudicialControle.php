<?php 
require_once '../classes/VoluntarioJudicial.php';

function formatoDataYMD($data)
    {
        $data_arr = explode("/", $data);
        
        $datac = $data_arr[2] . '-' . $data_arr[1] . '-' . $data_arr[0];
        
        return $datac;
    }


//if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	$cpf = $_POST['cpf'];

	$senha = '';

	$nome = $_POST['nome'];

	$sexo = $_POST['sexo'];

	$telefone = $_POST['telefone'];

	$data_nascimento = $_POST['dataNascimento'];

	$data_nascimento = formatoDataYMD($data_nascimento);

	$imagem = 'imagem';

	$cep = '';

	$cidade = '';

	$bairro = '';

	$logradouro = '';

	$numero_endereco = '';

	$complemento = '';

	$registro_geral = $_POST['registroGeral'];

	$orgao_emissor = $_POST['orgaoEmissor'];

	$data_expedicao = $_POST['dataExpedicao'];

	$data_expedicao = formatoDataYMD($data_expedicao);

	$nome_mae = $_POST['nomeMae'];

	$nome_pai = $_POST['nomePai'];

	$voluntario_judicial=new VoluntarioJudicial();

	$voluntario_judicial->incluir($cpf, $senha, $nome, $sexo, $telefone, $data_nascimento, $imagem, $cep, $cidade, $bairro, $logradouro, $numero_endereco, $complemento, $registro_geral, $orgao_emissor, $data_expedicao, $nome_mae, $nome_pai);
