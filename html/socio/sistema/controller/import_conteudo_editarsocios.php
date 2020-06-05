<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo($nome_empresa);  ?>
        <small>Sistema SaGA</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Ínicio</a></li>
        <li class="active">Painel</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <?php
        $id_socio = $_GET['socio'];
        $resultado = mysqli_query($conexao, "SELECT * FROM socio AS s LEFT JOIN pessoajuridica AS pj ON s.id = pj.idsocio LEFT JOIN pessoafisica AS pf ON s.id = pf.idsocio LEFT JOIN endereco AS e ON e.idsocio = s.id WHERE s.id = $id_socio");
        $registro = mysqli_fetch_array($resultado);
        $nome_socio = $registro['nome'];
        $email = $registro['email'];
        $telefone = $registro['telefone'];
        $tipo = $registro['tipo'];
        $data_nasc = "";
        if($tipo == "fisica"){
          $cpf_cnpj = $registro['cpf'];
          $data_nasc = $registro['datanascimento'];
        }else $cpf_cnpj = $registro['cnpj'];
        $logradouro = $registro['logradouro'];
        $numero = $registro['numero'];
        $complemento = $registro['complemento'];
        $cep = $registro['cep'];
        $bairro = $registro['bairro'];
        $cidade = $registro['cidade'];
        $estado = $registro['estado'];
    ?>
    <div class="row">
      <div class="col-md-12">
      <div class="box box-info box-solid socioModal">
            <div class="box-header">
              <h3 class="box-title"><i class="fa fa-user-plus"></i> Editar sócio</h3>
            </div>
            <div class="box-body">
            <form id="frm_editar_socio" method="POST">
            <input type="hidden" id="id_socio" name="id_socio" value="<?php echo($_GET['socio']); ?>">
        <div class="row">
        <div class="form-group mb-2 col-xs-5">
                  <label for="nome_cliente">Nome sócio</label>
                  <input type="text" class="form-control" id="socio_nome" name="socio_nome" value="<?php echo($nome_socio); ?>" placeholder="" required>
              </div>
        <div class="form-group col-xs-3">
          <label for="pessoa">Pessoa</label>
          <select class="form-control" name="pessoa" id="pessoa">
          <?php
                if($tipo == "fisica"){
          ?>
                    <option value="fisica" selected>Física</option>
                    <option value="juridica">Jurídica</option>
          <?php
                }else{
          ?>
                <option value="fisica">Física</option>
                <option value="juridica" selected>Jurídica</option>
          <?php
                }
          ?>
          </select>
        </div>
        <div class="form-group col-xs-4 cpf_div">
          <label id="label_cpf_cnpj" for="valor">CPF</label>
          <input type="text"  class="form-control" value="<?php echo($cpf_cnpj); ?>" id="cpf_cnpj" name="cpf" required>
        </div>
        </div>
        <div class="row">
        <div class="form-group col-xs-6">
          <label for="obs">E-mail</label>
          <input type="email" class="form-control" id="email" value="<?php echo($email); ?>" name="email" placeholder="">
        </div>
        <div class="form-group col-xs-6">
          <label for="valor">Telefone</label>
          <input type="tel" min="0"  class="form-control" id="telefone" value="<?php echo($telefone); ?>" name="telefone" required>
        </div>
        </div>
        <div class="row div_nasc">
        <?php
              if($tipo == "fisica"){
        ?>
        <div class="form-group col-xs-12">
          <label for="valor">Data de nascimento</label>
          <input type="date" class="form-control" id="data_nasc" value="<?php echo($data_nasc); ?>" name="data_nasc" required>
        </div>
        <?php
              }
        ?>
        </div>
        <div class="box box-info endereco">
            <div class="box-header with-border">
              <h3 class="box-title">Endereço</h3>
            </div>
            <div class="box-body">
            <div class="row">
            <div class="form-group mb-2 col-xs-6">
              <label for="cep">CEP</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                <input type="text" id="cep" class="form-control" value="<?php echo($cep); ?>" placeholder="" required>
              </div>
              <div class="status_cep col-xs-12"></div>
              </div>
            </div>
            <div class="row">
              <div class="form-group mb-2 col-xs-8">
                        <label for="nome_cliente">Rua</label>
                        <input type="text" class="form-control" id="rua" name="nome"value="<?php echo($logradouro); ?>" placeholder="" required>
                    </div>
              <div class="form-group col-xs-4">
                <label for="data_corte">Número</label>
                <input type="number" class="form-control" min="0" id="numero" name="numero" value="<?php echo($numero); ?>" placeholder="" required>
              </div>
            </div>
            <div class="row">
            <div class="form-group mb-2 col-xs-6">
                        <label for="nome_cliente">Complemento</label>
                        <input type="text" class="form-control" id="complemento" name="complemento" value="<?php echo($complemento); ?>" placeholder="">
                    </div>
              <div class="form-group col-xs-6">
                <label for="data_corte">Bairro</label>
                <input type="text" class="form-control" id="bairro" name="bairro" value="<?php echo($bairro); ?>" placeholder="" required>
              </div>
            </div>
            <div class="row">
            <div class="form-group mb-2 col-xs-6">
                        <label for="nome_cliente">Estado</label>
                        <input type="text" class="form-control" id="estado" name="estado" value="<?php echo($estado); ?>" placeholder="" required>
                    </div>
              <div class="form-group col-xs-6">
                <label for="data_corte">Cidade</label>
                <input type="text" class="form-control" id="cidade" name="cidade" value="<?php echo($cidade); ?>" placeholder="" required>
              </div>
            </div>
            <div class="pull-right">
            <a href="socios.php" id="btn_reset" type="reset" class="btn btn-danger">Cancelar</a>
        <button type="submit" class="btn btn-primary btn_salvar_socio">Salvar sócio</button>
            </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>  
      </div>
    </section>
  </div>