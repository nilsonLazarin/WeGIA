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
?>
<!doctype html>
<html class="fixed">
<head>
    <!-- Basic -->
    <meta charset="UTF-8">

    <title>3. Recursos</title>

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- Web Fonts  -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/vendor/magnific-popup/magnific-popup.css" />
    <link rel="stylesheet" href="../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
    
    <!-- Theme CSS -->
    <link rel="stylesheet" href="../assets/stylesheets/theme.css" />
    
    <!-- Skin CSS -->
    <link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />
    
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">
    
    <!-- Head Libs -->
    <script src="../assets/vendor/modernizr/modernizr.js"></script>

    <!-- Atualizacao CSS -->
    <link rel="stylesheet" href="../css/atualizacao.css" />

    <!-- Manual CSS -->
    <link rel="stylesheet" href="../css/manual.css">
    
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

    <!-- javascript functions --> <script
    src="../Functions/onlyNumbers.js"></script> <script
    src="../Functions/onlyChars.js"></script> <script
    src="../Functions/mascara.js"></script>

    <!-- jquery functions -->
    <script>
        document.write('<a href="' + document.referrer + '"></a>');
    </script>
    
    <!-- javascript tab management script -->


</head>
<body>
    <section class="body">
        <div id="header"></div>
            <!-- end: header -->
        <div class="inner-wrapper" style="padding-top: 50px;">
            <!-- start: sidebar -->
            <aside id="sidebar-left" class="sidebar-left menuu">





                <div class="sidebar-header">
                    <div class="sidebar-title">
                        Índices
                    </div>
                    <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
                        <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
                    </div>
                </div>
                
                <div class="nano">
                    <div class="nano-content">
                        <nav id="menu" class="nav-main" role="navigation">
                            <ul class="nav nav-main">
                                <!-- <li id="0">
                                    <a href="home.php">
                                        <i class="fa fa-home" aria-hidden="true"></i>
                                        <span>Início</span>
                                    </a>
                                </li> -->
                                <li>
                                    <a href="./">
                                        <i class="fas fa-book" aria-hidden="true"></i>
                                        <span>Manual</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="../">
                                        <i class="fas fa-arrow-left" aria-hidden="true"></i>
                                        <span>Voltar</span>
                                    </a>
                                </li>
                                <li id="0" class="nav-parent nav-active">
                                    <a>
                                        <i class="fas fa-align-justify" aria-hidden="true"></i>
                                        <span>Capítulos</span>
                                    </a>
                                    <ul class="nav nav-children">
                                        <li>
                                            <a href="./introducao.php">
                                                1. Introdução
                                            </a>
                                        </li>
                                        <li>
                                            <a href="./instalacao.php">
                                                2. Instalação
                                            </a>
                                        </li>
                                        <li>
                                            <a href="./recursos.php">
                                                3. Módulos
                                            </a>
                                        </li>
                                        <li>
                                            <a href="./seguranca.php">
                                                4. Segurança
                                            </a>
                                        </li>
                                        <li>
                                            <a href="./atualizacao.php">
                                                5. Atualização
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li id="3" class="nav-parent nav-active">
                                    <a>
                                        <span>3. Módulos</span>
                                    </a>
                                    <ul class="nav nav-children">
                                        <li>
                                            <a href="#_recursos">
                                                3.0 Recursos
                                            </a>
                                        </li>

                                        <li class="sub1">
                                            <a href="#_rh">
                                                3.1. Recursos Humanos
                                            </a>
                                        </li>
                                        <li class="sub2">
                                            <a href="#_cadastro_funcionario">
                                                3.1.1. Cadastro de Funcionários
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
                    <h2>Capítulo 3: Módulos</h2>
                    <div class="right-wrapper pull-right">
                        <ol class="breadcrumbs">
                            <li><span>Capítulo 3: Módulos</span></li>
                        </ol>
                        <a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
                    </div>
                </header>
                <!--start: page-->

                <!-- estrutura básica:
                    <dir id="_">
                        <h3></h3><hr>
                        <p></p>
                    </dir>
                -->

                <section id="_recursos">
                        <dir id="_rh">
                        <h3>3.1. Recursos Humanos</h3><hr>
                        <p>O módulo de Recursos Humanos, referido como <strong><i class="far fa-address-book"></i> Pessoas</strong> no menu, serve para controle e acesso a informações de funcionários e internos.</p>
                        <div class="justify-content-between">
                        <a href="./recursos.php" type="button" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            3.1 Recursos
                        </a>
                        <a href="./cadastro_funcionarios.php" type="button" class="btn btn-secondary" style="float: right;">
                            3.1.1  Cadastro de Funcionários
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                        </dir>
                           
                </section>

                <!-- estrutura básica:
                        <dir id="_">
                            <h3></h3><hr>
                            <p></p>
                        </dir>
                -->

                <!-- end: page -->
            </section>
        </div>
    </section>
</body>
<script>
    function setLoader(btn) {
        btn.firstElementChild.style.display = "none";
        if (btn.childElementCount == 1) {
            loader = document.createElement("DIV");
            loader.className = "loader";
            btn.appendChild(loader);
        }
        window.location.href = btn.firstElementChild.href;
    }
</script>
</html>