<?php
//requisitar arquivo de conexão
require_once '../dao/ConexaoDAO.php';

//requisitar model
require_once '../model/Socio.php';
class SocioDAO{
    private $pdo;

    public function __construct(PDO $pdo = null)
    {
        if(is_null($pdo)){
            $this->pdo = ConexaoDAO::conectar();
        }else{
            $this->pdo = $pdo;
        }
    }

    public function montarSocio($socioArray){
        $socio = new Socio();
        $socio
            ->setId($socioArray['id_socio'])
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
            ->setLogradouro($socioArray['logradouro'])
            ->setDocumento($socioArray['cpf']);

        return $socio;
    }

    public function buscarPorId($id){
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
            pessoa.cpf
            socio.id_socio, 
            socio.email 
        FROM pessoa, socio 
        WHERE pessoa.id_pessoa = socio.id_pessoa 
        AND socio.id_socio=:id";

        $stmt = $this->pdo->prepare($sqlBuscaPorDocumento);
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        if($stmt->rowCount() === 0){
            return null;
        }

        $socioArray = $stmt->fetch(PDO::FETCH_ASSOC);

        $socio = $this->montarSocio($socioArray);

        return $socio;
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
            pessoa.cpf,
            socio.id_socio, 
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

        $socio = $this->montarSocio($socioArray);

        return $socio;
    }

    public function registrarLog(Socio $socio, string $mensagem){
        $sqlRegistrarSocioLog = "INSERT INTO socio_log (id_socio, descricao)
        VALUES (:idSocio, :mensagem)";

        $stmt = $this->pdo->prepare($sqlRegistrarSocioLog);
        $stmt->bindParam(':idSocio', $socio->getId());
        $stmt->bindParam(':mensagem', $mensagem);

        return $stmt->execute();
    }
}