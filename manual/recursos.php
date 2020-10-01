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

    <style>
        .menuu{
            top: 0 !important;
        }

        .page-header{
            top: 0 !important;
        }

        p{
            color: black;
        }

        hr{
            border: 1px solid #ccc;
            height: 0;
        }

        .nav-children li a {
            padding: 6px 15px !important;
        }
    </style>

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
                                                3. Recursos
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
					<h2>Capítulo 3: Recursos</h2>
					<div class="right-wrapper pull-right">
						<ol class="breadcrumbs">
							<li><span>Capítulo 3: Recursos</span></li>
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

                <section>
                    <h3>3. Recursos</h3><hr>
                    <p>[Descrição de recursos aqui]</p>
                    <dir id="_memorando">
                        <h3>3.3. Memorando</h3><hr>
                        <p>O módulo do memorando é destinado à troca de mensagens institucionais pelos funcionários da instituição. Essa troca é feita através da criação, por um funcionário, de um <strong>memorando</strong> e de um <strong>despacho</strong>, que serão enviados a outro funcionário. O funcionário que receber esse memorando e esse despacho os enviará a outro e assim sucessivamente até que o memorando volte a sua origem e seja arquivado.</p>
                        <dir id="_criacao_memorando">
                            <h3>3.3.1. Criação do memorando</h3><hr>
                            <p>Para criar um memorando o funcionário deverá, munido das credenciais necessárias, acessar a <a href="../html/memorando/listar_memorandos_ativos.php">caixa de entrada do módulo memorando</a> e preencher o assunto do memorando  no campo "Assunto", da seção "Criar memorando", e acionar o botão "Criar memorando". Em seguida o funcionário será direcionado a página de envio de despacho.</p>
                        </dir>
                        <dir id="_envio_despacho">
                            <h3>3.3.2. Envio de despacho</h3><hr>
                            <p>Existem duas possibilidades para o envio de despachos: <i>enviar um despacho em um memorando que foi recebido</i> ou <i>enviar um despacho em um memorando que foi criado naquele momento</i>.</p>
                            <p>Para ambos os casos o procedimento é o mesmo:</p>
                                <p>1. Selecionar, no campo "destino", o funcionário para quem será enviado o despacho.</p>
                                <p>2. Selecionar arquivos para anexar ao despacho, clicando no botão "Escolher arquivos" <strong>(OPCIONAL)</strong></p>
                                <p>3. Preencher o campo "Despacho" com as informações que devem ser enviadas no despacho. Na parte superior desse campo é possível alterar a formatação dele com alterações como: negrito, itálico, cor do texto e cor da marcação do texto.</p>
                                <p>4. Acionar o botão "Enviar"</p>
                        </dir>
                        <dir id="_caixa_de_entrada">
                            <h3>3.3.3. Caixa de entrada</h3><hr>
                            <p>A <a href="../html/memorando/listar_memorandos_ativos.php">caixa de entrada do módulo memorando</a> é o espaço destinado ao recebimento de memorandos. Sempre que um despacho for enviado para você, o memorando desse despacho estará disponível na caixa de entrada. Para acessar um memorando basta clicar no seu título.</p>
                            <p>Nesse espaço também é possível criar um novo memorando (leia <a href="#_criacao_memorando">3.3.1. Criar memorando</a>)
                        </dir>
                        <dir id="_memorandos_despachados">
                            <h3>3.3.4. Memorandos despachados</h3><hr>
                            <p>A <a href="../html/memorando/listar_memorandos_antigos.php">lista de memorandos despachados</a> é um local para visualização dos memorandos que já foram enviados para você, inclusive os que já foram despachados para outras pessoas. Para acessar um memorando despachado basta clicar no seu título.</p>
                        </dir>
                        <dir id="_memorandos_despachados">
                            <h3>3.3.5. Opções da caixa de entrada</h3><hr>
                            <p>Os memorandos na <a href="../html/memorando/listar_memorandos_ativos.php">caixa de entrada</a> possuem algumas opções de configuração que são:</p>
                                <p>1. Não lido <img src="../img/nao-lido.png" width=25px height= 25px>, opção para marcar um memorando como não lido. <strong>Disponível apenas quando o memorando foi visualizado</strong>. Quando um memorando está marcado com essa opção sua cor fica <strong>azul</strong>.
                                <p>2. Lido <img src="../img/lido.png" width=25px height= 25px>, opção para marcar um memorando como lido. <strong>Disponível apenas quando o memorando não foi visualizado</strong>.
                                <p>3. Importante <img src="../img/importante.png" width=25px height= 25px>, opção para marcar um memorando como importante. Quando um memorando está marcado com essa opção sua cor fica <strong>vermelha</strong>.
                                <p>3. Pendente <img src="../img/importante.png" width=25px height= 25px>, opção para marcar um memorando como pendente. Quando um memorando está marcado com essa opção sua cor fica <strong>amarela</strong>.
                                <p>3. Arquivar memorando <img src="../img/arquivar.png" width=25px height= 25px>, opção para marcar um memorando como arquivado. Quando um memorando está marcado com essa opção ele não fica disponível na caixa de entrada, apenas na lista de memorandos despachados. <strong>Disponível apenas quando o usuário foi o criador do memorando</strong>.
                            <p>
                        </dir>
                    </dir>
                    <div class="justify-content-between">
                        <a href="./instalacao.php" type="button" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            2. Instalação
                        </a>
                        <a href="./seguranca.php" type="button" class="btn btn-secondary" style="float: right;">
                            4. Segurança
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
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