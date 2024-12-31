<?php
require_once dirname(__DIR__).'/dao/ConexaoDAO.php';
require_once dirname(__DIR__).'/dao/BrandDAO.php';
require_once dirname(__DIR__).'/model/Brand.php';

class BrandController
{

    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = ConexaoDAO::conectar();
        } catch (PDOException $e) {
            //implementar tratamento de erro
            exit();
        }
    }

    public function getBrand(): ?Brand
    {
        try {
            $brandDao = new BrandDAO($this->pdo);
            $brand = $brandDao->getBrand();

            return $brand;
        } catch (PDOException $e) {
            //implementar tratamento de erro
            exit("erro: {$e->getMessage()}");
        }
    }
}
