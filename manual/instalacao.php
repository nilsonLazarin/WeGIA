<!doctype html>
<html class="fixed">
<head>
	<!-- Basic -->
	<meta charset="UTF-8">

	<title>2. Instalação</title>

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
                               
                                <li class="nav-parent nav-active" id="2">
                                    <a>
                                        <span>2. Instalação</span>
                                    </a>
                                    <ul class="nav nav-children">
                                        <li id="20">
                                            <a href="#_instalacao">
                                                2.0. Instalação
                                            </a>
                                        </li>
                                        <li id="20">
                                            <a href="#_pre_requisitos">
                                                2.1. Pré-requisitos
                                            </a>
                                        </li>
                                        <li id="20">
                                            <a href="#_banco_de_dados">
                                                2.2. Banco de Dados
                                            </a>
                                        </li>
                                        <li id="20">
                                            <a href="#_nome_bd">
                                                2.2.1. Nome do Banco de Dados
                                            </a>
                                        </li>
                                        <li id="20">
                                            <a href="#_host_bd">
                                                2.2.2. Host do Banco de Dados
                                            </a>
                                        </li>
                                        <li id="20">
                                            <a href="#_usuario_senha_bd">
                                                2.2.3. Usuário e Senha do Banco de Dados
                                            </a>
                                        </li>
                                        <li id="20">
                                            <a href="#_dominio_diretorios">
                                                2.3. Domínio e Diretórios
                                            </a>
                                        </li>
                                        <li id="30">
                                            <a href="#_erros">
                                                2.4. Erros
                                            </a>
                                        </li>
                                        <li id="30">
                                            <a href="#_erro_usuario_senha">
                                                2.4.1. Usuário/Senha Incorretos
                                            </a>
                                        </li>
                                        <li id="30">
                                            <a href="#_erro_servidor_bd">
                                                2.4.2. Servidor MYSQL não encontrado
                                            </a>
                                        </li>
                                        <li id="30">
                                            <a href="#_erro_dados_iniciais">
                                                2.4.3. Falha ao inserir Dados Iniciais
                                            </a>
                                        </li>
                                        <li id="30">
                                            <a href="#_erro_criacao_bd">
                                                2.4.4. Falha na criaçao do banco de dados
                                            </a>
                                        </li>
                                        <li id="40">
                                            <a href="#_avisos">
                                                2.5. Avisos
                                            </a>
                                        </li>
                                        <li id="41">
                                            <a href="#_aviso_bkp">
                                                2.5.1. Diretório para Backup não existe
                                            </a>
                                        </li>
                                        <li id="42">
                                            <a href="#_aviso_bd_existente">
                                                2.5.2. Base de dados já existe
                                            </a>
                                        </li>
                                        <li id="43">
                                            <a href="#_aviso_instavel">
                                                2.5.3. Sistema Instável
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
					<h2>Capítulo 2: Instalação</h2>
					<div class="right-wrapper pull-right">
						<ol class="breadcrumbs">
							<li><span>Capítulo 2: Instalação</span></li>
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

                <section id="_instalacao">
                    <h3>2. Instalação</h3><hr>
                    <p>O processo de instalação é realizado após o preenchimento das informações pedidas na <a href="../instalador/index.php">página de instalação</a>. Ao concluir a instalação, o usuário será informado do resultado através de notificações.</p>
                    <dir id="_pre_requisitos">
                        <h3>2.1. Pré-requisitos</h3><hr>
                        <p>Para melhor funcionamento, o sistema deve ser hospedado em um sistema <strong>Linux</strong>. Outros sistemas serão capazes de executar a maioria das funcionalidades, mas apresentarão instabilidades e erros ocasionais, além de não poderem executar backups e importar triggers do Banco de Dados, que utilizam comandos exclusivo do Linux.</p>
                        <p>A instalação tanto do WeGIA quanto da Base de Dados deve ser feita em um <strong>servidor</strong> local ou online.</p>
                    </dir>
                    <dir id="_banco_de_dados">
                        <h3>2.2. Banco de Dados</h3><hr>
                        <p>O Banco de Dados funciona em MySQL e é uma parte funcamental para o funcionamento do site, e o preenchimento das informações realacionadas é obrigatório. Também é fornecida a opção de reinstalar a Base de Dados, caso o usuário queira criar uma base nova.</p>
                        <dir id="_nome_bd">
                            <h3>2.2.1. Nome do Banco de Dados</h3><hr>
                            <p>O nome da Base de Dados será usado pelo sistema para ter acesso ás informações armazenadas. É recomendado que não se utilize acentos e caracteres especiais.</p>
                            <p>Caso já exista uma Base de Dados com o nome fornecido, o sistema notificará e cancelará o processo de instalação.</p>
                        </dir>
                        <dir id="_host_bd">
                            <h3>2.2.2. Host do Banco de Dados</h3><hr>
                            <p>Em qual endereço o banco de dados será hospedado (pode ser diferente do site).</p>
                        </dir>
                        <dir id="_usuario_senha_bd">
                            <h3>2.2.3. Usuário e Senha do Banco de Dados</h3><hr>
                            <p>Por questões de segurança, para cada vez que o sistema acessa o banco de dados é exigido que se tenha o nome de usuário e senha. Preencher o campo Usuário é obrigatório, mas a senha pode ser vazia, então seu preenchimento não é exigido.</p>
                        </dir>
                    </dir>
                    <dir id="_dominio_diretorios">
                        <h3>2.3. Domínio e Diretórios</h3><hr>
                        <p>Esse tópico refere-se as domínio em que o sistema será hospedado, que como informado no tópico <a href="#_host_bd">2.2.2. Host do Banco de Dados</a>, pode ter um domínio diferente do Banco de Dados. Também diz respeito aos diretórios fora do domínio principal como o que armazena os backups do sistema.</p>
                        <p><strong>Atenção:</strong> Não é recomendado que o diretório de backup esteja contido no diretório do programa, pois os backups antigos serão incluidos no backup recente.</p>
                    </dir>
                    <dir id="_erros">
                        <h3>2.4. Erros</h3><hr>
                        <p>Caso haja algum problema no processo de instalação o sistema pode retornar alguns erros. As mensagens de erro possuem cor <strong>vermelha</strong>.</p>
                        <dir id="_erro_usuario_senha">
                            <h3>2.4.1. Nome de usuario e/ou senha incorreto(s)</h3><hr>
                            <p>Um domínio MySQL pode conter um ou mais usuários, e para criar um Banco de Dados, é preciso ter acesso a um deles. Verifique o Nome de Usuário e Senha de um dos Usuários para poder prosseguir.</p>
                        </dir>
                        <dir id="_erro_servidor_bd">
                            <h3>2.4.2. Servidor MYSQL não encontrado</h3><hr>
                            <p>Caso o Domínio para o Banco de Dados informado na página de instalação não exista. Certifique-se de colocar um domínio existente e acessível.</p>
                        </dir>
                        <dir id="_erro_dados_iniciais">
                            <h3>2.4.3. Falha ao inserir os dados iniciais no banco de dados</h3><hr>
                            <p>O Sistema possui Dados Iniciais para a Base de Dados que precisam ser instalados. Esse erro ocorre caso o Sistema Operacional em que o programa está sendo instalado não seja Linux (leia <a href="#_pre_requisitos">2.1. Pré-requisitos</a> ) e significa que não foi possível realizar a importação desses dados. Pode ser causado por Erros de Sintaxe nos arquivos importados.</p>
                        </dir>
                        <dir id="_erro_criacao_bd">
                            <h3>2.4.4. Falha na criaçao do banco de dados</h3><hr>
                            <p>Esse erro pode ser causado por informações sobre o Banco de Dados preenchidas de forma incorreta. Verifique se essas informações não contém caracteres especiais e acentos.</p>
                        </dir>
                    </dir>
                    <dir id="_avisos">
                        <h3>2.5. Avisos</h3><hr>
                        <p>As vezes podem ocorrer erros que não são fatais e não impossibilitam a instalação, mas que não podem ser ignorados. Neste caso, a instalação prossegue e os avisos notificam o usuário de que há problemas a serem resolvidos. As mensagens de aviso possuem cor <strong>laranja</strong>.</p>
                        <dir id="_aviso_bkp">
                            <h3>2.5.1. Diretório para Backup não existe</h3><hr>
                            <p>Se o caminho para o diretório de backup não existir. Neste caso, é preciso ou reistalar com as informações certas (recomendado) ou criar o diretório manualmente e inserir o caminho até ele no arquivo config.php, localizado no diretório WeGIA.</p>
                        </dir>
                        <dir id="_aviso_bd_existente">
                            <h3>2.5.2. Base de dados já existe</h3><hr>
                            <p>Se o Nome do Banco de Dados já estiver sendo utilizado para o Usuário escolhido. Neste caso, basta certificar-se de que esta base de dados não esteja sendo utilizada por outro programa para não causar inconsistências e erros.</p>
                        </dir>
                        <dir id="_aviso_instavel">
                            <h3>2.5.3. Sistema Instável</h3><hr>
                            <p>Se o Sistema Operacional em que o servidor for instalado não for em Linux (leia <a href="#_pre_requisitos">2.1. Pré-requisitos</a>). É fortemente recomendada a instalação do WeGIA em um servidor Linux.</p>
                        </dir>
                    </dir>
                    <div class="justify-content-between">
                        <a href="./introducao.php" type="button" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            1. Introdução
                        </a>
                        <a href="./recursos.php" type="button" class="btn btn-secondary" style="float: right;">
                            3. Recursos
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