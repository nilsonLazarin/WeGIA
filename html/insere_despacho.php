<?php

    ini_set('display_errors',1);
    ini_set('display_startup_erros',1);
    error_reporting(E_ALL);

    session_start();
    if(!isset($_SESSION['usuario'])){
        header ("Location: ../index.php");
    }

    require_once "../controle/FuncionarioControle.php";

    $funcionarios = new FuncionarioControle;
    $funcionarios->listarTodos2();

    // Adiciona a Função display_campo($nome_campo, $tipo_campo)
    require_once "personalizacao_display.php";
?>

<!DOCTYPE html>

<html class="fixed">
<head>
    <!-- Basic -->
    <meta charset="UTF-8">

    <title>Caixa de entrada</title>
        
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/vendor/magnific-popup/magnific-popup.css" />
    <link rel="stylesheet" href="../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
    <link rel="icon" href="<?php display_campo("Logo",'file');?>" type="image/x-icon" id="logo-icon">

    <!-- Specific Page Vendor CSS -->
    <link rel="stylesheet" href="../assets/vendor/select2/select2.css" />
    <link rel="stylesheet" href="../assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="../assets/stylesheets/theme.css" />

    <!-- Skin CSS -->
    <link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">

    <!-- Head Libs -->
    <script src="../assets/vendor/modernizr/modernizr.js"></script>
        
    <!-- Vendor -->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.js"></script>
    <script src="../assets/vendor/nanoscroller/nanoscroller.js"></script>
    <script src="../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="../assets/vendor/magnific-popup/magnific-popup.js"></script>
    <script src="../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
        
    <!-- Specific Page Vendor -->
    <script src="../assets/vendor/jquery-autosize/jquery.autosize.js"></script>
        
    <!-- Theme Base, Components and Settings -->
    <script src="../assets/javascripts/theme.js"></script>
        
    <!-- Theme Custom -->
    <script src="../assets/javascripts/theme.custom.js"></script>
        
    <!-- Theme Initialization Files -->
    <script src="../assets/javascripts/theme.init.js"></script>


    <!-- javascript functions -->
    <script src="../Functions/onlyNumbers.js"></script>
    <script src="../Functions/onlyChars.js"></script>
    <script src="../Functions/mascara.js"></script>
        
    <!-- jquery functions -->

    <script>
        $(function(){
            var funcionario=<?php echo $_SESSION['funcionarios2']?>;
            console.log(funcionario);
            $.each(funcionario,function(i,item){
                $("#destinatario")
                    .append($("<option id="+item.id_pessoa+" value="+item.id_pessoa+" name="+item.id_pessoa+">"+item.nome+"</option>"));
            });
            $("#header").load("header.php");
            $(".menuu").load("menu.html");
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
                    <h2>Caixa de entrada</h2>
                    <div class="right-wrapper pull-right">
                        <ol class="breadcrumbs">
                            <li>
                                <a href="home.php">
                                    <i class="fa fa-home"></i>
                                </a>
                            </li>
                            <li><span>Caixa de Entrada</span></li>
                        </ol>
                        <a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
                    </div>
                </header>
                <!-- start: page -->
                <section class="panel" >

                    <header class="panel-heading">
                        <h2 class="panel-title">Despachar memorando</h2>
                    </header>
                    <div class="panel-body">
                        <form action="../controle/control.php?memorando=$_GET[id_memorando]" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for=destinatario id=etiqueta_destinatario class='col-md-3 control-label'>Destino </label>
                                <div class='col-md-6'>
                                    <select name="destinatario" id="destinatario" required class='select-table-filter form-control mb-md'></select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for=arquivo id=etiqueta_arquivo class='col-md-3 control-label'>Arquivo </label>
                                <div class='col-md-6'>
                                    <input type="file" name="anexo[]" id="anexo" multiple>
                                </div>
                            </div>
                            <div class="form-group">
                                    <label for=texto id=etiqueta_despacho class='col-md-3 control-label'>Despacho </label>
                                    <div class='col-md-6'>
                                        <textarea cols='30' rows='5' id='despacho' name='texto' required class='form-control'></textarea>
                                    </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-9 col-md-offset-8'>
                                    <input type='hidden' value='DespachoControle' name='nomeClasse' class='mb-xs mt-xs mr-xs btn btn-default'>
                                </div>
                                <div class='col-md-9 col-md-offset-8'>
                                    <input type='hidden' value='incluir' name='metodo' class='mb-xs mt-xs mr-xs btn btn-default'>
                                </div>
                                <div class='col-md-9 col-md-offset-8'>
                                    <input type='hidden' value='<?php echo $_GET['id_memorando'];?>' name='id_memorando' class='mb-xs mt-xs mr-xs btn btn-default'>
                                </div>
                                <div class='col-md-9 col-md-offset-8'>
                                    <input type='submit' value='Enviar' name='enviar' id='enviar' class='mb-xs mt-xs mr-xs btn btn-default'>
                                </div>
                            </div>
                        </form>
                    </div> 
                    </div>
                </section>
            </section>
        </div>
    </section>
    
    <!-- end: page -->
    <!-- Vendor -->
        <script src="../assets/vendor/select2/select2.js"></script>
        <script src="../assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
        <script src="../assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
        <script src="../assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
        
        <!-- Theme Base, Components and Settings -->
        <script src="../assets/javascripts/theme.js"></script>
        
        <!-- Theme Custom -->
        <script src="../assets/javascripts/theme.custom.js"></script>
        
        <!-- Theme Initialization Files -->
        <script src="../assets/javascripts/theme.init.js"></script>
        <!-- Examples -->
        <script src="../assets/javascripts/tables/examples.datatables.default.js"></script>
        <script src="../assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
        <script src="../assets/javascripts/tables/examples.datatables.tabletools.js"></script>
    </body>
</html>