<?php
  session_start();
  if(!isset($_SESSION['usuario'])){
    header ("Location: ../index.php");
  }

    $mysqli = new mysqli("localhost","root","root","wegia");
    $beneficios = $mysqli->query("SELECT * FROM beneficios");
   
?>

<!doctype html>
<html class="fixed">
<head>
  <!-- Basic -->
  <meta charset="UTF-8">

  <title>Adicionar Benefício</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

  <!-- Vendor CSS -->
  <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.css" />
  <link rel="stylesheet" href="../assets/vendor/magnific-popup/magnific-popup.css" />
  <link rel="stylesheet" href="../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
  <link rel="icon" href="../img/logofinal.png" type="image/x-icon">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

  <!-- Theme CSS -->
  <link rel="stylesheet" href="../assets/stylesheets/theme.css" />

  <!-- Skin CSS -->
  <link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />

  <!-- Theme Custom CSS -->
  <link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">

  <!-- Head Libs -->
  <script src="../assets/vendor/modernizr/modernizr.js"></script>

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

  <!-- javascript functions -->
  <script src="../Functions/onlyNumbers.js"></script> 
  <script src="../Functions/onlyChars.js"></script>
  <script src="../Functions/mascara.js"></script>
  <script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>
  <script>

    function gerarBeneficios(){
      url = '../dao/exibir_beneficios.php';
      $.ajax({
      data: '',
      type: "POST",
      url: url,
      async: true,
      success: function(response){
        
        var beneficios = response;
        $('#ibeneficios').empty();
        $('#ibeneficios').append('<option selected disabled>Selecionar</option>');
        $.each(beneficios,function(i,item){
          $('#ibeneficios').append('<option value="' + item.id_beneficios + '">' + item.descricao_beneficios + '</option>');
        });
        },
        dataType: 'json'
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
</head>
  <body>
    <section class="body">
        <!-- start: header -->
      <div id="header"></div>
      <!-- end: header -->

      <div class="inner-wrapper">
        <!-- start: sidebar -->
        <aside id="sidebar-left" class="sidebar-left menuu"></aside>
          
        <section role="main" class="content-body">
          <header class="page-header">
            <h2>Editar</h2>
          
            <div class="right-wrapper pull-right">
              <ol class="breadcrumbs">
                <li>
                  <a href="home.php">
                    <i class="fa fa-home"></i>
                  </a>
                </li>
                <li><span>Adicionar</span></li>
                <li><span>Benefício</span></li>
              </ol>
          
              <a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
            </div>
          </header>

          <!-- start: page -->
          <div class="row" >
            <div class="col-md-4 col-lg-2" style=" visibility: hidden;"></div>
            <div class="col-md-8 col-lg-8" >
              <div class="tabs"  >
                <ul class="nav nav-tabs tabs-primary">
                  <li class="active">
                    <a href="#overview" data-toggle="tab">Adicionar Benefício</a>
                  </li>
                </ul>
                <div class="tab-content">
                  <div id="overview" class="tab-pane active">
                    <form class="form-horizontal" method="POST" action="../controle/control.php"> 
                      <h4 class="mb-xlg">Benefícios</h4>
                      <div id="beneficio" class="tab-pane">
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputSuccess">Benefícios</label>
                            <a onclick="adicionar_beneficios()"><i class="fas fa-plus w3-xlarge" style="margin-top: 0.75vw"></i></a>
                            <div class="col-md-6">
                               <select class="form-control input-lg mb-md" name="ibeneficios" id="ibeneficios">
                                  <option selected disabled>Selecionar</option>
                                  <?php 
                                  while($row = $beneficios->fetch_array(MYSQLI_NUM)){
                                    echo "<option value=".$row[0].">".$row[1]."</option>";
                                  }?>
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
                        <div class="form-group">
                          <label class="col-md-3 control-label" for="profileCompany">Data Início</label>
                          <div class="col-md-8">
                            <input type="date" placeholder="dd/mm/aaaa" maxlength="10" class="form-control" name="data_inicio" id="inicio" max=<?php echo date('Y-m-d'); ?> >
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-3 control-label" for="profileCompany">Data Fim</label>
                          <div class="col-md-8">
                            <input type="date" placeholder="dd/mm/aaaa" maxlength="10" class="form-control" name="data_fim" id="data_fim" max=<?php echo date('Y-m-d'); ?> >
                          </div>
                        </div>
                        <div class="form-group">
                        <label class="col-md-3 control-label" for="profileCompany">Valor</label>
                        <div class="col-md-8">
                           <input type="text" name="preco" class="dinheiro form-control" id="profileCompany" id="valor" maxlength="13" placeholder="Ex: 22.00" onkeypress="return Onlynumbers(event)">
                        </div>
                     </div>
                      </div>
                      <br>
                      <div class="panel-footer">
                          <div class="row">
                             <div class="col-md-9 col-md-offset-3">
                                <input type="hidden" name="nomeClasse" value="FuncionarioControle">
                                <input type="hidden" name="metodo" value="incluirBeneficio">
                                <input id="enviar" type="submit" class="btn btn-primary" value="Adicionar">
                                <input type="reset" class="btn btn-default">
                                <a href="../html/cadastro_epi.php"><input type="button" class="btn btn-primary" value="Próximo" style="background-color: green; text-decoration:none;"></a>
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
    </section>

  </body>
</html>