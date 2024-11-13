<?php
require_once '../dao/ConexaoDAO.php';
require_once '../dao/BrandDAO.php';
require_once '../model/Brand.php';

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
