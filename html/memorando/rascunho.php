$anexo2 = $pdo->query("SELECT extensao FROM anexo WHERE id_despacho=;")->fetch(PDO::FETCH_ASSOC) ["extensao"];


					$anexo2 = $pdo->query("SELECT extensao FROM anexo WHERE id_despacho=$id_memorando;")->fetch(PDO::FETCH_ASSOC) ["extensao"];
					$anexo1 = $pdo->query("SELECT nome, extensao FROM anexo WHERE id_despacho=1;")->fetch(PDO::FETCH_ASSOC);

					$anexo1 = $anexo1["nome"] . ($anexo1["extensao"] ? ("." . $anexo1["extensao"]) : "");

					 $array = [
					 	"1" => $anexo,
					 	"2" => $anexo1
					 ];
					 echo $array['2'];


					 $sth = $conexao->prepare('SELECT nome, extensao FROM 'anexo' WHERE 'nome' LIKE :nome');


					 <?php
					if(count($resultados)){
						foreach($resultados as $Resultado){
							?> 
							<label><?php echo $Resultado['id']; ?> <?php echo $Resultado['anexo'];  ?></label>
						<? } }
						else {
						?> <label> ops</label>
					<?php }
					?>




					//$sth = $pdo->query("SELECT nome, extensao FROM anexo WHERE id_despacho=$id_memorando");
					//$sth->bindParam(':nome', $arquivo, PDO::PARAM_STR);
					//$sth->execute();
					//$resultados = $sth->fetchAll(PDO::FETCH_ASSOC);
					//foreach($resultados as $valor):
						//echo $valor."<br>";
					//endforeach;

					///$anex = $pdo->query("SELECT id_memorando FROM memorando;")->fetch(PDO::FETCH_ASSOC) ["id_memorando"];


					13/08

					//$strAnexos;
					//$strArquivos;
					//$Qtd = $pdo->query("SELECT count(*) FROM anexo WHERE id_despacho=1;")->fetch(PDO::FETCH_ASSOC);
					//$intQtd = (int) $Qtd;


				///for ($intX=0; $intX < $intQtd; $i++) { 
					//$strArquivo = $pdo->query("SELECT * FROM anexo WHERE id_despacho=1 limit intX,1;")->fetch(PDO::FETCH_ASSOC);
					//$strAnexos = $strAnexos + $strArquivo;
					
				}
				//echo "$strArquivo";
					
					//$anexo = $pdo->query("SELECT nome, extensao FROM anexo WHERE id_despacho=$id_memorando;")->fetch(PDO::FETCH_ASSOC);

					//$anexo = $anexo["nome"] . ($anexo["extensao"] ? ("." . $anexo["extensao"]) : "");







					
					// $resultado= explode("-", $anexo);
					// echo "<pre>";
					 ///print_r ($resultado);
					 //echo "</pre>";
					 //foreach($resultado as $valor):
						//echo $valor."<br>";
					// endforeach;


					//$strArquivo = $pdo->query("SELECT nome FROM anexo WHERE id_despacho=$id_memorando;")->fetchAll(PDO::FETCH_ASSOC);
					//$x = (array) $strArquivo;
					//$array = (array)$pdo->query("SELECT COUNT(*) FROM anexo WHERE id_despacho=$id_memorando;")->fetchAll(PDO::FETCH_ASSOC);$pdo->query("SELECT COUNT(*) FROM anexo WHERE id_despacho=$id_memorando;")->fetchAll(PDO::FETCH_ASSOC);

					//print_r($array);
					//for ($i = 0; $i < $anexo; $i++) { 
					//	echo $array;
					//}
					
				

					//var_dump($intAnexo);
					//
					//var_dump($strArquivo);





					
					


					///for($intX=0; $intX <= $anexo; $intX++)
					//{

					//echo $anexo;
					//echo $strArquivo;

					//}
					

					

					

					

					
					

					//$strAnexo =  $pdo->query("SELECT nome, extensao FROM anexo WHERE id_despacho=$id_memorando;")->fetch(PDO::FETCH_ASSOC);

					//$strAnexo = $strAnexo["nome"] . ($strAnexo["extensao"] ? ("." . $strAnexo["extensao"]) : "");

					// { 
						//$strArquivo = $pdo->query("SELECT * FROM anexo WHERE id_despacho=1 limit intX,1;")->fetch(PDO::FETCH_ASSOC);
						//$strAnexo = $strAnexo + $strArquivo;
					//}
				    //echo $anexo;


				    //$Qtd = $pdo->query("SELECT COUNT(*) FROM anexo WHERE id_despacho=$id_memorando")->fetch(PDO::FETCH_ASSOC);
					//var_dump($Qtd);
					
					//$intQtd = (int) $Qtd;
					//var_dump($Qtd);