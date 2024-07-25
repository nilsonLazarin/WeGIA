<?php
namespace Versao;

$config_path = "config.php";
if(file_exists($config_path))
{
   require_once($config_path);
}else{
   while(true){
      $config_path = "../".$config_path;
      if(file_exists($config_path)) break;
   }
   require_once($config_path);
}

   Class Conexao 
   {
      private $linhas;
      private $array_dados;
      public $pdo;
      public $banco;
      public $rows;
      public $vetordados;
      public $affected;

      public function __construct()
      {
         try {
               $this->pdo = new \PDO("mysql:host=".DB_HOST. ';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
               $this->pdo->exec("set names utf8");
               $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
              
            }catch(\PDOException $e) {
              
               echo"Não conectado ao banco de dados:".$e->getMessage();
            }
      }

      public function query($sql)
      {
         $query = $this->pdo->query($sql);
         $this->linhas = $query->rowCount();
      }
      
      public function querydados($sql){
         $dados = $this->pdo->query($sql);
         $this->array_dados = $dados->fetch();
         $this->rows = $dados->rowCount();
         $this->array_dados = $dados->fetchAll();
      }
      
      public function rows()
      {
         return $this->rows;
      }

      public function linhas()
      {
         return $this->linhas;
      }

      public function result()
      {
          return $this->array_dados;
      }
      public function arraydados()
      {
         return $this->array_dados;
      }
   }

?>



      
   




