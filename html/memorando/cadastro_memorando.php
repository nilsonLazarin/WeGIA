<?php

  session_start();
  if(!isset($_SESSION['usuario'])){
    header ("Location: ../../index.php");
  }

?>
<!doctype html>
<html class="fixed">
<head>

  <!-- Basic -->
  <meta charset="UTF-8">

  <title>Cadastro de Memorando</title>

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
  <link rel="icon" href="../../img/logofinal.png" type="image/x-icon">

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
      $(function () {
          $("#header").load("header.html");
          $(".menuu").load("menu.html");
        });
  </script>

<!--Utilizado para o autocomplete no destino -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
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
              <li><span>Cadastros</span></li>
              <li><span>Interno</span></li>
            </ol>
            <a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
          </div>
        </header>

        <!-- start: page -->
        <div class="row">
         <!-- <div class="col-md-4 col-lg-3">
            <section class="panel">
              <div class="panel-body">
                <div class="thumb-info mb-md">
                  <?php
                    if($_SERVER['REQUEST_METHOD'] == 'POST'){
                      if(isset($_FILES['imgperfil'])){
                        $image = file_get_contents ($_FILES['imgperfil']['tmp_name']);
                        session_start();
                        $_SESSION['imagem']=$image;
                            echo '<img src="data:image/gif;base64,'.base64_encode($image).'" class="rounded img-responsive" alt="John Doe">';
                      } 
                    }else{
                  ?>
                     <!--<img src="../../img/semfoto.jpg" class="rounded img-responsive" alt="John Doe">
                  <?php 
                      }
                  ?>
                  <i class="fas fa-camera-retro btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"></i>
                  <div class="container">
                    <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog">
                          <!-- Modal content
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
          </div>-->

          <div class="col-md-8 col-lg-8">
            <div class="tabs">
              <ul class="nav nav-tabs tabs-primary">
                <li class="active">
                  <a href="#overview" data-toggle="tab">Cadastro de Memorando</a>
                </li>
               
              </ul>
              <div class="tab-content">
                <div id="overview" class="tab-pane active">
                  <h4 class="mb-xlg">Informações do Memorando</h4>
                  <form method="POST"   action="" id="formulario" enctype="multipart/form-data" >
                    <div class="form-group">
                      <label class="col-md-3 control-label">Destino: </label>
                      <div class="col-md-8">
                        <input type="text"name="destino" id="destino" placeholder="Orgão,Pessoa..." list="destinos" class="form-control"  id="profileFirstName" onkeypress="return Onlychars(event)"  autocomplete="off" required>
                      </form>
                        <script>
                          $(function()){
                            $("#destino").autocomplete({
                              source: 'processa_pesquisa_msg.php'
                            })
                          }
                       </script>
                      <form>
                         
                      </div>
                    </div>
                   
                    <div class="form-group">
                      <label class="col-md-3 control-label" >Titulo do Memorando: </label>
                      <div class="col-md-8">
                        <input type="text" class="form-control" name="nomeContato" id="nomeContato" id="profileFirstName" onkeypress="return Onlychars(event)">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-md-3 control-label" for="inputSuccess">Tipo Sanguíneo</label>
                      <div class="col-md-6">
                        <select name="sangue" id="sangue" class="form-control input-lg mb-md">
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
                    </div><br/>
                  
                 
                   
                    </div><br/>
                    </div>

                    <section class="panel">
                      <header class="panel-heading">
                        <div class="panel-actions">
                          <a href="#" class="fa fa-caret-down"></a>
                        </div>

                        <h2 class="panel-title">Informações do Memorando</h2>
                      </header>
                      <div class="panel-body" style="display: block;">
                        <section class="simple-compose-box mb-xlg ">

                            <textarea name="observacoes" data-plugin-textarea-autosize placeholder="Observações" rows="1" style="height: 10vw"></textarea>
                        </section>
                      </div>
                    </section>
                  </div>
                  </form>
                  <div class="panel-footer">
                    <div class="row">
                      <div class="col-md-9 col-md-offset-3">
                        <button id="enviar" class="btn btn-primary"  type="submit" disabled="true" >Enviar</button>  
                      </div>
                    </div>
                  </div>                    
                </div>
              </div>
            </div>
          </div>-->
            
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
</body>
</html>
