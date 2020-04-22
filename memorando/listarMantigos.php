<?php
 session_start();
 if(!isset($_SESSION['usuario'])){
    header ("Location: ../index.php");
 }
 ?>
 <!DOCTYPE html>
<html class="fixed">
    <head>
        <title>Memorando</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

        <!-- Basic -->
    <meta charset="UTF-8">

<title>Home</title>

<!-- Mobile Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

<!-- Web Fonts  -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="main.css">

<!-- Vendor CSS -->
<link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.css" />
<link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.css" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<link rel="stylesheet" href="../assets/vendor/magnific-popup/magnific-popup.css" />
<link rel="stylesheet" href="../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

<!--Página Css que não interfere no estilo de oputras páginas do sistema-->
<link rel="stylesheet" href="../css/home-theme.css" />

<!-- Specific Page Vendor CSS -->
<link rel="stylesheet" href="../assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
<link rel="stylesheet" href="../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
<link rel="stylesheet" href="../assets/vendor/morris/morris.css" />

<!-- Theme CSS -->
<link rel="stylesheet" href="../assets/stylesheets/theme.css" />
<link rel="icon" href="../img/logofinal.png" type="image/x-icon">

<!-- Skin CSS -->
<link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />

<!-- Theme Custom CSS -->
<link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">

<!-- Head Libs -->
<script src="../assets/vendor/modernizr/modernizr.js"></script>
<script src="../Functions/lista.js"></script>
<!-- Vendor -->
<script src="../assets/vendor/jquery/jquery.min.js"></script>
    </head>

    <body>
    <section class="body">
    <div id="header">
    <header class="header">
    <div class="logo-container">
        <a href="home.php" class="logo">
            <img src="../img/logofinal.png" height="35" alt="Porto Admin" />
        </a>
        <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
            <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>

    <!-- start: search & user box -->
    <div class="header-right">
        <span class="separator"></span>
        <div id="userbox" class="userbox">
            <a href="#" data-toggle="dropdown">
                <figure class="profile-picture">
                    <img src="../img/semfoto.jpg" alt="Joseph Doe" class="img-circle" data-lock-picture="../assets/images/!logged-user.jpg" />
                </figure>
                <div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
                    <span class="name">Usuário</span>
                    <span class="role">Funcionário</span>
                </div>
                <i class="fa custom-caret"></i>
            </a>
    
            <div class="dropdown-menu">
                <ul class="list-unstyled">
                    <li class="divider"></li>
                    <li>
                        <a role="menuitem" tabindex="-1" href="../html/alterar_senha.php"><i class="glyphicon glyphicon-lock"></i> Alterar senha</a>
                    </li>
                    <li>
                        <a role="menuitem" tabindex="-1" href="./logout.php"><i class="fa fa-power-off"></i> Sair da sessão</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- end: search & user box -->
    </header>
    </div>
    <!-- end: search & user box -->
</header>
    </div>
    <!-- end: header -->
    <div class="inner-wrapper">
                <!-- start: sidebar -->
                <aside id="sidebar-left" class="sidebar-left menuu">

                <div class="sidebar-header">
        <div class="sidebar-title">
            Menu
        </div>
        <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
            <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>
    
    <div class="nano">
        <div class="nano-content">
            <nav id="menu" class="nav-main" role="navigation">
                <ul class="nav nav-main">
                    <li>
                        <a href="../html/home.php">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <span>Início</span>
                        </a>
                    </li>
                    <li class="nav-parent nav-active">
                        <a>
                            <i class="fa fa-copy"></i>
                            <span>Pessoas</span>
                        </a>
                        <ul class="nav nav-children">
                            <li>
                                <a href="cadastro_funcionario.php">
                                     Cadastrar Funcionário
                                </a>
                            </li>
                            <li>
                                <a href="cadastro_interno.php">
                                     Cadastrar Atendido
                                </a>
                            </li>
                            <!--<li>
                                <a href="cadastro_voluntario.php">
                                     Cadastrar voluntário
                                </a>
                            </li>
                            <li>
                                <a href="cadastro_voluntario_judicial.php">
                                     Cadastrar voluntário judicial
                                </a>
                            </li>-->
                            <li>
                                <a href="../controle/control.php?metodo=listarTodos&nomeClasse=FuncionarioControle&nextPage=../html/informacao_funcionario.php">
                                     Informações Funcionários
                                </a>
                            </li>
                            <li>
                                <a href="../controle/control.php?metodo=listarTodos&nomeClasse=InternoControle&nextPage=../html/informacao_interno.php">
                                     Informações Atendido
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-parent nav-active">
                        <a>
                            <i class="fa fa-copy" aria-hidden="true"></i>
                            <span>Material e Patrimônio</span>
                        </a>
                        <ul class="nav nav-children">
                            <li>
                                <a href="../html/cadastro_entrada.php">
                                     Cadastrar Produtos
                                </a>
                            </li>
                            <li>
                                <a href="../html/cadastro_saida.php">
                                     Saida de Produtos
                                </a>
                            </li>
                            <li>
                                <a href="../html/estoque.php">
                                     Estoque
                                </a>
                            </li>
                            <li>
                                <a href="../html/listar_almox.php">
                                     Almoxarifados
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-parent nav-active">
                        <a>
                            <i class="fa fa-cog" aria-hidden="true"></i>
                            <span>Configurações</span>
                        </a>
                        <ul class="nav nav-children">
                            <li>
                                <a href="../html/personalizacao.php">
                                    Editar Conteúdos
                                </a>
                            </li>
                            <li>
                                <a href="../html/personalizacao_imagem.php">
                                    Lista de Imagens
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <form id="listarFuncionario" method="POST" action="../controle/control.php">
        <input type="hidden" name="nomeClasse" value="FuncionarioControle">
        <input type="hidden" name="metodo" value="listartodos">
        <input type="hidden" name="nextPage" value="../html/informacao_funcionario.php">
    </form>
    
    <form id="listarInterno" method="POST" action="../controle/control.php">
        <input type="hidden" name="nomeClasse" value="InternoControle">
        <input type="hidden" name="metodo" value="listartodos">
        <input type="hidden" name="nextPage" value="../html/informacao_interno.php">
    </form>
        
    <!-- Theme Base, Components and Settings -->
    <script src="../assets/javascripts/theme.js"></script>
        
    <!-- Theme Custom -->
    <script src="../assets/javascripts/theme.custom.js"></script>
    
    <!-- Theme Initialization Files -->
    <script src="../assets/javascripts/theme.init.js"></script>


                </aside>
                <!-- end: sidebar -->
                <section role="main" class="content-body">
                <header class="page-header">
                    <h2>Home</h2>
                    <div class="right-wrapper pull-right">
                        <ol class="breadcrumbs">
                            <li>
                                <a href="./home.php">
                                    <i class="fa fa-home"></i>
                                </a>
                            </li>
                            <li><span>Início</span></li>
                        </ol>
                        <a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
                    </div>
                </header>
 <?php
 include ("conexao.php");
 ?>
 <h4>Memorandos despachados</h4>
 <table class="table table-hover">
 <thead>
 <tr>
 <th scope="col"></th>
 <th scope="col">Memorando</th>
 </tr>
 </thead>
 <tbody>
 <?php
$cpf_remetente=$_SESSION['usuario'];
            $comando5="select id_pessoa from pessoa where cpf='$cpf_remetente'";
            $query5=mysqli_query($conexao, $comando5);
            $linhas5=mysqli_num_rows($query5);
            for($i=0; $i<$linhas5; $i++)
            {
                $consulta5=mysqli_fetch_row($query5);
                $remetente=$consulta5[0];
            }
$comando="SELECT distinct memorando.id_memorando, memorando.titulo from memorando join despacho on(despacho.id_memorando=memorando.id_memorando) where despacho.id_destinatario=$remetente or despacho.id_remetente=$remetente";
$query=mysqli_query($conexao, $comando);
$linhas=mysqli_num_rows($query);
            for($i=0; $i<$linhas; $i++)
            {
                $consulta=mysqli_fetch_row($query);
                $id_mem=$consulta[0];
                $titulo_des=$consulta[1];
                $num=$i+1;
                echo "<tr><th scope=row>".$num."</th>";
                echo "<td value=".$id_mem."><a href=listaM.php?desp=".$id_mem."&arq=1>".$titulo_des."</a></td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
?>


