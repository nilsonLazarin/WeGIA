<?php
      require_once "/var/www/html/WeGIA/dao/Conexao.php";
	require_once $caminho.'classes/Documento.php';
	class QuadroHorarioDAO
	{
		public function incluir($quadro_horario)
		{
      		try {
                  $sql = 'call cadhorariofunc(:escala, :tipo, :carga_horaria, :entrada1, :saida1,:entrada2,:saida2, :total, :dias_trabalhados, :folga)';
                  $sql = str_replace("'", "\'", $sql);            
                  $pdo = Conexao::connect();
                  $stmt = $pdo->prepare($sql);

                  $escala=$quadro_horario->getEscala();
                  $tipo=$quadro_horario->getTipo();
                  $carga_horaria=$quadro_horario->getCarga_horaria();
                  $entrada1=$quadro_horario->getEntrada1();
                  $saida1=$quadro_horario->getSaida1();
                  $entrada2=$quadro_horario->getEntrada2();
                  $saida2=$quadro_horario->getSaida2();
                  $total=$quadro_horario->getTotal();
                  $dias_trabalhados=$quadro_horario->getDias_trabalhados();
                  $folga=$quadro_horario->getFolga();

                  $stmt->bindParam(':escala',$escala);
                  $stmt->bindParam(':tipo',$tipo);
                  $stmt->bindParam(':carga_horaria',$carga_horaria);
                  $stmt->bindParam(':entrada1',$entrada1);
                  $stmt->bindParam(':saida1',$saida1);
                  $stmt->bindParam(':entrada2',$entrada2);
                  $stmt->bindParam(':saida2',$saida2);
                  $stmt->bindParam(':total',$total);
                  $stmt->bindParam(':dias_trabalhados',$dias_trabalhados);
                  $stmt->bindParam(':folga',$folga);

                  $stmt->execute();
      	        }catch (PDOExeption $e) {
      	            echo 'Error: <b>  na tabela quadro horario = ' . $sql . '</b> <br /><br />' . $e->getMessage();
      	        }
		}

            public function alterar($quadro_horario, $id_funcionario)
            {
                  try {
                  $sql = 'UPDATE quadro_horario_funcionario SET escala=:escala, tipo=:tipo, carga_horaria=:carga_horaria, entrada1=:entrada1, saida1=:saida1,entrada2=:entrada2,saida2=:saida2, total=:total, dias_trabalhados=:dias_trabalhados, folga=:folga WHERE id_funcionario=:id_funcionario';
                  $sql = str_replace("'", "\'", $sql);            
                  $pdo = Conexao::connect();
                  $stmt = $pdo->prepare($sql);

                  $escala=$quadro_horario->getEscala();
                  $tipo=$quadro_horario->getTipo();
                  $carga_horaria=$quadro_horario->getCarga_horaria();
                  $entrada1=$quadro_horario->getEntrada1();
                  $saida1=$quadro_horario->getSaida1();
                  $entrada2=$quadro_horario->getEntrada2();
                  $saida2=$quadro_horario->getSaida2();
                  $total=$quadro_horario->getTotal();
                  $dias_trabalhados=$quadro_horario->getDias_trabalhados();
                  $folga=$quadro_horario->getFolga();

                  $stmt->bindParam(':id_funcionario',$id_funcionario);
                  $stmt->bindParam(':escala',$escala);
                  $stmt->bindParam(':tipo',$tipo);
                  $stmt->bindParam(':carga_horaria',$carga_horaria);
                  $stmt->bindParam(':entrada1',$entrada1);
                  $stmt->bindParam(':saida1',$saida1);
                  $stmt->bindParam(':entrada2',$entrada2);
                  $stmt->bindParam(':saida2',$saida2);
                  $stmt->bindParam(':total',$total);
                  $stmt->bindParam(':dias_trabalhados',$dias_trabalhados);
                  $stmt->bindParam(':folga',$folga);

                  $stmt->execute();
                    }catch (PDOExeption $e) {
                        echo 'Error: <b>  na tabela quadro horario = ' . $sql . '</b> <br /><br />' . $e->getMessage();
                    }
            }
	}
?>