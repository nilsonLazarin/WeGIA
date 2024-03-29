<?php

$config_path = "config.php";
if (file_exists($config_path)) {
     require_once($config_path);
} else {
     while (true) {
          $config_path = "../" . $config_path;
          if (file_exists($config_path)) break;
     }
     require_once($config_path);
}


require_once ROOT . '/classes/AvisoNotificacao.php';
require_once ROOT . '/dao/AvisoNotificacaoDAO.php';

class AvisoNotificacaoControle
{
     /**
      * Recebe como parâmetro um aviso, instância dois objetos, um do tipo AvisoNotificacao e outro do tipo AvisoNotificacaoDAO, chamando o método cadastrar deste último.
      */
     public function incluir($aviso)
     {

          $avisoNotificacao = new AvisoNotificacao($aviso);

          try {
               $avisoNotificacaoDAO = new AvisoNotificacaoDAO();
               $avisoNotificacaoDAO->cadastrar($avisoNotificacao);
          } catch (PDOException $e) {
               $e->getMessage();
          }
     }

     /**
      * Recebe como parâmetro o id de uma pessoa, retorna o resultado do método buscarRecentes de um objeto do tipo AvisoNotificacaoDAO
      */
     public function listarRecentes($idPessoa)
     {
          try {
               $avisoNotificacaoDAO = new AvisoNotificacaoDAO();
               $recentes = $avisoNotificacaoDAO->buscarRecentes($idPessoa);
               return $recentes;
          } catch (PDOException $e) {
               $e->getMessage();
          }
     }

     /**
      * Recebe como parâmetro o id de uma pessoa, retorna o resultado do método buscarHistoricos de um objeto do tipo AvisoNotificacaoDAO
      */
     public function listarHistoricos($idPessoa)
     {
          try {
               $avisoNotificacaoDAO = new AvisoNotificacaoDAO();
               $historicos = $avisoNotificacaoDAO->buscarHistoricos($idPessoa);
               return $historicos;
          } catch (PDOException $e) {
               $e->getMessage();
          }
     }

     /**
      * Recebe como parâmetro o id de uma pessoa, e retorna a quantidade de notificações recentes que essa pessoa possuí
      */
     public function quantidadeRecentes($idPessoa)
     {
          try {
               $avisoNotificacaoDAO = new AvisoNotificacaoDAO();
               $recentesQuantidade = $avisoNotificacaoDAO->contarRecentes($idPessoa);
               return $recentesQuantidade;
          } catch (PDOException $e) {
               $e->getMessage();
          }
     }

     /**
      * Extraí via POST o id de uma notificação, e chama o método alterarStatus de um objeto do tipo AvisoNotificacaoDAO
      */
     public function mudarStatus()
     {
          $idNotificacao = $_POST['id_notificacao'];
     
          try{
               $avisoNotificacaoDAO = new AvisoNotificacaoDAO();
               $avisoNotificacaoDAO->alterarStatus($idNotificacao);
               header("Location: ../html/saude/intercorrencia_visualizar.php");
          }catch(PDOException $e){
               $e->getMessage();
          }
     }
}
