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
   $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
   $intTipo = $mysqli->query("SELECT * FROM atendido_tipo");
   $intStatus = $mysqli->query("SELECT * FROM atendido_status");
   
?>

<!Doctype html>
<html class="fixed">
<head>

	<!-- Basic -->
	<meta charset="UTF-8">

	<title>Cadastro ficha médica</title>

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

	<!-- Vendor CSS -->
	<link rel="stylesheet" href="../../assets/vendor/bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" href="../../assets/vendor/font-awesome/css/font-awesome.css" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	<link rel="stylesheet" href="../../assets/vendor/magnific-popup/magnific-popup.css" />
	<link rel="stylesheet" href="../../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
	
	<!-- Specific Page Vendor CSS -->
	<link rel="stylesheet" href="<?php echo WWW;?>assets/vendor/select2/select2.css" />
    <link rel="stylesheet" href="<?php echo WWW;?>assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
	<!-- Theme CSS -->
	<link rel="stylesheet" href="../../assets/stylesheets/theme.css" />

	<!-- Skin CSS -->
	<link rel="stylesheet" href="../../assets/stylesheets/skins/default.css" />

	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="../../assets/stylesheets/theme-custom.css">

	<script src="../../assets/vendor/modernizr/modernizr.js"></script>
	
	
	<<!-- Vendor 
    <script src="<?php echo WWW;?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/bootstrap/js/bootstrap.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/nanoscroller/nanoscroller.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/magnific-popup/magnific-popup.js"></script>
    <script src="<?php echo WWW;?>assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
--><!-- javascript functions -->



	<!-- Vendor -->
	<script src="../../assets/vendor/jquery/jquery.min.js"></script>
	<script src="../../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
	<script src="../../assets/vendor/bootstrap/js/bootstrap.js"></script>
	<script src="../../assets/vendor/nanoscroller/nanoscroller.js"></script>
	<script src="../../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="../../assets/vendor/magnific-popup/magnific-popup.js"></script>
	<script src="../../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
	<script src="<?php echo WWW;?>assets/vendor/ckeditor/ckeditor.js"></script>
		
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
	<script src="<?php echo WWW;?>assets/javascripts/theme.init.js"></script>


	<script>
        $(function(){
            var funcionario=<?php echo $_SESSION['funcionarios2']?>;
            $.each(funcionario,function(i,item){
                $("#destinatario")
                    .append($("<option id="+item.id_pessoa+" value="+item.id_pessoa+" name="+item.id_pessoa+">"+item.nome+" "+item.sobrenome+"</option>"));
            });
            $("#header").load("<?php echo WWW;?>html/header.php");
            $(".menuu").load("<?php echo WWW;?>html/menu.php");

            var id_memorando = <?php echo $_GET['id_memorando']?>;
            $("#id_memorando").val(id_memorando);

            CKEDITOR.replace('despacho');
        });
    </script>
	<style type="text/css">
		#cke_despacho
        {
            height: 500px;
        }
	</style>

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
					<h2>Cadastro ficha médica</h2>
					<div class="right-wrapper pull-right">
						<ol class="breadcrumbs">
							<li>
								<a href="home.php">
									<i class="fa fa-home"></i>
								</a>
							</li>
							<li><span>Cadastro ficha médica</span></li>
						</ol>
						<a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
					</div>
				</header>

        

				<!-- start: page -->
				<div class="row">
        <div class="col-md-8 col-lg-8">
          <div class="tabs">
            <ul class="nav nav-tabs tabs-primary">
              <li class="active">
                <a href="#overview" data-toggle="tab">Cadastro ficha médica</a>
              </li>
            </ul>
            <div class="tab-content">
              <div id="overview" class="tab-pane active">
                <form class="form-horizontal" method="GET" action="../controle/control.php">
                <div id="cadastro_exames" class="tab-pane">
                 <section class="panel">  
                <header class="panel-heading">
                  <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                  </div>
                  <h2 class="panel-title">Informações Pessoais</h2>
                  </header>
                  <div class="panel-body">
				

                  <h5 class="obrig">Campos Obrigatórios(*)</h5>
                  <div class="form-group">
                    <label class="col-md-3 control-label" for="profileFirstName">Nome<sup class="obrig">*</sup></label>
                    <div class="col-md-8">
                      <input type="text" class="form-control" name="nome" id="profileFirstName" id="nome" onkeypress="return Onlychars(event)" required>
                    </div>
                  </div>


                  <!--<div class="form-group">
                    <label class="col-md-3 control-label" for="profileFirstName">Descrição médica<sup class="obrig">*</sup></label>
                    <div class="col-md-8">
                      <input type="text" class="form-control" name="descricao" id="profileFirstName" id="descricao" onkeypress="return Onlychars(event)" required>
                    </div>
                  </div>-->

				  <div class="form-group">
                    <label for=texto id=etiqueta_despacho class='col-md-3 control-label'>Descrição médica<sup class="obrig">*</sup></label>
                        <div class='col-md-8' id='div_texto'>
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
                                    <input type='hidden' name='id_memorando' id='id_memorando' class='mb-xs mt-xs mr-xs btn btn-default'>
                                </div>
                                <div class='col-md-9 col-md-offset-8'>
                                    <input type='hidden' name='modulo' value="memorando" class='mb-xs mt-xs mr-xs btn btn-default'>
                                </div>
                                <div class='col-md-9 col-md-offset-8'>
                                    <input type='submit' value='Enviar' name='enviar' id='enviar' class='mb-xs mt-xs mr-xs btn btn-primary'>
                                </div>
                    </div>
    			</section>
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
 <!-- end: page -->
    <!-- Vendor -->
	<script src="<?php echo WWW;?>assets/vendor/select2/select2.js"></script>
        <script src="<?php echo WWW;?>assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
        <script src="<?php echo WWW;?>assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
        <script src="<?php echo WWW;?>assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
        
        <!-- Theme Base, Components and Settings -->
        <script src="<?php echo WWW;?>assets/javascripts/theme.js"></script>
        
        <!-- Theme Custom -->
        <script src="<?php echo WWW;?>assets/javascripts/theme.custom.js"></script>
        
        <!-- Theme Initialization Files -->
        <script src="<?php echo WWW;?>assets/javascripts/theme.init.js"></script>
        <!-- Examples -->
        <script src="<?php echo WWW;?>assets/javascripts/tables/examples.datatables.default.js"></script>
        <script src="<?php echo WWW;?>assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
        <script src="<?php echo WWW;?>assets/javascripts/tables/examples.datatables.tabletools.js"></script>

	
</body>
</html>