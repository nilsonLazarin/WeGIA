<?php
	session_start();
	if(!isset($_SESSION['usuario'])){
		header ("Location: ../php.html");
	}
?>

<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>Cadastro de Interno</title>

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="../assets/vendor/fontawesome/svg-with-js/css/fa-svg-with-js.css" />
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
		<link rel="stylesheet" href="../assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
		<link rel="icon" href="../img/logofinal.png" type="image/x-icon">

		<!-- Theme CSS -->
		<link rel="stylesheet" href="../assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">
		<script src="../Functions/lista.js"></script>
		<!-- Head Libs -->
		<script src="../assets/vendor/modernizr/modernizr.js"></script>

	</head>
	<body>
		<section class="body">

			<!-- start: header -->
			<header class="header">
				<div class="logo-container">
					<a href="../" class="logo">
						<img src="../img/logofinal.png" height="35" alt="Porto Admin" />
					</a>
					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>
			
				<!-- start: search & user box -->
				<div class="header-right">
			
					<form action="pages-search-results.html" class="search nav-form">
						<div class="input-group input-search">
							<input type="text" class="form-control" name="q" id="q" placeholder="Search...">
							<span class="input-group-btn">
								<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
							</span>
						</div>
					</form>	
					
					<span class="separator"></span>
			
					<div id="userbox" class="userbox">
						<a href="#" data-toggle="dropdown">
							<figure class="profile-picture">
								<img src="../img/koala.jpg" alt="Joseph Doe" class="img-circle" data-lock-picture="../assets/images/!logged-user.jpg" />
							</figure>
							<div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
								<span class="name">John Doe Junior</span>
								<span class="role">administrator</span>
							</div>
			
							<i class="fa custom-caret"></i>
						</a>
			
						<div class="dropdown-menu">
							<ul class="list-unstyled">
								<li class="divider"></li>
								<li>
									<a role="menuitem" tabindex="-1" href="pages-user-profile.html"><i class="fa fa-user"></i> My Profile</a>
								</li>
								<li>
									<a role="menuitem" tabindex="-1" href="#" data-lock-screen="true"><i class="fa fa-lock"></i> Lock Screen</a>
								</li>
								<li>
									<a role="menuitem" tabindex="-1" href="pages-signin.html"><i class="fa fa-power-off"></i> Logout</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- end: search & user box -->
			</header>
			<!-- end: header -->

			<div class="inner-wrapper">
				<!-- start: sidebar -->
				<aside id="sidebar-left" class="sidebar-left">
					<div class="sidebar-header">
						<div class="sidebar-title">
							Navigation
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
										<a href="home.php">
											<i class="fa fa-home" aria-hidden="true"></i>
											<span>Início</span>
										</a>
									</li>
									<li class="nav-parent nav-expanded nav-active">
										<a>
											<i class="fa fa-copy" aria-hidden="true"></i>
											<span>Cadastros</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="cadastro_funcionario.php">
													 Cadastrar funcionário
												</a>
											</li>
											<li>
												<a href="cadastro_interno.php">
													 Cadastrar interno
												</a>
											</li>
											<li>
												<a href="cadastro_voluntario.php">
													 Cadastrar voluntário
												</a>
											</li>
											<li>
												<a href="cadastro_voluntario_judicial.php">
													 Cadastrar voluntário judicial
												</a>
											</li>
										</ul>
									</li>

									<li class="nav-parent nav-expanded nav-active">
										<a>
											<i class="fa fa-copy" aria-hidden="true"></i>
											<span>Informação</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a onclick="listarFuncionario()">
													 Informações funcionarios
												</a>
											</li>
										</ul>
										<ul class="nav nav-children">
											<li>
												<a onclick="listarInterno()">
													 Informações interno
												</a>
											</li>
										</ul>
									</li>
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
				</aside>
				<!-- end: sidebar -->

				<section role="main" class="content-body">
					<header class="page-header">
						<h2>Cadastro</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="home.php">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Páginas</span></li>
								<li><span>Perfil</span></li>
							</ol>
					
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>

					<!-- start: page -->

					<div class="row">
						<div class="col-md-4 col-lg-3">
							<section class="panel">
								<div class="panel-body">
									<div class="thumb-info mb-md">
										<img src="semfoto.jpg" class="rounded img-responsive" alt="John Doe">
										<i class="fas fa-camera-retro btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"></i>
										<div class="container">

											  <div class="modal fade" id="myModal" role="dialog">
											    <div class="modal-dialog">
											    
											      <!-- Modal content-->
											      <div class="modal-content">
											        <div class="modal-header">
											          <button type="button" class="close" data-dismiss="modal">&times;</button>
											          <h4 class="modal-title">Adicionar uma Foto</h4>
											        </div>
											        <div class="modal-body">
											        	<form action="/action_page.php">
											        	<div class="form-group">
															<label class="col-md-4 control-label" for="imgperfil">Carregue uma imagem de perfil:</label>
															<div class="col-md-8">
																<input type="file" name="imgperfil" size="60" id="imgform" class="form-control">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label" for="imgrg">Carregue a imagem do RG:</label>
															<div class="col-md-8">
																<input type="file" name="imgrg" size="60" id="imgform" class="form-control">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label" for="imgcpf">CPF:</label>
															<div class="col-md-8">
																<input type="file" name="imgcpf" size="60" id="imgform" class="form-control">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label" for="imgctdnas">Certidão de Nascimento:</label>
															<div class="col-md-8">
																<input type="file" name="imgctdnas" size="60" id="imgform" class="form-control">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label" for="imgrg">INSS:</label>
															<div class="col-md-8">
																<input type="file" name="imgrg" size="60" id="imgform" class="form-control">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label" for="imgrg">LOAS:</label>
															<div class="col-md-8">
																<input type="file" name="imgrg" size="60" id="imgform" class="form-control">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label" for="imgrg">FUNRURAL:</label>
															<div class="col-md-8">
																<input type="file" name="imgrg" size="60" id="imgform" class="form-control">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label" for="imgrg">Título de Eleitor:</label>
															<div class="col-md-8">
																<input type="file" name="imgrg" size="60" id="imgform" class="form-control">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label" for="imgrg">CTPS:</label>
															<div class="col-md-8">
																<input type="file" name="imgrg" size="60" id="imgform" class="form-control">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label" for="imgrg">SAF:</label>
															<div class="col-md-8">
																<input type="file" name="imgrg" size="60" id="imgform" class="form-control">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label" for="imgrg">SUS:</label>
															<div class="col-md-8">
																<input type="file" name="imgrg" size="60" id="imgform" class="form-control">
															</div>
														</div>
											        </div>
											        <div class="modal-footer">
											          <input type="submit" id="formsubmit">
											        </div>
											      </div>
											      
											    </div>
											  </div>
											  
											</div>
									</div>

									<div class="widget-toggle-expand mb-md">
										<div class="widget-header">
											
											<div class="widget-content-expanded">
											<ul class="simple-todo-list">
											
											</ul>
										</div>
										</div>
									</div>

									<hr class="dotted short">

									<h6 class="text-muted"></h6>
									
									<div class="clearfix">
										<a class="text-uppercase text-muted pull-right" href="#">(View All)</a>
									</div>

									<hr class="dotted short">

									<div class="social-icons-list">
										<a rel="tooltip" data-placement="bottom" target="_blank" href="http://www.facebook.com" data-original-title="Facebook"><i class="fa fa-facebook"></i><span>Facebook</span></a>
										<a rel="tooltip" data-placement="bottom" href="http://www.twitter.com" data-original-title="Twitter"><i class="fa fa-twitter"></i><span>Twitter</span></a>
										<a rel="tooltip" data-placement="bottom" href="http://www.linkedin.com" data-original-title="Linkedin"><i class="fa fa-linkedin"></i><span>Linkedin</span></a>
									</div>

								</div>
							</section>
						</div>
						<div class="col-md-8 col-lg-8">

							<div class="tabs">
								<ul class="nav nav-tabs tabs-primary">
									<li class="active">
										<a href="#overview" data-toggle="tab">Cadastro de Interno</a>
									</li>
								</ul>
								<div class="tab-content">
									<div id="overview" class="tab-pane active">
										<form class="form-horizontal" method="post" action=".">
											<h4 class="mb-xlg">Informações Pessoais</h4>
											<fieldset>
												<div class="form-group">
													<label class="col-md-3 control-label" for="profileFirstName">Primeiro Nome</label>
													<div class="col-md-8">
														<input type="text" class="form-control" id="profileFirstName">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label" for="profileLastName">Sobrenome</label>
													<div class="col-md-8">
														<input type="text" class="form-control" id="profileLastName">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label" for="profileLastName">Sexo</label>
													<div class="col-md-8">
														<input type="radio" name="gender" id="radio" value="male" style="margin-top: 10px; margin-left: 15px;"><i class="fa fa-male" style="font-size: 20px;"></i>
														<input type="radio" name="gender" id="radio" value="female" style="margin-top: 10px; margin-left: 15px;"><i class="fa fa-female" style="font-size: 20px;"></i> 
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label" for="profileCompany">Telefone</label>
													<div class="col-md-8">
														<input type="text" class="form-control" minlength="11" id="profileCompany">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label" for="profileCompany">Nascimento</label>
													<div class="col-md-8">
														<input type="date" class="form-control" id="profileCompany">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label" for="profileFirstName">Nome do Pai</label>
													<div class="col-md-8">
														<input type="text" class="form-control" id="profileFirstName">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label" for="profileFirstName">Nome da Mãe</label>
													<div class="col-md-8">
														<input type="text" class="form-control" id="profileFirstName">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label" for="inputSuccess">Tipo Sanguíneo</label>
													<div class="col-md-6">
													<select class="form-control input-lg mb-md">
														<option>Selecionar</option>
														<option>A+</option>
														<option>A-</option>
														<option>B+</option>
														<option>B-</option>
														<option>O+</option>
														<option>O-</option>
														<option>AB+</option>
														<option>AB-</option>
													</select>
													</div>	
												</div>
												<br/>

											<hr class="dotted short">
											
													<div class="thumb-info mb-md documentacao">
														<i class="fas fa-camera-retro btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"></i>
													</div>
												<h4 class="mb-xlg doch4">Documentação</h4>

												
													<div class="form-group">
														<label class="col-md-3 control-label" for="profileCompany">Número do RG</label>
														<div class="col-md-6">
															<input type="text" class="form-control" id="profileCompany">
														</div>
														
													</div>
													<div class="form-group">
														<label class="col-md-3 control-label" for="profileCompany">Órgão Emissor</label>
														<div class="col-md-6">
															<input type="text" class="form-control" id="profileCompany">
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-3 control-label" for="profileCompany">Data de Expedição</label>
														<div class="col-md-6">
															<input type="date" class="form-control" id="profileCompany">
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-3 control-label" for="profileCompany">Número do CPF</label>
														<div class="col-md-6">
															<input type="text" class="form-control" id="profileCompany">
														</div>
														
													</div>
													<div class="form-group">
														<label class="col-md-3 control-label" for="profileLastName">Certidão de Nascimento</label>
														<div class="col-md-4">
															<input type="radio" name="certidao" id="radio" value="certidaosim" style="margin-top: 15px; margin-left: 15px;"><i class="fa fa-check" style="font-size: 20px;"></i>
															<input type="radio" name="certidao" id="radio" value="certidaonao" style="margin-top: 15px; margin-left: 15px;"><i class="fa fa-times" style="font-size: 20px;"></i>
														</div>
														
													</div>
													<div class="form-group">
														<label class="col-md-3 control-label" for="profileLastName">Curatela</label>
														<div class="col-md-4">
															<input type="radio" name="curatela" id="radio" value="curatelasim" style="margin-top: 10px; margin-left: 15px;"><i class="fa fa-check" style="font-size: 20px;"></i>
															<input type="radio" name="curatela" id="radio" value="curatelanao" style="margin-top: 10px; margin-left: 15px;"><i class="fa fa-times" style="font-size: 20px;"></i>
														</div>
														
													</div>

												<hr class="dotted short">
												<div class="form-group">
													<label class="col-md-3 control-label">Benefícios</label>
		
													<div class="col-md-8">
														<div class="checkbox">
															<label for="beneficio">
																<input type="checkbox" value="" id="beneficio" >INSS
															</label>
														</div>
														<div class="checkbox">
															<label for="beneficio">
																<input type="checkbox" value="" id="beneficio" >LOAS
															</label>
														</div>
														<div class="checkbox">
															<label for="beneficio">
																<input type="checkbox" value="" id="beneficio" >FUNRURAL
															</label>
														</div>
														<div class="checkbox">
															<label for="beneficio">
																<input type="checkbox" value="" id="beneficio" >RG
															</label>
														</div>
														<div class="checkbox">
															<label for="beneficio">
																<input type="checkbox" value="" id="beneficio" >CPF
															</label>
														</div>
														<div class="checkbox">
															<label for="beneficio">
																<input type="checkbox" value="" id="beneficio" >Título de Eleitor
															</label>
														</div>
														<div class="checkbox">
															<label for="beneficio">
																<input type="checkbox" value="" id="beneficio" >CTPS
															</label>
														</div>
														<div class="checkbox">
															<label for="beneficio">
																<input type="checkbox" value="" id="beneficio" >SAF
															</label>
														</div>
														<div class="checkbox">
															<label for="beneficio">
																<input type="checkbox" value="" id="beneficio" >SUS
															</label>
														</div>
													</div>
												
												</div>

											</form>
											<br/>

											<section class="panel">
												<header class="panel-heading">
													<div class="panel-actions">
														<a href="#" class="fa fa-caret-down"></a>
													</div>

													<h2 class="panel-title">Informações do Interno</h2>
												</header>
												<div class="panel-body" style="display: block;">
													<section class="simple-compose-box mb-xlg ">
														<form method="get" action="/">
															<textarea name="message-text" data-plugin-textarea-autosize placeholder="What's on your mind?" rows="1"></textarea>
														</form>
														<div class="compose-box-footer">
															<ul class="compose-btn">
																<li>
																	<a class="btn btn-primary btn-xs">Post</a>
																</li>
															</ul>
														</div>
													</section>
												</div>
											</section>
										</fieldset>
											<div class="panel-footer">
												<div class="row">
													<div class="col-md-9 col-md-offset-3">
														<button type="submit" class="btn btn-primary">Enviar</button>
														<button type="reset" class="btn btn-default">Apagar</button>
													</div>
												</div>
											</div>

				
									</div>
								</div>
							</div>
						</div>
						
					</div>
					<!-- end: page -->
				</section>
			</div>

			<aside id="sidebar-right" class="sidebar-right">
				<div class="nano">
					<div class="nano-content">
						<a href="#" class="mobile-close visible-xs">
							Collapse <i class="fa fa-chevron-right"></i>
						</a>
			
						<div class="sidebar-right-wrapper">
			
							<div class="sidebar-widget widget-calendar">
								<h6>Upcoming Tasks</h6>
								<div data-plugin-datepicker data-plugin-skin="dark" ></div>
			
								<ul>
									<li>
										<time datetime="2014-04-19T00:00+00:00">04/19/2014</time>
										<span>Company Meeting</span>
									</li>
								</ul>
							</div>
			
							<div class="sidebar-widget widget-friends">
								<h6>Friends</h6>
								<ul>
									<li class="status-online">
										<figure class="profile-picture">
											<img src="assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-online">
										<figure class="profile-picture">
											<img src="assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-offline">
										<figure class="profile-picture">
											<img src="assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-offline">
										<figure class="profile-picture">
											<img src="assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
								</ul>
							</div>
			
						</div>
					</div>
				</div>
			</aside>
		</section>

		<!-- Vendor -->
		<script src="assets/vendor/jquery/jquery.js"></script>
		<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<!-- Specific Page Vendor -->
		<script src="assets/vendor/jquery-autosize/jquery.autosize.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>

	</body>
</html>