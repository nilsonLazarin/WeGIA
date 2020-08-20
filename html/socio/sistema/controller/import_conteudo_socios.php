<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo($nome);  ?>
        <small>Sistema SaGA</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Ínicio</a></li>
        <li class="active">Painel</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="row">
      <div class="col-md-12">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Sócios cadastrados</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="">
            <table id="example" class="table table-hover" style="width: 100%">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nome</th>
                      <th>Email</th>
                      <th>Telefone</th>
                      <th>Endereço</th>
                      <th>CPF/CNPJ</th>
                      <th>Editar</th>
                      <th>Deletar</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                          $query = mysqli_query($conexao, "SELECT * FROM socio AS s LEFT JOIN pessoajuridica AS pj ON s.id = pj.idsocio LEFT JOIN pessoafisica AS pf ON s.id = pf.idsocio LEFT JOIN endereco AS e ON e.idsocio = s.id");
                          while($resultado = mysqli_fetch_array($query)){
                            $id = $resultado['id'];
                            if($resultado['cpf'] == "" || $resultado['cpf'] == null){
                              $cpf_cnpj = $resultado['cnpj'];
                            }else $cpf_cnpj = $resultado['cpf'];
                            $nome_s = $resultado['nome'];
                            $email = $resultado['email'];
                            $telefone = $resultado['telefone'];
                            $endereco = $resultado['logradouro']." ".$resultado['numero'].", ".$resultado['bairro'].", ".$resultado['cidade']." - ".$resultado['estado'];
                            if(strlen($telefone) == 14){
                              $tel_url = preg_replace("/[^0-9]/", "", $telefone);
                              $telefone = "<a target='_blank' href='http://wa.me/55$tel_url'>$telefone</a>";
                            }
                            $pessoa = $resultado['tipo'];
                            $del_json = json_encode(array("id"=>$id,"nome"=>$nome_s,"pessoa"=>$pessoa));
                            echo("<tr><td>$id</td><td>$nome_s</td><td><a href='mailto:$email'>$email</a></td><td>$telefone</td><td>$endereco</td><td>$cpf_cnpj</td><td><a href='editar_socio.php?socio=$id'><button type='button' class='btn btn-default btn-flat'><i class='fa fa-edit'></i></button></a></td><td><button onclick='deletar_socio_modal($del_json)' type='button' class='btn btn-default btn-flat'><i class='fa fa-remove text-red'></i></button></td></tr>");
                          }
                      ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>Nome</th>
                      <th>Email</th>
                      <th>Telefone</th>
                      <th>Endereço</th>
                      <th>CPF/CNPJ</th>
                      <th>Deletar</th>
                    </tr>
                  </tfoot>
                </table>
                <?php $num_socios = mysqli_num_rows(mysqli_query($conexao,"select * from socio")); ?>
              <a id="btn_add_socio" class="btn btn-app">
                <span class="badge bg-purple"><span id="qtd_socios"><?php echo($num_socios); ?></span></span>
                <i class="fa fa-user-plus"></i> Adicionar Sócio
              </a>
              <a id="btn_importar_xlsx" class="btn btn-app">
                <i class="fa fa-upload"></i> Importar sócios
              </a>
              <a onclick="location.reload()" id="btn_importar_xlsx" class="btn btn-app">
                <i class="fa fa-refresh"></i> Atualizar
              </a>
              <a id="btn_bd" class="btn btn-app">
                <i class="fa fa-database"></i> Banco de dados
              </a>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>  
      </div>
    </section>
  </div>