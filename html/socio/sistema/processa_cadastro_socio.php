<?php
//Considerar transformar em POO posteriormente

//Escolher qual ação executar
$acao = trim(filter_input(INPUT_POST, 'acao'));

if (!$acao || empty($acao)) {
    http_response_code(400);
    echo json_encode(['erro' => 'Ação não definida']);
    exit();
}

switch ($acao) {
    case 'cadastrar':
        cadastrar();
        break;
    case 'atualizar':
        atualizar();
        break;
    default:
        echo json_encode(['erro' => 'Ação não válida']);
        exit();
}


/**
 * Realiza os procedimentos necessários para inserir um novo sócio no banco de dados da aplicação
 */
function cadastrar()
{
    //extrair dados da requisição (considerar separar em uma função própria)
    $cpf = trim(filter_input(INPUT_POST, 'cpf'));
    $nome = trim(filter_input(INPUT_POST, 'nome'));
    $telefone = trim(filter_input(INPUT_POST, 'telefone'));
    $dataNascimento = trim(filter_input(INPUT_POST, 'data_nascimento'));
    $cep = trim(filter_input(INPUT_POST, 'cep'));
    $rua = trim(filter_input(INPUT_POST, 'rua'));
    $bairro = trim(filter_input(INPUT_POST, 'bairro'));
    $uf = trim(filter_input(INPUT_POST, 'uf'));
    $cidade = trim(filter_input(INPUT_POST, 'cidade'));
    $complemento = trim(filter_input(INPUT_POST, 'complemento'));
    $numero = trim(filter_input(INPUT_POST, 'numero'));
    $ibge = trim(filter_input(INPUT_POST, 'ibge'));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $valor = trim(filter_input(INPUT_POST, 'valor'));
    $periodicidade = trim(filter_input(INPUT_POST, 'periodicidade'));
    $dataVencimento = trim(filter_input(INPUT_POST, 'data_vencimento'));

    //validar dados (considerar separar em uma função própria)
    try {
        //validação do CPF
        require_once('../../../classes/Util.php');
        $util = new Util();

        if (!$util->validarCPF($cpf)) {
            throw new InvalidArgumentException('O CPF informado não é válido');
        }

        //validação do nome
        if (!$nome || strlen($nome) < 3) {
            throw new InvalidArgumentException('O nome informado não pode ser vazio');
        }

        //validação do telefone
        if (!$telefone || strlen($telefone) != 14) { //considerar melhorar a validação posteriormente
            throw new InvalidArgumentException('O telefone informado não está no formato válido');
        }

        //validação da data de nascimento
        $hoje = new DateTime();
        $hoje = $hoje->format('Y-m-d');

        if ($dataNascimento > $hoje) {
            throw new InvalidArgumentException('A data de nascimento não pode ser maior que a data atual');
        }

        //validação do CEP
        if (!$cep || strlen($cep) != 9) {
            throw new InvalidArgumentException('O CEP informado não está no formato válido');
        }

        //validação da rua
        if (!$rua || empty($rua)) {
            throw new InvalidArgumentException('A rua informada não pode ser vazia');
        }

        //validação do bairro
        if (!$bairro || empty($bairro)) {
            throw new InvalidArgumentException('O bairro informado não pode ser vazio');
        }

        //validação do estado
        if (!$uf || strlen($uf) != 2) {
            throw new InvalidArgumentException('O Estado informada não pode ser vazio');
        }

        //validação da cidade
        if (!$cidade || empty($cidade)) {
            throw new InvalidArgumentException('A cidade informada não pode ser vazia');
        }

        //validação do número da residência
        if (!$numero || empty($numero)) {
            throw new InvalidArgumentException('O número da residência informada não pode ser vazio');
        }

        //validação do email
        if (!$email || empty($email)) {
            throw new InvalidArgumentException('O email informado não está em um formato válido');
        }

        //validação do valor
        if (!$valor || $valor < 30) { //Pegar o valor de maneira dinâmica posteriormente
            throw new InvalidArgumentException('O valor informada deve ser de no mínimo 30 reais.');
        }

        //validação da periodicidade (To-do)

        //validação da data de vencimento
        $diasValidos = ['1', '5', '10', '15', '20'];

        if (!in_array($dataVencimento, $diasValidos)) {
            throw new InvalidArgumentException('O dia escolhido não é válido');
        }
    } catch (InvalidArgumentException $e) {
        http_response_code(400);
        echo json_encode(['erro' => $e->getMessage()]);
        exit();
    }

    //requisitar conexão com o BD
    require_once('../../../dao/Conexao.php');
    try {

        $pdo = Conexao::connect();
        $pdo->beginTransaction();

        //criar pessoa
        $sqlPessoa = 'INSERT INTO pessoa(cpf, nome, telefone, data_nascimento, cep, estado, cidade, bairro, logradouro, numero_endereco, complemento, ibge) VALUES(:cpf, :nome, :telefone, :dataNascimento, :cep, :estado, :cidade, :bairro, :logradouro, :numeroEndereco, :complemento, :ibge)';

        $stmtPessoa = $pdo->prepare($sqlPessoa);

        $stmtPessoa->bindParam(':cpf', $cpf);
        $stmtPessoa->bindParam(':nome', $nome);
        $stmtPessoa->bindParam(':telefone', $telefone);
        $stmtPessoa->bindParam(':dataNascimento', $dataNascimento);
        $stmtPessoa->bindParam(':cep', $cep);
        $stmtPessoa->bindParam(':estado', $uf);
        $stmtPessoa->bindParam(':cidade', $cidade);
        $stmtPessoa->bindParam(':bairro', $bairro);
        $stmtPessoa->bindParam(':logradouro', $rua);
        $stmtPessoa->bindParam(':numeroEndereco', $numero);
        $stmtPessoa->bindParam(':complemento', $complemento);
        $stmtPessoa->bindParam(':ibge', $ibge);

        $stmtPessoa->execute();
        $idPessoa = $pdo->lastInsertId();

        //criar socio
        $idSocioStatus = 3;
        $idSocioTipo = 2;
        $idSocioTag = 1;

        $dataAtual = new DateTime();

        // Verificar se o dia informado já passou neste mês
        if ($dataVencimento <= $dataAtual->format('d')) {
            // Se o dia informado já passou, começar a partir do próximo mês
            $dataAtual->modify('first day of next month');
        }

        // Clonar a data atual para evitar modificar o objeto original
        $dataReferencia = clone $dataAtual;

        // Definir o dia do vencimento para o dia informado
        $dataReferencia->setDate($dataReferencia->format('Y'), $dataReferencia->format('m'), $dataVencimento);

        $dataReferencia = $dataReferencia->format('Y-m-d');

        $sqlSocio = 'INSERT INTO socio(id_pessoa, id_sociostatus, id_sociotipo, id_sociotag, email, valor_periodo, data_referencia) VALUES(:idPessoa, :idSocioStatus, :idSocioTipo, :idSocioTag, :email, :valor, :dataReferencia)';

        $stmtSocio = $pdo->prepare($sqlSocio);

        $stmtSocio->bindParam(':idPessoa', $idPessoa);
        $stmtSocio->bindParam(':idSocioStatus', $idSocioStatus);
        $stmtSocio->bindParam(':idSocioTipo', $idSocioTipo);
        $stmtSocio->bindParam(':idSocioTag', $idSocioTag);
        $stmtSocio->bindParam(':email', $email);
        $stmtSocio->bindParam(':valor', $valor);
        $stmtSocio->bindParam(':dataReferencia', $dataReferencia);

        if ($stmtSocio->execute()) {
            $pdo->commit();
            http_response_code(200);
            echo json_encode(['retorno' => 'Sócio cadastrado']);
            exit();
        } else {
            $pdo->rollBack();
            http_response_code(500);
            echo json_encode(['erro' => 'Erro ao cadastrar sócio no sistema']);
            exit();
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['erro' => 'Erro ao cadastrar sócio no sistema']);
        exit();
    }
}
//Atualizar dados de sócio existente
function atualizar() {}
