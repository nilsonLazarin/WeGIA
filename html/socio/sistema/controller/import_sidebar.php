<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo($foto); ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo($nome); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <!-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Navegação</li>
        <li class="active treeview">
          <a href="#">
          <?php
                if(isset($_SESSION['adm_configurado'])){
            ?>
            <i class="fa fa-dashboard"></i> <span>Painel [ADMIN]</span>
            <?php
                }else{
            ?>
            <i class="fa fa-dashboard"></i> <span>Painel</span>
            <?php
                }
            ?>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="index.php"><i class="fa fa-circle-o"></i> Ínicio</a></li>
            <?php
                if(isset($_SESSION['adm_configurado'])){
            ?>
            <li><a href="socios.php"><i class="fa fa-circle-o"></i> Controle Sócios</a></li>
            <li><a href="integracao.php"><i class="fa fa-circle-o"></i> Integração</a></li>
            <?php
                }
            ?>
    </section>
  </aside>