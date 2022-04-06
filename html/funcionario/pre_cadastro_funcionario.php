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
session_start();
if(!isset($_SESSION['usuario'])){
    header ("Location: ".WWW."html/index.php");
}

require_once ROOT."/controle/memorando/MemorandoControle.php";
require_once ROOT."/controle/FuncionarioControle.php";

$funcionarios = new FuncionarioControle;
$funcionarios->listarTodos2();

$memorando = new MemorandoControle;
$memorando->listarTodos();

$memorando = $_POST['dados'];



  $conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $id_pessoa = $_SESSION['id_pessoa'];
  $resultado = mysqli_query($conexao, "SELECT * FROM funcionario WHERE id_pessoa=$id_pessoa");
  if(!is_null($resultado)){
    $id_cargo = mysqli_fetch_array($resultado);
    if(!is_null($id_cargo)){
      $id_cargo = $id_cargo['id_cargo'];
    }
    $resultado = mysqli_query($conexao, "SELECT * FROM permissao WHERE id_cargo=$id_cargo and id_recurso=3");
    if(!is_bool($resultado) and mysqli_num_rows($resultado)){
      $permissao = mysqli_fetch_array($resultado);
      if($permissao['id_acao'] == 1){
        $msg = "Você não tem as permissões necessárias para essa página.";
        header("Location: ".WWW."html/home.php?msg_c=$msg");
      }
      $permissao = $permissao['id_acao'];
    }else{
          $permissao = 1;
          $msg = "Você não tem as permissões necessárias para essa página.";
          header("Location: ".WWW."html/home.php?msg_c=$msg");
    } 
  }else{
    $permissao = 1;
    $msg = "Você não tem as permissões necessárias para essa página.";
    header("Location: ".WWW."html/home.php?msg_c=$msg");
  } 
  require_once ROOT."/controle/FuncionarioControle.php";
require_once ROOT."/controle/memorando/MemorandoControle.php";



// Adiciona a Função display_campo($nome_campo, $tipo_campo)
require_once ROOT."/html/personalizacao_display.php";
?>


<!DOCTYPE html>

<html class="fixed">
<head>
    <!-- Basic -->
    <meta charset="UTF-8">

    <title>Cadastro de Funcionário</title>
        
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="<?php echo WWW;?>assets/vendor/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo WWW;?>assets/vendor/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo WWW;?>assets/vendor/magnific-popup/magnific-popup.css" />
    <link rel="stylesheet" href="<?php echo WWW;?>assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
    <link rel="icon" href="<?php display_campo("Logo",'file');?>" type="image/x-icon" id="logo-icon">

    <!-- Specific Page Vendor CSS -->
    <link rel="stylesheet" href="<?php echo WWW;?>assets/vendor/select2/select2.css" />
    <link rel="stylesheet" href="<?php echo WWW;?>assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?php echo WWW;?>assets/stylesheets/theme.css" />

    <!-- Skin CSS -->
    <link rel="stylesheet" href="<?php echo WWW;?>/assets/stylesheets/skins/default.css" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="<?php echo WWW;?>assets/stylesheets/theme-custom.css">

    <!-- Head Libs -->
    <script src="<?php echo WWW;?>assets/vendor/modernizr/modernizr.js"></script>
        
    <!-- Vendor -->
    <script src="<?php echo WWW;?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/bootstrap/js/bootstrap.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/nanoscroller/nanoscroller.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/magnific-popup/magnific-popup.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
        
    <!-- Specific Page Vendor -->
    <script src="<?php echo WWW;?>assets/vendor/jquery-autosize/jquery.autosize.js"></script>
        
    <!-- Theme Base, Components and Settings -->
    <script src="<?php echo WWW;?>assets/javascripts/theme.js"></script>
        
    <!-- Theme Custom -->
    <script src="<?php echo WWW;?>assets/javascripts/theme.custom.js"></script>
        
    <!-- Theme Initialization Files -->
    <script src="<?php echo WWW;?>assets/javascripts/theme.init.js"></script>


    <!-- javascript functions -->
    <script src="<?php echo WWW;?>Functions/onlyNumbers.js"></script>
    <script src="<?php echo WWW;?>Functions/onlyChars.js"></script>
    <script src="<?php echo WWW;?>Functions/mascara.js"></script>

    <!-- printThis -->
    <script src="<?php echo WWW;?>assets/vendor/jasonday-printThis-f73ca19/printThis.js"></script>

        
    <!-- jquery functions -->

    <script>
    $(function(){
        $("#header").load("<?php echo WWW;?>html/header.php");
        $(".menuu").load("<?php echo WWW;?>html/menu.php");
    });

    </script>
 
    <style type="text/css">
        .select{
            position: absolute;
            width: 235px;
        }

        .panel-body
        {
            margin-bottom: 15px;
        }

        img
        {
          margin-left:11px;
        }
        /* print styles*/
        @media print {
            .printable {
                display: block;
             }
            .screen {
                display: none;
            }
        }
        .select{
            position: absolute;
            width: 235px;
        }
        .select-table-filter{
            width: 140px;
            float: left;
        }
        .panel-body{
            margin-bottom: 15px;
        }
        img{
            margin-left:10px;
        }
        #div_texto
        {
            width: 100%;
        }
        #cke_despacho
        {
            height: 500px;
        }
        .cke_inner
        {
            height: 500px;
        }
        #cke_1_contents
        {
            height: 455px !important;
        }
        .col-md-3 {
            width: 10%;
        }
       #area1{
            display: block;

        }
        #area2{
            display: none;
    } 
          
    </style>
</head>


    <body>
        <section class="body">
            <!-- start: header -->
            <div id="header"></div>
            <!-- end: header -->
            <div class="inner-wrapper">
                <!-- start: sidebar -->
                <aside id="sidebar-left" class="sidebar-left menuu"></aside>
                <!-- end: sidebar -->
                <section role="main" class="content-body">
                    <header class="page-header">
                        <h2>Cadastro</h2>
                        <div class="right-wrapper pull-right">
                            <ol class="breadcrumbs">
                                <li>
                                    <a href="<?php echo WWW;?>html/home.php">
                                        <i class="fa fa-home"></i>
                                    </a>
                                </li>
                                <li><span>Digite seu CPF</span></li>
                            </ol>
                            <a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
                        </div>
                    </header>
                
                    <!-- start: page -->
 

                        <section class="panel" >
                        <?php
									if(isset($_GET['msg_c'])){
										$msg = $_GET['msg_c'];
										echo('<div class="alert alert-success" role="alert">
										'. $msg .'
									  </div>');
									}else if(isset($_GET['msg_e'])){
										$msg = $_GET['msg_e'];
										echo('<div class="alert alert-danger" role="alert">
										'. $msg .'
									  </div>');
									}
							?>
                            <header class="panel-heading">
                                <h2 class="panel-title">Digite seu CPF</h2>
                            </header>
                            <div class="panel-body">
                           
                                <form method="GET" action="../../controle/control.php">
                                    <!-- <input type="text" id="assunto" name="assunto" required placeholder="Título do Novo Memorando" class="form-control">
                                    <input type="hidden" name="nomeClasse" value="MemorandoControle" id="memorandocontrole">
                                    <input type="hidden" id="incluir" name="metodo" value="incluir">
                                    <input type='hidden' id="modulo" value='memorando' name='modulo'>
                                    <input type='submit'  form= "form1" value='Criar memorando'   name='enviar' id='enviar' class='mb-xs mt-xs mr-xs btn btn-default'> -->

                                    <!-- <label class="col-md-3 control-label" for="cpf">Número do CPF<sup class="obrig">*</sup></label> -->
                                    <input type="text" class="form-control" id="cpf" id="cpf" name="cpf" placeholder="Ex: 222.222.222-22" maxlength="14" onblur="validarCPF(this.value)" onkeypress="return Onlynumbers(event)" onkeyup="mascara('###.###.###-##',this,event)" required>
                                    <p id="cpfInvalido" style="display: none; color: #b30000">CPF INVÁLIDO!</p>
                                    <br>
                                    <input type="hidden" name="nomeClasse" value="FuncionarioControle">
                                    <input type="hidden" name="metodo" value="selecionarCadastro">
                                    <input type='submit' value='Enviar' name='enviar' id='enviar' class='mb-xs mt-xs mr-xs btn btn-primary'> 
                                </form>
                            </div>
                        </section>
                </section>
            </div>
        </section>
        <script>
            function testaCPF(strCPF) { //strCPF é o cpf que será validado. Ele deve vir em formato string e sem nenhum tipo de pontuação.
                var strCPF = strCPF.replace(/[^\d]+/g, ''); // Limpa a string do CPF removendo espaços em branco e caracteres especiais.
                var Soma;
                var Resto;
                Soma = 0;
                if (strCPF == "00000000000") return false;

                for (i = 1; i <= 9; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i);
                Resto = (Soma * 10) % 11;

                if ((Resto == 10) || (Resto == 11)) Resto = 0;
                if (Resto != parseInt(strCPF.substring(9, 10))) return false;

                Soma = 0;
                for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i);
                Resto = (Soma * 10) % 11;

                if ((Resto == 10) || (Resto == 11)) Resto = 0;
                if (Resto != parseInt(strCPF.substring(10, 11))) return false;
                return true;
            }
            function validarCPF(strCPF) {

                if (!testaCPF(strCPF)) {
                $('#cpfInvalido').show();
                document.getElementById("enviar").disabled = true;

                } else {
                $('#cpfInvalido').hide();

                document.getElementById("enviar").disabled = false;
                }
            }
        </script>
    <!-- end: page -->
    <!-- Vendor -->
        <script src="../../Functions/onlyNumbers.js"></script>
        <script src="../../Functions/onlyChars.js"></script>
        <script src="../../Functions/mascara.js"></script>
        <script src="../../Functions/lista.js"></script>
        <script src="<?php echo WWW;?>assets/vendor/select2/select2.js"></script>
        <script src="<?php echo WWW;?>assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
        <script src="<?php echo WWW;?>assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
        <script src="<?php echo WWW;?>assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
        
        <!-- Theme Base, Components and Settings -->
        <script src="<?php echo WWW;?>assets/javascripts/theme.js"></script>
        
        <!-- Theme Custom -->
        <script src="<?php echo WWW;?>assets/javascripts/theme.custom.js"></script>
        
        <!-- Theme Initialization Files -->
        <script src="<?php echo WWW;?>assets/javascripts/theme.init.js"></script>
        <!-- Examples -->
        <script src="<?php echo WWW;?>assets/javascripts/tables/examples.datatables.default.js"></script>
        <script src="<?php echo WWW;?>assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
        <script src="<?php echo WWW;?>assets/javascripts/tables/examples.datatables.tabletools.js"></script>
      
	<div align="right">
		<iframe src="https://www.wegia.org/software/footer/funcionario.html" width="200" height="60" style="border:none;"></iframe>
	</div>   
    </body>

</html>
