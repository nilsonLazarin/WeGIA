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
require_once ROOT."/classes/Atendido.php";
require_once ROOT."/Functions/funcoes.php";

class AtendidoDAO
{
    public function formatoDataDMY($data)
    {
        $data_arr = explode("-", $data);
        
        $datad = $data_arr[2] . '/' . $data_arr[1] . '/' . $data_arr[0];
        
        return $datad;
    }
	public function incluir($atendido)
    {               
        try {
            $sql = "call cadatendido(:strNome,:strSobrenome,:strCpf,:strSexo,:strTelefone,:dateNascimento, :intStatus, :intTipo)";
            //$sql = str_replace("'", "\'", $sql); 
            $pdo = Conexao::connect();
            $stmt = $pdo->prepare($sql);

            
            $nome=$atendido->getNome();
            $sobrenome=$atendido->getSobrenome();
            $cpf=$atendido->getCpf();
            $sexo=$atendido->getSexo();
            $telefone=$atendido->getTelefone();
            $dataNascimento=$atendido->getDataNascimento();
            $intTipo=$atendido->getIntTipo();
            $intStatus=$atendido->getIntStatus();

            $stmt->bindParam(':strNome',$nome);
            $stmt->bindParam(':strSobrenome',$sobrenome);
            $stmt->bindParam(':strCpf',$cpf);
            $stmt->bindParam(':strSexo',$sexo);
            $stmt->bindParam(':strTelefone',$telefone);
            $stmt->bindParam(':dateNascimento',$dataNascimento);
            $stmt->bindParam(':intStatus',$intStatus);
            $stmt->bindParam(':intTipo',$intTipo);
            $stmt->execute();
            
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela pessoas = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
        
        
    }
    //excluir  
    public function excluir($id)
    {
        
        try {
            
            $sql = 'call excluiratendido(:idatendido)';
            $sql = str_replace("'", "\'", $sql);
            $pdo = Conexao::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':idatendido', $id);
            
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela pessoas = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }

    public function alterarImagem($atendido)
    {
        try {
            $sql = 'update pessoa as p inner join interno as i on p.id_pessoa=i.id_pessoa set imagem=:imagem where id_pessoa=:id_pessoa';
            $sql = str_replace("'", "\'", $sql);
            $pdo = Conexao::connect();
            $stmt = $pdo->prepare($sql);

            $stmt = $pdo->prepare($sql);
            $imagem=$atendido->getImagem();
            $idatendido=$atendido->getIdatendido();
            $stmt->bindParam(':imagem',$imagem);
            $stmt->bindParam(':id_pessoa',$id_pessoa);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela pessoas = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }

    // Editar
    public function alterar($atendido)
    {
        try {
            $sql = 'update pessoa as p inner join atendido as a on p.id_pessoa=a.pessoa_id_pessoa set p.senha=:senha,p.nome=:nome, p.sobrenome=:sobrenome,p.cpf=:cpf,p.sexo=:sexo,p.telefone=:telefone,data_nascimento=:data_nascimento,p.imagem=:imagem,p.cep=:cep,p.estado=:estado,p.cidade=:cidade,p.bairro=:bairro,p.logradouro=:logradouro,p.numero_endereco=:numero_endereco,p.complemento=:complemento,p.ibge=:ibge,p.registro_geral=:registro_geral,p.orgao_emissor=:orgao_emissor,p.data_expedicao=:data_expedicao,p.nome_pai=:nome_pai,p.nome_mae=:nome_mae,p.intTipo_sanguineo=:intTipo_sanguineo,i.nome_contato_urgente=:nome_contato_urgente,i.strTelefone_contato_urgente_1=:strTelefone_contato_urgente_1,i.strTelefone_contato_urgente_2=:strTelefone_contato_urgente_2,i.strTelefone_contato_urgente_3=:strTelefone_contato_urgente_3,i.observacao=:observacao,i.certidao_nascimento=:certidao,i.curatela=:curatela,i.inss=:inss,i.loas=:loas,i.bpc=:bpc,i.funrural=:funrural,i.saf=:saf,i.sus=:sus,i.certidao_casamento=:certidao_casamento,i.ctps=:ctps,i.titulo=:titulo where a.pessoa_id_pessoa=:id_pessoa';
            
            $sql = str_replace("'", "\'", $sql);
            $pdo = Conexao::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $nome=$atendido->getNome();
            $sobrenome=$atendido->getSobrenome();
            $cpf=$atendido->getCpf();
            $sexo=$atendido->getSexo();
            $telefone=$atendido->getTelefone();
            $nascimento=$atendido->getDataNascimento();

            $stmt->bindParam('nome',$nome);
            $stmt->bindParam('sobrenome',$sobrenome);
            $stmt->bindParam(':cpf',$cpf);
            $stmt->bindParam(':sexo',$sexo);
            $stmt->bindParam(':telefone',$telefone);
            $stmt->bindParam(':data_nascimento',$nascimento);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela pessoas = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }
    public function listarTodos(){

        try{
            $atendidos=array();
            $pdo = Conexao::connect();
            $consulta = $pdo->query("SELECT p.nome,p.sobrenome,p.cpf,a.idatendido FROM pessoa p INNER JOIN atendido a ON p.id_pessoa = a.pessoa_id_pessoa");
            //$produtos = Array();
            $x=0;
            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                if ($linha['cpf']==="Não informado") {
                    $atendidos[$x]=array('cpf'=>$linha['cpf'],'nome'=>$linha['nome'],'sobrenome'=>$linha['sobrenome'],'id'=>$linha['id_pessoa']);
                }
                else{
                $atendidos[$x]=array('cpf'=>mask($linha['cpf'],'###.###.###-##'),'nome'=>$linha['nome'],'sobrenome'=>$linha['sobrenome'],'id'=>$linha['idatendido']);
                }
                $x++;
            }
            } catch (PDOExeption $e){
                echo 'Error:' . $e->getMessage;
            }
            return json_encode($atendidos);
        }


    public function listarTodos2(){

        try{
            $pessoas=array();
            $pdo = Conexao::connect();
            $consulta = $pdo->query("SELECT p.nome,p.sobrenome,p.cpf,i.id_pessoa FROM pessoa p INNER JOIN pessoa i ON p.id_pessoa = i.id_pessoa");
            $produtos = Array();
            $x=0;
            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                if ($linha['cpf']==="Não informado") {
                    $pessoas[$x]=array('cpf'=>$linha['cpf'],'nome'=>$linha['nome'],'sobrenome'=>$linha['sobrenome'],'id'=>$linha['id_pessoa']);
                }
                else{
                $pessoas[$x]=array('cpf'=>mask($linha['cpf'],'###.###.###-##'),'nome'=>$linha['nome'],'sobrenome'=>$linha['sobrenome'],'id'=>$linha['id_pessoa']);
                }
                $x++;
            }
            } catch (PDOExeption $e){
                echo 'Error:' . $e->getMessage;
            }
            return $pessoas;
        }

    public function listar($id){
        try{
            echo $id;
            $pdo = Conexao::connect();
            $sql = "SELECT p.imagem,p.nome,p.sobrenome,p.cpf, p.senha, p.sexo, p.telefone,p.data_nascimento, p.cep,p.cidade,p.bairro,p.logradouro,p.numero_endereco,p.complemento,p.ibge,p.registro_geral,p.orgao_emissor,p.data_expedicao,p.nome_pai,p.nome_mae,p.tipo_sanguineo,d.id_documento FROM pessoa p LEFT JOIN atendido a ON p.id_pessoa = a.pessoa_id_pessoa left join documento d on p.id_pessoa=d.id_pessoa WHERE a.idatendido=:id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id',$id);

            $stmt->execute();
            $pessoa=array();
            while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($linha['cpf']==="Não informado") {
                $pessoa[]=array('imagem'=>$linha['imagem'],'nome'=>$linha['nome'],'sobrenome'=>$linha['sobrenome'],'cpf'=>$linha['cpf'], 'senha'=>$linha['senha'], 'sexo'=>$linha['sexo'], 'telefone'=>$linha['telefone'],'data_nascimento'=>$linha['data_nascimento'], 'cep'=>$linha['cep'],'cidade'=>$linha['cidade'],'bairro'=>$linha['bairro'],'logradouro'=>$linha['logradouro'],'numero_endereco'=>$linha['numero_endereco'],'complemento'=>$linha['complemento'],'ibge'=>$linha['ibge'],'registro_geral'=>$linha['registro_geral'],'orgao_emissor'=>$linha['orgao_emissor'],'data_expedicao'=>$linha['data_expedicao'],'nome_pai'=>$linha['nome_pai'],'nome_mae'=>$linha['nome_mae'],'tipo_sanguineo'=>$linha['tipo_sanguineo'],'idatendido'=>$linha['pessoa_id_pessoa'],'imgdoc'=>$linha['imgdoc'],'descricao'=>$linha['descricao'],'id_documento'=>$linha['id_documento']);
                
            }
            else{
                $pessoa[]=array('imagem'=>$linha['imagem'],'nome'=>$linha['nome'],'sobrenome'=>$linha['sobrenome'],'cpf'=>mask($linha['cpf'],'###.###.###-##'), 'senha'=>$linha['senha'], 'sexo'=>$linha['sexo'], 'telefone'=>$linha['telefone'],'data_nascimento'=>$linha['data_nascimento'], 'cep'=>$linha['cep'],'cidade'=>$linha['cidade'],'bairro'=>$linha['bairro'],'logradouro'=>$linha['logradouro'],'numero_endereco'=>$linha['numero_endereco'],'complemento'=>$linha['complemento'],'ibge'=>$linha['ibge'],'registro_geral'=>$linha['registro_geral'],'orgao_emissor'=>$linha['orgao_emissor'],'data_expedicao'=>$linha['data_expedicao'],'nome_pai'=>$linha['nome_pai'],'nome_mae'=>$linha['nome_mae'],'tipo_sanguineo'=>$linha['tipo_sanguineo'],'idatendido'=>$linha['pessoa_id_pessoa'],'imgdoc'=>$linha['imgdoc'],'descricao'=>$linha['descricao'],'id_documento'=>$linha['id_documento']);
            }
        }
        }catch (PDOExeption $e){
            echo 'Error: ' .  $e->getMessage();
        }
        return json_encode($pessoa);
    }

    public function listarcpf()
    {
        try
        {
            $cpfs = array();
            $pdo = Conexao::connect();
            $consulta = $pdo->query("SELECT cpf from pessoa p INNER JOIN atendido a ON(p.id_pessoa=a.pessoa_id_pessoa)");
            $x=0;
            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
                $cpfs[$x] = array('cpf'=>$linha['cpf']);
                $x++;
            }
        }
        catch(PDOExeption $e)
        {
            echo 'Error:' . $e->getMessage;
        }
        return json_encode($cpfs);
    }
    public function alterarInfPessoal($atendido)
    {
        try {
            $sql = 'update pessoa as p inner join atendido as a on p.id_pessoa=a.pessoa_id_pessoa set nome=:nome,sobrenome=:sobrenome,sexo=:sexo,telefone=:telefone,data_nascimento=:data_nascimento,nome_pai=:nome_pai,nome_mae=:nome_mae,tipo_sanguineo=:tipo_sanguineo where idatendido=:idatendido';

            $sql = str_replace("'", "\'", $sql);
            $pdo = Conexao::connect();
            $stmt = $pdo->prepare($sql);

            $stmt = $pdo->prepare($sql);
            $nome=$atendido->getNome();
            $sobrenome=$atendido->getSobrenome();
            $id=$atendido->getIdatendido();
            $sexo=$atendido->getSexo();
            $telefone=$atendido->getTelefone();
            $nascimento=$atendido->getDataNascimento();
            $nomePai=$atendido->getNomePai();        
            $nomeMae=$atendido->getNomeMae();
            $sangue=$atendido->getTipoSanguineo();

            $stmt->bindParam(':nome',$nome);
            $stmt->bindParam(':sobrenome',$sobrenome);
            $stmt->bindParam(':idatendido',$id);
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

    public function alterarDocumentacao($atendido)
    {
        try {

            $sql = 'update pessoa as p inner join atendido as a on p.id_pessoa=a.pessoa_id_pessoa set p.registro_geral=:rg,p.orgao_emissor=:orgao,p.data_expedicao=:data_expedicao,p.cpf=:cpf where idatendido=:idatendido';
            
           $sql = str_replace("'", "\'", $sql);

            $pdo = Conexao::connect();
            $stmt = $pdo->prepare($sql);

            $cpf=$atendido->getCpf();
            $idatendido=$atendido->getIdatendido();
            $rg=$atendido->getRegistroGeral();
            $orgao=$atendido->getOrgaoEmissor();
            $data_expedicao=$atendido->getDataExpedicao();

            $stmt->bindParam(':cpf',$cpf);
            $stmt->bindParam(':idatendido',$idatendido);
            $stmt->bindParam(':registro_geral',$rg);
            $stmt->bindParam(':orgao_emissor',$orgao);
            $stmt->bindParam(':data_expedicao',$data_expedicao);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela pessoas = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }


}
?>