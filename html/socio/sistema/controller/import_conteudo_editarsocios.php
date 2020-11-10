<section class="body">

		<!-- start: header -->
		<header id="header" class="header">
			
		<!-- end: search & user box -->
		</header>
		<!-- end: header -->
		<div class="inner-wrapper">
			<!-- start: sidebar -->
			<aside id="sidebar-left" class="sidebar-left menuu"></aside>
			<!-- end: sidebar -->

			<section role="main" class="content-body">
				<header class="page-header">
					<h2>Sócios</h2>
					
					<div class="right-wrapper pull-right">
						<ol class="breadcrumbs">
							<li>
								<a href="home.php">
									<i class="fa fa-home"></i>
								</a>
							</li>
							<li><span>Páginas</span></li>
							<li><span>Sócios</span></li>
						</ol>
					
						<a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
					</div>
				</header>

				<!-- start: page -->
				<div class="row">
        <div class="box box-info box-solid socioModal">
            <div class="box-header">
              <h3 class="box-title"><i class="fa fa-user-plus"></i> Editar sócio</h3>
            </div>
            <div class="box-body">
            <form id="frm_editar_socio" method="POST">
            <input type="hidden" id="id_socio" name="id_socio" value="<?php echo($_GET['socio']); ?>">
            <?php
        $id_socio = $_GET['socio'];
        $resultado = mysqli_query($conexao, "SELECT * FROM socio AS s LEFT JOIN pessoa AS p ON s.id_pessoa = p.id_pessoa WHERE id_socio = $id_socio");
        $registro = mysqli_fetch_array($resultado);
        $nome_socio = $registro['nome'];
        $email = $registro['email'];
        $telefone = $registro['telefone'];
        $status = $registro['id_sociostatus'];
        $data_nasc = $registro['data_nascimento'];
        $cpf_cnpj = $registro['cpf'];
        $logradouro = $registro['logradouro'];
        $numero = $registro['numero_endereco'];
        $complemento = $registro['complemento'];
        $cep = $registro['cep'];
        $socio_tipo = $registro['id_sociotipo'];
        $bairro = $registro['bairro'];
        $cidade = $registro['cidade'];
        $estado = $registro['estado'];
    ?>
        <div class="row">
        <div class="form-group mb-2 col-xs-5">
                  <label for="nome_cliente">Nome sócio</label>
                  <input type="text" class="form-control" id="socio_nome" name="socio_nome" value="<?php echo($nome_socio); ?>" placeholder="" required>
              </div>
        <div class="form-group col-xs-3">
          <label for="pessoa">Pessoa</label>
          <select class="form-control" name="pessoa" id="pessoa">
          <?php
                if(strlen($cpf_cnpj) == 14){
                  $pessoa = "fisica";
                }else $pessoa = "juridica";
                if($pessoa == "fisica"){
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
       
         <div class="row">
        <div class="form-group col-xs-4">
          <label for="pessoa">Contribuinte</label>
          <select class="form-control" name="contribuinte" id="contribuinte">
                    <option value="mensal">Mensal</option>
                    <option value="bimestral">Bimestral</option>
                    <option value="trimestral">Trimestral</option>
                    <option value="semestral">Semestral</option>
                    <option value="casual">Casual (avulso)</option>
                    <option value="si">Sem informação</option>
          </select>
        </div>
        <div class="form-group col-xs-4">
          <label for="pessoa">Status</label>
          <select class="form-control" name="status" id="status">
                    <option value="0">Ativo</option>
                    <option value="1">Inativo</option>
                    <option value="2">Inadimplente</option>
                    <option value="3">Inativo temporariamente</option>
                    <option value="4">Sem informação</option>
          </select>
        </div>
        <div class="div_nasc">
        <?php
              if($pessoa == "fisica"){
        ?>
          
          <div class="form-group col-xs-4">
            <label for="valor">Data de nascimento</label>
            <input type="date" class="form-control" id="data_nasc" value="<?php echo($data_nasc); ?>" name="data_nasc" required>
          </div>
        
          <?php
              }
        ?>
          </div>
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
            <a href="./" id="btn_reset" type="reset" class="btn btn-danger">Cancelar</a>
        <button type="submit" class="btn btn-primary btn_salvar_socio">Salvar sócio</button>
            </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>  
      </div>
			<!-- end: page -->
			</section>
		</div>	
	</section>
</body>
<script>
    $(document).ready(function(){
        var sociotipo = <?php echo($socio_tipo); ?>;
        var status = <?php echo($status); ?>;
        $("#status").val(status);
        if(status == 4){
          $("#contribuinte").val("si");
        }

        switch(sociotipo){
          case 0: case 1: 
              $("#contribuinte").val("casual");
              break;
          case 2: case 3:
              $("#contribuinte").val("mensal");
              break;
          case 6: case 7:
              $("#contribuinte").val("bimestral");
              break;
          case 8: case 9:
              $("#contribuinte").val("trimestral");
              break;
          case 10: case 11:
              $("#contribuinte").val("semestral");
              break;
          default:
              $("#contribuinte").val("si");
              break;
        }
    });
</script>
