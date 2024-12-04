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
require_once ROOT . "/dao/Conexao.php";
require_once ROOT . "/classes/pet/padrinho/Padrinho.php";
require_once ROOT . "/Functions/funcoes.php";

class PadrinhoDAO
{
    public function retornarIdPessoa($id_pessoa)
    {
        try {
            $pessoa = array();
            $pdo = Conexao::connect();
            $consulta = $pdo->query("SELECT id_pessoa FROM pessoa WHERE id_pessoa='$id_pesssoa'");
            $x = 0;
            while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $pessoa[$x] = $linha['id_pessoa'];
                $x++;
            }
        } catch (PDOException $e) {
            echo 'Error:' . $e->getMessage();
        }
        return $pessoa;
    }
    public function listarIdPessoa($cpf)
    {
        try {
            $pdo = Conexao::connect();

            // Usando prepared statement para evitar SQL Injection
            $stmt = $pdo->prepare("SELECT id_pessoa FROM pessoa WHERE cpf = :cpf");
            $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
            $stmt->execute();

            // Verificando se existe algum resultado
            $linha = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($linha) {
                return $linha['id_pessoa'];
            } else {
                return null; // Caso não encontre o CPF
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return null; // Retorna null em caso de erro
        }
    }

    public function listarSobrenome($cpf)
    {
        try {
            $pdo = Conexao::connect();
    
            // Usando prepared statement para evitar SQL Injection
            $stmt = $pdo->prepare("SELECT sobrenome FROM pessoa WHERE cpf = :cpf");
            $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
            $stmt->execute();
    
            // Verificando se existe algum resultado
            $linha = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($linha) {
                return $linha['sobrenome'];
            } else {
                return null; // Caso não encontre o CPF
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return null; // Retorna null em caso de erro
        }
    }    

    public function formatoDataDMY($data)
    {
        if ($data) {
            $data_arr = explode("-", $data);

            $datad = $data_arr[2] . '/' . $data_arr[1] . '/' . $data_arr[0];

            return $datad;
        }
        return "Sem informação";
    }

    public function selecionarCadastro($cpf)
    {
        try {
            // Conexão com o banco de dados
            $pdo = Conexao::connect();

            // Consultar se o CPF já está registrado no banco de dados
            $stmt = $pdo->prepare("SELECT id_pessoa FROM pessoa WHERE cpf = :cpf");
            $stmt->bindParam(':cpf', $cpf);
            $stmt->execute();
            
            // Verificar se encontrou o CPF na tabela pessoa
            $consulta = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($consulta) {
                // Caso o CPF já esteja cadastrado, redirecionar para a página de erro
                header("Location: " . WWW . "/html/pet/padrinho/cadastro_padrinho_pessoa_existente.php?msg_e=Erro, Padrinho já cadastrado no sistema.");
                exit; // Após redirecionamento, é importante usar 'exit' para garantir que o script pare
            }

            // Se não encontrou o CPF na tabela pessoa, verificar se já existe outro CPF cadastrado
            $stmt = $pdo->prepare("SELECT cpf FROM pessoa WHERE cpf = :cpf");
            $stmt->bindParam(':cpf', $cpf);
            $stmt->execute();

            // Se não encontrar nenhum CPF, redirecionar para o cadastro
            if ($stmt->rowCount() == 0) {
                header("Location: " . WWW . "/html/pet/padrinho/cadastro_padrinho.php?cpf=$cpf");
            } else {
                // Se o CPF já está na tabela, redirecionar para página de cadastro existente
                header("Location: " . WWW . "/html/pet/padrinho/cadastro_padrinho_pessoa_existente.php?msg_e=Erro, Padrinho já cadastrado no sistema.");
            }

            exit; // Parar a execução do script após o redirecionamento

        } catch (PDOException $e) {
            // Caso ocorra algum erro no banco de dados, exibir mensagem
            echo 'Error: ' . $e->getMessage();
        }
    }


    public function incluir($padrinho, $cpf)
    {
        try {
            // Chamada ao procedimento armazenado (stored procedure)
            $sql = 'CALL cadpessoa(:nome, :sobrenome, :cpf, :sexo, :telefone, :data_nascimento, :cep, :estado, :cidade, :bairro, :logradouro, :numero_endereco, :complemento)';

            // Conectar ao banco de dados
            $pdo = Conexao::connect();
            $stmt = $pdo->prepare($sql);

            // Obter os dados do objeto $padrinho
            $nome = $padrinho->getNome();
            $sobrenome = $padrinho->getSobrenome();
            $cpf = $padrinho->getCpf();
            $sexo = $padrinho->getSexo();
            $telefone = $padrinho->getTelefone();
            $nascimento = $padrinho->getDataNascimento();
            $cep = $padrinho->getCep();
            $estado = $padrinho->getEstado();
            $cidade = $padrinho->getCidade();
            $bairro = $padrinho->getBairro();
            $logradouro = $padrinho->getLogradouro();
            $numeroEndereco = $padrinho->getNumeroEndereco();
            $complemento = $padrinho->getComplemento();


            // Vincular os parâmetros
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':sobrenome', $sobrenome);
            $stmt->bindParam(':cpf', $cpf);
            $stmt->bindParam(':senha', $senha);
            $stmt->bindParam(':sexo', $sexo);
            $stmt->bindParam(':telefone', $telefone);
            $stmt->bindParam(':data_nascimento', $nascimento);
            $stmt->bindParam(':cep', $cep);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':cidade', $cidade);
            $stmt->bindParam(':bairro', $bairro);
            $stmt->bindParam(':logradouro', $logradouro);
            $stmt->bindParam(':numero_endereco', $numeroEndereco);
            $stmt->bindParam(':complemento', $complemento);

            // Executar a consulta
            $stmt->execute();
            
            // Caso precise verificar o sucesso, podemos verificar o número de linhas afetadas
            if ($stmt->rowCount() > 0) {
                // Sucesso
                return true;
            } else {
                // Nenhuma linha afetada, algo deu errado
                return false;
            }

        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela pessoa = ' . $sql . '</b> <br /><br />' . $e->getMessage();
            return false; // Retorna false em caso de erro
        }
    }   


    public function incluirExistente($padrinho, $id_pessoa)
    {
        try {
            // Corrigir a consulta SQL para atualizar os campos corretos
            $sql = "UPDATE pessoa SET 
                    sobrenome = :sobrenome, 
                    sexo = :sexo, 
                    telefone = :telefone, 
                    data_nascimento = :data_nascimento 
                    WHERE id_pessoa = :id_pessoa";

            // Conectar ao banco de dados
            $pdo = Conexao::connect();
            $stmt = $pdo->prepare($sql);

            // Obter os dados do objeto $padrinho
            $sobrenome = $padrinho->getSobrenome();
            $sexo = $padrinho->getSexo();
            $telefone = $padrinho->getTelefone();
            $nascimento = $padrinho->getDataNascimento();

            // Vincular os parâmetros
            $stmt->bindParam(':id_pessoa', $id_pessoa);
            $stmt->bindParam(':sobrenome', $sobrenome);
            $stmt->bindParam(':sexo', $sexo);
            $stmt->bindParam(':telefone', $telefone);
            $stmt->bindParam(':data_nascimento', $nascimento);

            // Executar a consulta
            $stmt->execute();
            
            // Verificar se a operação foi bem-sucedida
            if ($stmt->rowCount() > 0) {
                // Se houve alteração, o commit é desnecessário, pois não há transação múltipla
                return true;  // Retorna true caso a operação tenha sido bem-sucedida
            } else {
                // Se não houve nenhuma alteração, faz o rollback
                return false;
            }
        } catch (PDOException $e) {
            echo 'Error: <b> na tabela pessoa = ' . $sql . '</b> <br /><br />' . $e->getMessage();
            return false;  // Retorna false em caso de erro
        }
    }


    // excluir
    public function excluir($id_pessoa)
    {
        try {
            // Usar DELETE para excluir a pessoa
            $sql = 'DELETE FROM pessoa WHERE id_pessoa = :id_pessoa';
            
            // Preparar a consulta
            $pdo = Conexao::connect();
            $stmt = $pdo->prepare($sql);

            // Vincular o parâmetro :id_pessoa
            $stmt->bindParam(':id_pessoa', $id_pessoa);

            // Executar a consulta de exclusão
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: <b> na tabela pessoa = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }


    // Editar
        public function alterarInfPessoal($padrinho)
        {
            try {
                // Corrigir SQL para UPDATE na tabela pessoa
                $sql = 'UPDATE pessoa SET 
                        nome = :nome, 
                        sobrenome = :sobrenome, 
                        sexo = :sexo, 
                        telefone = :telefone, 
                        data_nascimento = :data_nascimento
                        WHERE id_pessoa = :id_pessoa';

                $pdo = Conexao::connect();
                $stmt = $pdo->prepare($sql);

                // Acessando os métodos do objeto $padrinho
                $nome = $padrinho->getNome();
                $sobrenome = $padrinho->getSobrenome();
                $id_pessoa = $padrinho->getId_pessoa();  // Corrigido para getId_pessoa() e não getId_padrinho()
                $sexo = $padrinho->getSexo();
                $telefone = $padrinho->getTelefone();
                $nascimento = $padrinho->getDataNascimento();

                // Bind dos parâmetros para prevenir SQL Injection
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':sobrenome', $sobrenome);
                $stmt->bindParam(':id_pessoa', $id_pessoa);
                $stmt->bindParam(':sexo', $sexo);
                $stmt->bindParam(':telefone', $telefone);
                $stmt->bindParam(':data_nascimento', $nascimento);

                // Executa a consulta de atualização
                $stmt->execute();
            } catch (PDOException $e) {
                echo 'Error: <b>na tabela pessoa = ' . $sql . '</b> <br /><br />' . $e->getMessage();
            }
        }



    public function alterarEndereco($padrinho)
        {
            try {
                //  SQL fazedo UPDATE corretamente na tabela pessoa
                $sql = 'UPDATE pessoa SET 
                        cep = :cep, 
                        estado = :estado, 
                        cidade = :cidade, 
                        bairro = :bairro, 
                        logradouro = :logradouro, 
                        numero_endereco = :numero_endereco, 
                        complemento = :complemento 
                        WHERE id_pessoa = :id_pessoa';

                $pdo = Conexao::connect();
                $stmt = $pdo->prepare($sql);

                // Acessando os métodos do objeto $padrinho
                $id_pessoa = $padrinho->getId_pessoa();  // Ajustado para usar getId_pessoa()
                $cep = $padrinho->getCep();
                $estado = $padrinho->getEstado();
                $cidade = $padrinho->getCidade();
                $bairro = $padrinho->getBairro();
                $logradouro = $padrinho->getLogradouro();
                $numero_endereco = $padrinho->getNumeroEndereco();
                $complemento = $padrinho->getComplemento();

                // Binding dos parâmetros para prevenir SQL injection
                $stmt->bindParam(':id_pessoa', $id_pessoa);
                $stmt->bindParam(':cep', $cep);
                $stmt->bindParam(':estado', $estado);
                $stmt->bindParam(':cidade', $cidade);
                $stmt->bindParam(':bairro', $bairro);
                $stmt->bindParam(':logradouro', $logradouro);
                $stmt->bindParam(':numero_endereco', $numero_endereco);
                $stmt->bindParam(':complemento', $complemento);

                // Executa a consulta
                $stmt->execute();
            } catch (PDOException $e) {
                echo 'Error: <b> na tabela pessoa = ' . $sql . '</b> <br /><br />' . $e->getMessage();
            }
        }

    

    public function listarTodos()
        {
            try {
                session_start();
             
                // Obter o ID do usuário atual da sessão
                require_once ROOT . "/dao/memorando/UsuarioDAO.php";
                $usuario = new UsuarioDAO();
            
                $id_usuario = $usuario->obterUsuario($_SESSION['usuario'])[0]["id_pessoa"];
                
                $pessoas = array();
                $pdo = Conexao::connect();

                // Alteração da consulta SQL para pegar dados apenas da tabela pessoa
                $consulta = $pdo->query("SELECT p.id_pessoa, p.nome, p.sobrenome 
                                        FROM pessoa p 
                                        WHERE p.id_pessoa != '$id_usuario'");

                $x = 0;
                while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    // Preencher o array com os dados das pessoas
                    $pessoas[$x] = array(
                        'id_pessoa' => $linha['id_pessoa'],
                        'nome' => $linha['nome'],
                        'sobrenome' => $linha['sobrenome']
                    );
                    $x++;
                }
                var_dump($consulta->fetchAll(PDO::FETCH_ASSOC));
            } catch (PDOException $e) {
                echo 'Error: ' . $e->getMessage();
            }

            // Retornar as pessoas em formato JSON
            return json_encode($pessoas);
     }  


    public function listarCPFPessoas()
    {
        try {
            $cpfs = array();
            $pdo = Conexao::connect();
        
            // Alteração da consulta SQL para pegar apenas dados da tabela pessoa
            $consulta = $pdo->query("SELECT id_pessoa, cpf FROM pessoa ");
        
            $x = 0;
            while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
                // Agora estamos apenas pegando as informações da tabela pessoa
                $cpfs[$x] = array('cpf' => $linha['cpf'], 'id_pessoa' => $linha['id_pessoa']);
                $x++;
            }
        } catch (PDOException $e) {
        
            echo 'Error: ' . $e->getMessage();
        }
    
        return json_encode($cpfs);
    }


    //Consultar um utilizando o id
        public function listarPessoa($id_pessoa)
        {   
            try {
                $pdo = Conexao::connect();   
                // Alteração da consulta SQL para pegar apenas dados da tabela pessoa
                $sql = "SELECT p.nome, p.sobrenome, p.cpf, p.sexo, p.telefone, p.data_nascimento, p.cep,
                            p.estado, p.cidade, p.bairro, p.logradouro, p.numero_endereco, p.complemento
                        FROM pessoa p
                        WHERE p.id_pessoa = :id_pessoa";
                
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id_pessoa', $id_pessoa);

                $stmt->execute();
                $pessoa = array();

                while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // Agora estamos apenas pegando as informações da tabela pessoa
                    $pessoa[] = array(
                        'cpf' => $linha['cpf'], 
                        'nome' => $linha['nome'], 
                        'sobrenome' => $linha['sobrenome'], 
                        'sexo' => $linha['sexo'], 
                        'data_nascimento' => $this->formatoDataDMY($linha['data_nascimento']),
                        'senha' => $linha['senha'], 
                        'telefone' => $linha['telefone'], 
                        'cep' => $linha['cep'], 
                        'estado' => $linha['estado'], 
                        'cidade' => $linha['cidade'], 
                        'bairro' => $linha['bairro'], 
                        'logradouro' => $linha['logradouro'], 
                        'numero_endereco' => $linha['numero_endereco'], 
                        'complemento' => $linha['complemento']
                    );
                }
            } catch (PDOException $e) {
                echo 'Error: ' . $e->getMessage();
            }

            // Retorno dos dados como JSON
            return json_encode($pessoa);
        }


        public function listarPessoaExistente($cpf)
        {
            try {
                $pdo = Conexao::connect();

                // Alteração da consulta SQL para pegar apenas dados da tabela pessoa
                $sql = "SELECT id_pessoa, nome, sobrenome, sexo, telefone, data_nascimento, cpf 
                        FROM pessoa 
                        WHERE cpf = :cpf";

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':cpf', $cpf);

                $stmt->execute();
                $pessoa = array();

                while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // Agora estamos apenas pegando as informações da tabela pessoa
                    $pessoa[] = array(
                        'id_pessoa' => $linha['id_pessoa'],
                        'cpf' => $linha['cpf'],
                        'nome' => $linha['nome'],
                        'sobrenome' => $linha['sobrenome'],
                        'sexo' => $linha['sexo'],
                        'data_nascimento' => $this->formatoDataDMY($linha['data_nascimento']),
                        'telefone' => $linha['telefone']
                    );
                }
            } catch (PDOException $e) {
                echo 'Error: ' .  $e->getMessage();
            }

            // Retorno como JSON
            return json_encode($pessoa);
        }


        public function retornaId($cpf)
        {
            try {
                $pdo = Conexao::connect();
                
                // Alteração da consulta SQL para pegar apenas o id_pessoa
                $sql = "SELECT id_pessoa FROM pessoa WHERE cpf = :cpf";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':cpf', $cpf);

                $stmt->execute();

                // Verificar se encontrou um id_pessoa e retorná-lo
                if ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $idPessoa = $linha['id_pessoa'];
                }

            } catch (PDOException $e) {
                echo 'Error: ' .  $e->getMessage();
            }

            return isset($idPessoa) ? $idPessoa : null; // Retorna o id_pessoa ou null caso não encontrado
        }

}
