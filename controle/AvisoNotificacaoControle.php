<?php
     //require_once ROOT . '/dao/Conexao.php';
     require_once ROOT . '/classes/AvisoNotificacao.php';
     require_once ROOT . '/dao/AvisoNotificacaoDAO.php';

     class AvisoNotificacaoControle{
          public function incluir($aviso){

               $avisoNotificacao = new AvisoNotificacao($aviso);
               $avisoNotificacaoDAO = new AvisoNotificacaoDAO();

               try{
                    $avisoNotificacaoDAO->cadastrar($avisoNotificacao);
               }catch(PDOException $e){
                    $e->getMessage();
               }
          }

          public function listarRecentes($idPessoa){
               //echo $idPessoa;
               $avisoNotificacaoDAO = new AvisoNotificacaoDAO();
               
               try{
                    $recentes = $avisoNotificacaoDAO->buscarRecentes($idPessoa);
                    return $recentes;
               }catch(PDOException $e){
                    $e->getMessage();
               }
          }
     }
?>