<!DOCTYPE html>
<html class="fixed">
    <head>
        <meta charset="UTF-8">
        <title>Getaway de pagamento</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="stylesheet" href="../../../assets/vendor/bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" href="../../../assets/vendor/font-awesome/css/font-awesome.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.1.1/css/all.css">
        <link rel="stylesheet" href="../../../assets/vendor/magnific-popup/magnific-popup.css" />
        <link rel="stylesheet" href="../../../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
        <link rel="stylesheet" href="../../../assets/stylesheets/theme.css" />
        <link rel="stylesheet" href="../../../assets/stylesheets/skins/default.css" />
        <link rel="stylesheet" href="../../../assets/stylesheets/theme-custom.css">
        <script src="../../../assets/vendor/modernizr/modernizr.js"></script>
        <link rel="stylesheet" href="../../../css/personalizacao-theme.css" />
        <link rel="stylesheet" type="text/css" href="../outros/css/config.css">
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
       
        <script type="text/javascript" src="../js/transicoes.js"></script>

    </head>
    <style>
    .btn-salvar {
        display: none;
    }

    .btn-limpar{
        display: none;
    }
    </style>
    <body>

    <section class="body">
        <div id="header"></div>
        <div class="inner-wrapper">
			
            <aside id="sidebar-left" class="sidebar-left menuu"></aside>
            <section role="main" class="content-body">
            <header class="page-header">
					<h2>Getaway de pagamento</h2>
					<div class="right-wrapper pull-right">
						<ol class="breadcrumbs">
							<li>
								<a href="../../home.php">
									<i class="fa fa-home"></i>
								</a>
							</li>
							<li><span>Getaway de pagamento</span></li>
						</ol>
						<a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
					</div>
            </header>

            <div class="getaway-box" id="getaway-box">
                <form action="#" class="getaway-form">
                    <label for="plataforma">Plataforma</label>
                    <input type="text" name="plataforma" readonly required>
                    
                    <label for="endpoint">Endpoint</label>
                    <input type="text" name="endpoint" readonly required>

                    <label for="token">Token</label>
                    <input type="text" name="token" readonly required>
                    
                    <button class="btn-novo" id="btn-novo">Novo</button>
                    <input type="clear" name="btn-limpar" id="btn-limpar" class="btn-limpar" value="Limpar">
                    <input type="submit" name="btn-salvar" id="btn-salvar" class="btn-salvar" value="Salvar">
                </form>
            </div>

        </section>
    </section>
    </body>
    <script>
        $(document).ready(function() 
        {   
            atualiza();
        });
    </script>
</html>