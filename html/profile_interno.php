<?php 
   include_once '../classes/Cache.php';
   	session_start();
   	if(!isset($_SESSION['usuario'])){
   		header ("Location: ../index.php");
   	}
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
      $conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
      $id_pessoa = $_SESSION['id_pessoa'];
      $resultado = mysqli_query($conexao, "SELECT * FROM funcionario WHERE id_pessoa=$id_pessoa");
      if(!is_null($resultado)){
         $id_cargo = mysqli_fetch_array($resultado);
         if(!is_null($id_cargo)){
            $id_cargo = $id_cargo['id_cargo'];
         }
         $resultado = mysqli_query($conexao, "SELECT * FROM permissao WHERE id_cargo=$id_cargo and id_recurso=12");
         if(!is_bool($resultado) and mysqli_num_rows($resultado)){
            $permissao = mysqli_fetch_array($resultado);
            if($permissao['id_acao'] < 7){
           $msg = "Você não tem as permissões necessárias para essa página.";
           header("Location: ./home.php?msg_c=$msg");
            }
            $permissao = $permissao['id_acao'];
         }else{
              $permissao = 1;
             $msg = "Você não tem as permissões necessárias para essa página.";
             header("Location: ./home.php?msg_c=$msg");
         }	
      }else{
         $permissao = 1;
       $msg = "Você não tem as permissões necessárias para essa página.";
       header("Location: ./home.php?msg_c=$msg");
      }	
	// Adiciona a Função display_campo($nome_campo, $tipo_campo)
	require_once "personalizacao_display.php";
  require_once ROOT."/controle/FuncionarioControle.php";
  $cpf = new FuncionarioControle;
  $cpf->listarCPF();

  require_once ROOT."/controle/InternoControle.php";
  $cpf1 = new InternoControle;
  $cpf1->listarCPF();

  require_once ROOT."/controle/EnderecoControle.php";
  $endereco = new EnderecoControle;
  $endereco->listarInstituicao();
   
   $id=$_GET['id'];
   $cache = new Cache();
   $teste = $cache->read($id);
   
   if (!isset($teste)) {
   		
   		header('Location: ../controle/control.php?metodo=listarUm&nomeClasse=InternoControle&nextPage=../html/profile_interno.php?id='.$id.'&id='.$id);
   	} 
   ?>
<!doctype html>
<html class="fixed">
   <head>
      <!-- Basic -->
      <meta charset="UTF-8">
      <title>Perfil interno</title>
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
      <link rel="icon" href="<?php display_campo("Logo",'file');?>" type="image/x-icon" id="logo-icon">
      <link rel="stylesheet" type="text/css" href="../css/profile-theme.css">
      <script src="../assets/vendor/jquery/jquery.min.js"></script>
      <script src="../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
      <script src="../assets/vendor/bootstrap/js/bootstrap.js"></script>
      <script src="../assets/vendor/nanoscroller/nanoscroller.js"></script>
      <script src="../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
      <script src="../assets/vendor/magnific-popup/magnific-popup.js"></script>
      <script src="../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
      <!-- Theme CSS -->
      <link rel="stylesheet" href="../assets/stylesheets/theme.css" />
      <!-- Skin CSS -->
      <link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />
      <!-- Theme Custom CSS -->
      <link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">
      <!-- Head Libs -->
      <script src="../assets/vendor/modernizr/modernizr.js"></script>
      <script src="../Functions/lista.js"></script>

      <!-- JavaScript Functions -->
	   <script src="../Functions/enviar_dados.js"></script>
      <script>
         function alterardate(data)
         {
         	var date=data.split("-");
         	return date[2]+"/"+date[1]+"/"+date[0];
         }
         function excluirimg(id)
            {
               $("#excluirimg").modal('show');
               $('input[name="id_documento"]').val(id);
            }
         function editimg(id,descricao)
            {
               $('#teste').val(descricao).prop('selected', true);
               $('input[name="id_documento"]').val(id);
               $("#editimg").modal('show');
            }
         $(function(){
         	var interno=<?php echo $infInterno = $cache->read($id);?>;
            var endereco=<?php echo $_SESSION['endereco']; ?>;
            console.log(interno);
            $.each(endereco,function(i,item){
               $("#cep").text("CEP: "+item.cep);
               $("#cidade").text("Cidade: "+item.cidade);
               $("#bairro").text("Bairro: "+item.bairro);
               $("#logradouro").text("Logradouro: "+item.logradouro);
               $("#numero").text("Numero: "+item.numero_endereco);
               $("#complemento").text("Complemento: "+item.complemento);
            });
         	$.each(interno,function(i,item){
         		if(i=1)
         		{
                  $("#formulario").append($("<input type='hidden' name='idInterno' value='"+item.idInterno+"'>"));
         			var cpf=item.cpf;
         			$("#nome").text("Nome: "+item.nome+' '+item.sobrenome);
         			$("#nomeform").val(item.nome);
                  $("#sobrenomeform").val(item.sobrenome);

         			if(item.imagem!=""){
                     $("#imagem").attr("src","data:image/gif;base64,"+item.imagem);
                  }else{
                     $("#imagem").attr("src","../img/semfoto.png");
                  }
         			if(item.sexo=="m")
         			{
         				$("#sexo").html("Sexo: <i class='fa fa-male'></i>  Masculino");
         				$("#radio1").prop('checked',true);
         			}
         			else if(item.sexo=="f")
         			{
         				$("#sexo").html("Sexo: <i class='fa fa-female'>  Feminino");
         				$("#radio2").prop('checked',true);
         			}
         			$("#pai").text("Nome do pai: "+item.nome_pai);
         			$("#paiform").val(item.nome_pai);
         
         			$("#mae").text("Nome da mãe: "+item.nome_mae);
         			$("#maeform").val(item.nome_mae);
         
         			$("#contato_urgente").text("Nome contato urgente: "+item.nome_contato_urgente);
         			$("#nomeContatoform").val(item.nome_contato_urgente);
         
         			$("#telefone1").text("Telefone contato urgente 1: "+item.telefone_contato_urgente_1);
         			$("#telefone1form").val(item.telefone_contato_urgente_1);
         
         			$("#telefone2").text("Telefone contato urgente 2: "+item.telefone_contato_urgente_2);
         			$("#telefone2form").val(item.telefone_contato_urgente_2);
         
         			$("#telefone3").text("Telefone contato urgente 3: "+item.telefone_contato_urgente_3);
         			$("#telefone3form").val(item.telefone_contato_urgente_3);
         
         			$("#sangue").text("Sangue: "+item.tipo_sanguineo);
         			$("#sangueform").val(item.tipo_sanguineo);
         			
         			$("#nascimento").text("Data de nascimento: "+alterardate(item.data_nascimento));
         			$("#nascimentoform").val(item.data_nascimento);
         
         			$("#rg").text("Registro geral: "+item.registro_geral);
         			$("#rgform").val(item.registro_geral);
                  
                  if(item.data_expedicao=="0000-00-00")
                  {
                     $("#data_expedicao").text("Data de expedição: Não informado");
                  }
                  else{
                     $("#data_expedicao").text("Data de expedição: "+item.data_expedicao);     
                  }
                  $("#expedicaoform").val(item.data_expedicao);
         
         			$('#orgao').text("Orgão emissor: "+item.orgao_emissor);
         			$("#orgaoform").val(item.orgao_emissor);
                  if(item.cpf.indexOf("ni")!=-1)
                  {
                     $("#cpf").text("Não informado");
                     $("#cpfform").val("Não informado");
                  }
                  else
                  {
         			$("#cpf").text(item.cpf);
                  $("#cpfform").val(item.cpf);
                  }
         
         			$("#inss").text("INSS: "+item.inss);
         
         			$("#loas").text("LOAS: "+item.loas);
         
         			$("#funrural").text("FUNRURAL: "+item.funrural);
         
         			$("#certidao").text("Certidão de nascimento: "+item.certidao);
         
         			$("#casamento").text("Certidão de Casamento: "+item.casamento);
         
         			$("#curatela").text("Curatela: "+item.curatela);
         
         			$("#saf").text("SAF: "+item.saf);
         
         			$("#sus").text("SUS: "+item.sus);
         
         			$("#bpc").text("BPC: "+item.bpc);
         
         			$("#ctps").text("CTPS: "+item.ctps);
         
         			$("#titulo").text("Titulo de eleitor: "+item.titulo);
                  
                  $("#observacao").text("Observações: "+item.observacao);
                  $("#observacaoform").val(item.observacao);
         		}
               if(item.imgdoc==null)
               {
                  $('#docs').append($("<strong >").append($("<p >").text("Não foi possível encontrar nenhuma imagem referente a esse interno!")));
               }
               else{
         		$('#docs').append($("<strong >").append($("<p >").text(item.descricao).attr("class","col-md-8"))).append($("<a >").attr("onclick","excluirimg("+item.id_documento+")").attr("class","link").append($("<i >").attr("class","fa fa-trash col-md-1 pull-right icones"))).append($("<a >").attr("onclick","editimg("+item.id_documento+",'"+item.descricao+"')").attr("class","link").append($("<i >").attr("class","fa fa-edit col-md-1 pull-right icones"))).append($("<div>").append($("<img />").attr("src","data:image/gif;base64,"+item.imgdoc).addClass("lazyload").attr("max-height","50px")));
            }
         	})
         });
         $(function () {
            $("#header").load("header.php");
            $(".menuu").load("menu.php");
         });
      </script>
   </head>
   <body>
      <section class="body">
         <div id="header"></div>
            <!-- end: header -->
            <div class="inner-wrapper">
               <!-- start: sidebar -->
               <aside id="sidebar-left" class="sidebar-left menuu"></aside>
         <!-- end: sidebar -->
         <section role="main" class="content-body">
            <header class="page-header">
               <h2>Perfil</h2>
               <div class="right-wrapper pull-right">
                  <ol class="breadcrumbs">
                     <li>
                        <a href="index.html">
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
                           <?php
                              $enderecoArray = (array) $_SESSION['endereco'];
                              if($enderecoArray[0] == "[]")
                              {
                           ?>
                                 <div class="alert alert-warning" style="font-size: 15px;"><i class="fas fa-check mr-md"></i>O endereço da instituição não está cadastrado no sistema<br><a href=<?php echo WWW."html/personalizacao.php"; ?>>Cadastrar endereço da instituição</a></div>
                           <?php
                              }
                           ?>
                           <div class="thumb-info mb-md">
                              <?php
                                 if($_SERVER['REQUEST_METHOD'] == 'POST')
                                 {
                                   if(isset($_FILES['imgperfil']))
                                   {
                                     $image = file_get_contents ($_FILES['imgperfil']['tmp_name']);
                                     //session_start();
                                     $_SESSION['imagem']=$image;
                                                 echo '<img src="data:image/gif;base64,'.base64_encode($image).'" class="rounded img-responsive" alt="John Doe">';
                                   } 
                                 }
                                 else
                                 {
                                 ?>
                              <img id="imagem" alt="John Doe">
                              <?php 
                                 }
                                 ?>
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
                                             <form class="form-horizontal" method="POST" action="../controle/control.php" enctype="multipart/form-data">
                                                <input type="hidden" name="nomeClasse" value="InternoControle">
                                                <input type="hidden" name="metodo" value="alterarImagem">
                                                <div class="form-group">
                                                   <label class="col-md-4 control-label" for="imgperfil">Carregue nova imagem de perfil:</label>
                                                   <div class="col-md-8">
                                                      <input type="file" name="imgperfil" size="60" id="imgform" class="form-control">
                                                   </div>
                                                </div>
                                          </div>
                                          <div class="modal-footer">
                                          <input type="hidden" name="id_interno" value=<?php echo $_GET['id'] ?> >
                                          <input type="submit" id="formsubmit" value="Alterar imagem">
                                          </div>
                                       </div>
                                       </form>
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
                        </div>
               </section>
            </div>
            <div class="col-md-8 col-lg-6">
            <div class="tabs">
            <ul class="nav nav-tabs tabs-primary">
               <li class="active">
                  <a href="#overview" data-toggle="tab">Visão Geral</a>
               </li>
               <li>
                  <a href="#edit" data-toggle="tab">Editar Dados</a>
               </li>
               <li>
                  <a href="#docs" data-toggle="tab">Documentos</a>
               </li>
            </ul>
            <div class="tab-content">
            <div id="overview" class="tab-pane active">
               <div>
                  <section class="panel">
                     <header class="panel-heading">
                        <div class="panel-actions">
                           <a href="#" class="fa fa-caret-down"></a>
                        </div>
                        <h2 class="panel-title">Visão Geral</h2>
                     </header>
                     <div class="panel-body" style="display: block;">
                        <ul class="nav nav-children" id="info">
                           <li id="cap">Dados Pessoais:</li>
                           <li id="nome">Nome:</li>
                           <li id="sexo">Sexo:</li>
                           <li id="pai">Nome do pai:</li>
                           <li id="mae">Nome do mãe:</li>
                           <li id="contato_urgente">Nome do contato urgente:</li>
                           <li id="telefone1">Telefone1:</li>
                           <li id="telefone2">Telefone2:</li>
                           <li id="telefone3">Telefone3:</li>
                           <li id="sangue">Tipo Sanguineo</li>
                           <li id="nascimento">Data de Nascimento:</li>
                           <li id="cep">CEP:</li>
                           <li id="cidade">Cidade:</li>
                           <li id="bairro">Bairro:</li>
                           <li id="logradouro">Logradouro:</li>
                           <li id="numero">Número:</li>
                           <li id="complemento">Complemento:</li>
                           <br/>
                           <li id="cap">RG</li>
                           <li id="rg">Número:</li>
                           <li id="data_expedicao">Data de Expedição do RG:</li>
                           <li id="orgao"></li>
                           <br/>
                           <li id="cap">CPF</li>
                           <li id="cpf">Número:</li>
                           <br/>
                           <li id="cap">Beneficios</li>
                           <li id="inss">INSS:</li>
                           <li id="loas">LOAS:</li>
                           <li id="funrural">FUNRURAL:</li>
                           <li id="certidao">Certidão de nascimento:</li>
                           <li id="casamento">Certidão de casamento:</li>
                           <li id="curatela">CTPS:</li>
                           <li id="saf">SAF:</li>
                           <li id="sus">SUS:</li>
                           <li id="bpc">BPC:</li>
                           <li id="ctps">CTPS:</li>
                           <li id="titulo">Titulo de eleitor:</li>
                           <li id="observacao">Observações:</li>
                           <br/>
                        </ul>
                     </div>
                  </section>
               </div>
            </div>
            <div id="edit" class="tab-pane">
               <h4 class="mb-xlg">Informações Pessoais</h4>
               <form id="formulario" action="../controle/control.php" enctype="multipart/form-data" method="POST">
                  <fieldset>
                     <div class="form-group">
                        <label class="col-md-3 control-label">Nome</label>
                        <div class="col-md-8">
                           <input type="text" class="form-control" name="nome" id="nomeform" id="profileFirstName" onkeypress="return Onlychars(event)" >
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-md-3 control-label">Sobrenome</label>
                        <div class="col-md-8">
                           <input type="text" class="form-control" name="sobrenome" id="sobrenomeform" id="profileLastName" onkeypress="return Onlychars(event)" >
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-md-3 control-label">Sexo</label>
                        <div class="col-md-8">
                           <input type="radio" name="sexo" id="radio1" value="m" style="margin-top: 10px margin-left: 15px;" required><i class="fa fa-male" style="font-size: 20px;" required></i>
                           <input type="radio" name="sexo" id="radio2"  value="f" style="margin-top: 10px; margin-left: 15px;"><i class="fa fa-female" style="font-size: 20px;"></i> 
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-md-3 control-label" >Nome Contato</label>
                        <div class="col-md-8">
                           <input type="text" class="form-control" name="nomeContato" id="nomeContatoform" id="profileFirstName" onkeypress="return Onlychars(event)">
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-md-3 control-label" for="telefone1">Telefone contato 1</label>
                        <div class="col-md-8">
                           <input type="text" class="form-control" maxlength="14" minlength="14" name="telefone1" id="telefone1form" placeholder="Ex: (22)99999-9999" onkeypress="return Onlynumbers(event)" onkeyup="mascara('(##)#####-####',this,event)" required>
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-md-3 control-label">Telefone contato 2</label>
                        <div class="col-md-8">
                           <input type="text" class="form-control" maxlength="14" minlength="14" name="telefone2" id="telefone2form" placeholder="Ex: (22)99999-9999" onkeypress="return Onlynumbers(event)" onkeyup="mascara('(##)#####-####',this,event)" required>
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-md-3 control-label">Telefone contato 3</label>
                        <div class="col-md-8">
                           <input type="text" class="form-control" maxlength="14" minlength="14" name="telefone3" id="telefone3form" placeholder="Ex: (22)99999-9999" onkeypress="return Onlynumbers(event)" onkeyup="mascara('(##)#####-####',this,event)" required>
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-md-3 control-label">Nascimento</label>
                        <div class="col-md-8">
                           <input type="date" max=<?php echo date('Y-m-d'); ?> maxlength="10" class="form-control" name="nascimento" id="nascimentoform" required>
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-md-3 control-label">Nome do Pai</label>
                        <div class="col-md-8">
                           <input type="text" name="pai" class="form-control"  onkeypress="return Onlychars(event)" id="paiform" >
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-md-3 control-label">Nome da Mãe</label>
                        <div class="col-md-8">
                           <input type="text" name="nomeMae" class="form-control" id="maeform" id="profileFirstNameform" onkeypress="return Onlychars(event)" >
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-md-3 control-label">Tipo Sanguíneo</label>
                        <div class="col-md-6">
                           <select name="sangue" id="sangueform" class="form-control input-lg mb-md">
                              <option selected disabled value="blank">Selecionar</option>
                              <option value="A+">A+</option>
                              <option value="A-">A-</option>
                              <option value="B+">B+</option>
                              <option value="B-">B-</option>
                              <option value="O+">O+</option>
                              <option value="O-">O-</option>
                              <option value="AB+">AB+</option>
                              <option value="AB-">AB-</option>
                           </select>
                        </div>
                     </div>
                     <br/>
                     <hr class="dotted short">
                     <h4 class="mb-xlg doch4">Documentação</h4>
                     <div class="form-group">
                        <label class="col-md-3 control-label">Número do RG</label>
                        <div class="col-md-6">
                           <input type="text" class="form-control" name="rg" id="rgform" onkeypress="return Onlynumbers(event)" placeholder="Ex: 22.222.222-2" >
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-md-3 control-label" >Órgão Emissor</label>
                        <div class="col-md-6">
                           <input type="text" name="orgaoEmissor" class="form-control" id="orgaoform" onkeypress="return Onlychars(event)">
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-md-3 control-label" for="dataExpedicao">Data de Expedição</label>
                        <div class="col-md-6">
                           <input type="date" max=<?php echo date('Y-m-d'); ?> class="form-control" maxlength="10" name="dataExpedicao" id="expedicaoform" >
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-md-3 control-label">Número do CPF</label>
                        <div class="col-md-6">
                           <input type="text" class="form-control" id="cpfform" id="cpfform" name="numeroCPF" placeholder="Ex: 222.222.222-22" maxlength="14" onblur="validarCPF(this.value)"" onkeypress="return Onlynumbers(event)" onkeyup="mascara('###.###.###-##',this,event)">
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-6">
                           <p id="cpfInvalido" style="display: none; color: #b30000">CPF INVÁLIDO!</p>
                        </div>
                     </div>
                     <hr class="dotted short">
                     <div class="form-group">
                        <label class="col-md-3 control-label">Benefícios</label>
                        <div class="col-md-8 " >
												<div class="">
													<label>
														<input type="checkbox" name="certidao" value="Possui" id="certidao-checkbox" >Certidão de Nascimento			
													</label><br>
													<label>
														<input type="checkbox" name="certidaoCasamento" value="Possui" id="certidaoCasamento-checkbox" >Certidão de Casamento			
													</label><br>
													<label>
														<input type="checkbox" name="curatela" value="Possui" id="curatela-checkbox" >Curatela
													</label><br>
													<label>
														<input type="checkbox" name="inss" value="Possui" id="inss-checkbox" >INSS
													</label><br>
													
													<label>
														<input type="checkbox" name="loas" value="Possui" id="loas-checkbox" >LOAS
													</label><br>
													
													<label>
														<input type="checkbox" name="funrural" value="Possui" id="funrural-checkbox" >FUNRURAL
													</label><br>														
													<label>
														<input type="checkbox" name="tituloEleitor" value="Possui" id="tituloEleitor-checkbox" >Título de Eleitor
														<input type="hidden" name="nomeClasse" value="InternoControle">
														<input type="hidden" name="metodo" value="incluir">
													</label><br>
													
													<label>
														<input type="checkbox" name="ctps" value="Possui" id="ctps-checkbox" >CTPS
													</label><br>
													
													<label>
														<input type="checkbox" name="saf" value="Possui" id="saf-checkbox" >SAF
													</label><br>
													
													<label>
														<input type="checkbox" name="sus" value="Possui" id="sus-checkbox" >SUS
													</label><br>

													<label>
														<input type="checkbox" name="bpc" value="Possui" id="bpc-checkbox" >BPC
													</label><br>
												</div>
											</div>
                        <br>
                        <hr class="dotted short">
                        <h4 class="mb-xlg doch4" id="label-imagens" style="display: none;">Imagens</h4>
                        <div class="form-group" id="imgRg" style="display: none;">
                           <label class="col-md-4 control-label" id="label-rg" for="imgRg" >RG:</label>
                           <div class="col-md-8">
                              <input type="file" name="imgRg" size="60"  class="form-control" >
                           </div>
                        </div>
                        <div class="form-group" id="imgCpf"  style="display: none;">
                           <label class="col-md-4 control-label" for="imgCpf" id="label-cpf">CPF:</label>
                           <div class="col-md-8">
                              <input type="file" name="imgCpf" size="60" class="form-control">
                           </div>
                        </div>
                        <div class="form-group" id="imgCertidaoNascimento" style="display: none;">
                           <label class="col-md-4 control-label" for="imgCertidaoNascimento" id="label-certidao">Certidão de Nascimento:</label>
                           <div class="col-md-8">
                              <input type="file" name="imgCertidaoNascimento" size="60"  class="form-control">
                           </div>
                        </div>
                        <div class="form-group" id="imgCuratela" style="display: none;">
                           <label class="col-md-4 control-label" id="label-curatela" for="imgCuratela">Curatela:</label>
                           <div class="col-md-8">
                              <input type="file" name="imgCuratela" size="60"  class="form-control">
                           </div>
                        </div>
                        <div class="form-group" id="imgInss" style="display: none;">
                           <label class="col-md-4 control-label"  for="imgInss" id="label-inss">INSS:</label>
                           <div class="col-md-8">
                              <input type="file" name="imgInss" size="60"  class="form-control">
                           </div>
                        </div>
                        <div class="form-group" id="imgLoas" style="display: none;">
                           <label class="col-md-4 control-label" id="label-loas"  for="imgLoas">LOAS:</label>
                           <div class="col-md-8">
                              <input type="file" name="imgLoas" size="60" class="form-control">
                           </div>
                        </div>
                        <div class="form-group" id="imgFunrural" style="display: none;">
                           <label class="col-md-4 control-label" id="label-funrural" for="imgFunrural">FUNRURAL:</label>
                           <div class="col-md-8">
                              <input type="file" name="imgFunrural" size="60" class="form-control">
                           </div>
                        </div>
                        <div class="form-group" id="imgTituloEleitor" style="display: none;">
                           <label class="col-md-4 control-label" id="label-titulo" for="imgTituloEleitor">Título de Eleitor:</label>
                           <div class="col-md-8">
                              <input type="file" name="imgTituloEleitor" size="60" class="form-control">
                           </div>
                        </div>
                        <div class="form-group" id="imgCtps" style="display: none;">
                           <label class="col-md-4 control-label" id="label-ctps" for="imgCtps">CTPS:</label>
                           <div class="col-md-8">
                              <input type="file" name="imgCtps" size="60" class="form-control">
                           </div>
                        </div>
                        <div class="form-group" id="imgSaf" style="display: none;">
                           <label class="col-md-4 control-label" id="label-saf" for="imgSaf">SAF:</label>
                           <div class="col-md-8">
                              <input type="file" name="imgSaf" size="60" class="form-control">
                           </div>
                        </div>
                        <div class="form-group" id="imgSus" style="display: none;">
                           <label class="col-md-4 control-label" id="label-sus" for="imgSus">SUS:</label>
                           <div class="col-md-8">
                              <input type="file" name="imgSus" size="60" class="form-control">
                           </div>
                        </div>
                        <div class="form-group" id="imgBpc"  style="display: none;">
                           <label class="col-md-4 control-label" for="imgBpc">BPC:</label>
                           <div class="col-md-8">
                              <input type="file" name="imgBpc" size="60"class="form-control">
                           </div>
                        </div>
                     </div>
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
                              <textarea id="observacaoform" name="observacao" data-plugin-textarea-autosize placeholder="Observações" rows="1" style="height: 10vw"></textarea>
                           </section>
                        </div>
                     </section>
                  </fieldset>
                  <div class="panel-footer">
                     <div class="row">
                        <div class="col-md-9 col-md-offset-3">
                           <input type="submit" class="btn btn-primary" value="Alterar" onclick="funcao1()"></button>
               </form>
               <button id="excluir" type="button" class="btn btn-danger" data-toggle="modal" data-target="#exclusao">Excluir</button>
               <div class="modal fade" id="exclusao" role="dialog">
               <div class="modal-dialog">
               <!-- Modal content-->
               <div class="modal-content">
               <div class="modal-header">
	               <button type="button" class="close" data-dismiss="modal">×</button>
	               <h3>Excluir um Interno</h3>
               </div>
               <div class="modal-body">
               		<p> Tem certeza que deseja excluir esse interno? Essa ação não poderá ser desfeita e todas as informações referentes a esse interno serão perdidas!</p>
               		<a href="../controle/control.php?metodo=excluir&nomeClasse=InternoControle&id=<?php echo $_GET['id']; ?>"><button button type="button" class="btn btn-success">Confirmar</button></a>
               		<button button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
               </div>
               </div>
               </div>
               </div>
               </div>
               </div>
               </div>
            </div>
            <div id="docs" class="tab-pane">
            </div>
            <!-- end: page -->
         </section>
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
                                 <img src="../img/semfoto.png" alt="Joseph Doe" class="img-circle">
                              </figure>
                              <div class="profile-info">
                                 <span class="name">Joseph Doe Junior</span>
                                 <span class="title">Hey, how are you?</span>
                              </div>
                           </li>
                           <li class="status-online">
                              <figure class="profile-picture">
                                 <img src="../img/semfoto.png" alt="Joseph Doe" class="img-circle">
                              </figure>
                              <div class="profile-info">
                                 <span class="name">Joseph Doe Junior</span>
                                 <span class="title">Hey, how are you?</span>
                              </div>
                           </li>
                           <li class="status-offline">
                              <figure class="profile-picture">
                                 <img src="../img/semfoto.png" alt="Joseph Doe" class="img-circle">
                              </figure>
                              <div class="profile-info">
                                 <span class="name">Joseph Doe Junior</span>
                                 <span class="title">Hey, how are you?</span>
                              </div>
                           </li>
                           <li class="status-offline">
                              <figure class="profile-picture">
                                 <img src="../img/semfoto.png" alt="Joseph Doe" class="img-circle">
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
		<script src="../assets/vendor/select2/select2.js"></script>
        <script src="../assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
        <script src="../assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
        <script src="../assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>

        <!-- Theme Base, Components and Settings -->
        <script src="../assets/javascripts/theme.js"></script>

        <!-- Theme Custom -->
        <script src="../assets/javascripts/theme.custom.js"></script>

        <!-- Theme Initialization Files -->
        <script src="../assets/javascripts/theme.init.js"></script>


        <!-- Examples -->
        <script src="../assets/javascripts/tables/examples.datatables.default.js"></script>
        <script src="../assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
        <script src="../assets/javascripts/tables/examples.datatables.tabletools.js"></script>
         <div class="modal fade" id="excluirimg" role="dialog">
         <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content">
         <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">×</button>
	      <h3>Excluir um Documento</h3>
         </div>
         <div class="modal-body">
         <p> Tem certeza que deseja a imagem desse documento? Essa ação não poderá ser desfeita! </p>
         <form action="../controle/control.php" method="GET">
            <input type="hidden" name="id_documento" id="excluirdoc">
            <input type="hidden" name="nomeClasse" value="DocumentoControle">
            <input type="hidden" name="metodo" value="excluir">
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
            <input type="submit" value="Confirmar" class="btn btn-success">
            <button button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
         </form>
         </div>
         </div>
         </div>
         </div>
         <iv class="modal fade" id="editimg" role="dialog">
         <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content">
         <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">×</button>
         <h3>Alterar um Documento</h3>
         </div>
         <div class="modal-body">
         <p> Selecione o benefício referente a nova imagem</p>
         <form action="../controle/control.php" method="POST" enctype="multipart/form-data">
            <select name="descricao" id="teste">
               <option value="Certidão de Nascimento">Certidão de Nascimento</option>
               <option value="Certidão de Casamento">Certidão de Casamento</option>
               <option value="Curatela">Curatela</option>
               <option value="INSS">INSS</option>
               <option value="LOAS">LOAS</option>
               <option value="FUNRURAL">FUNRURAL</option>
               <option value="Título de Eleitor">Título de Eleitor</option>
               <option value="CTPS">CTPS</option>
               <option value="SAF">SAF</option>
               <option value="SUS">SUS</option>
               <option value="BPC">BPC</option> 
               <option value="CPF">CPF</option>
               <option value="Registro Geral">RG</option>
            </select><br/>
            
            <p> Selecione a nova imagem</p>
            <div class="col-md-12">
               <input type="file" name="doc" size="60"  class="form-control" > 
            </div><br/>
            <input type="hidden" name="id_documento" id="id_documento">
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
            <input type="hidden" name="nomeClasse" value="DocumentoControle">
            <input type="hidden" name="metodo" value="alterar">
            <input type="submit" value="Confirmar" class="btn btn-success">
            <button button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
         </form>
         </div>
         </div>
         </div>
         </div>
         <script>
   function funcao1(){
        var cpfs = <?php echo $_SESSION['cpf_funcionario'];?> ;
        var cpf_funcionario = $("#cpf").val();
        var cpf_funcionario_correto = cpf_funcionario.replace(".", "");
        var cpf_funcionario_correto1 = cpf_funcionario_correto.replace(".", "");
        var cpf_funcionario_correto2 = cpf_funcionario_correto1.replace(".", "");
        var cpf_funcionario_correto3 = cpf_funcionario_correto2.replace("-", "");
        var apoio = 0;
        var cpfs1 = <?php echo $_SESSION['cpf_interno'];?> ;
        $.each(cpfs,function(i,item){
          if(item.cpf==cpf_funcionario_correto3)
          {
            alert("Alteração não realizada! O CPF informado já está cadastrado no sistema");
            apoio = 1;
          }
        });
        $.each(cpfs1,function(i,item){
          if(item.cpf==cpf_funcionario_correto3)
          { 
            alert("Cadastro não realizado! O CPF informado já está cadastrado no sistema");
            apoio = 1;
          }
        });
        if(apoio == 0)
        {
          alert("Cadastrado com sucesso!")
        }
      }
   </script>
    </body>
</html>