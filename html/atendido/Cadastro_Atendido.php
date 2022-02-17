<?php

   session_start();
   if (!isset($_SESSION['usuario'])) {
	 header("Location: ../index.php");
   }
   
   $config_path = "config.php";
   if (file_exists($config_path)) {
	 require_once($config_path);
   } 
   else {
	 while (true) {
	   $config_path = "../" . $config_path;
	   if (file_exists($config_path)) break;
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

   $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
   $intTipo = $mysqli->query("SELECT * FROM atendido_tipo");
   $intStatus = $mysqli->query("SELECT * FROM atendido_status");

   $cpf= $_GET['cpf'];
?>
	<!doctype html>
<html class="fixed">
<head>

	<!-- Basic -->
	<meta charset="UTF-8">

	<title>Cadastro de Atendido</title>

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<!-- Web Fonts  -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

	<!-- Vendor CSS -->
	<link rel="stylesheet" href="../../assets/vendor/bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" href="../../assets/vendor/font-awesome/css/font-awesome.css" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	<link rel="stylesheet" href="../../assets/vendor/magnific-popup/magnific-popup.css" />
	<link rel="stylesheet" href="../../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
	
	<!-- Theme CSS -->
	<link rel="stylesheet" href="../../assets/stylesheets/theme.css" />

	<!-- Skin CSS -->
	<link rel="stylesheet" href="../../assets/stylesheets/skins/default.css" />

	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="../../assets/stylesheets/theme-custom.css">

	<!-- Head Libs -->
	<script src="../../assets/vendor/modernizr/modernizr.js"></script>

	<!-- Vendor -->
	<script src="../../assets/vendor/jquery/jquery.min.js"></script>
	<script src="../../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
	<script src="../../assets/vendor/bootstrap/js/bootstrap.js"></script>
	<script src="../../assets/vendor/nanoscroller/nanoscroller.js"></script>
	<script src="../../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="../../assets/vendor/magnific-popup/magnific-popup.js"></script>
	<script src="../../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
	<!-- Specific Page Vendor -->
	<script src="../../assets/vendor/jquery-autosize/jquery.autosize.js"></script>
		
	<!-- Theme Base, Components and Settings -->
	<script src="../../assets/javascripts/theme.js"></script>
		
	<!-- Theme Custom -->
	<script src="../../assets/javascripts/theme.custom.js"></script>
		
	<!-- Theme Initialization Files -->
	<script src="../../assets/javascripts/theme.init.js"></script>

	<!-- javascript functions -->
	<script src="../../Functions/onlyNumbers.js"></script>
	<script src="../../Functions/onlyChars.js"></script>
	<script src="../../Functions/enviar_dados.js"></script>
	<script src="../../Functions/mascara.js"></script>
	<script src="../../Functions/lista.js"></script>

	<!-- jquery functions -->
	<script>
		function testaCPF(strCPF) { //strCPF é o cpf que será validado. Ele deve vir em formato string e sem nenhum tipo de pontuação.
            var strCPF = strCPF.replace(/[^\d]+/g,''); // Limpa a string do CPF removendo espaços em branco e caracteres especiais. 
                                                        // PODE SER QUE NÃO ESTEJA LIMPANDO COMPLETAMENTE. FAVOR FAZER O TESTE!!!!
            var Soma;
            var Resto;
            Soma = 0;
            if (strCPF == "00000000000") return false;
            
            for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
            Resto = (Soma * 10) % 11;
            
            if ((Resto == 10) || (Resto == 11))  Resto = 0;
            if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;
            
            Soma = 0;
            for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
            Resto = (Soma * 10) % 11;
            
            if ((Resto == 10) || (Resto == 11))  Resto = 0;
            if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
            return true;
    	}
	
	    function validarCPF(strCPF){
	    	if (!testaCPF(strCPF)){
    			$('#cpfInvalido').show();
    			document.getElementById("enviar").disabled = true;
    		}else{
    			$('#cpfInvalido').hide();
    			document.getElementById("enviar").disabled = false;
    		}
	    }
    
    	function desabilitar_cpf(){

    		if($("#nao_cpf").prop("checked")){
	    		document.getElementById("cpf").readOnly = true;
    			document.getElementById("enviar").disabled = false;
    			document.getElementById("imgCpf").style.display="none";
 		   	}else{
    			document.getElementById("cpf").readOnly = false;
    			document.getElementById("enviar").disabled = true;
    			document.getElementById("imgCpf").style.display="block";
    		}
		}

		function desabilitar_rg(){

    		if($("#nao_rg").prop("checked")){
	    		document.getElementById("rg").readOnly = true;
    			document.getElementById("enviar").disabled = false;
    			document.getElementById("imgRg").style.display="none";
 		   	}else{
    			document.getElementById("rg").readOnly = false;
    			document.getElementById("enviar").disabled = true;
    			document.getElementById("imgRg").style.display="block";
    		}
		}

	   

    	$(function () {
	        $("#header").load("../header.php");
	        $(".menuu").load("../menu.php");
	      });
		 
		// $(document).ready(function(){
		// 	$('#form-cadastro').on("submit", function(event){
		// 		event.preventDefault();
			
		// 		var dados = $("#form-cadastro").serialize();
		// 		alert(dados);
		// 	}) 
		// });
        
		 
	</script>
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
					<h2>Cadastro</h2>
					<div class="right-wrapper pull-right">
						<ol class="breadcrumbs">
							<li>
								<a href="home.php">
									<i class="fa fa-home"></i>
								</a>
							</li>
							<li><span>Cadastro</span></li>
							<li><span>Atendido</span></li>
						</ol>
						<a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
					</div>
				</header>

				<!-- start: page -->
				<!-- <div class="row">
					<div class="col-md-4 col-lg-3">
						<section class="panel">
							<div class="panel-body">
								<div class="thumb-info mb-md">
									<?php
										if($_SERVER['REQUEST_METHOD'] == 'POST'){
											if(isset($_FILES['imgperfil'])){
												$image = file_get_contents ($_FILES['imgperfil']['tmp_name']);
												$_SESSION['imagem']=$image;
	        									echo '<img src="data:image/gif;base64,'.base64_encode($image).'" class="rounded img-responsive" alt="John Doe">';
											}	
										}else{
									?>
											<img src="../../img/semfoto.png" class="rounded img-responsive" alt="John Doe">
									<?php 
											}
									?>
									<i class="fas fa-camera-retro btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"></i>
									<div class="container">
										<div class="modal fade" id="myModal" role="dialog">
										    <div class="modal-dialog">
											    <!-- Modal content-->
											    <!-- <div class="modal-content"> 
											        <div class="modal-header">
											         	<button type="button" class="close" data-dismiss="modal">&times;</button>
											        	<h4 class="modal-title">Adicionar uma Foto</h4>
											        </div>
											    	<div class="modal-body">
											        	<form action="#" method="POST" enctype="multipart/form-data" >
											        		<div class="form-group">
																<label class="col-md-4 control-label" for="imgperfil">Carregue uma imagem de perfil:</label>
																<div class="col-md-8">
																	<input type="file" name="imgperfil" size="60" id="imgform" class="form-control">
																</div>
															</div>
											               	<div class="modal-footer">
											        			<input type="submit" id="formsubmit" value="Ok">
											        		</div>
											        	</form>
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
								<h6 class="text-muted"></h6>
							</div>
						</section>
					</div> -->

					<div class="col-md-8 col-lg-12">
						<div class="tabs">
							<ul class="nav nav-tabs tabs-primary">
								<li class="active">
									<a href="#overview" data-toggle="tab">Cadastro de Atendido</a>
							  
								</li>
								
							</ul>
							<div class="tab-content">
								<div id="overview" class="tab-pane active">
									 <form class="form-horizontal" method="GET" action="../../controle/control.php" id="form-cadastro" enctype="multipart/form-data">
									<h4 class="mb-xlg">Informações Pessoais</h4>
									<h5 class="obrig">Campos Obrigatórios(*)</h5>
										<div class="form-group">
											<label class="col-md-3 control-label" for="profileFirstName">Nome<sup class="obrig">*</sup></label>
											<div class="col-md-6">
												<input type="text" class="form-control" name="nome" id="nome" id="profileFirstName" onkeypress="return Onlychars(event)">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">Sobrenome<sup class="obrig">*</sup></label>
											<div class="col-md-6">
												<input type="text" class="form-control" name="sobrenome" id="sobrenome" onkeypress="return Onlychars(event)">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label" for="profileLastName">Sexo<sup class="obrig">*</sup></label>
											<div class="col-md-6">
												<input type="radio" name="sexo" id="radio1" value="m" style="margin-top: 10px margin-left: 15px;" required><i class="fa fa-male" style="font-size: 20px;" ></i>
												<input type="radio" name="sexo" id="radio2"  value="f" style="margin-top: 10px; margin-left: 15px;"><i class="fa fa-female" style="font-size: 20px;"></i> 
											</div>
										</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label" for="profileCompany">Telefone</label>
											<div class="col-md-6">
												<input type="text" class="form-control" maxlength="14" minlength="14" name="telefone" id="telefone" id="profileCompany" placeholder="Ex: (22)99999-9999" onkeypress="return Onlynumbers(event)" onkeyup="mascara('(##)#####-####',this,event)" >
											</div>
										</div>
										
										<div class="form-group">
											 <label class="col-md-3 control-label" for="profileCompany">Nascimento<sup class="obrig">*</sup></label>
											<div class="col-md-6">
												<input type="date" placeholder="dd/mm/aaaa" maxlength="10" class="form-control" name="nascimento" id="nascimento" max=<?php echo date('Y-m-d');?>> 
										    </div>
										</div>
										
										<div class="form-group">
										<label class="col-md-3 control-label" for="inputSuccess">Status<sup class="obrig">*</sup></label>
										<div class="col-md-6">
										<select class="form-control input-lg mb-md" name="intStatus" id="intStatus">
											<option selected disabled>Selecionar</option>
											<?php
											while ($row = $intStatus->fetch_array(MYSQLI_NUM)) {
											echo "<option value=" . $row[0] . ">" . $row[1] . "</option>";
											}
											?>
										</select>
										</div>
									</div>
										<div class="form-group">
										<label class="col-md-3 control-label" for="inputSuccess">Tipo<sup class="obrig">*</sup></label>
										<div class="col-md-6">
										<select class="form-control input-lg mb-md" name="intTipo" id="intTipo">
											<option selected disabled>Selecionar</option>
											<?php
											while ($row = $intTipo->fetch_array(MYSQLI_NUM)) {
											echo "<option value=" . $row[0] . ">" . $row[1] . "</option>";
											}
											?>
										</select>
										</div>
									</div>


									<h4 class="mb-xlg doch4">Documentação</h4>
										<div class="form-group">
											 <label class="col-md-3 control-label" for="cpf">Número do CPF<sup class="obrig">*</sup></label>
											<div class="col-md-4">
												<input type="text" class="form-control" id="cpf" name="cpf" placeholder="Ex: 222.222.222-22" maxlength="14" onblur="validarCPF(this.value)" onkeypress="return Onlynumbers(event)" onkeyup="mascara('###.###.###-##',this,event)" value="<?php echo $cpf?>" disabled >
											</div>
																							
										</div>

										<div class="form-group">
											<label class="col-md-3 control-label" for="profileCompany"></label>
											<div class="col-md-6">
												<p id="cpfInvalido" style="display: none; color: #b30000">CPF INVÁLIDO!</p>
											</div>														
										</div>
									
										 <div class="panel-footer">
						                    <div class="row">
						                      <div class="col-md-9 col-md-offset-3">
						                        <input type="hidden" name="nomeClasse" value="AtendidoControle">
												<input type="hidden" name="cpf" value="<?php  echo $cpf ?>">
						                        <input type="hidden" name="metodo" value="incluir">
						                        <input id="enviar" type="submit" class="btn btn-primary" value="Enviar" onclick="validarInterno()">
						                      </div>
						                    </div>
						                  </div>				
									</form>
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
					<a href="#" class="mobile-close visible-xs">Collapse <i class="fa fa-chevron-right"></i></a>	
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
	  <style type="text/css">
	  .obrig {
      color: rgb(255, 0, 0);
    }
  </style>
  <script type="text/javascript">
    // Exibe a imagem selecionada no input file:
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
          $('#img-selection')
            .attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
      }
    }

    $('#form-cadastro').submit(function() {
        let imgForm = document.getElementById("imgform");
        document.getElementById("form-cadastro").append(imgForm);
        return true;
    });
    
    function funcao1() {
      var send = $("#enviar");
      var cpfs = [{"cpf":"admin","id":"1"},{"cpf":"12487216166","id":"2"}];
      var cpf_atendido = $("#cpf").val();
      var cpf_atendido_correto = cpf_atendido.replace(".", "");
      var cpf_atendido_correto1 = cpf_atendido_correto.replace(".", "");
      var cpf_atendido_correto2 = cpf_atendido_correto1.replace(".", "");
      var cpf_atendido_correto3 = cpf_atendido_correto2.replace("-", "");
      var apoio = 0;
      var cpfs1 = [{"cpf":"06512358716"},{"cpf":""},{"cpf":"01027049702"},{"cpf":"18136521719"},{"cpf":"57703212539"},{"cpf":"48913397480"},{"cpf":"19861411364"},{"cpf":"26377548508"},{"cpf":"Luiza1ni"},{"cpf":"Luiza2ni"},{"cpf":"63422141154"},{"cpf":"21130377008"},{"cpf":"luiza3ni"},{"cpf":"jiwdfhni"},{"cpf":"Joaoni"},{"cpf":"luiza4ni"},{"cpf":"luiza5ni"},{"cpf":"luiza6ni"},{"cpf":"teste1ni"},{"cpf":"luiza7ni"},{"cpf":"luiza8ni"},{"cpf":"luiza9ni"}];
      $.each(cpfs, function(i, item) {
        if (item.cpf == cpf_atendido_correto3) {
          alert("Cadastro não realizado! O CPF informado já está cadastrado no sistema");
          apoio = 1;
          send.attr('disabled', 'disabled');
        }
      });
      $.each(cpfs1, function(i, item) {
        if (item.cpf == cpf_atendido_correto3) {
          alert("Cadastro não realizado! O CPF informado já está cadastrado no sistema");
          apoio = 1;
         $("#formulario").submit();
        }
      });
      if (apoio == 0) {
        alert("Cadastrado com sucesso!");
      }
    }

    function validarInterno(){
      var btn = $("#enviar");
      var cpf_cadastrado = ([{"cpf":"admin","id":"1"}]);
      var cpf = (($("#cpf").val()).replaceAll(".", "")).replaceAll("-", "");
      console.log(this);
      $.each(cpf_cadastrado, function(i, item) {
        if (item.cpf == cpf) {
          alert("Cadastro não realizado! O CPF informado já está cadastrado no sistema");
          btn.attr('disabled', 'disabled');
          return false;
        }
      }
	  )};
      
      
    
</script>
</body>
</html>