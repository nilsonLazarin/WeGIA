<?php
   session_start();
   if(!isset($_SESSION['usuario'])){
   	header ("Location: ../index.php");
   }
   
      $usuario = "root";
    	$senha =  "root";
    	$servidor = "localhost";
    	$bddnome = "wegia";
    	$mysqli = new mysqli($servidor,$usuario,$senha,$bddnome);
    	$situacao = $mysqli->query("SELECT situacoes FROM situacao");
    	$cargo = $mysqli->query("SELECT * FROM cargo");
      $beneficios = $mysqli->query("SELECT descricao_beneficios FROM beneficios");
      $descricao_epi = $mysqli->query("SELECT descricao_epi FROM epi");
   
   ?>
<!doctype html>
<html class="fixed">
  <head>
    <!-- Basic -->
    <meta charset="UTF-8">
    <title>Cadastro de Funcionário</title>
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
    <link rel="icon" href="../img/logofinal.png" type="image/x-icon">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="../assets/stylesheets/theme.css" />

    <!-- Skin CSS -->
    <link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">
  </head>
  <body>
      <!-- start: header -->
      <div id="header"></div>
      <!-- end: header -->
      <div class="inner-wrapper">
        <!-- start: sidebar -->
        <aside id="sidebar-left" class="sidebar-left menuu"></aside>
         
         <section role="main" class="content-body">
            <header class="page-header">
               <h2>Cadastro</h2>
               <div class="right-wrapper pull-right">
                  <ol class="breadcrumbs">
                     <li>
                        <a href="./home.php">
                        <i class="fa fa-home"></i>
                        </a>
                     </li>
                     <li><span>Cadastros</span></li>
                     <li><span>Funcionário</span></li>
                  </ol>
                  <a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
               </div>
            </header>
            <!-- start: page -->
            <div class="row" id="formulario">
               <div class="col-md-4 col-lg-3">
                  <section class="panel">
                     <div class="panel-body">
                        <div class="thumb-info mb-md">
                           <?php
                              if($_SERVER['REQUEST_METHOD'] == 'POST')
                              {
                              	if(isset($_FILES['imgperfil']))
                              	{
                              		$image = file_get_contents ($_FILES['imgperfil']['tmp_name']);
                              		$_SESSION['images']=$image;
                              		echo '<img src="data:image/gif;base64,'.base64_encode($image).'" class="rounded img-responsive" alt="John Doe">';
                              	}
                              }
                              else
                              {
                              ?>
                                <img src="../img/semfoto.jpg" class="rounded img-responsive" alt="John Doe">
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
                                        <form action="#" method="POST" enctype="multipart/form-data" >
                                           <div class="form-group">
                                              <label class="col-md-4 control-label" for="imgperfil">Carregue uma imagem de perfil:</label>
                                              <div class="col-md-8">
                                                 <input type="file" name="imgperfil" size="60" id="imgform" class="form-control">
                                              </div>
                                           </div>
                                       </div>
                                       <div class="modal-footer">
                                       <input type="submit" id="formsubmit" value="Ok">
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
               <div class="col-md-8 col-lg-8">
                  <div class="tabs">
                    <ul class="nav nav-tabs tabs-primary">
                      <li class="active">
                        <a href="#overview" data-toggle="tab">Cadastro de Funcionário</a>
                      </li>
                      <!--li>
                        <a href="#endereco" data-toggle="tab">Endereço</a>
                      </li>
                      <li>
                        <a href="#cargaHoraria" data-toggle="tab">Carga Horária</a>
                      </li>
                      <li>
                        <a href="#beneficio" data-toggle="tab">Benefícios</a>
                      </li>
                      <li>
                        <a href="#epi" data-toggle="tab">EPI</a>
                      </li>
                      <li>
                        <a href="#outros" data-toggle="tab">Outros</a>
                      </li-->
                    </ul>
                    <div class="tab-content"> 
                      <div id="overview" class="tab-pane active">
                         <form class="form-horizontal" method="post" action="../controle/control.php">
                            <h4 class="mb-xlg">Informações Pessoais</h4>
                            <h5 class="obrig">Campos Obrigatórios(*)</h5>
                               <div class="form-group">
                                  <label class="col-md-3 control-label" for="profileFirstName">Nome completo<sup class="obrig">*</sup></label>
                                  <div class="col-md-8">
                                     <input type="text" class="form-control" name="nome" id="profileFirstName" id="nome" onkeypress="return Onlychars(event)" required>
                                  </div>
                               </div>
                               <div class="form-group">
                                  <label class="col-md-3 control-label" for="profileLastName">Sexo<sup class="obrig">*</sup></label>
                                  <div class="col-md-8">
                                     <label><input type="radio" name="gender" id="radio" id="M" value="m" style="margin-top: 10px; margin-left: 15px;" onclick="return exibir_reservista()" required><i class="fa fa-male" style="font-size: 20px;"></i></label>
                                     <label><input type="radio" name="gender" id="radio" id="F" value="f" style="margin-top: 10px; margin-left: 15px;" onclick="return esconder_reservista()" ><i class="fa fa-female" style="font-size: 20px;"></i> </label>
                                  </div>
                               </div>
                               <div class="form-group">
                                  <label class="col-md-3 control-label" for="profileCompany">Telefone<sup class="obrig">*</sup></label>
                                  <div class="col-md-8">
                                     <input type="text" class="form-control" maxlength="14" minlength="14" name="telefone" id="telefone" id="profileCompany" placeholder="Ex: (22)99999-9999" onkeypress="return Onlynumbers(event)" onkeyup="mascara('(##)#####-####',this,event)" required>
                                  </div>
                               </div>
                               <div class="form-group">
                                  <label class="col-md-3 control-label" for="profileCompany">Nascimento<sup class="obrig">*</sup></label>
                                  <div class="col-md-8">
                                     <input type="date" placeholder="dd/mm/aaaa" maxlength="10" class="form-control" name="nascimento" id="nascimento" max=<?php echo date('Y-m-d'); ?> required>
                                  </div>
                               </div>
                          <hr class="dotted short">
                         <h4 class="mb-xlg doch4">Documentação</h4>
                         <div class="form-group">
                            <label class="col-md-3 control-label" for="profileCompany">Número do RG<sup class="obrig">*</sup></label>
                            <div class="col-md-6">
                               <input type="text" class="form-control" name="rg" id="rg" onkeypress="return Onlynumbers(event)" placeholder="Ex: 22.222.222-2" onkeyup="mascara('##.###.###-#',this,event)" required>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label" for="profileCompany">Órgão Emissor<sup class="obrig">*</sup></label>
                            <div class="col-md-6">
                               <input type="text" class="form-control" name="orgao_emissor" id="profileCompany" id="orgao_emissor" onkeypress="return Onlychars(event)" required>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label" for="profileCompany">Data de expedição<sup class="obrig">*</sup></label>
                            <div class="col-md-6">
                               <input type="date" class="form-control" maxlength="10" placeholder="dd/mm/aaaa" id="profileCompany" name="data_expedicao" id="data_expedicao" max=<?php echo date('Y-m-d'); ?> required>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label" for="profileCompany">Número do CPF<sup class="obrig">*</sup></label>
                            <div class="col-md-6">
                               <input type="text" class="form-control" id="profileCompany" id="cpf" name="cpf" placeholder="Ex: 222.222.222-22" maxlength="14" onblur="validarCPF(this.value)" onkeypress="return Onlynumbers(event)" onkeyup="mascara('###.###.###-##',this,event)" required>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label" for="profileCompany"></label>
                            <div class="col-md-6">
                               <p id="cpfInvalido" style="display: none; color: #b30000">CPF INVÁLIDO!</p>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label" for="profileCompany">Data de Admissão<sup class="obrig">*</sup></label>
                            <div class="col-md-8">
                               <input type="date" placeholder="dd/mm/aaaa" maxlength="10" class="form-control" name="data_admissao" id="profileCompany" id="data_admissao" max=<?php echo date('Y-m-d'); ?>  required>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label" for="inputSuccess">Situação<sup class="obrig">*</sup></label>
                            <a onclick="adicionar_situacao()"><i class="fas fa-plus w3-xlarge" style="margin-top: 0.75vw"></i></a>
                            <div class="col-md-6">
                               <select class="form-control input-lg mb-md" name="situacao" id="situacao" required>
                                  <option selected disabled>Selecionar</option>
                                  <?php 
                                     while($row = $situacao->fetch_array(MYSQLI_NUM))
                                     {
                                      echo "<option value=".$row[0].">".$row[0]."</option>";
                                     }                            ?>
                               </select>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label" for="inputSuccess">Cargo<sup class="obrig">*</sup></label>
                            <a onclick="adicionar_cargo()"><i class="fas fa-plus w3-xlarge" style="margin-top: 0.75vw"></i></a>
                            <div class="col-md-6">
                               <select class="form-control input-lg mb-md" name="cargo" id="cargo" required>
                                  <option selected disabled>Selecionar</option>
                                  <?php 
                                     while($row = $cargo->fetch_array(MYSQLI_NUM))
                                     {
                                      echo "<option value=".$row[1].">".$row[1]."</option>";
                                     }                            ?>
                               </select>
                            </div>
                         </div>
                      </div>
                        <!--div id="endereco" class="tab-pane">
                        
                           <h4 class="mb-xlg">Endereço</h4>
                           <div class="form-group">
                              <label class="col-md-3 control-label" for="cep">CEP</label>
                              <div class="col-md-8">
                                 <input type="text" name="cep"  value="" size="10" onblur="pesquisacep(this.value);" class="form-control" id="cep" maxlength="9" placeholder="Ex: 22222-222" onkeypress="return Onlynumbers(event)" onkeyup="mascara('#####-###',this,event)">
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
                                 <input type="text" size="40" class="form-control" name="cidade" id="cidade">
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
                              <label class="col-md-3 control-label" for="profileCompany">Número residencial</label>
                              <div class="col-md-4">
                                 <input type="number" min="0" oninput="this.value = Math.abs(this.value)" class="form-control" name="numero_residencia"  id="numero_residencia">
                              </div>
                              <div class="col-md-3"> 
                                 <label>Não possuo número
                                 <input type="checkbox" id="numResidencial" name="naoPossuiNumeroResidencial"  style="margin-left: 4px" onclick="return numero_residencial()">
                                 </label>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-md-3 control-label" for="profileCompany">Complemento</label>
                              <div class="col-md-8">
                                 <input type="text" class="form-control" name="complemento" id="complemento" id="profileCompany">
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-md-3 control-label" for="ibge">IBGE</label>
                              <div class="col-md-8">
                                 <input type="text" size="8" name="ibge" class="form-control"  id="ibge">
                              </div>
                           </div>
                           <br/>
                      </div>
                      <div id="cargaHoraria" class="tab-pane">
                        <h4 class="mb-xlg doch4">Carga Horária</h4>
                        <div class="form-group">
                          <label class="col-md-3 control-label" for="inputSuccess">Escala</label>
                          <div class="col-md-6">
                             <select class="form-control input-lg mb-md" name="escala" id="escala">
                                <option selected disabled>Selecionar</option>
                                <option value="Plantonista">Plantonista</option>
                                <option value="Diarista">Diarista</option>
                             </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-3 control-label" for="inputSuccess">Tipo</label>
                          <div class="col-md-6">
                             <select class="form-control input-lg mb-md" name="tipoCargaHoraria" id="tipoCargaHoraria">
                                <option selected disabled>Selecionar</option>
                                <option value="Mensalista">Mensalista</option>
                                <option value="Diarista">Diarista</option>
                                <option value="Horista">Horista</option>
                             </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-3 control-label" for="profileCompany">Primeira entrada</label>
                          <div class="col-md-3">
                             <input type="time" placeholder="07:25" class="form-control" name="entrada1" id="entrada1" >
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-3 control-label" for="profileCompany">Primeira saída</label>
                          <div class="col-md-3">
                             <input type="time" placeholder="07:25" class="form-control" name="saida1" id="saida1" >
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-3 control-label" for="profileCompany">Segunda entrada</label>
                          <div class="col-md-3">
                             <input type="time" placeholder="07:25" class="form-control" name="entrada2" id="entrada2" >
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-3 control-label" for="profileCompany">Segunda saída</label>
                          <div class="col-md-3">
                             <input type="time" placeholder="07:25" class="form-control" name="saida2" id="saida2" >
                          </div>
                        </div>
                        
                        <div class="text-center">
                          <h3 class="col-md-12">Dias Trabalhados</h3>
                          <div class="btn-group " data-toggle="buttons">
                            <label class="btn btn-primary ">
                              <input type="checkbox" id="diaTrabalhado" name="trabSeg" value="Seg">Seg
                              <span class="fa fa-check"></span>
                            </label>
                            <label class="btn btn-primary" >
                              <input type="checkbox" id="diaTrabalhado" name="trabTer" value="Ter"> Ter
                              <span class="fa fa-check"></span>
                            </label>
                            <label class="btn btn-primary">
                              <input type="checkbox" id="diaTrabalhado" name="trabQua" value="Qua"> Qua
                              <span class="fa fa-check"></span>
                            </label>
                            <label class="btn btn-primary">
                              <input type="checkbox" id="diaTrabalhado" name="trabQui" value="Qui"> Qui
                              <span class="fa fa-check"></span>
                            </label>
                            <label class="btn btn-primary">
                              <input type="checkbox" id="diaTrabalhado" name="trabSex" value="Sex"> Sex
                              <span class="fa fa-check"></span>
                            </label>
                            <label class="btn btn-primary">
                              <input type="checkbox" id="diaTrabalhado" name="trabSab" value="Sab"> Sab
                              <span class="fa fa-check"></span>
                            </label>
                            <label class="btn btn-primary">
                              <input type="checkbox" id="diaTrabalhado" name="trabDom" value="Dom"> Dom
                              <span class="fa fa-check"></span>
                            </label>
                            <label class="btn btn-primary">
                              <input type="checkbox" id="diaTrabalhado" name="plantao" value="Plantão 12/36"> Plantão 12/36
                              <span class="fa fa-check"></span>
                            </label>
                          </div>
                        </div>

                      <div class="text-center">
                          <h3 class="col-md-12">Dias de Folga</h3>
                          <div class="btn-group " data-toggle="buttons">
                            <label class="btn btn-primary ">
                              <input type="checkbox" id="diaTrabalhado" name="folgaSeg" value="Seg">Seg
                              <span class="fa fa-check"></span>
                            </label>
                            <label class="btn btn-primary" >
                              <input type="checkbox" id="diaTrabalhado" name="folgaTer" value="Ter"> Ter
                              <span class="fa fa-check"></span>
                            </label>
                            <label class="btn btn-primary">
                              <input type="checkbox" id="diaTrabalhado" name="folgaQua" value="Qua"> Qua
                              <span class="fa fa-check"></span>
                            </label>
                            <label class="btn btn-primary">
                              <input type="checkbox" id="diaTrabalhado" name="folgaQui" value="Qui"> Qui
                              <span class="fa fa-check"></span>
                            </label>
                            <label class="btn btn-primary">
                              <input type="checkbox" id="diaTrabalhado" name="folgaSex" value="Sex"> Sex
                              <span class="fa fa-check"></span>
                            </label>
                            <label class="btn btn-primary">
                              <input type="checkbox" id="diaTrabalhado" name="folgaSab" value="Sab"> Sab
                              <span class="fa fa-check"></span>
                            </label>
                            <label class="btn btn-primary">
                              <input type="checkbox" id="diaTrabalhado" name="folgaDom" value="Dom"> Dom
                              <span class="fa fa-check"></span>
                            </label>
                            <label class="btn btn-primary">
                              <input type="checkbox" id="diaTrabalhado" name="folgaAlternado" value="Alternado"> Alternado
                              <span class="fa fa-check"></span>
                            </label>
                          </div>
                        </div>
                       
                      </div>
                      <div id="beneficio" class="tab-pane">
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputSuccess">Benefícios</label>
                            <a onclick="adicionar_beneficios()"><i class="fas fa-plus w3-xlarge" style="margin-top: 0.75vw"></i></a>
                            <div class="col-md-6">
                               <select class="form-control input-lg mb-md" name="beneficios" id="beneficios">
                                  <option selected disabled>Selecionar</option>
                                  <?php 
                                     while($row = $beneficios->fetch_array(MYSQLI_NUM))
                                     {
                                      echo "<option value=".$row[0].">".$row[0]."</option>";
                                     }                            ?>
                               </select>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label" for="inputSuccess">Benefícios Status</label>
                            <div class="col-md-6">
                               <select class="form-control input-lg mb-md" name="beneficios_status" id="beneficios_status">
                                  <option selected disabled>Selecionar</option>
                                  <option value="Ativo">Ativo</option>
                                  <option value="Inativo">Inativo</option>
                               </select>
                            </div>
                         </div>
                      </div>

                      <div id="epi" class="tab-pane">
                        <div class="form-group">
                          <label class="col-md-3 control-label" for="inputSuccess">Epi</label>
                          <a onclick="adicionar_descricao_epi()"><i class="fas fa-plus w3-xlarge" style="margin-top: 0.75vw"></i></a>
                          <div class="col-md-6">
                            <select class="form-control input-lg mb-md" name="descricao_epi" id="descricao_epi" required>
                                <option selected disabled>Selecionar</option>
                                <?php 
                                   while($row = $descricao_epi->fetch_array(MYSQLI_NUM))
                                   {
                                    echo "<option value=".$row[0].">".$row[0]."</option>";
                                   }                            ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputSuccess">Epi Status</label>
                            <div class="col-md-6">
                               <select class="form-control input-lg mb-md" name="epi_status" id="epi_status">
                                  <option selected disabled>Selecionar</option>
                                  <option value="Ativo">Ativo</option>
                                  <option value="Inativo">Inativo</option>
                               </select>
                            </div>
                         </div>
                      </div>
                      <div id="outros" class="tab-pane">
                         
                         <h4 class="mb-xlg doch4">Outros</h4>
                         
                         <div class="form-group">
                                  <label class="col-md-3 control-label" for="profileFirstName">Nome do pai</label>
                                  <div class="col-md-8">
                                     <input type="text" class="form-control" name="nome_pai" id="profileFirstName pai" onkeypress="return Onlychars(event)">
                                  </div>
                               </div>
                               <div class="form-group">
                                  <label class="col-md-3 control-label" for="profileFirstName">Nome da mãe</label>
                                  <div class="col-md-8">
                                     <input type="text" class="form-control" name="nome_mae" id="profileFirstName" id="mae" onkeypress="return Onlychars(event)">
                                  </div>
                               </div>
                               <div class="form-group">
                                  <label class="col-md-3 control-label" for="inputSuccess">Tipo sanguíneo</label>
                                  <div class="col-md-6">
                                     <select class="form-control input-lg mb-md" name="sangue" id="sangue">
                                        <option selected disabled>Selecionar</option>
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
                         <div class="form-group">
                            <label class="col-md-3 control-label" >PIS</label>
                            <div class="col-md-6">
                               <input type="text" name="pis" class="form-control" onkeyup="mascara('###.#####.##-##',this,event)">
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label" >CTPS</label>
                            <div class="col-md-6">
                               <input type="text" name="ctps" class="form-control">
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label" for="uf">Estado CTPS</label>
                            <div class="col-md-6">
                               <input type="text" name="uf_ctps" size="60" class="form-control" id="uf">
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label" >Título de eleitor</label>
                            <div class="col-md-6">
                               <input type="text" name="titulo_eleitor" class="form-control">
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label" >Zona eleitoral</label>
                            <div class="col-md-6">
                               <input type="text" name="zona_eleitoral" class="form-control">
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label" >Seção do título de eleitor</label>
                            <div class="col-md-6">
                               <input type="text" name="secao_titulo_eleitor" class="form-control">
                            </div>
                         </div>
                         <div class="form-group" id="reservista1" style="display: none">
                            <label class="col-md-3 control-label" >Número do certificado reservista</label>
                            <div class="col-md-6">
                               <input type="text" name="certificado_reservista_numero" class="form-control num_reservista">
                            </div>
                         </div>
                         <div class="form-group" id="reservista2" style="display: none">
                            <label class="col-md-3 control-label" >Série do certificado reservista</label>
                            <div class="col-md-6">
                               <input type="text" name="certificado_reservista_serie" class="form-control serie_reservista">
                            </div>
                         </div-->
                         
                      </div>    
                       <div class="panel-footer">
                          <div class="row">
                             <div class="col-md-9 col-md-offset-3">
                                <input type="hidden" name="nomeClasse" value="FuncionarioControle">
                                <input type="hidden" name="metodo" value="incluir">
                                <input id="enviar" type="submit" class="btn btn-primary" disabled="true" value="Cadastrar">
                                <input type="reset" class="btn btn-default">
                             </div>
                          </div>
                       </div>
                 </form>
                    <!--</div>
                     </div>
                  </div>
               </div>
            </div>-->
            <!-- end: page -->
         </section>
      </div>
      </section>
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://requirejs.org/docs/release/2.3.6/r.js"></script>
  <style type="text/css">

    .btn span.fa-check {          
      opacity: 0;       
    }
    .btn.active span.fa-check {
      opacity: 1;       
    }
    .obrig{
      color:rgb(255, 0, 0);
    }
  </style>
  <script type="text/javascript" >
   function numero_residencial(){
    if($("#numResidencial").prop('checked')){
   
      document.getElementById("numero_residencia").disabled = true;
   
    }else {
   
      document.getElementById("numero_residencia").disabled = false;
   
    }
   }
   
   function exibir_reservista() {
   
    $("#reservista1").show();
    $("#reservista2").show();
   }
   
   function esconder_reservista() {
   
    $('.num_reservista').val("");
    $('.serie_reservista').val("");
   
    $("#reservista1").hide();
    $("#reservista2").hide();
   }
      
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
   
      function testaCPF(strCPF) { //strCPF é o cpf que será validado. Ele deve vir em formato string e sem nenhum tipo de pontuação.
              var strCPF = strCPF.replace(/[^\d]+/g,''); // Limpa a string do CPF removendo espaços em branco e caracteres especiais.
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

      function gerarSituacao(){
          data = '';
          url = '../dao/exibir_situacao.php';
          $.ajax({
          type: "POST",
          url: url,
          data: data,
          success: function(response){
            var situacoes = response.split(",");

            document.getElementById('situacao').innerHTML = ''; //limpar
            for(var i=0; i<situacoes.length-1; i++)
              document.getElementById('situacao').innerHTML += 
                  '<option>' +situacoes[i] +'</option>';
          },
          dataType: 'text'
        });
      }

      function adicionar_situacao(){
        url = '../dao/adicionar_situacao.php';
        var situacao = window.prompt("Cadastre uma Nova Situação:");
        if(!situacao){return}
        situacao = situacao.trim();
        if(situacao == ''){return}

          data = 'situacao=' +situacao; 

          console.log(data);
          $.ajax({
          type: "POST",
          url: url,
          data: data,
          success: function(response){
            gerarSituacao();
          },
          dataType: 'text'
        })
      }

      function gerarCargo(){
          data = '';
          url = '../dao/exibir_cargo.php';
          $.ajax({
          type: "POST",
          url: url,
          data: data,
          success: function(response){
            var cargo = response.split(",");

            document.getElementById('cargo').innerHTML = ''; //limpar
            for(var i=0; i<cargo.length-1; i++)
              document.getElementById('cargo').innerHTML += 
                  '<option>' +cargo[i] +'</option>';
          },
          dataType: 'text'
        });
      }

      function adicionar_cargo(){
        url = '../dao/adicionar_cargo.php';
        var cargo = window.prompt("Cadastre um Novo Cargo:");
        if(!cargo){return}
        situacao = cargo.trim();
        if(cargo == ''){return}              
        
          data = 'cargo=' +cargo; 
          console.log(data);
          $.ajax({
          type: "POST",
          url: url,
          data: data,
          success: function(response){
            gerarCargo();
          },
          dataType: 'text'
        })
      }
      function gerarDescricao_epi(){
        data = '';
        url = '../dao/exibir_epi.php';
        $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function(response){
          var descricao_epi = response.split(",");

          document.getElementById('descricao_epi').innerHTML = ''; //limpar
          for(var i=0; i<descricao_epi.length-1; i++)
            document.getElementById('descricao_epi').innerHTML += 
                '<option>' +descricao_epi[i] +'</option>';
          },
          dataType: 'text'
        });
      }

      function adicionar_descricao_epi(){
        url = '../dao/adicionar_epi.php';
        var descricao_epi = window.prompt("Cadastre uma Nova epi:");
        if(!descricao_epi){return}
        situacao = descricao_epi.trim();
        if(descricao_epi == ''){return}    
          data = 'descricao_epi=' +descricao_epi; 
          console.log(data);
          $.ajax({
          type: "POST",
          url: url,
          data: data,
          success: function(response){
            gerarDescricao_epi();
          },
          dataType: 'text'
        })
      }
       
      function gerarBeneficios(){
        data = '';
        url = '../dao/exibir_beneficios.php';
        $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function(response){
          var beneficios = response.split(",");

          document.getElementById('beneficios').innerHTML = ''; //limpar
          for(var i=0; i<beneficios.length-1; i++)
            document.getElementById('beneficios').innerHTML += 
                '<option>' +beneficios[i] +'</option>';
          },
          dataType: 'text'
        });
      }

      function adicionar_beneficios(){
        url = '../dao/adicionar_beneficios.php';
        var beneficios = window.prompt("Cadastre um Novo Benefício:");
        if(!beneficios){return}
        situacao = beneficios.trim();
        if(beneficios == ''){return}  
          data = 'beneficios=' +beneficios; 
          console.log(data);
          $.ajax({
          type: "POST",
          url: url,
          data: data,
          success: function(response){
            gerarBeneficios();
          },
          dataType: 'text'
        })
      }

      $(function () {
        $("#header").load("header.html");
        $(".menuu").load("menu.html");
      });
  </script>
    <!-- Head Libs -->
  <script src="../assets/vendor/modernizr/modernizr.js"></script>

  <!-- javascript functions -->
  <script src="../Functions/onlyNumbers.js"></script>
  <script src="../Functions/onlyChars.js"></script>
  <script src="../Functions/enviar_dados.js"></script>
  <script src="../Functions/mascara.js"></script>
  <script src="../Functions/lista.js"></script>
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
    <!-- Vendor -->
    <script src="../assets/vendor/jquery/jquery.js"></script>
    <script src="../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.js"></script>
    <script src="../assets/vendor/nanoscroller/nanoscroller.js"></script>
    <script src="../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="../assets/vendor/magnific-popup/magnific-popup.js"></script>
    <script src="../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
   </body>
</html>
