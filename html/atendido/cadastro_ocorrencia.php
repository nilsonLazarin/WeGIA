<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
extract($_REQUEST);
session_start();

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

if(!isset($_SESSION['usuario'])){
    header ("Location: ".WWW."index.php");
}

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

require_once ROOT."/dao/Conexao.php";
require_once ROOT."/controle/Atendido_ocorrenciaControle.php";
require_once ROOT."/html/personalizacao_display.php";

$pdo = Conexao::connect();
$nome = $pdo->query("SELECT a.idatendido, p.nome, p.sobrenome FROM pessoa p JOIN atendido a ON(p.id_pessoa=a.pessoa_id_pessoa)")->fetchAll(PDO::FETCH_ASSOC);
$tipo = $pdo->query("SELECT * FROM atendido_ocorrencia_tipos")->fetchAll(PDO::FETCH_ASSOC);
$recupera_id_funcionario = $pdo->query("SELECT id_funcionario FROM funcionario WHERE id_pessoa=" .$id_pessoa.";")->fetchAll(PDO::FETCH_ASSOC);
$id_funcionario = $recupera_id_funcionario[0]['id_funcionario'];

?> 

<!DOCTYPE html>
<html class="fixed">
<head>
    <!-- Basic -->
    <meta charset="UTF-8">

    <title>Cadastro Ocorrência</title>
        
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
    <link rel="stylesheet" href="<?php echo WWW;?>assets/stylesheets/skins/default.css" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="<?php echo WWW;?>assets/stylesheets/theme-custom.css"> 

    <!-- Head Libs -->
    <script src="<?php echo WWW;?>assets/vendor/modernizr/modernizr.js"></script>

    <!-- Vermelho dos campos obrigatórios -->
    <style type="text/css">
	  .obrig {
      color: rgb(255, 0, 0);
         }
    </style>
        
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

    <!-- jkeditor -->
    <script src="<?php echo WWW;?>assets/vendor/ckeditor/ckeditor.js"></script>
        
    <!-- jquery functions -->
    <script>
        $(function(){
            var funcionario=[];
            $.each(funcionario,function(i,item){
                $("#destinatario")
                    .append($("<option id="+item.id_pessoa+" value="+item.id_pessoa+" name="+item.id_pessoa+">"+item.nome+" "+item.sobrenome+"</option>"));
            });
            $("#header").load("../header.php");
            $(".menuu").load("../menu.php");

            //var id_memorando = 1;
            //$("#id_memorando").val(id_memorando);

            CKEDITOR.replace('despacho');
        });
    </script>    
    
    

    <style type="text/css">
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
                    <h2>Cadastro Ocorrência</h2>
                    <div class="right-wrapper pull-right">
                        <ol class="breadcrumbs">
                            <li>
                                <a href="home.php">
                                    <i class="fa fa-home"></i>
                                </a>
                            </li>
                            <li><span>Cadastro Ocorrência</span></li>
                        </ol>
                        <a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
                    </div>
                </header>
               <!-- Nao sei dizer oq mudou, mas nada está igual -->

            <div class="row">
                <div class="col-md-8 col-lg-12">
                <div class="tabs">
                <ul class="nav nav-tabs tabs-primary">
                    <li class="active">
                        <a href="#overview" data-toggle="tab">Cadastro Ocorrência</a>
                    </li>
                </ul>
                <div class="tab-content">
                <div id="overview" class="tab-pane active">
                    <form class="form-horizontal" method="GET" action="../../controle/control.php">


                <section class="panel">  
                <header class="panel-heading">
                <div class="panel-actions">
                    <a href="#" class="fa fa-caret-down"></a>
                </div>
                <h2 class="panel-title">Informações Pessoais</h2>
                  </header>
                    <div class="panel-body">

                        <!--<?php
                        echo "<form action='".WWW."controle/control.php' class='file-uploader' method='post' enctype='multipart/form-data'>";
                        ?>-->
                        
							<form class="form-horizontal" method="GET" action="../../controle/control.php" id="form-cadastro" enctype="multipart/form-data">	
                            <h5 class="obrig">Campos Obrigatórios(*)</h5>
                            <br>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="profileLastName">Atendido:<sup class="obrig">*</sup></label> 
                                <div class="col-md-6">
                                <select class="form-control input-lg mb-md" name="atendido_idatendido" id="atendido_idatendido" required>
                                <option selected disabled>Selecionar</option>
                                    <?php
                                    foreach($nome as $key => $value)
                                    {
                                        echo "<option value=" . $nome[$key]['idatendido'] . ">" . $nome[$key]['nome'] . " " . $nome[$key]['sobrenome'] . "</option>";
                                    }
                                    ?>
                                </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="profileLastName">Tipo de ocorrência:<sup class="obrig">*</sup></label> 
                                <div class="col-md-6">
                                <select class="form-control input-lg mb-md" name="id_tipos_ocorrencia" id="id_tipos_ocorrencia" required>
                                <option selected disabled>Selecionar</option>
                                    <?php
                                    foreach($tipo as $key => $value)
                                    {
                                        echo "<option value=" . $tipo[$key]['idatendido_ocorrencia_tipos'] . ">" . $tipo[$key]['descricao'] .  "</option>";
                                    }
                                    ?>
                                </select>
                                </div>
                            </div>
                            <div class="form-group">
											 <label class="col-md-3 control-label" for="profileCompany">Data da ocorrência:<sup class="obrig">*</sup></label>
											<div class="col-md-4">
												<input type="date" placeholder="dd/mm/aaaa" maxlength="10" class="form-control" name="data" id="data" max=<?php echo date('Y-m-d');?> required> 
										    </div>
										</div>
                            <div class="form-group">
                                <label for=arquivo id=etiqueta_arquivo class='col-md-3 control-label' >Arquivo </label>
                                <!-- <div class="file-uploader__message-area"></div>
                                <div class='col-md-6' class="file-chooser">
                                    <input type="file" multiple name="anexo[]" class="file-chooser__input" id="anexo">
                                </div> -->
                                
                                <div class="file-chooser">
                                    <input type="file" multiple name='anexo[]' class="file-chooser__input" id='teste'>
                                </div><br>
                                <div class="file-uploader__message-area">
                                    <!-- <p>Select a file to upload</p> -->
                                </div>
                            </div> 
            
 
                                <div class="form-group">
                                    <div class='col-md-6' id='div_texto' style="height: 499px;">
                                    
                                        <label for="texto" id="descricao" style="padding-left: 15px;">Descrição ocorrência<sup class="obrig">*</sup></label>
                                        <textarea cols='30' rows='5' id='despacho' name='descricao' class='form-control' onkeypress="return Onlychars(event)"required></textarea>
                                        <!-- eh o id despacho que atrapalha a descricao-->
                                        <!-- pegar o lugar que tem todos esses campos obrigatorios -->
                                        <!-- porque o only chars não funciona com o CKEDITOR.replace -->
										
                                        <!-- <input type="text" class="form-control" name="nome" id="nome" id="profileFirstName" onkeypress="return Onlychars(event)"required> -->
                                        
                                    </div>
                                </div>

                           
                                <!--<div class='col-md-9 col-md-offset-8'>
                                    <input type='hidden' value='DespachoControle' name='nomeClasse' class='mb-xs mt-xs mr-xs btn btn-default'>
                                </div>
                                <div class='col-md-9 col-md-offset-8'>
                                    <input type='hidden' value='incluir' name='metodo' class='mb-xs mt-xs mr-xs btn btn-default'>
                                </div>
                                <div class='col-md-9 col-md-offset-8'>
                                    <input type='hidden' name='id_memorando' id='id_memorando' class='mb-xs mt-xs mr-xs btn btn-default'>
                                </div>
                                <div class='col-md-9 col-md-offset-8'>
                                    <input type='hidden' name='modulo' value="memorando" class='mb-xs mt-xs mr-xs btn btn-default'>
                                </div>-->
                                <br>
                                <div class="panel-footer">
                                <div class='row'>
                                <div class="col-md-9 col-md-offset-3">
                                <input type="hidden" name="id_funcionario" value="<?= $id_funcionario; ?>">
						        <input type="hidden" name="nomeClasse" value="Atendido_ocorrenciaControle">
						        <input type="hidden" name="metodo" value="incluir">
						        <input id="enviar" type="submit" class="btn btn-primary" value="Enviar">
						        </div>
                                </div>
                            </form>
                        </div>
                </div>
                </div>
                </form>
                </div> 
                
            </div>
            </div>
            </div>
            </div>
            </section>
            </section>
        </div>
    </section><!--section do body-->

    <!-- teste para o radio do paciente -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
           
    <!-- end: page -->
    <!-- Vendor -->
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
    </body>
</html>