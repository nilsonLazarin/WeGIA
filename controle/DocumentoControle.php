<?php 
	require_once'../classes/Documento.php';
	require_once'../dao/DocumentoDAO.php';
	class DocumentoControle
	{	
		public function comprimir($documParaCompressao)
	    {
			$documento_zip = gzcompress($documParaCompressao);
			return $documento_zip;
		}
		public function incluir($documento)
		{
			$docuDAO=new DocumentoDAO();
			try 
			{
				$docuDAO->incluir($documento);
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
		}
		public function alterar()
		{
			extract($_REQUEST);
			$docuDAO=new DocumentoDAO();
			try {
				$imagem=base64_encode(comprimir(file_get_contents($_FILES['doc']['tmp_name'])));
                $extensao=pathinfo($_FILES['doc']['name'],PATHINFO_EXTENSION);
                $documento=new Documento(1,$imagem,$extensao,$descricao);
				$documento->setIdDocumento($id_documento);
				$docuDAO->alterar($documento);
				header('Location: ../controle/control.php?metodo=listarUm&nomeClasse=InternoControle&nextPage=../html/profile_interno.php?id='.$id.'&id='.$id);
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
		}
		 public function excluir()
	    {
	        extract($_REQUEST);
	        $docuDAO=new DocumentoDAO();
	        try {
	            $docuDAO->excluir($id_documento);
	            header('Location: ../controle/control.php?metodo=listarUm&nomeClasse=InternoControle&nextPage=../html/profile_interno.php?id='.$id.'&id='.$id);
	        } catch (Exception $e) {
	            echo $e->getMessage();
	        }
		}
	}
?>