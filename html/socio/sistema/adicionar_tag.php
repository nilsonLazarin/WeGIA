<?php
	require_once('../conexao.php');

	if (isset($_POST["tag"])) {
		$tag = $_POST["tag"];
		$tag = addslashes($tag);
		$tag = trim($tag);
	
		if (!empty($tag)) {
			$sql = "INSERT INTO socio_tag (tag) VALUES (?)";
			$stmt = mysqli_prepare($conexao, $sql);
			
			mysqli_stmt_bind_param($stmt, "s", $tag);
			mysqli_stmt_execute($stmt);
	
			if (mysqli_stmt_affected_rows($stmt) > 0) {
				echo "Tag inserida com sucesso.";
			} else {
				echo "Erro ao inserir tag.";
			}
		} else {
			echo "A tag não pode estar vazia.";
		}
	} else {
		echo "Tag não recebida pelo formulário.";
	}
?>