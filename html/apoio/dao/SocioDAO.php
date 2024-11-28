<?php
//requisitar arquivo de conexão
require_once '../dao/ConexaoDAO.php';

//requisitar model
require_once '../model/Socio.php';
class SocioDAO
{
    private $pdo;

    public function __construct(PDO $pdo = null)
    {
        if (is_null($pdo)) {
            $this->pdo = ConexaoDAO::conectar();
        } else {
            $this->pdo = $pdo;
        }
    }

    public function montarSocio($socioArray)
    {
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

    public function criarSocio(Socio $socio)
    {
        $this->pdo->beginTransaction();

        //criar pessoa
        $sqlPessoa = 'INSERT INTO pessoa(cpf, nome, telefone, data_nascimento, cep, estado, cidade, bairro, logradouro, numero_endereco, complemento, ibge) VALUES(:cpf, :nome, :telefone, :dataNascimento, :cep, :estado, :cidade, :bairro, :logradouro, :numeroEndereco, :complemento, :ibge)';

        $stmtPessoa = $this->pdo->prepare($sqlPessoa);

        $stmtPessoa->bindParam(':cpf', $socio->getDocumento());
        $stmtPessoa->bindParam(':nome', $socio->getNome());
        $stmtPessoa->bindParam(':telefone', $socio->getTelefone());
        $stmtPessoa->bindParam(':dataNascimento', $socio->getDataNascimento());
        $stmtPessoa->bindParam(':cep', $socio->getCep());
        $stmtPessoa->bindParam(':estado', $socio->getEstado());
        $stmtPessoa->bindParam(':cidade', $socio->getCidade());
        $stmtPessoa->bindParam(':bairro', $socio->getBairro());
        $stmtPessoa->bindParam(':logradouro', $socio->getLogradouro());
        $stmtPessoa->bindParam(':numeroEndereco', $socio->getNumeroEndereco());
        $stmtPessoa->bindParam(':complemento', $socio->getComplemento());
        $stmtPessoa->bindParam(':ibge', $socio->getIbge());

        $stmtPessoa->execute();
        $idPessoa = $this->pdo->lastInsertId();

        //criar socio
        $idSocioStatus = 3; //Define o status do sócio como Inativo temporariamente

        $tagSolicitante = $this->pdo->query("SELECT * FROM socio_tag WHERE tag='Solicitante'")->fetch(PDO::FETCH_ASSOC);

        $idSocioTag = $tagSolicitante['id_sociotag']; //Define o grupo do sócio como Solicitante

        $sqlSocio = 'INSERT INTO socio(id_pessoa, id_sociostatus, id_sociotipo, id_sociotag, email, valor_periodo, data_referencia) VALUES(:idPessoa, :idSocioStatus, :idSocioTipo, :idSocioTag, :email, :valor, :dataReferencia)';

        $stmtSocio = $this->pdo->prepare($sqlSocio);

        $periodicidade = 0;
        $dataReferencia = new DateTime();
        $dataReferencia = $dataReferencia->format('Y-m-d');

        $stmtSocio->bindParam(':idPessoa', $idPessoa);
        $stmtSocio->bindParam(':idSocioStatus', $idSocioStatus);
        $stmtSocio->bindParam(':idSocioTipo', $periodicidade);
        $stmtSocio->bindParam(':idSocioTag', $idSocioTag);
        $stmtSocio->bindParam(':email', $socio->getEmail());
        $stmtSocio->bindParam(':valor', $socio->getValor());
        $stmtSocio->bindParam(':dataReferencia', $dataReferencia);

        $stmtSocio->execute();

        //registrar no socio_log
        $idSocio = $this->pdo->lastInsertId();

        $sqlRegistrarSocioLog = "INSERT INTO socio_log (id_socio, descricao)
            VALUES (:idSocio,'Inscrição recente')";

        $stmtSocioLog = $this->pdo->prepare($sqlRegistrarSocioLog);
        $stmtSocioLog->bindParam(':idSocio', $idSocio);

        if ($stmtSocioLog->execute()) {
            $this->pdo->commit();
        } else {
            $this->pdo->rollBack();
            http_response_code(500);
            echo json_encode(['erro' => 'Erro ao cadastrar sócio no sistema']);
            exit();
        }
    }

    public function buscarPorId($id)
    {
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

        if ($stmt->rowCount() === 0) {
            return null;
        }

        $socioArray = $stmt->fetch(PDO::FETCH_ASSOC);

        $socio = $this->montarSocio($socioArray);

        return $socio;
    }

    public function buscarPorDocumento($documento)
    {
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

        if ($stmt->rowCount() === 0) {
            return null;
        }

        $socioArray = $stmt->fetch(PDO::FETCH_ASSOC);

        $socio = $this->montarSocio($socioArray);

        return $socio;
    }

    public function registrarLog(Socio $socio, string $mensagem)
    {
        $sqlRegistrarSocioLog = "INSERT INTO socio_log (id_socio, descricao)
        VALUES (:idSocio, :mensagem)";

        $stmt = $this->pdo->prepare($sqlRegistrarSocioLog);
        $stmt->bindParam(':idSocio', $socio->getId());
        $stmt->bindParam(':mensagem', $mensagem);

        return $stmt->execute();
    }
}
