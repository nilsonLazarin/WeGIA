<?php
//requisitar arquivo de conexão
require_once '../dao/ConexaoDAO.php';

//requisitar model
require_once '../model/Socio.php';
class SocioDAO{
    private $pdo;

    public function __construct()
    {
        $this->pdo = ConexaoDAO::conectar();
    }

    public function buscarPorDocumento($documento){
        $sqlBuscaPorDocumento = 
        "SELECT 
            pessoa.id_pessoa, 
            pessoa.nome, 
            pessoa.telefone, 
            pessoa.cep, 
            pessoa.estado, 
            pessoa.cidade, 
            pessoa.bairro, 
            pessoa.complemento, 
            pessoa.numero_endereco, 
            pessoa.logradouro, 
            socio.id_pessoa, 
            socio.email 
        FROM pessoa, socio 
        WHERE pessoa.id_pessoa = socio.id_pessoa 
        AND pessoa.cpf=:documento";

        $stmt = $this->pdo->prepare($sqlBuscaPorDocumento);
        $stmt->bindParam(':documento', $documento);

        $stmt->execute();

        if($stmt->rowCount() === 0){
            return null;
        }

        $socioArray = $stmt->fetch(PDO::FETCH_ASSOC);

        $socio = new Socio();
        $socio
            ->setNome($socioArray['nome'])
            ->setTelefone($socioArray['telefone'])
            ->setEmail($socioArray['email'])
            ->setEstado($socioArray['estado'])
            ->setTelefone($socioArray['telefone'])
            ->setCidade($socioArray['cidade'])
            ->setBairro($socioArray['bairro'])
            ->setComplemento($socioArray['complemento'])
            ->setCep($socioArray['cep'])
            ->setNumeroEndereco($socioArray['numero_endereco'])
            ->setLogradouro($socioArray['logradouro']);

        return $socio;
    }
}