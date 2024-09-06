<?php

?>

<!DOCTYPE html>
<html class="fixed">
<head>
    <meta charset="UTF-8">
    <title>Regra de Pagamento</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.1.1/css/all.css">
    <link rel="stylesheet" href="../../../assets/vendor/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../../../assets/vendor/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="../../../assets/vendor/magnific-popup/magnific-popup.css" />
    <link rel="stylesheet" href="../../../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
    <link rel="stylesheet" href="../../../assets/stylesheets/theme.css" />
    <link rel="stylesheet" href="../../../assets/stylesheets/skins/default.css" />
    <link rel="stylesheet" href="../../../assets/stylesheets/theme-custom.css">
    <link rel="stylesheet" href="../../../css/personalizacao-theme.css" />
    <script src="../../../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../../../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
    <script src="../../../assets/vendor/bootstrap/js/bootstrap.js"></script>
    <script src="../../../assets/vendor/nanoscroller/nanoscroller.js"></script>
    <script src="../../../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="../../../assets/vendor/magnific-popup/magnific-popup.js"></script>
    <script src="../../../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
    <script src="../../../assets/vendor/jquery-autosize/jquery.autosize.js"></script>
    <script src="../../../assets/javascripts/theme.js"></script>
    <script src="../../../assets/javascripts/theme.custom.js"></script>  
    <script src="../../../assets/javascripts/theme.init.js"></script>

</head>
<body>
<section class="body">
    <div id="header"></div>
    <div class="inner-wrapper">
        <aside id="sidebar-left" class="sidebar-left menuu"></aside>
        <section role="main" class="content-body">
            <header class="page-header">
                <h2>Regra de Pagamento</h2>
                <div class="right-wrapper pull-right">
                    <ol class="breadcrumbs">
                        <li>
                            <a href="../../home.php">
                                <i class="fa fa-home"></i>
                            </a>
                        </li>
                        <li><span>Regra de Pagamento</span></li>
                    </ol>
                    <a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
                </div>
            </header>
            <div class="regra-pagamento-box" id="regra-pagamento-box">
            </div>
        </section>
    </div>
</section>
<script>
    $(function() {
            $("#header").load("../../header.php");
            $(".menuu").load("../../menu.php");
        });
</script>

</body>
</html>