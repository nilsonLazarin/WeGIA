<?php
	require_once('../conexao.php');
	$tag = trim(filter_input(INPUT_POST, 'tag', FILTER_SANITIZE_STRING));
	
	$sql = "INSERT into socio_tag(tag) values(?)";
	$stmt = mysqli_prepare($conexao, $sql);

	if(!$stmt){
		http_response_code(500);
		exit('Erro ao preparar consulta');
	}

	$stmt->bind_param('s', $tag);
	if(!$stmt->execute()){
		http_response_code(500);
		exit('Erro ao realizar consulta');
	}

	http_response_code(200);
	exit('Consulta realizada com sucesso');
?>