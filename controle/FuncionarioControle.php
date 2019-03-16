<?php
include_once '../classes/Funcionario.php';
include_once '../classes/QuadroHorario.php';
include_once '../dao/FuncionarioDAO.php';
include_once '../dao/QuadroHorarioDAO.php';

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

        $horaTotal = ((intval($hora2[0])*60) + intval($hora2[1])) - ((intval($hora1[0])*60) + intval($hora1[1])) ;

        $horaTotal = floor($horaTotal/60);
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

    function geraChave($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
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
            $msg = "Escala do funcionario n√£o informado. Por favor, informe umm escala!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($tipoCargaHoraria)) || (empty($tipoCargaHoraria))){
            $msg .= "Tipo da carga hor·ria do funcionario n√£o informado. Por favor, informe um tipo!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($entrada1)) || (empty($entrada1))){
            $msg .= "Primeira entrada do funcionario n√£o informado. Por favor, informe uma entrada!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($saida1)) || (empty($saida1))){
            $msg .= "Primeira saÌda do funcionario n√£o informado. Por favor, informe uma saÌda!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($entrada2)) || (empty($entrada2))){
            $msg .= "Segunda entrada do funcionario n√£o informado. Por favor, informe uma entrada!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($saida2)) || (empty($saida2))){
            $msg .= "Segunda saÌda do funcionario n√£o informado. Por favor, informe uma saÌda!";
            header('Location: ../html/funcionario.html?msg='.$msg);
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
            $msg = "Nome do funcionario n√£o informado. Por favor, informe um nome!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($gender)) || (empty($gender))){
            $msg .= "Sexo do funcionario n√£o informado. Por favor, informe um sexo!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($cargo)) || (empty($cargo))){
            $msg .= "Cargo do funcionario n√£o informado. Por favor, informe um cargo!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($telefone)) || (empty($telefone))){
            $telefone='null';
        }
        if((!isset($nascimento)) || (empty($nascimento))){
            $msg .= "Data de nascimento do funcionario n√£o informado. Por favor, informe uma data de nascimento!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($nome_pai)) || (empty($nome_pai))){
            $msg .= "Nome do pai do funcionario n√£o informado. Por favor, informe um nome!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($nome_mae)) || (empty($nome_mae))){
            $msg .= "Nome da mae do funcionario n√£o informado. Por favor, informe um nome!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($sangue)) || (empty($sangue))){
            $msg .= "Tipo sanguineo do funcionario n√£o informado. Por favor, informe um tipo sanguineo!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($cep)) || empty(($cep))){
            $msg .= "Cep do funcionario n√£o informado. Por favor, informe um cep!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($uf)) || empty(($uf))){
            $msg .= "Estado do funcionario n√£o informado. Por favor, informe um estado!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($cidade)) || empty(($cidade))){
            $msg .= "Cidade do funcionario n√£o informado. Por favor, informe uma cidade!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($bairro)) || empty(($bairro))){
            $msg .= "Bairro do funcionario n√£o informado. Por favor, informe um bairro!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($rua)) || empty(($rua))){
            $msg .= "Logradouro do funcionario n√£o informado. Por favor, informe um logradouro!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($numero_residencia)) || empty(($numero_residencia))){
            $numero_residencia = "N„o possui";
        }
        if((!isset($complemento)) || (empty($complemento))){
            $complemento='NULL';
        }
        if((!isset($ibge)) || (empty($ibge))){
            $ibge='NULL';
        }
        if((!isset($rg)) || empty(($rg))){
            $msg .= "RG do funcionario n√£o informado. Por favor, informe um rg!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($orgao_emissor)) || empty(($orgao_emissor))){
            $msg .= "”rg„o emissor do funcionario n√£o informado. Por favor, informe o Ûrg„o emissor!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($data_expedicao)) || (empty($data_expedicao))){
            $msg .= "Data de expedi√ß√£o do rg do funcionario n√£o informado. Por favor, informe um data de expedi√ß√£o!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($cpf)) || (empty($cpf))){
            $msg .= "CPF do funcionario n√£o informado. Por favor, informe um CPF!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($certidao)) || (empty($certidao))){
            $msg .= "Cerdidao de nascimento do funcionario n√£o informada. Por favor, informe a persenÁa de certid„o de nascimento!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($vale_transporte)) || (empty($vale_transporte))){
            $msg .= "Usa Vale Transporte do funcionario n√£o informada. Por favor, informe se usa ou n„o vale transporte!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($num_vale_transporte)) || (empty($num_vale_transporte))){
            $num_vale_transporte='null';
        }
        if((!isset($pis)) || (empty($pis))){
            $msg .= "Pis do funcionario n√£o informada. Por favor, informe um pis!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($ctps)) || (empty($ctps))){
            $msg .= "Ctps do funcionario n√£o informada. Por favor, informe um ctps!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($uf_ctps)) || (empty($uf_ctps))){
            $msg .= "Estado da Ctps do funcionario n√£o informada. Por favor, informe a Uf da ctps!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($titulo_eleitor)) || (empty($titulo_eleitor))){
            $msg .= "N˙mero do tÌtulo de Eleitor do funcionario n√£o informado. Por favor, informe o n˙mero tÌtulo de eleitor!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($zona_eleitoral)) || (empty($zona_eleitoral))){
            $msg .= "Zona do Eleitor do funcionario n√£o informado. Por favor, informe a zona do eleitor!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($secao_titulo_eleitor)) || (empty($secao_titulo_eleitor))){
            $msg .= "SeÁ„o de Eleitor do funcionario n√£o informado. Por favor, informe a seÁ„o do eleitor!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        
        if((!isset($data_admissao)) || (empty($data_admissao))){
            $msg .= "Data de Admissao do funcionario n√£o informada. Por favor, informe a data de admissao!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        if((!isset($situacao)) || (empty($situacao))){
            $msg .= "SituaÁ„o do funcionario n√£o informada. Por favor, informe a situaÁ„o!";
            header('Location: ../html/funcionario.html?msg='.$msg);
        }
        
        if((!isset($certificado_reservista_numero)) || (empty($certificado_reservista_numero))){
            $certificado_reservista_numero='null';
        }
        if((!isset($certificado_reservista_serie)) || (empty($certificado_reservista_serie))){
            $certificado_reservista_serie='null';
        }

        if((!isset($calcado)) || (empty($calcado))){
            $calcado='null';
        }
        if((!isset($calca)) || (empty($calca))){
            $calca='null';
        }
        if((!isset($jaleco)) || (empty($jaleco))){
            $jaleco='null';
        }
        if((!isset($camisa)) || (empty($camisa))){
            $camisa='null';
        }
        if((!isset($cesta_basica)) || (empty($cesta_basica))){
            $cesta_basica='null';
        }

        if((!isset($calcado)) || (empty($calcado))){
            $calcado='N„o informado';
        }

        if((!isset($calcado)) || (empty($calcado))){
            $calcado='N„o informado';
        }

        if((!isset($calcado)) || (empty($calcado))){
            $calcado='N„o informado';
        }

        if((!isset($calcado)) || (empty($calcado))){
            $calcado='N„o informado';
        }

        if((!isset($calcado)) || (empty($calcado))){
            $calcado='N„o informado';
        }

        if((!isset($calcado)) || (empty($calcado))){
            $calcado='N„o informado';
        }

        if((!isset($calcado)) || (empty($calcado))){
            $calcado='N„o informado';
        }

        if((!isset($calcado)) || (empty($calcado))){
            $calcado='N„o informado';
        }

        session_start();
        $imgperfil=base64_encode($_SESSION['imagem']);
        $cpf=str_replace(".", '', $cpf);
        $cpf=str_replace("-", "", $cpf);
        $senha=$this->geraChave(8);
        $funcionario = new Funcionario($cpf,$nome,$gender,$nascimento,$rg,$orgao_emissor,$data_expedicao,$nome_mae,$nome_pai,$sangue,$senha,$telefone,$imgperfil,$cep,$uf,$cidade,$bairro,$rua,$numero_residencia,$complemento,$ibge);
        $funcionario->setVale_transporte($num_vale_transporte);
        $funcionario->setData_admissao($data_admissao);
        $funcionario->setCargo($cargo);
        $funcionario->setPis($pis);
        $funcionario->setCtps($ctps);
        $funcionario->setUf_ctps($uf_ctps);
        $funcionario->setNumero_titulo($titulo_eleitor);
        $funcionario->setZona($zona_eleitoral);
        $funcionario->setSecao($secao_titulo_eleitor);
        $funcionario->setCertificado_reservista_numero($certificado_reservista_numero);
        $funcionario->setCertificado_reservista_serie($certificado_reservista_serie);
        $funcionario->setCalcado($calcado);
        $funcionario->setCalca($calca);
        $funcionario->setJaleco($jaleco);
        $funcionario->setCamisa($camisa);
        $funcionario->setUsa_vtp($vale_transporte);
        $funcionario->setCesta_basica($cesta_basica);
        $funcionario->setSituacao($situacao);
        
        return $funcionario;
    }

    public function verificarSenha(){
        extract($_REQUEST);
        $nova_senha=hash('sha256', $nova_senha);
        $confirmar_senha=hash('sha256', $confirmar_senha);
        $senha_antiga=hash('sha256', $senha_antiga);
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

    public function listarTodos(){
        extract($_REQUEST);
        $funcionariosDAO = new FuncionarioDAO();
        $funcionarios = $funcionariosDAO->listarTodos();
        session_start();
        $_SESSION['funcionarios']=$funcionarios;
        header('Location: '.$nextPage);
    }
    
    public function listarUm()
    {
        extract($_REQUEST);
        try {
            $funcionarioDAO=new FuncionarioDAO();
            $funcionario=$funcionarioDAO->listar($id_funcionario);
            session_start();
            $_SESSION['funcionario']=$funcionario;
            header('Location:'.$nextPage);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        
    }
    
    public function incluir(){
        $funcionario = $this->verificarFuncionario();
        $horario = $this->verificarHorario();
        $funcionarioDAO = new FuncionarioDAO();
        $horarioDAO = new QuadroHorarioDAO();
        
        try{
            $funcionarioDAO->incluir($funcionario);
            $_SESSION['msg']="Funcionario cadastrado com sucesso";
            $_SESSION['proxima']="Cadastrar outro funcionario";
            $_SESSION['link']="../html/cadastro_funcionario.php";

        } catch (PDOException $e){
            $msg= "N√£o foi poss√≠vel registrar o funcion·rio"."<br>".$e->getMessage();
            echo $msg;
        }
        try{
            $horarioDAO->incluir($horario);
            header("Location: ../html/sucesso.php");
        } catch (PDOException $e){
            $msg= "N√£o foi poss√≠vel registrar o horario"."<br>".$e->getMessage();
            echo $msg;
        }
        
    }

    public function alterarInfPessoal()
    {
        extract($_REQUEST);
        $funcionario = new Funcionario('',$nome,$gender,$nascimento,'','','',$nome_mae,$nome_pai,$sangue,'',$telefone,'','','','','','','','','');
        $funcionario->setId_funcionario($id_funcionario);
        echo $funcionario->getId_Funcionario();
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
        $verificacao=$this->verificarSenha();
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
    public function alterarOutros()
    {
        extract($_REQUEST);
        $cpf=str_replace(".", '', $cpf);
        $cpf=str_replace("-", "", $cpf);
        if((!isset($num_vale_transporte)) || (empty($num_vale_transporte))){
            $num_vale_transporte='null';
        }
        if((!isset($cesta_basica)) || (empty($cesta_basica))){
            $cesta_basica='null';
        }
        $funcionario = new Funcionario('','','','','','','','','','','','','','','','','','','','','');
        $funcionario->setId_funcionario($id_funcionario);
        $funcionario->setVale_transporte($num_vale_transporte);
        $funcionario->setCargo($cargo);
        $funcionario->setPis($pis);
        $funcionario->setCtps($ctps);
        $funcionario->setUf_ctps($uf_ctps);
        $funcionario->setNumero_titulo($titulo_eleitor);
        $funcionario->setZona($zona_eleitoral);
        $funcionario->setSecao($secao_titulo_eleitor);
        $funcionario->setCertificado_reservista_numero($certificado_reservista_numero);
        $funcionario->setCertificado_reservista_serie($certificado_reservista_serie);
        $funcionario->setCalcado($calcado);
        $funcionario->setCalca($calca);
        $funcionario->setJaleco($jaleco);
        $funcionario->setCamisa($camisa);
        $funcionario->setUsa_vtp($vale_transporte);
        $funcionario->setCesta_basica($cesta_basica);
        $funcionario->setSituacao($situacao);
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
        $funcionario = new Funcionario('','','','','','','','','','','','',$perfil,'','','','','','','','');
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
        $cpfForm=str_replace(".", '', $cpfForm);
        $cpfForm=str_replace("-", "", $cpfForm);

        $funcionario = new Funcionario($cpfForm,'','','',$rg,$orgao_emissor,$data_expedicao,'','','','','','','','','','','','','','');
            
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
            $numero_residencia = "N„o possui";
        }
        $funcionario = new Funcionario('','','','','','','','','','','','','',$cep,$uf,$cidade,$bairro,$rua,$numero_residencia,$complemento,$ibge);
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
            $_SESSION['msg']="Informacoes do funcionario alteradas com sucesso.";
            $_SESSION['proxima']="Continuar vendo informacao do funcionario";
            $_SESSION['link']="../html/profile_funcionario.php?cpf=".$cpf;
            header("Location: ../html/sucesso.php");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    protected function retornaIdFuncionario($cpf){
        try {
            $funcionarioDAO=new FuncionarioDAO();
            $cpf=str_replace(".", '', $cpf);
            $cpf=str_replace("-", "", $cpf);
            $id=$funcionarioDAO->retornaId($cpf);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $id;
    }

    public function excluir()
    {
        extract($_REQUEST);
        $funcionarioDAO=new FuncionarioDAO();
        try {
            $funcionarioDAO->excluir($id_funcionario);
            header("Location:../controle/control.php?metodo=listarTodos&nomeClasse=FuncionarioControle&nextPage=../html/informacao_funcionario.php");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}