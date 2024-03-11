<?php
     //require_once ROOT . '/dao/Conexao.php';
     require_once ROOT . '/classes/AvisoNotificacao.php';
     require_once ROOT . '/dao/AvisoNotificacaoDAO.php';

     class AvisoNotificacaoControle{
          public function incluir($aviso){

               $avisoNotificacao = new AvisoNotificacao($aviso);
          
               try{
                    $avisoNotificacaoDAO = new AvisoNotificacaoDAO();
                    $avisoNotificacaoDAO->cadastrar($avisoNotificacao);
               }catch(PDOException $e){
                    $e->getMessage();
               }
          }

          public function listarRecentes($idPessoa){
               try{
                    $avisoNotificacaoDAO = new AvisoNotificacaoDAO();
                    $recentes = $avisoNotificacaoDAO->buscarRecentes($idPessoa);
                    return $recentes;
               }catch(PDOException $e){
                    $e->getMessage();
               }
          }

          public function quantidadeRecentes($idPessoa){
               try{
                    $avisoNotificacaoDAO = new AvisoNotificacaoDAO();
                    $recentesQuantidade = $avisoNotificacaoDAO->contarRecentes($idPessoa);
                    return $recentesQuantidade;
               }catch(PDOException $e){
                    $e->getMessage();
               }
          }
     }
?>