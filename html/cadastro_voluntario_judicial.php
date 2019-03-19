
<?php

	session_start();
	if(!isset($_SESSION['usuario'])){
		header ("Location: ../index.php");
	}

?>
<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>Cadastro de Voluntario Judicial</title>

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

		<!-- Head Libs -->
		<script src="../assets/vendor/modernizr/modernizr.js"></script>
		<script src="../Functions/lista.js"></script>
		<script type="text/javascript" >

    
    function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('rua').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('uf').value=("");
            document.getElementById('ibge').value=("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('rua').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('uf').value=(conteudo.uf);
            document.getElementById('ibge').value=(conteudo.ibge);
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }
        
    function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('rua').value="...";
                document.getElementById('bairro').value="...";
                document.getElementById('cidade').value="...";
                document.getElementById('uf').value="...";
                document.getElementById('ibge').value="...";

                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };

    </script>
		<script language="JavaScript">
		 var numValidos = "0123456789-()";
         var num1invalido = "78";
         var i;
         	function validarTelefone(){
         		//Verificando quantos dígitos existem no campo, para controlarmos o looping;
         		digitos = document.form1.telefone.value.length;
         			
         		for(i=0; i<digitos; i++) {
         			if (numValidos.indexOf(document.form1.telefone.value.charAt(i),0) == -1) {
         				alert("Apenas números são permitidos no campo Telefone!");
         				document.form1.telefone.select();
         				return false;
         			}
         			if(i==0){
         				if (num1invalido.indexOf(document.form1.telefone.value.charAt(i),0) != -1) {
         					alert("Número de telefone inválido!");
         					document.form1.telefone.select();
         					return false;
         				}
         			}
         		} 
         	}
		</script>

	</head>
	<body>
		<section class="body">

			<!-- start: header -->
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
										<span>Cadastros Pessoas</span>
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
										<span>Informação Pessoas</span>
									</a>
									<ul class="nav nav-children">
										<li>
											<a href="../controle/control.php?metodo=listarTodos&nomeClasse=FuncionarioControle&nextPage=../html/informacao_funcionario.php">
												 Informações funcionarios
											</a>
										</li>
									</ul>
									<ul class="nav nav-children">
										<li>
											<a href="../controle/control.php?metodo=listarTodos&nomeClasse=InternoControle&nextPage=../html/informacao_interno.php">
												 Informações interno
											</a>
										</li>
									</ul>
								</li>

								<li class="nav-parent nav-expanded nav-active">
									<a>
										<i class="fa fa-copy" aria-hidden="true"></i>
										<span>Cadastrar Produtos</span>
									</a>
									<ul class="nav nav-children">
										<li>
											<a href="../html/cadastro_entrada.php">
												 Cadastrar Produtos
											</a>
										</li>
									</ul>
									<ul class="nav nav-children">
										<li>
											<a href="../html/cadastro_saida.php">
												 Saida de Produtos
											</a>
										</li>
									</ul>
								</li>

								<li class="nav-parent nav-expanded nav-active">
									<a>
										<i class="fa fa-copy" aria-hidden="true"></i>
										<span>Informações Produtos</span>
									</a>
									<ul class="nav nav-children">
										<li>
											<a href="../html/estoque.php">
												 Estoque
											</a>
										</li>
									</ul>
									<ul class="nav nav-children">
										<li>
											<a href="../html/listar_almox.php">
												 Almoxarifados
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

				<section role="main" class="content-body">
					<header class="page-header">
						<h2>Cadastro </h2>
					
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
					
							<a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>

					<!-- start: page -->

					<div class="row">
						<div class="col-md-4 col-lg-3">
							<section class="panel">
								<div class="panel-body">
									<div class="thumb-info mb-md">
										<img src="../img/semfoto.jpg" class="rounded img-responsive" alt="John Doe">
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


								</div>
							</section>
						</div>
						<div class="col-md-8 col-lg-8">

							<div class="tabs">
								<ul class="nav nav-tabs tabs-primary">
									<li class="active">
										<a href="#overview" data-toggle="tab">Cadastro de Voluntario Judicial</a>
									</li>
								</ul>
								<div class="tab-content">
									<div id="overview" class="tab-pane active">
										<form class="form-horizontal" method="post" action=".">
											<h4 class="mb-xlg">Informações Pessoais</h4>
											<fieldset>
												<div class="form-group">
													<label class="col-md-3 control-label" for="profileFirstName">Nome completo</label>
													<div class="col-md-8">
														<input type="text" class="form-control" id="profileFirstName">
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
				                                       <input type="text" class="form-control" maxlength="14" minlength="14" name="telefone" id="telefone" id="profileCompany" placeholder="Ex: (22)99999-9999" onkeypress="return Onlynumbers(event)" onkeyup="mascara('(##)#####-####',this,event)" required>
				                                    </div>
				                                 </div>
												<div class="form-group">
													<label class="col-md-3 control-label" for="profileCompany">Nascimento</label>
													<div class="col-md-8">
														<input type="date" class="form-control" id="profileCompany">
													</div>
												</div>
												
												
											<hr class="dotted short">
											<h4 class="mb-xlg">Endereço</h4>
											
												<div class="form-group">
													<label class="col-md-3 control-label" for="cep">CEP</label>
													<div class="col-md-8">
														<input type="text" name="cep"  value="" size="10" onblur="pesquisacep(this.value);" class="form-control" id="cep">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label" for="uf">Estado</label>
													<div class="col-md-8">
														<input type="text" name="uf" size="60" class="form-control" id="uf">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label" for="cidade">Cidade</label>
													<div class="col-md-8">
														<input type="text" size="40" class="form-control" id="cidade">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label" for="bairro">Bairro</label>
													<div class="col-md-8">
														<input type="text" name="bairro" size="40" class="form-control" id="bairro">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label" for="rua">Logradouro</label>
													<div class="col-md-8">
														<input type="text" name="rua" size="2" class="form-control" id="rua">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label" for="profileCompany">Número</label>
													<div class="col-md-8">
														<input type="number" name="numero" class="form-control" id="profileCompany">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label" for="profileCompany">Complemento</label>
													<div class="col-md-8">
														<input type="text" class="form-control" id="profileCompany">
													</div>
												</div>
												<br/>
											
											<hr class="dotted short">
											<h4 class="mb-xlg doch4">Documentação</h4>

												<div class="form-group">
													<label class="col-md-3 control-label" for="profileCompany">Número do CPF</label>
													<div class="col-md-6">
														<input type="text" name="cpf" class="form-control" id="profileCompany">
													</div>														
												</div>
												
												<div class="form-group">
													<label class="col-md-3 control-label" for="profileCompany">Documento Judicial</label>
													<div class="col-md-6">
														<input type="text" name="judicial" class="form-control" id="profileCompany">
													</div>														
												</div>
											<br>
											
											<hr class="dotted short">
											<h4 class="mb-xlg doch4">Senha</h4>

												<div class="form-group">
													<label class="col-md-3 control-label" for="profileCompany">Senha</label>
													<div class="col-md-6">
														<input type="password" name="senha" class="form-control" id="profileCompany">
													</div>														
												</div>	
													
										</form>
										<br/>

										</fieldset>
											<div class="panel-footer">
												<div class="row">
													<div class="col-md-9 col-md-offset-3">
														<input type="submit" class="btn btn-primary">
														<input type="reset" class="btn btn-default">
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
		<script src="../assets/vendor/jquery/jquery.js"></script>
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

	</body>
</html>