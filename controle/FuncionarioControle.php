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
include_once ROOT.'/classes/Funcionario.php';
include_once ROOT.'/classes/Pessoa_epi.php';
include_once ROOT.'/classes/QuadroHorario.php';
include_once ROOT.'/dao/FuncionarioDAO.php';
include_once ROOT.'/dao/QuadroHorarioDAO.php';
include_once ROOT.'/dao/BeneficiadosDAO.php';
include_once ROOT.'/dao/Pessoa_epiDAO.php';
include_once ROOT.'/dao/PermissaoDAO.php';


class FuncionarioControle
{
    public function formatoDataYMD($data)
    {
        $data_arr = explode("/", $data);
        
        $datac = $data_arr[2] . '-' . $data_arr[1] . '-' . $data_arr[0];
        
        return $datac;
    }

    function somarHoras($subtotal1, $subtotal2){
        $hora1 = explode(":",$subtotal1);
        $hora2 = explode(":",$subtotal2);

        $tempoTotal = (intval($hora1[0])*60) + (intval($hora2[0])*60) + intval($hora1[1]) + intval($hora2[1]);

        $horaTotal = floor($tempoTotal/60);
        $minutoTotal = $tempoTotal%60;

        if (strlen($minutoTotal) == 1) {
                $minutoTotal = "0" . $minutoTotal;
            }

            if (strlen($horaTotal) == 1) {
                $horaTotal = "0" . $horaTotal;
            }

            $final = $horaTotal . ":" . $minutoTotal;



        return $final;


    }

    function calcularHora($entrada, $saida){
        $hora1 = explode(":",$entrada);
        $hora2 = explode(":",$saida);
        $horaTotal = ((intval($hora2[0])*60) + intval($hora2[1])) - ((intval($hora1[0])*60) + intval($hora1[1]));

        $horaTotall = floor($horaTotal/60);
        $minutoTotal = $horaTotal%60;

        if (strlen($minutoTotal) == 1) {
                $minutoTotal = "0" . $minutoTotal;
            }

            if (strlen($horaTotall) == 1) {
                $horaTotal = "0" . $horaTotal;
            }

            $final = $horaTotall . ":" . $minutoTotal;

        return $final;
    }

    function geraChave($cpf, $tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
    {
        $lmin = 'abcdefghijklmnopqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '1234567890';
        $simb = '!@#$%*-';
        $retorno = '';
        $caracteres = '';
        $caracteres .= $lmin;
        if ($maiusculas) $caracteres .= $lmai;
        if ($numeros) $caracteres .= $num;
        if ($simbolos) $caracteres .= $simb;
        $len = strlen($caracteres);
        for ($n = 1; $n <= $tamanho; $n++) {
            $rand = mt_rand(1, $len);
            $retorno .= $caracteres[$rand-1];
        }
        
        $retorno=hash('sha256', $retorno);
        return $retorno;
    }

    public function verificarHorario(){
        extract($_REQUEST);
        if((!isset($escala)) || (empty($escala))){
            $escala = '';
        }
        if((!isset($tipoCargaHoraria)) || (empty($tipoCargaHoraria))){
            $tipoCargaHoraria = '';
        }
        if((!isset($entrada1)) || (empty($entrada1))){
            $entrada1 = '';
        }
        if((!isset($saida1)) || (empty($saida1))){
            $saida1 = '';
        }
        if((!isset($entrada2)) || (empty($entrada2))){
            $entrada2 = '';
        }
        if((!isset($saida2)) || (empty($saida2))){
            $saida2 = '';
        }

            $subtotal1 = $this->calcularHora($entrada1, $saida1);
            $subtotal2 = $this->calcularHora($entrada2, $saida2);
            $total = $this->somarHoras($subtotal1, $subtotal2);

            $diasTrabalhados = array();
            $folgas = array();


            if (isset($folgaSeg)) {
                array_push($folgas, $folgaSeg);
            }
            if (isset($folgaTer)) {
                array_push($folgas, $folgaTer);
            }

            if (isset($folgaQua)) {
                array_push($folgas, $folgaQua);
            }
            if (isset($folgaQui)) {
                array_push($folgas, $folgaQui);
            }
            if (isset($folgaSex)) {
                array_push($folgas, $folgaSex);
            }
            if (isset($folgaSab)) {
                array_push($folgas, $folgaSab);
            }
            if (isset($folgaDom)) {
                array_push($folgas, $folgaDom);
            }
            if (isset($folgaAlternado)) {
                array_push($folgas, $folgaAlternado);
            }

            $folga = implode(",", $folgas);

            if (isset($trabSeg)) {
                array_push($diasTrabalhados, $trabSeg);
            }
            if (isset($trabTer)) {
                array_push($diasTrabalhados, $trabTer);
            }

            if (isset($trabQua)) {
                array_push($diasTrabalhados, $trabQua);
            }
            if (isset($trabQui)) {
                array_push($diasTrabalhados, $trabQui);
            }
            if (isset($trabSex)) {
                array_push($diasTrabalhados, $trabSex);
            }
            if (isset($trabSab)) {
                array_push($diasTrabalhados, $trabSab);
            }
            if (isset($trabDom)) {
                array_push($diasTrabalhados, $trabDom);
            }

            $diasMultiplicados = count($diasTrabalhados);

            $arrayHorasDiarias = explode(":", $total);
            $minutosDiarios = intval($arrayHorasDiarias[0])*60 + intval($arrayHorasDiarias[1]);

            $minutosDiarios = $minutosDiarios * $diasMultiplicados;
            $minutosDiarios = $minutosDiarios * 4;

            $horaTotal = floor($minutosDiarios/60);
            $minutoTotal = $minutosDiarios%60;

            if (strlen($minutoTotal) == 1) {
                $minutoTotal = "0" . $minutoTotal;
            }

            if (strlen($horaTotal) == 1) {
                $horaTotal = "0" . $horaTotal;
            }

            $carga_horaria = $horaTotal . ":" . $minutoTotal;

            $dias_trabalhados = implode(",", $diasTrabalhados);

        $horario = new QuadroHorario();

        $horario->setEscala($escala);
        $horario->setTipo($tipoCargaHoraria);
        $horario->setCarga_horaria($carga_horaria);
        $horario->setEntrada1($entrada1);
        $horario->setSaida1($saida1);
        $horario->setEntrada2($entrada2);
        $horario->setSaida2($saida2);
        $horario->setTotal($total);
        $horario->setDias_trabalhados($dias_trabalhados);
        $horario->setFolga($folga);

        return $horario;
    }

    public function verificarFuncionario(){
        extract($_REQUEST);

        if((!isset($nome)) || (empty($nome))){
            $msg = "Nome do funcionario nÃ£o informado. Por favor, informe um nome!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($sobrenome)) || (empty($sobrenome))){
            $msg = "Sobrenome do funcionario nÃ£o informado. Por favor, informe um sobrenome!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($gender)) || (empty($gender))){
            $msg .= "Sexo do funcionario nÃ£o informado. Por favor, informe um sexo!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($cargo)) || (empty($cargo))){
            $msg .= "Cargo do funcionario nÃ£o informado. Por favor, informe um cargo!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($telefone)) || (empty($telefone))){
            $telefone='null';
        }
        if((!isset($nascimento)) || (empty($nascimento))){
            $msg .= "Data de nascimento do funcionario nÃ£o informado. Por favor, informe uma data de nascimento!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($nome_pai)) || (empty($nome_pai))){
            $nome_pai = '';
        }
        if((!isset($nome_mae)) || (empty($nome_mae))){
            $nome_mae = '';
        }
        if((!isset($sangue)) || (empty($sangue))){
            $sangue = '';
        }
        if((!isset($cep)) || empty(($cep))){
            $cep = '';
        }
        if((!isset($uf)) || empty(($uf))){
            $uf = '';
        }
        if((!isset($cidade)) || empty(($cidade))){
            $cidade = '';
        }
        if((!isset($bairro)) || empty(($bairro))){
            $bairro = '';
        }
        if((!isset($rua)) || empty(($rua))){
            $rua = '';
        }
        if((!isset($numero_residencia)) || empty(($numero_residencia))){
            $numero_residencia = "";
        }
        if((!isset($complemento)) || (empty($complemento))){
            $complemento='';
        }
        if((!isset($ibge)) || (empty($ibge))){
            $ibge='';
        }
        if((!isset($rg)) || empty(($rg))){
            $msg .= "RG do funcionario nÃ£o informado. Por favor, informe um rg!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($orgao_emissor)) || empty(($orgao_emissor))){
            $msg .= "Órgão emissor do funcionario nÃ£o informado. Por favor, informe o órgão emissor!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($data_expedicao)) || (empty($data_expedicao))){
            $msg .= "Data de expediÃ§Ã£o do rg do funcionario nÃ£o informado. Por favor, informe um data de expediÃ§Ã£o!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($cpf)) || (empty($cpf))){
            $msg .= "CPF do funcionario nÃ£o informado. Por favor, informe um CPF!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($pis)) || (empty($pis))){
            $pis = '';
        }
        if((!isset($ctps)) || (empty($ctps))){
            $ctps = '';
        }
        if((!isset($uf_ctps)) || (empty($uf_ctps))){
            $uf_ctps = '';
        }
        if((!isset($titulo_eleitor)) || (empty($titulo_eleitor))){
            $titulo_eleitor = '';
        }
        if((!isset($zona_eleitoral)) || (empty($zona_eleitoral))){
            $zona_eleitoral = '';
        }
        if((!isset($secao_titulo_eleitor)) || (empty($secao_titulo_eleitor))){
            $secao_titulo_eleitor = '';
        }
        
        if((!isset($data_admissao)) || (empty($data_admissao))){
            $msg .= "Data de Admissao do funcionario nÃ£o informada. Por favor, informe a data de admissao!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($situacao)) || (empty($situacao))){
            $msg .= "Situação do funcionario nÃ£o informada. Por favor, informe a situação!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        
        if((!isset($certificado_reservista_numero)) || (empty($certificado_reservista_numero))){
            $certificado_reservista_numero='';
        }
        if((!isset($certificado_reservista_serie)) || (empty($certificado_reservista_serie))){
            $certificado_reservista_serie='';
        }

        session_start();
        if((!isset($_SESSION['imagem'])) || (empty($_SESSION['imagem']))){
            $imgperfil = '';
        }else{
            $imgperfil = base64_encode($_SESSION['imagem']);
        }
        $cpf=str_replace(".", '', $cpf);
        $cpf=str_replace("-", "", $cpf);
        $senha=$this->geraChave($cpf);
        $funcionario = new Funcionario($cpf,$nome,$sobrenome,$gender,$nascimento,$rg,$orgao_emissor,$data_expedicao,$nome_mae,$nome_pai,$sangue,$senha,$telefone,$imgperfil,$cep,$uf,$cidade,$bairro,$rua,$numero_residencia,$complemento,$ibge);
        $funcionario->setData_admissao($data_admissao);
        $funcionario->setPis($pis);
        $funcionario->setCtps($ctps);
        $funcionario->setUf_ctps($uf_ctps);
        $funcionario->setNumero_titulo($titulo_eleitor);
        $funcionario->setZona($zona_eleitoral);
        $funcionario->setSecao($secao_titulo_eleitor);
        $funcionario->setCertificado_reservista_numero($certificado_reservista_numero);
        $funcionario->setCertificado_reservista_serie($certificado_reservista_serie);
        $funcionario->setId_situacao($situacao);
        $funcionario->setId_cargo($cargo);
        
        return $funcionario;
    }

    public function verificarBeneficiados(){
        extract($_REQUEST);
        
        if((!isset($ibeneficios)) || (empty($ibeneficios))){
            $ibeneficios = '0';
            //$msg .= "Descricao do beneficio nÃ£o informado. Por favor, informe uma descricao!";
            //header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($data_inicio)) || (empty($data_inicio))){
            $data_inicio = '';
            //date_default_timezone_set('America/Sao_Paulo');
            //$data_inicio = date('d-m-Y');
        }
        if((!isset($data_fim)) || (empty($data_fim))){
            $data_fim='';
        }
        if((!isset($beneficios_status)) || (empty($beneficios_status))){
            $beneficios_status='';
        }
        if((!isset($valor)) || (empty($valor))){
            $valor='0000';
        }

        $beneficiados = new Beneficiados();
        $beneficiados->setId_beneficios($ibeneficios);
        $beneficiados->setData_inicio($data_inicio);
        $beneficiados->setData_fim($data_fim);
        $beneficiados->setBeneficios_status($beneficios_status);
        $beneficiados->setValor($valor);

        return $beneficiados;
    }

    public function verificarEpi(){
        extract($_REQUEST);
        
        if((!isset($descricao_epi)) || (empty($descricao_epi))){
            $descricao_epi = '0';
            //$msg .= "Descricao da epi nÃ£o informado. Por favor, informe uma descricao!";
            //header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($data)) || (empty($data))){
            $data = '';
            //date_default_timezone_set('America/Sao_Paulo');
            //$data = date('d-m-Y');
        }
        if((!isset($epi_status)) || (empty($epi_status))){
            $epi_status='';
        }

        $epi = new Pessoa_epi();
        $epi->setId_epi($descricao_epi);
        $epi->setData($data);
        $epi->setEpi_status($epi_status);

        return $epi;
    }

    public function verificarSenha(){
        extract($_REQUEST);
        $nova_senha=hash('sha256', $nova_senha);
        $confirmar_senha=hash('sha256', $confirmar_senha);
        $senha_antiga=hash('sha256', $senha_antiga);
        if ($nova_senha!=$confirmar_senha) {
            return 1;
        }else{
              $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD, DB_NAME);
              $senha = $mysqli->query("SELECT senha FROM pessoa where id_pessoa=".$id_pessoa);
              while($row = $senha->fetch_array(MYSQLI_NUM))
                {
                  if ($row[0]!=$senha_antiga) {
                      return 2;
                  }
                }
        }
        return 3;
    }
    public function verificarSenhaConfig(){
        extract($_REQUEST);
        $nova_senha=hash('sha256', $nova_senha);
        $confirmar_senha=hash('sha256', $confirmar_senha);
        if ($nova_senha!=$confirmar_senha) {
            return 1;
        }else{
            return 3;
        }
    }

    public function listarTodos(){
        extract($_REQUEST);
        $funcionariosDAO = new FuncionarioDAO();
        $funcionarios = $funcionariosDAO->listarTodos();
        session_start();
        $_SESSION['funcionarios']=$funcionarios;
        header('Location: '.$nextPage);
    }

    public function listarTodos2(){
        extract($_REQUEST);
        $funcionariosDAO = new FuncionarioDAO();
        $funcionarios = $funcionariosDAO->listarTodos2();
        $_SESSION['funcionarios2']=$funcionarios;
    }

    public function listarCpf(){
        extract($_REQUEST);
        $funcionariosDAO = new FuncionarioDAO();
        $funcionarioscpf = $funcionariosDAO->listarCPF();
        $_SESSION['cpf_funcionario']=$funcionarioscpf;
    }
    
    public function listarUm()
    {
        extract($_REQUEST);
        try {
            $funcionarioDAO = new FuncionarioDAO();
            $funcionario=$funcionarioDAO->listar($id_funcionario);
            session_start();
            $_SESSION['funcionario']=$funcionario;
            header('Location:'.$nextPage);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        
    }

    public function listarEpi()
    {
        extract($_REQUEST);
        try {
            $epiDAO = new Pessoa_epiDAO();
            $epi=$epiDAO->listarEpi($id_funcionario);
            session_start();
            $_SESSION['epi']=$epi;
            header('Location:'.$nextPage);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        
    }
    public function adicionar_permissao(){
        extract($_REQUEST);
        try {
            $permissao = new PermissaoDAO();
            $adicao_permissao = $permissao->adicionarPermissao($cargo, $acao, $recurso);
            header('Location:'.$nextPage.'?msg_c=Permissão efetivada com sucesso.');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function listarBeneficio()
    {
        extract($_REQUEST);
        try {
            $beneficiadoDAO = new BeneficiadosDAO();
            $beneficio=$beneficiadoDAO->listarBeneficio($id_funcionario);
            session_start();
            $_SESSION['beneficio']=$beneficio;
            header('Location:'.$nextPage);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        
    }
   
    public function incluir(){
        $funcionario = $this->verificarFuncionario();
        $horario = $this->verificarHorario();
        //$beneficiados = $this->verificarBeneficiados();
        //$epi = $this->verificarEpi();
        $funcionarioDAO = new FuncionarioDAO();
        $horarioDAO = new QuadroHorarioDAO();
        //$beneficiadosDAO = new BeneficiadosDAO();
        //$epiDAO = new Pessoa_epiDAO();
        
        try{
            $funcionarioDAO->incluir($funcionario);
            $horarioDAO->incluir($horario);
            //$beneficiadosDAO->incluir($beneficiados);
            //$epiDAO->incluir($epi);
            $_SESSION['msg']="Funcionario cadastrado com sucesso";
            $_SESSION['proxima']="Cadastrar outro funcionario";
            $_SESSION['link']="../html/cadastro_funcionario.php";
            header("Location: ../html/informacao_funcionario.php");

        } catch (PDOException $e){
            $msg= "NÃ£o foi possÃ­vel registrar o funcionário"."<br>".$e->getMessage();
            echo $msg;
        }
    }

        public function incluirBeneficio(){
            $beneficiados = $this->verificarBeneficiados();
            $beneficiadosDAO = new BeneficiadosDAO();
            
            try{
                $beneficiadosDAO->incluir($beneficiados);
                $_SESSION['msg']="Funcionario cadastrado com sucesso";
                $_SESSION['proxima']="Cadastrar outro funcionario";
                $_SESSION['link']="../html/cadastro_funcionario.php";
                header("Location: ../html/informacao_funcionario.php");

            } catch (PDOException $e){
                $msg= "NÃ£o foi possÃ­vel registrar o funcionário"."<br>".$e->getMessage();
                echo $msg;
            }
        }

        public function incluirEpi(){
            $epi = $this->verificarEpi();
            $epiDAO = new Pessoa_epiDAO();
            
            try{
                $epiDAO->incluir($epi);
                $_SESSION['msg']="Funcionario cadastrado com sucesso";
                $_SESSION['proxima']="Cadastrar outro funcionario";
                $_SESSION['link']="../html/cadastro_funcionario.php";
                header("Location: ../html/informacao_funcionario.php");

            } catch (PDOException $e){
                $msg= "NÃ£o foi possÃ­vel registrar o funcionário"."<br>".$e->getMessage();
                echo $msg;
            }
        }
        public function incluirEpi1(){
            $epi = $this->verificarEpi();
            $epiDAO = new Pessoa_epiDAO();
            
            try{
                $epiDAO->incluir($epi);
                header("Location: ../html/informacao_funcionario.php");

            } catch (PDOException $e){
                $msg= "NÃ£o foi possÃ­vel registrar o funcionário"."<br>".$e->getMessage();
                echo $msg;
            }
        }
        /*try{
            $horarioDAO->incluir($horario);
            //header("Location: ../html/sucesso.php");
        } catch (PDOException $e){
            $msg= "NÃ£o foi possÃ­vel registrar o horario"."<br>".$e->getMessage();
            echo $msg;
        }
        try{
            $beneficiadosDAO->incluir($beneficiados);
            $_SESSION['msg']="Funcionario cadastrado com sucesso";
            $_SESSION['proxima']="Cadastrar outro funcionario";
            $_SESSION['link']="../html/cadastro_funcionario.php";
            header("Location: ../html/sucesso.php");
        } catch (PDOException $e){
            $msg= "NÃ£o foi possÃ­vel registrar o beneficio"."<br>".$e->getMessage();
            echo $msg;
        }

        try{
            $episDAO->incluir($epis);
            
        } catch (PDOException $e){
            $msg= "NÃ£o foi possÃ­vel registrar o epi"."<br>".$e->getMessage();
            echo $msg;
        }
        */

    public function alterarInfPessoal()
    {
        extract($_REQUEST);
        $funcionario = new Funcionario('',$nome,$sobrenome,$gender,$nascimento,'','','',$nome_mae,$nome_pai,$sangue,'',$telefone,'','','','','','','','','');
        $funcionario->setId_funcionario($id_funcionario);
        //echo $funcionario->getId_Funcionario();
        $funcionarioDAO=new FuncionarioDAO();
        try {
            $funcionarioDAO->alterarInfPessoal($funcionario);
            header("Location: ../html/profile_funcionario.php?id_funcionario=".$id_funcionario);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        
    }

    public function alterarSenha()
    {
        extract($_REQUEST); 
        $nova_senha=hash('sha256', $nova_senha);
        if(isset($redir)){
            $page = $redir;
            $verificacao=$this->verificarSenhaConfig();
        }else{
            $verificacao=$this->verificarSenha();
            $page = "alterar_senha.php";

        } 
        if ($verificacao==1) {
            header("Location: ".WWW."html/$page?verificacao=".$verificacao);
        }elseif ($verificacao==2) {
            header("Location: ".WWW."html/$page?verificacao=".$verificacao);
        }else{
            $funcionarioDAO=new FuncionarioDAO();
            try {
                $funcionarioDAO->alterarSenha($id_pessoa, $nova_senha);
                 $conexao =  mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
                 $resultado = mysqli_query($conexao, "UPDATE pessoa set adm_configurado=1 where cpf='admin'");
                 $resultado = mysqli_query($conexao, "SELECT original from selecao_paragrafo where id_selecao = 1");
                 $registro = mysqli_fetch_array($resultado);
                 if($registro['original'] == 1){
                    header("Location: ".WWW."html/$page?verificacao=".$verificacao."&redir_config=true");
                 }else  header("Location: ".WWW."html/$page.php?verificacao=".$verificacao);
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
/*
    public function checarSenha(){
        extract($_REQUEST);
        $nova_senha=hash('sha256', $nova_senha);
        $confirmar_senha=hash('sha256', $confirmar_senha);
        $senha_antiga=$_GET['hash'];
        if ($nova_senha!=$confirmar_senha) {
            return 1;
        }else{
              $usuario = "wegia";
              $senha = "wegia";
              $servidor = "localhost";
              $bddnome = "wegia";
              $mysqli = new mysqli($servidor,$usuario,$senha,$bddnome);
              $senha = $mysqli->query("SELECT senha FROM pessoa where id_pessoa=".$id_pessoa);
              while($row = $senha->fetch_array(MYSQLI_NUM))
                {
                  if ($row[0]!=$senha_antiga) {
                      return 2;
                  }
                }
        }
        return 3;
    }

    public function esqueciSenha()
    {
        extract($_REQUEST);
        $nova_senha=hash('sha256', $nova_senha);
        $verificacao=$this->checarSenha();
        if ($verificacao==1) {
            header("Location: ../html/alterar_senha.php?verificacao=".$verificacao);
        }elseif ($verificacao==2) {
            header("Location: ../html/alterar_senha.php?verificacao=".$verificacao);
        }else{
            $funcionarioDAO=new FuncionarioDAO();
            try {
                $funcionarioDAO->alterarSenha($id_pessoa, $nova_senha);
                 header("Location: ../html/alterar_senha.php?verificacao=".$verificacao);
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
*/  

    public function alterarBeneficiados(){
        extract($_REQUEST);
        $beneficiados = new Beneficiados();
        $beneficiados->setId_pessoa($id_funcionario);
        //$beneficiados->setId_Beneficiados($id_beneficiados);
        $beneficiados->setId_beneficios($ibeneficios);
        $beneficiados->setData_inicio($data_inicio);
        $beneficiados->setData_fim($data_fim);
        $beneficiados->setBeneficios_status($beneficios_status);
        $beneficiados->setValor($valor);
        $beneficiadosDAO = new BeneficiadosDAO();
        try {
            $beneficiadosDAO->alterarBeneficiados($beneficiados);
            header("Location: ../html/profile_funcionario.php?id_funcionario=".$id_funcionario);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function alterarEpi(){
        extract($_REQUEST);
        $epi = new Pessoa_epi();
        $epi->setId_pessoa($id_funcionario);
        $epi->setId_epi($descricao_epi);
        $epi->setData($data);
        $epi->setepi_status($epi_status);
        $epiDAO = new Pessoa_epiDAO();
        try {
            $epiDAO->alterarEpi($epi);
            header("Location: ../html/profile_funcionario.php?id_funcionario=".$id_funcionario);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function alterarOutros()
    {
        extract($_REQUEST);
        $cpf=str_replace(".", '', $cpf);
        $cpf=str_replace("-", "", $cpf);

        $funcionario = new Funcionario('','','','','','','','','','','','','','','','','','','','','','');
        $funcionario->setId_funcionario($id_funcionario);
        //$funcionario->setVale_transporte($num_vale_transporte);
        $funcionario->setId_cargo($cargo);
        $funcionario->setPis($pis);
        $funcionario->setCtps($ctps);
        $funcionario->setUf_ctps($uf_ctps);
        $funcionario->setNumero_titulo($titulo_eleitor);
        $funcionario->setZona($zona_eleitoral);
        $funcionario->setSecao($secao_titulo_eleitor);
        $funcionario->setCertificado_reservista_numero($certificado_reservista_numero);
        $funcionario->setCertificado_reservista_serie($certificado_reservista_serie);
        $funcionario->setId_situacao($situacao);
        $funcionarioDAO=new FuncionarioDAO();
        try {
            $funcionarioDAO->alterarOutros($funcionario);
            header("Location: ../html/profile_funcionario.php?id_funcionario=".$id_funcionario);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        
    }

    public function alterarImagem()
    {
        extract($_REQUEST);
        $image = file_get_contents ($_FILES['imgperfil']['tmp_name']);
        $perfil = base64_encode($image);
        $funcionario = new Funcionario('','','','','','','','','','','','','',$perfil,'','','','','','','','');
        $funcionario->setId_funcionario($id_funcionario);
        $funcionarioDAO=new FuncionarioDAO();
        try {
            $funcionarioDAO->alterarImagem($funcionario);
            header("Location: ../html/profile_funcionario.php?id_funcionario=".$id_funcionario);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        
    }

    public function alterarDocumentacao()
    {
        extract($_REQUEST);
        $cpf=str_replace(".", '', $cpf);
        $cpf=str_replace("-", "", $cpf);

        $funcionario = new Funcionario($cpf,'','','','',$rg,$orgao_emissor,$data_expedicao,'','','','','','','','','','','','','','');
            
            $funcionario->setData_admissao($data_admissao);
            $funcionario->setId_funcionario($id_funcionario);

        $funcionarioDAO=new FuncionarioDAO();
        try {
            $funcionarioDAO->alterarDocumentacao($funcionario);
            header("Location: ../html/profile_funcionario.php?id_funcionario=".$id_funcionario);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        
    }

    public function alterarEndereco()
    {
        extract($_REQUEST);
        if((!isset($numero_residencia)) || empty(($numero_residencia))){
            $numero_residencia = "null";
        }
        $funcionario = new Funcionario('','','','','','','','','','','','','','',$cep,$uf,$cidade,$bairro,$rua,$numero_residencia,$complemento,$ibge);
        $funcionario->setId_funcionario($id_funcionario);
        $funcionarioDAO=new FuncionarioDAO();
        try {
            $funcionarioDAO->alterarEndereco($funcionario);
            header("Location: ../html/profile_funcionario.php?id_funcionario=".$id_funcionario);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }    
    }

    public function alterarCargaHoraria()
    {
        extract($_REQUEST);
        $carga_horaria=$this->verificarHorario();
        $quadroHorarioDAO=new QuadroHorarioDAO();
        try {
            $quadroHorarioDAO->alterar($carga_horaria, $id_funcionario);
            session_start();
            $_SESSION['msg']="Informações do funcionário alteradas com sucesso!";
            $_SESSION['proxima']="Ver lista de funcionario";
            $_SESSION['link']="../html/informacao_funcionario.php";
            header("Location: ../html/sucesso.php");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }



    /*protected function retornaIdFuncionario($cpf){
        try {
            $funcionarioDAO=new FuncionarioDAO();
            $cpf=str_replace(".", '', $cpf);
            $cpf=str_replace("-", "", $cpf);
            $id=$funcionarioDAO->retornaId($cpf);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $id;
    }*/

    public function excluir()
    {
        extract($_REQUEST);
        $funcionarioDAO = new FuncionarioDAO();
        try {
            $funcionarioDAO->excluir($id_funcionario);
            header("Location:../controle/control.php?metodo=listarTodos&nomeClasse=FuncionarioControle&nextPage=../html/informacao_funcionario.php");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function excluirBeneficio()
    {
        extract($_REQUEST);
        $beneficiadosDAO = new BeneficiadosDAO();
        try {
            $beneficiadosDAO->excluir($id_beneficiados);
            header("Location:../controle/control.php?metodo=listarTodos&nomeClasse=FuncionarioControle&nextPage=../html/informacao_funcionario.php");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function excluirEpi()
    {
        extract($_REQUEST);
        $pessoa_epiDAO = new pessoa_epiDAO();
        try {
            $pessoa_epiDAO->excluir($id_pessoa_epi);
            header("Location:../controle/control.php?metodo=listarTodos&nomeClasse=FuncionarioControle&nextPage=../html/informacao_funcionario.php");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}