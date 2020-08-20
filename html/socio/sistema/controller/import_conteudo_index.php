<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <small>Sistema SaGA</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Ínicio</a></li>
        <li class="active">Painel</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
 
        <div data-toggle="modal" data-target="#configModal" href="#" class="col-md-3 col-sm-6 col-xs-12" style="cursor: pointer">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><b>Configurações</b></span>
              <small>Acesse as configurações de administrador</small>
            </div>
          </div>
        </div>

        <a href="socios.php" style="text-decoration: none; color: black"><div data-toggle="modal" class="col-md-3 col-sm-6 col-xs-12" style="cursor: pointer">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>
            <?php $num_socios = mysqli_num_rows(mysqli_query($conexao,"select * from socio")); ?>
            <div class="info-box-content">
            <span class="info-box-text"><b>SÓCIOS</b></span>
              <small>Ir para a página de administração de sócios</small>
            </div>
          </div>
        </div></a>

        <a href="integracao.php" style="text-decoration: none; color: black"><div data-toggle="modal" class="col-md-3 col-sm-6 col-xs-12" style="cursor: pointer">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>
            <div class="info-box-content">
            <span class="info-box-text"><b>INTEGRAÇÃO</b></span>
              <small>Configure e integre sistemas de pagamento</small>
            </div>
          </div>
        </div></a>
      
      <div class="row">
      <div class="col-xs-12">
      <div class="box">
            <div class="box-header">
              <h3 class="box-title">Administração</h3>
            </div>
            <div class="box-body">
              <p>Opções de controle de associados.</p>
              <a id="btn_socios" class="btn btn-app">
                <span class="badge bg-purple"><span id="qtd_socios"><?php echo($num_socios); ?></span></span>
                <i class="fa fa-users"></i> Associados
              </a>
              <a id="btn_bd" class="btn btn-app">
                <i class="fa fa-database"></i> Banco de dados
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>