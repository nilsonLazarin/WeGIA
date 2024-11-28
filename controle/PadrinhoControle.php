<?php
$config_path = "config.php";
if(file_exists($config_path)){
    require_once($config_path);
}else{
    while(true){
        $config_path = "../" . $config_path;
        if(file_exists($config_path)) break;
    }
    require_once($config_path);
}
include_once ROOT."/dao/Conexao.php";
include_once ROOT.'/classes/pet/padrinho/Padrinho.php';
include_once ROOT.'/dao/pet/padrinho/PadrinhoDAO.php';
include_once ROOT.'/dao/PermissaoDAO.php';
require_once ROOT . '/classes/Util.php';


class PadrinhoControle
{
    
    public function formatoDataYMD($data)
    {
        $data_arr = explode("/", $data);
        
        $datac = $data_arr[2] . '-' . $data_arr[1] . '-' . $data_arr[0];
        
        return $datac;
    }

    public function verificarPadrinho()
    {
        // Extrai os dados da requisição
        extract($_REQUEST);

        // Validações de campos obrigatórios
        if (empty($nome)) {
            $msg = "Nome do padrinho não informado. Por favor, informe um nome!";
            header('Location: ../../../html/padrinho.html?msg=' . urlencode($msg));
            exit;
        }

        if (empty($sobrenome)) {
            $msg = "Sobrenome do padrinho não informado. Por favor, informe um sobrenome!";
            header('Location: ../../../html/padrinho.html?msg=' . urlencode($msg));
            exit;
        }

        if (empty($sexo)) {
            $msg = "Sexo do padrinho não informado. Por favor, informe um sexo!";
            header('Location: ../../../html/padrinho.html?msg=' . urlencode($msg));
            exit;
        }

        if (empty($cpf)) {
            $msg = "CPF do padrinho não informado. Por favor, informe um CPF!";
            header('Location: ../../../html/padrinho.html?msg=' . urlencode($msg));
            exit;
        }

        if (empty($nascimento)) {
            $msg = "Data de nascimento do padrinho não informada. Por favor, informe uma data de nascimento!";
            header('Location: ../../../html/padrinho.html?msg=' . urlencode($msg));
            exit;
        }

        // Campos adicionais (valores default para não obrigatórios)
        $telefone = !empty($telefone) ? $telefone : 'null'; // Se não informado, valor default como null
        $cep = !empty($cep) ? $cep : ''; 
        $estado = !empty($estado) ? $estado : ''; 
        $cidade = !empty($cidade) ? $cidade : ''; 
        $bairro = !empty($bairro) ? $bairro : ''; 
        $rua = !empty($rua) ? $rua : ''; 
        $numeroEndereco = !empty($numeroEndereco) ? $numeroEndereco : ''; 
        $complemento = !empty($complemento) ? $complemento : '';

        // Criação da instância do padrinho (herda de Pessoa)
        $padrinho = new Padrinho($cpf, $nome, $sobrenome, $sexo, $nascimento, $telefone, $cep, $estado, $cidade, $bairro, $rua, $numeroEndereco, $complemento);

        // Retorno da instância do padrinho
        return $padrinho;
    }

    public function verificarExistente(){
        extract($_REQUEST); // Extrai os parâmetros da requisição
    
        // Verificação e atribuição de valores default caso os campos não sejam preenchidos
        if (empty($nome)) {
            $nome = '';
        }
        if (empty($sobrenome)) {
            $sobrenome = '';
        }
        if (empty($sexo)) {
            $sexo = ''; // 'sexo' deve ser utilizado aqui, para manter consistência com a classe 'Pessoa'
        }
        if (empty($telefone)) {
            $telefone = 'null'; // Valor default para telefone caso não seja fornecido
        }
        if (empty($nascimento)) {
            $nascimento = '';
        }
        if (empty($cep)) {
            $cep = '';
        }
        if (empty($estado)) {
            $estado = '';
        }
        if (empty($cidade)) {
            $cidade = '';
        }
        if (empty($bairro)) {
            $bairro = '';
        }
        if (empty($rua)) {
            $rua = '';
        }
        if (empty($numeroEndereco)) {
            $numeroEndereco = "";
        }
        if (empty($complemento)) {
            $complemento = '';
        }
        if (empty($cpf)) {
            $cpf = '';
        }
    
        // Instanciando a classe 'Padrinho', que herda de 'Pessoa'
        $padrinho = new Padrinho( // A classe 'Padrinho' vai herdar os atributos de 'Pessoa'
            $cpf, $nome, $sobrenome, $sexo, $nascimento, 
            $telefone, $cep, $estado, $cidade, 
            $bairro, $rua, $numeroEndereco, $complemento,
        );
    
        // Retorna o objeto Padrinho
        return $padrinho;
    }
    

    public function retornarIdPessoa($id_padrinho)
    {   
        // Avaliar se este método está sendo utilizado em alguma parte do sistema
        $padrinhoDAO = new PadrinhoDAO(); // Usando PadrinhoDAO ao invés de FuncionarioDAO
        $pessoa = $padrinhoDAO->retornarIdPessoa($id_padrinho);
        $_SESSION['id_pessoa'] = $pessoa; // Armazena o id da pessoa na sessão
    }

    public function listarTodos()
    {
        extract($_REQUEST);
        $padrinhoDAO = new PadrinhoDAO(); // Usando PadrinhoDAO
        $padrinhos = $padrinhoDAO->listarTodos(); // Método que retorna todos os padrinhos
        $_SESSION['padrinhos'] = $padrinhos; // Armazena todos os padrinhos na sessão
    }

    public function listarCpf()
    {
        extract($_REQUEST);
        $padrinhoDAO = new PadrinhoDAO(); // Usando PadrinhoDAO
        $padrinhosCpf = $padrinhoDAO->listarCPFPessoas(); // Retorna todos os cpfs dos padrinhos
        $_SESSION['cpf_padrinho'] = $padrinhosCpf; // Armazena os cpfs na sessão
    }

    
    public function listarUm()
    {
        extract($_REQUEST);
        try {
            $padrinhoDAO = new PadrinhoDAO(); // Usando PadrinhoDAO
            $padrinho = $padrinhoDAO->listar($id_padrinho); // Busca um padrinho pelo id
            session_start();
            $_SESSION['padrinho'] = $padrinho; // Armazena o padrinho na sessão
            header('Location: ' . $nextPage); // Redireciona para a próxima página
        } catch (PDOException $e) {
            echo $e->getMessage(); // Caso haja erro, exibe a mensagem
        }
    }
    public function selecionarCadastro(){
        $cpf = $_GET['cpf']; // Obtém o CPF da requisição GET
        $validador = new Util(); // Instancia a classe de validação (presumivelmente para validar CPF)
    
        // Valida o CPF usando a função validarCPF da classe Util
        if(!$validador->validarCPF($cpf)){
            http_response_code(400); // Retorna código de erro 400 caso o CPF não seja válido
            exit('Erro, o CPF informado não é válido'); // Encerra o script com mensagem de erro
        }
    
        $padrinhoDAO = new PadrinhoDAO(); // Instancia o PadrinhoDAO
        $padrinhoDAO->selecionarCadastro($cpf); // Chama o método para selecionar o cadastro do padrinho
    
         //header("Location: ../html/padrinho/cadastro_padrinho.php");
    }
    

    public function incluir(){
        // Verifica os dados do padrinho
        $padrinho = $this->verificarPadrinho(); 
        $horario = $this->verificarHorario();
        $cpf = $_GET['cpf']; // Obtém o CPF da requisição
        $validador = new Util(); // Instancia a classe de validação do CPF
    
        // Valida o CPF
        if(!$validador->validarCPF($cpf)){
            http_response_code(400); // Retorna erro 400 caso o CPF seja inválido
            exit('Erro, o CPF informado não é válido');
        }
    
        // Verifica a data de nascimento do padrinho
        if($padrinho->getDataNascimento() > Padrinho::getDataNascimentoMaxima() || $padrinho->getDataNascimento() < Padrinho::getDataNascimentoMinima()){
            http_response_code(400); // Retorna erro 400 caso a data de nascimento esteja fora do limite
            exit('Erro, a data de nascimento do padrinho não está dentro dos limites permitidos.');
        }
    
        // Instancia o DAO de Padrinho e de Horário
        $padrinhoDAO = new PadrinhoDAO();
        $horarioDAO = new QuadroHorarioDAO();
    
        try {
            // Inclui o padrinho e o horário no banco
            $padrinhoDAO->incluir($padrinho, $cpf);
            $horarioDAO->incluir($horario);
    
            // Armazena as informações da próxima ação no session
            $_SESSION['proxima'] = "Cadastrar outro padrinho";
            $_SESSION['link'] = "../../../html/pet/padrinho/cadastro_padrinho.php";
            
            // Redireciona para a página de informações do padrinho
            header("Location: ".WWW. "/html/pet/padrinho/informacao_padrinho.php");
    
        } catch (PDOException $e) {
            // Caso ocorra erro, exibe a mensagem
            $msg = "Não foi possível registrar o padrinho" . "<br>" . $e->getMessage();
            echo $msg;
        }
    }
    

    public function incluirExistente(){
        // Verifica se o padrinho já existe
        $padrinho = $this->verificarExistente();
        $idPessoa = $_GET['id_pessoa']; // Obtém o ID da pessoa do padrinho
        $sobrenome = $_GET['sobrenome']; // Obtém o sobrenome do padrinho
        
        // Instancia o DAO de Padrinho
        $padrinhoDAO = new PadrinhoDAO();
    
        try {
            // Inclui os dados do padrinho existente no banco de dados
            $padrinhoDAO->incluirExistente($padrinho, $idPessoa, $sobrenome);
    
            // Armazena as informações da próxima ação no session
            $_SESSION['proxima'] = "Cadastrar outro padrinho";
            $_SESSION['link'] = "../../../html/pet/padrinho/cadastro_padrinho.php";
            
            // Redireciona para a página de informações do padrinho
            header("Location: ".WWW. "/html/pet/padrinho/informacao_padrinho.php");
    
        } catch (PDOException $e) {
            // Caso ocorra erro, exibe a mensagem
            $msg = "Não foi possível registrar o padrinho" . "<br>" . $e->getMessage();
            echo $msg;
        }
    }
    

    public function alterarInfPessoal()
    {           
        extract($_REQUEST);
        
        // Cria um objeto Padrinho com os dados recebidos
        $padrinho = new Padrinho('',$nome,$sobrenome,$sexo,$nascimento,'','','','',$telefone,'','','','','','','','','');
        $padrinho->setId_pessoa($id_pessoa);  // Assumindo que o id do padrinho é 'id_pessoa'

        $padrinhoDAO = new PadrinhoDAO();  // Instancia o PadrinhoDAO

        try {
            // Altera as informações pessoais do padrinho
            $padrinhoDAO->alterarInfPessoal($padrinho);
            // Redireciona para o perfil do padrinho
            header("Location:" . ROOT . "/html/pet/padrinho/profile_padrinho.php?id_pessoa=" . $id_pessoa);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function alterarDocumentacao()
    {
        extract($_REQUEST);

        // Cria um objeto Padrinho com os dados de documentação recebidos
        $padrinho = new Padrinho($cpf, '', '', '', '', $rg, $orgao_emissor, $data_expedicao, '', '', '', '', '', '', '', '', '', '', '', '');

        $padrinho->setId_pessoa($id_pessoa);  // Assumindo que o id do padrinho é 'id_pessoa'
        $padrinhoDAO = new PadrinhoDAO();  // Instancia o PadrinhoDAO

        try {
            // Altera os dados de documentação do padrinho
            $padrinhoDAO->alterarDocumentacao($padrinho);
            // Redireciona para o perfil do padrinho
            header("Location:" . ROOT . "/html/pet/padrinho/profile_padrinho.php?id_pessoa=" . $id_pessoa);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }   


    public function alterarEndereco()
    {
        extract($_REQUEST);

        // Definir valores padrões caso estejam vazios
        if((!isset($numero_residencia)) || empty(($numero_residencia))){
            $numero_residencia = "null";
        }

        // Cria um objeto Padrinho com os dados de endereço recebidos
        $padrinho = new Padrinho('', '', '', '', '', '', '', '', '', '', '', '', '', '', $cep, $uf, $cidade, $bairro, $rua, $numero_residencia, $complemento, $ibge);
        $padrinho->setId_pessoa($id_pessoa);  // Assumindo que o id do padrinho é 'id_pessoa'

        $padrinhoDAO = new PadrinhoDAO();  // Instancia o PadrinhoDAO

        try {
            // Altera os dados de endereço do padrinho
            $padrinhoDAO->alterarEndereco($padrinho);
            // Redireciona para o perfil do padrinho
            header("Location:" . ROOT . "/html/pet/padrinho/profile_padrinho.php?id_pessoa=" . $id_pessoa);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function excluir()
    {
        extract($_REQUEST);

        $padrinhoDAO = new PadrinhoDAO();  // Instancia o PadrinhoDAO

        try {
            // Exclui o padrinho com o id recebido
            $padrinhoDAO->excluir($id_pessoa);  // Supondo que 'id_pessoa' é o identificador do padrinho
            // Redireciona para a listagem de padrinhos
            header("Location: ../../../controle/control.php?metodo=listarTodos&nomeClasse=PadrinhoControle&nextPage=.../html/pet/padrinho/informacao_padrinho.php");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }      
}