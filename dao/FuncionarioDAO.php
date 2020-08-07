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
require_once ROOT."/dao/Conexao.php";
require_once ROOT."/classes/Funcionario.php";
require_once ROOT."/Functions/funcoes.php";

class FuncionarioDAO
{
    public function formatoDataDMY($data)
    {
        $data_arr = explode("-", $data);
        
        $datad = $data_arr[2] . '/' . $data_arr[1] . '/' . $data_arr[0];
        
        return $datad;
    }
    public function incluir($funcionario)
    {
        try {

            $sql = 'call cadfuncionario(:nome,:sobrenome,:cpf,:senha,:sexo,:telefone,:data_nascimento,:imagem,:cep,:estado,:cidade,:bairro,:logradouro,:numero_endereco,:complemento,:ibge,:registro_geral,:orgao_emissor,:data_expedicao,:nome_pai,:nome_mae,:tipo_sangue,:data_admissao,:pis,:ctps,:uf_ctps,:numero_titulo,:zona,:secao,:certificado_reservista_numero,:certificado_reservista_serie,:id_situacao,:id_cargo)';
            
            $sql = str_replace("'", "\'", $sql);
            $pdo = Conexao::connect();
            $stmt = $pdo->prepare($sql);
            $nome=$funcionario->getNome();
            $sobrenome=$funcionario->getSobrenome();
            $cpf=$funcionario->getCpf();
            $senha=$funcionario->getSenha();
            $sexo=$funcionario->getSexo();
            $telefone=$funcionario->getTelefone();
            $nascimento=$funcionario->getDataNascimento();
            $imagem=$funcionario->getImagem();
            $cep=$funcionario->getCep();
            $estado=$funcionario->getEstado();
            $cidade=$funcionario->getCidade();
            $bairro=$funcionario->getBairro();
            $logradouro=$funcionario->getLogradouro();
            $numeroEndereco=$funcionario->getNumeroEndereco();
            $complemento=$funcionario->getComplemento();
            $ibge=$funcionario->getIbge();
            $rg=$funcionario->getRegistroGeral();
            $orgaoEmissor=$funcionario->getOrgaoEmissor();
            $dataExpedicao=$funcionario->getDataExpedicao();
            $nomePai=$funcionario->getNomePai();
            $nomeMae=$funcionario->getNomeMae();
            $sangue=$funcionario->getTipoSanguineo();
            //$valeTransporte=$funcionario->getVale_transporte();
            $dataAdmissao=$funcionario->getData_admissao();
            $pis=$funcionario->getPis();
            $ctps=$funcionario->getCtps();
            $ufCtps=$funcionario->getUf_ctps();
            $numeroTitulo=$funcionario->getNumero_titulo();
            $zona=$funcionario->getZona();
            $secao=$funcionario->getSecao();
            $certificadoReservistaNumero=$funcionario->getCertificado_reservista_numero();
            $certificadoReservistaSerie=$funcionario->getCertificado_reservista_serie();
            /*$calcado=$funcionario->getCalcado();
            $calca=$funcionario->getCalca();
            $jaleco=$funcionario->getJaleco();
            $camisa=$funcionario->getCamisa();
            $usaVtp=$funcionario->getUsa_vtp();
            $cestaBasica=$funcionario->getCesta_basica();*/
            $situacao=$funcionario->getId_situacao();
            $cargo=$funcionario->getId_cargo();


            $stmt->bindParam(':nome',$nome);
            $stmt->bindParam(':sobrenome',$sobrenome);
            $stmt->bindParam(':id_cargo',$cargo);
            $stmt->bindParam(':cpf',$cpf);
            $stmt->bindParam(':senha',$senha);
            $stmt->bindParam(':sexo',$sexo);
            $stmt->bindParam(':telefone',$telefone);
            $stmt->bindParam(':data_nascimento',$nascimento);
            $stmt->bindParam(':imagem',$imagem);
            $stmt->bindParam(':cep',$cep);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':cidade',$cidade);
            $stmt->bindParam(':bairro',$bairro);
            $stmt->bindParam(':logradouro',$logradouro);
            $stmt->bindParam(':numero_endereco',$numeroEndereco);
            $stmt->bindParam(':complemento',$complemento);
            $stmt->bindParam(':ibge',$ibge);
            $stmt->bindParam(':registro_geral',$rg);
            $stmt->bindParam(':orgao_emissor',$orgaoEmissor);
            $stmt->bindParam(':nome_pai',$nomePai);
            $stmt->bindParam(':nome_mae',$nomeMae);
            $stmt->bindParam(':tipo_sangue',$sangue);
            //$stmt->bindParam(':vale_transporte', $valeTransporte);
            $stmt->bindParam(':data_admissao', $dataAdmissao);
            $stmt->bindParam(':pis', $pis);
            $stmt->bindParam(':ctps', $ctps);
            $stmt->bindParam(':uf_ctps', $ufCtps);
            $stmt->bindParam(':numero_titulo', $numeroTitulo);
            $stmt->bindParam(':zona', $zona);
            $stmt->bindParam(':secao', $secao);
            $stmt->bindParam(':certificado_reservista_numero', $certificadoReservistaNumero);
            $stmt->bindParam(':certificado_reservista_serie', $certificadoReservistaSerie);
            /*$stmt->bindParam(':calcado', $calcado);
            $stmt->bindParam(':calca', $calca);
            $stmt->bindParam(':jaleco', $jaleco);
            $stmt->bindParam(':camisa', $camisa);
            $stmt->bindParam(':usa_vtp', $usaVtp);
            $stmt->bindParam(':cesta_basica', $cestaBasica);*/
            $stmt->bindParam(':id_situacao', $situacao);
            $stmt->bindParam(':data_expedicao',$dataExpedicao);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela pessoas1 = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }

    // excluir
    public function excluir($id_funcionario)
    {
        try {
            $sql = 'call excluirfuncionario(:id_funcionario)';
            $sql = str_replace("'", "\'", $sql);
            $pdo = Conexao::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $pdo->prepare($sql);
            
            $stmt->bindParam(':id_funcionario', $id_funcionario);
            
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela pessoas = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }

    // Editar
    public function alterarInfPessoal($funcionario)
    {
        try {
            $sql = 'update pessoa as p inner join funcionario as f on p.id_pessoa=f.id_pessoa set nome=:nome,sobrenome=:sobrenome,sexo=:sexo,telefone=:telefone,data_nascimento=:data_nascimento,nome_pai=:nome_pai,nome_mae=:nome_mae,tipo_sanguineo=:tipo_sanguineo where id_funcionario=:id_funcionario';
            
           $sql = str_replace("'", "\'", $sql);
            $pdo = Conexao::connect();
            $stmt = $pdo->prepare($sql);
            
            $stmt = $pdo->prepare($sql);
            $nome=$funcionario->getNome();
            $sobrenome=$funcionario->getSobrenome();
            $id_funcionario=$funcionario->getId_funcionario();
            $sexo=$funcionario->getSexo();
            $telefone=$funcionario->getTelefone();
            $nascimento=$funcionario->getDataNascimento();
            $nomePai=$funcionario->getNomePai();        
            $nomeMae=$funcionario->getNomeMae();
            $sangue=$funcionario->getTipoSanguineo();

            $stmt->bindParam(':nome',$nome);
            $stmt->bindParam(':sobrenome',$sobrenome);
            $stmt->bindParam(':id_funcionario',$id_funcionario);
            $stmt->bindParam(':sexo',$sexo);
            $stmt->bindParam(':telefone',$telefone);
            $stmt->bindParam(':data_nascimento',$nascimento);
            $stmt->bindParam(':nome_pai',$nomePai);        
            $stmt->bindParam(':nome_mae',$nomeMae);
            $stmt->bindParam(':tipo_sanguineo',$sangue);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela pessoas = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }

    public function alterarImagem($funcionario)
    {
        try {
            $sql = 'update pessoa as p inner join funcionario as f on p.id_pessoa=f.id_pessoa set imagem=:imagem where id_funcionario=:id_funcionario';
            
           $sql = str_replace("'", "\'", $sql);
            $pdo = Conexao::connect();
            $stmt = $pdo->prepare($sql);
            
            $stmt = $pdo->prepare($sql);
            $imagem=$funcionario->getImagem();
            $id_funcionario=$funcionario->getId_funcionario();

            $stmt->bindParam(':imagem',$imagem);
            $stmt->bindParam(':id_funcionario',$id_funcionario);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela pessoas = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }

    public function alterarSenha($id_pessoa, $nova_senha)
    {
        try {
            $sql = 'update pessoa set senha=:nova_senha where id_pessoa=:id_pessoa';
            
            $sql = str_replace("'", "\'", $sql);
            $pdo = Conexao::connect();
            $stmt = $pdo->prepare($sql);
            
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':id_pessoa',$id_pessoa);
            $stmt->bindParam(':nova_senha',$nova_senha);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela pessoas = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }

    public function alterarEndereco($funcionario)
    {
        try {
            $sql = 'update pessoa as p inner join funcionario as f on p.id_pessoa=f.id_pessoa set cep=:cep,estado=:estado,cidade=:cidade,bairro=:bairro,logradouro=:logradouro,numero_endereco=:numero_endereco,complemento=:complemento,ibge=:ibge where id_funcionario=:id_funcionario';
            
           $sql = str_replace("'", "\'", $sql);

            $pdo = Conexao::connect();
            $stmt = $pdo->prepare($sql);

            $id_funcionario=$funcionario->getId_funcionario();
            $cep=$funcionario->getCep();
            $estado=$funcionario->getEstado();
            $cidade=$funcionario->getCidade();
            $bairro=$funcionario->getBairro();
            $logradouro=$funcionario->getLogradouro();
            $numero_endereco=$funcionario->getNumeroEndereco();        
            $complemento=$funcionario->getComplemento();
            $ibge=$funcionario->getIbge();

            $stmt->bindParam(':id_funcionario',$id_funcionario);
            $stmt->bindParam(':cep',$cep);
            $stmt->bindParam(':estado',$estado);
            $stmt->bindParam(':cidade',$cidade);
            $stmt->bindParam(':bairro',$bairro);
            $stmt->bindParam(':logradouro',$logradouro);
            $stmt->bindParam(':numero_endereco',$numero_endereco);        
            $stmt->bindParam(':complemento',$complemento);
            $stmt->bindParam(':ibge',$ibge);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela pessoas = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }

    public function alterarDocumentacao($funcionario)
    {
        try {

            $sql = 'update pessoa as p inner join funcionario as f on p.id_pessoa=f.id_pessoa set p.registro_geral=:registro_geral,p.orgao_emissor=:orgao_emissor,p.data_expedicao=:data_expedicao,p.cpf=:cpf,f.data_admissao=:data_admissao where id_funcionario=:id_funcionario';
            
           $sql = str_replace("'", "\'", $sql);

            $pdo = Conexao::connect();
            $stmt = $pdo->prepare($sql);

            $cpf=$funcionario->getCpf();
            $id_funcionario=$funcionario->getId_funcionario();
            $registro_geral=$funcionario->getRegistroGeral();
            $orgao_emissor=$funcionario->getOrgaoEmissor();
            $data_expedicao=$funcionario->getDataExpedicao();
            $data_admissao=$funcionario->getData_admissao();

            $stmt->bindParam(':cpf',$cpf);
            $stmt->bindParam(':id_funcionario',$id_funcionario);
            $stmt->bindParam(':registro_geral',$registro_geral);
            $stmt->bindParam(':orgao_emissor',$orgao_emissor);
            $stmt->bindParam(':data_expedicao',$data_expedicao);
            $stmt->bindParam(':data_admissao',$data_admissao);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela pessoas = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }

    public function alterarOutros($funcionario)
    {
        try {

            $sql = 'update pessoa as p inner join funcionario as f on p.id_pessoa=f.id_pessoa set f.pis=:pis,f.ctps=:ctps,f.uf_ctps=:uf_ctps,f.numero_titulo=:numero_titulo,f.zona=:zona, f.secao=:secao,f.certificado_reservista_numero=:certificado_reservista_numero,f.certificado_reservista_serie=:certificado_reservista_serie,f.id_situacao=:id_situacao,f.id_cargo=:id_cargo where f.id_funcionario=:id_funcionario';
            
           $sql = str_replace("'", "\'", $sql);

            $pdo = Conexao::connect();
            $stmt = $pdo->prepare($sql);

            $id_funcionario=$funcionario->getId_funcionario();
            $id_cargo=$funcionario->getId_cargo();
            $pis=$funcionario->getPis();
            $ctps=$funcionario->getCtps();
            $uf_ctps=$funcionario->getUf_ctps();
            $numero_titulo=$funcionario->getNumero_titulo();
            $zona=$funcionario->getZona();
            $secao=$funcionario->getSecao();
            $certificado_reservista_numero=$funcionario->getCertificado_reservista_numero();
            $certificado_reservista_serie=$funcionario->getCertificado_reservista_serie();
            $id_situacao=$funcionario->getId_situacao();

            $stmt->bindParam(':id_funcionario',$id_funcionario);
            $stmt->bindParam(':id_cargo',$id_cargo);
            $stmt->bindParam(':pis',$pis);
            $stmt->bindParam(':ctps',$ctps);
            $stmt->bindParam(':uf_ctps',$uf_ctps);
            $stmt->bindParam(':numero_titulo',$numero_titulo);
            $stmt->bindParam(':zona',$zona);
            $stmt->bindParam(':secao',$secao);
            $stmt->bindParam(':certificado_reservista_numero',$certificado_reservista_numero);
            $stmt->bindParam(':certificado_reservista_serie',$certificado_reservista_serie);
            $stmt->bindParam(':id_situacao',$id_situacao);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela pessoas = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }

    public function listarTodos(){

        try{
            $funcionarios=array();
            $pdo = Conexao::connect();
            $consulta = $pdo->query("SELECT f.id_funcionario, p.nome, p.sobrenome,p.cpf, c.cargo FROM pessoa p INNER JOIN funcionario f ON p.id_pessoa = f.id_pessoa LEFT JOIN cargo c ON c.id_cargo=f.id_cargo");
            $produtos = Array();
            $x=0;
            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                $funcionarios[$x]=array('id_funcionario'=>$linha['id_funcionario'],'cpf'=>mask($linha['cpf'],'###.###.###-##'),'nome'=>$linha['nome'],'sobrenome'=>$linha['sobrenome'] , 'cargo'=>$linha['cargo']);
                $x++;
            }
            } catch (PDOExeption $e){
                echo 'Error:' . $e->getMessage;
            }
            return json_encode($funcionarios);
    }

    public function listarTodos2(){
        try{
            require_once ROOT."/dao/memorando/UsuarioDAO.php";
            $usuario = new UsuarioDAO();
            $id_usuario = $usuario->obterUsuario($_SESSION['usuario'])[0]["id_pessoa"];
            $funcionarios=array();
            $pdo = Conexao::connect();
            $consulta = $pdo->query("SELECT p.id_pessoa, p.nome, p.sobrenome FROM funcionario f INNER JOIN pessoa p ON f.id_pessoa = p.id_pessoa WHERE p.id_pessoa!='$id_usuario'");
            $produtos = Array();
            $x=0;
            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                $funcionarios[$x]=array('id_pessoa'=>$linha['id_pessoa'],'nome'=>$linha['nome'], 'sobrenome'=>$linha['sobrenome']);
                $x++;
            }
            } catch (PDOExeption $e){
                echo 'Error:' . $e->getMessage;
            }
            return json_encode($funcionarios);
    }

    //Consultar um utilizando o id
    public function listar($id_funcionario){
        try{
            $pdo = Conexao::connect();
            $sql = "SELECT p.imagem,p.nome,p.sobrenome,p.cpf,p.senha,p.sexo,p.telefone,p.data_nascimento,p.cep,p.ibge,p.estado,p.cidade,p.bairro,p.logradouro,p.numero_endereco,p.complemento,p.ibge,p.registro_geral,p.orgao_emissor,p.data_expedicao,p.nome_pai,p.nome_mae,p.tipo_sanguineo,f.id_funcionario,f.data_admissao,f.pis,f.ctps,f.uf_ctps,f.numero_titulo,f.zona,f.secao,f.certificado_reservista_numero,f.certificado_reservista_serie,s.id_situacao,s.situacoes,c.id_cargo,c.cargo,qh.escala,qh.tipo,qh.carga_horaria,qh.entrada1,qh.saida1,qh.entrada2,qh.saida2,qh.total,qh.dias_trabalhados,qh.folga FROM pessoa p INNER JOIN funcionario f ON p.id_pessoa = f.id_pessoa INNER JOIN quadro_horario_funcionario qh ON qh.id_funcionario = f.id_funcionario INNER JOIN situacao s ON s.id_situacao = f.id_situacao INNER JOIN cargo c ON c.id_cargo = f.id_cargo WHERE f.id_funcionario = :id_funcionario";
           

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id_funcionario',$id_funcionario);

            $stmt->execute();
            $funcionario=array();

            while($linha = $stmt->fetch(PDO::FETCH_ASSOC)){
                $funcionario[] = array('imagem'=>$linha['imagem'],'cpf'=>$linha['cpf'],'nome'=>$linha['nome'],'sobrenome'=>$linha['sobrenome'],'sexo'=>$linha['sexo'],'data_nascimento'=>$this->formatoDataDMY($linha['data_nascimento']),'registro_geral'=>$linha['registro_geral'],'orgao_emissor'=>$linha['orgao_emissor'],'data_expedicao'=>$this->formatoDataDMY($linha['data_expedicao']),'nome_mae'=>$linha['nome_mae'],'nome_pai'=>$linha['nome_pai'],'tipo_sanguineo'=>$linha['tipo_sanguineo'],'senha'=>$linha['senha'],'telefone'=>$linha['telefone'],'cep'=>$linha['cep'],'estado'=>$linha['estado'],'ibge'=>$linha['ibge'],'cidade'=>$linha['cidade'],'bairro'=>$linha['bairro'],'logradouro'=>$linha['logradouro'],'numero_endereco'=>$linha['numero_endereco'],'complemento'=>$linha['complemento'],'id_funcionario'=>$linha['id_funcionario'],'data_admissao'=>$this->formatoDataDMY($linha['data_admissao']),'pis'=>$linha['pis'],'ctps'=>$linha['ctps'],'uf_ctps'=>$linha['uf_ctps'],'numero_titulo'=>$linha['numero_titulo'],'zona'=>$linha['zona'],'secao'=>$linha['secao'],'certificado_reservista_numero'=>$linha['certificado_reservista_numero'],'certificado_reservista_serie'=>$linha['certificado_reservista_serie'],'id_situacao'=>$linha['id_situacao'],'situacao'=>$linha['situacao'],'escala'=>$linha['escala'],'tipo'=>$linha['tipo'],'carga_horaria'=>$linha['carga_horaria'],'entrada1'=>$linha['entrada1'],'saida1'=>$linha['saida1'],'entrada2'=>$linha['entrada2'],'saida2'=>$linha['saida2'],'total'=>$linha['total'],'dias_trabalhados'=>$linha['dias_trabalhados'],'folga'=>$linha['folga'],'id_cargo'=>$linha['id_cargo'],'cargo'=>$linha['cargo']);
            }
        }catch (PDOExeption $e){
            echo 'Error: ' .  $e->getMessage();
        }
        return json_encode($funcionario);
    }

   public function retornaId($cpf){
         try{
            $pdo = Conexao::connect();
            $sql = "SELECT f.id_funcionario FROM pessoa p INNER JOIN funcionario f ON p.id_pessoa = f.id_pessoa WHERE p.cpf = :cpf";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':cpf',$cpf);

            $stmt->execute();
           while($linha = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $idFuncionario=$linha['id_funcionario'];
            }
        }catch (PDOExeption $e){
            echo 'Error: ' .  $e->getMessage();
        }

        return $idFuncionario;
    }

}