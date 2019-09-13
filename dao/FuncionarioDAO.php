
<?php
require_once '../classes/Funcionario.php';
require_once'../Functions/funcoes.php';
require_once'Conexao.php';
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

            $sql = 'call cadfuncionario(:nome,:cpf,:senha,:sexo,:telefone,:data_nascimento,:imagem,:cep,:estado,:cidade,:bairro,:logradouro,:numero_endereco,:complemento,:ibge,:registro_geral,:orgao_emissor,:data_expedicao,:nome_pai,:nome_mae,:tipo_sangue,:data_admissao,:pis,:ctps,:uf_ctps,:numero_titulo,:zona,:secao,:certificado_reservista_numero,:certificado_reservista_serie,:situacao,:cargo)';
            
            $sql = str_replace("'", "\'", $sql);
            $pdo = Conexao::connect();
            $stmt = $pdo->prepare($sql);
            $nome=$funcionario->getNome();
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
            $situacao=$funcionario->getSituacao();
            $cargo=$funcionario->getCargo();



            $stmt->bindParam(':nome',$nome);
            $stmt->bindParam(':cargo',$cargo);
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
            $stmt->bindParam(':situacao', $situacao);
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
            $sql = 'update pessoa as p inner join funcionario as f on p.id_pessoa=f.id_pessoa set nome=:nome,sexo=:sexo,telefone=:telefone,data_nascimento=:data_nascimento,nome_pai=:nome_pai,nome_mae=:nome_mae,tipo_sanguineo=:tipo_sanguineo where id_funcionario=:id_funcionario';
            
           $sql = str_replace("'", "\'", $sql);
            $pdo = Conexao::connect();
            $stmt = $pdo->prepare($sql);
            
            $stmt = $pdo->prepare($sql);
            $nome=$funcionario->getNome();
            $id_funcionario=$funcionario->getId_funcionario();
            $sexo=$funcionario->getSexo();
            $telefone=$funcionario->getTelefone();
            $nascimento=$funcionario->getDataNascimento();
            $nomePai=$funcionario->getNomePai();        
            $nomeMae=$funcionario->getNomeMae();
            $sangue=$funcionario->getTipoSanguineo();

            $stmt->bindParam(':nome',$nome);
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

            $sql = 'update pessoa as p inner join funcionario as f on p.id_pessoa=f.id_pessoa set f.pis=:pis,f.ctps=:ctps,f.uf_ctps=:uf_ctps,f.numero_titulo=:numero_titulo,f.zona=:zona, f.secao=:secao,f.certificado_reservista_numero=:certificado_reservista_numero,f.certificado_reservista_serie=:certificado_reservista_serie,f.situacao=:situacao,f.cargo=:cargo where f.id_funcionario=:id_funcionario';
            
           $sql = str_replace("'", "\'", $sql);

            $pdo = Conexao::connect();
            $stmt = $pdo->prepare($sql);

            $id_funcionario=$funcionario->getId_funcionario();
            $cargo=$funcionario->getCargo();
            $pis=$funcionario->getPis();
            $ctps=$funcionario->getCtps();
            $uf_ctps=$funcionario->getUf_ctps();
            $numero_titulo=$funcionario->getNumero_titulo();
            $zona=$funcionario->getZona();
            $secao=$funcionario->getSecao();
            $certificado_reservista_numero=$funcionario->getCertificado_reservista_numero();
            $certificado_reservista_serie=$funcionario->getCertificado_reservista_serie();
            $situacao=$funcionario->getSituacao();

            $stmt->bindParam(':id_funcionario',$id_funcionario);
            $stmt->bindParam(':cargo',$cargo);
            $stmt->bindParam(':pis',$pis);
            $stmt->bindParam(':ctps',$ctps);
            $stmt->bindParam(':uf_ctps',$uf_ctps);
            $stmt->bindParam(':numero_titulo',$numero_titulo);
            $stmt->bindParam(':zona',$zona);
            $stmt->bindParam(':secao',$secao);
            $stmt->bindParam(':certificado_reservista_numero',$certificado_reservista_numero);
            $stmt->bindParam(':certificado_reservista_serie',$certificado_reservista_serie);
            $stmt->bindParam(':situacao',$situacao);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela pessoas = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }

    public function listarTodos(){

        try{
            $funcionarios=array();
            $pdo = Conexao::connect();
            $consulta = $pdo->query("SELECT f.id_funcionario, p.nome,p.cpf, f.cargo FROM pessoa p INNER JOIN funcionario f ON p.id_pessoa = f.id_pessoa");
            $produtos = Array();
            $x=0;
            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                $funcionarios[$x]=array('id_funcionario'=>$linha['id_funcionario'],'cpf'=>mask($linha['cpf'],'###.###.###-##'),'nome'=>$linha['nome'], 'cargo'=>$linha['cargo']);
                $x++;
            }
            } catch (PDOExeption $e){
                echo 'Error:' . $e->getMessage;
            }
            return json_encode($funcionarios);
    }
    //Consultar um utilizando o cpf
   public function listar($id_funcionario){
        try{
            $pdo = Conexao::connect();
            $sql = "SELECT p.imagem,p.nome,p.cpf, p.senha, p.sexo, p.telefone,p.data_nascimento, p.cep,p.ibge, p.estado, p.cidade,p.bairro,p.logradouro,p.numero_endereco,p.complemento,p.ibge,p.registro_geral,p.orgao_emissor,p.data_expedicao,p.nome_pai,p.nome_mae,p.tipo_sanguineo,f.data_admissao,f.pis,f.ctps,f.uf_ctps,f.numero_titulo,f.zona,f.secao,f.certificado_reservista_numero,f.certificado_reservista_serie,f.situacao,f.cargo, qh.escala,qh.tipo,qh.carga_horaria,qh.entrada1,qh.saida1,qh.entrada2,qh.saida2,qh.total,qh.dias_trabalhados,qh.folga,b.data_inicio,b.data_fim,b.beneficios_status,be.id_beneficios,be.descricao_beneficios,pe.data,pe.epi_status,e.id_epi, e.descricao_epi FROM pessoa p INNER JOIN funcionario f ON p.id_pessoa = f.id_pessoa LEFT JOIN quadro_horario_funcionario qh ON qh.id_funcionario = f.id_funcionario LEFT JOIN beneficiados b ON b.id_pessoa = p.id_pessoa LEFT JOIN beneficios be ON be.id_beneficios = b.id_beneficios LEFT JOIN pessoa_epi pe ON pe.id_pessoa = f.id_pessoa LEFT JOIN epi e ON e.id_epi = pe.id_epi WHERE f.id_funcionario = :id_funcionario";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id_funcionario',$id_funcionario);

            $stmt->execute();
            $funcionario=array();
           while($linha = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $funcionario[]=array('imagem'=>$linha['imagem'], 'cpf'=>$linha['cpf'],'nome'=>$linha['nome'],'sexo'=>$linha['sexo'],'data_nascimento'=>$this->formatoDataDMY($linha['data_nascimento']),'registro_geral'=>$linha['registro_geral'],'orgao_emissor'=>$linha['orgao_emissor'],'data_expedicao'=>$this->formatoDataDMY($linha['data_expedicao']),'nome_mae'=>$linha['nome_mae'],'nome_pai'=>$linha['nome_pai'],'tipo_sanguineo'=>$linha['tipo_sanguineo'],'senha'=>$linha['senha'],'telefone'=>$linha['telefone'],'cep'=>$linha['cep'],'estado'=>$linha['estado'],'ibge'=>$linha['ibge'],'cidade'=>$linha['cidade'],'bairro'=>$linha['bairro'],'logradouro'=>$linha['logradouro'],'numero_endereco'=>$linha['numero_endereco'],'complemento'=>$linha['complemento'],'data_admissao'=>$this->formatoDataDMY($linha['data_admissao']),'pis'=>$linha['pis'],'ctps'=>$linha['ctps'],'uf_ctps'=>$linha['uf_ctps'],'numero_titulo'=>$linha['numero_titulo'],'zona'=>$linha['zona'],'secao'=>$linha['secao'],'certificado_reservista_numero'=>$linha['certificado_reservista_numero'],'certificado_reservista_serie'=>$linha['certificado_reservista_serie'],'situacao'=>$linha['situacao'],'escala'=>$linha['escala'],'tipo'=>$linha['tipo'],'carga_horaria'=>$linha['carga_horaria'],'entrada1'=>$linha['entrada1'],'saida1'=>$linha['saida1'],'entrada2'=>$linha['entrada2'],'saida2'=>$linha['saida2'],'total'=>$linha['total'],'dias_trabalhados'=>$linha['dias_trabalhados'],'folga'=>$linha['folga'],'cargo'=>$linha['cargo'],'data_inicio'=>$linha['data_inicio'],'data_fim'=>$linha['data_fim'],'beneficios_status'=>$linha['beneficios_status'],'id_beneficios'=>$linha['id_beneficios'],'descricao_beneficios'=>$linha['descricao_beneficios'],'data'=>$linha['data'],'epi_status'=>$linha['epi_status'],'id_epi'=>$linha['id_epi'], 'descricao_epi'=>$linha['descricao_epi']);
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