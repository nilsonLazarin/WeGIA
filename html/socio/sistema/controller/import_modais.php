<?php
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

?>

<div class="modal fade" id="adicionarSocioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Novo Sócio</h5>
      </div>
      <div class="modal-body">
      <!-- <div class="callout callout-info">
                <h4>Adicione um novo sócio</h4>
                <p>Preencha os dados corretamente para cadastrar um novo sócio.</p>
              </div> -->
              <div class="box box-info box-solid socioModal">
            <div class="box-header">
              <h3 class="box-title"><i class="fa fa-user-plus"></i> Novo sócio</h3>
            </div>
            <div class="box-body">
            <form id="frm_novo_socio" method="POST">
        <div class="row">
        <div class="form-group mb-2 col-xs-5">
                  <label for="nome_cliente">Nome sócio</label>
                  <input type="text" class="form-control" id="socio_nome" name="socio_nome" placeholder="" required>
              </div>
        <div class="form-group col-xs-3">
          <label for="pessoa">Pessoa</label>
          <select class="form-control" name="pessoa" id="pessoa">
                    <option value="fisica">Física</option>
                    <option value="juridica">Jurídica</option>
          </select>
        </div>
        <div class="form-group col-xs-4 cpf_div">
          <label id="label_cpf_cnpj" for="valor">CPF</label>
          <input type="text"  class="form-control" id="cpf_cnpj" name="cpf" required>
        </div>
        </div>
        <div class="row">
        <div class="form-group col-xs-6">
          <label for="obs">E-mail</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="">
        </div>
        <div class="form-group col-xs-6">
          <label for="valor">Telefone</label>
          <input type="tel" min="0"  class="form-control" id="telefone" name="telefone" required>
        </div>
        </div>
        <div class="row">
        <div class="form-group col-xs-4">
          <label for="pessoa">Periodiciade (Contribuinte)</label>
          <select class="form-control" name="contribuinte" id="contribuinte">
                    <option value="mensal">Mensal</option>
                    <option value="bimestral">Bimestral</option>
                    <option value="trimestral">Trimestral</option>
                    <option value="semestral">Semestral</option>
                    <option value="casual">Casual (avulso)</option>
          </select>
        </div>
        <div class="form-group col-xs-4">
          <label for="pessoa">Status</label>
          <select class="form-control" name="status" id="status">
                    <option value="0">Ativo</option>
                    <option value="1">Inativo</option>
                    <option value="2">Inadimplente</option>
                    <option value="3">Inativo temporariamente</option>
          </select>
        </div>
          <div class="div_nasc">
          <div class="form-group col-xs-4">
            <label for="valor">Data de nascimento</label>
            <input type="date" class="form-control" id="data_nasc" name="data_nasc" required>
          </div>
          </div>
        </div>
        <div class="row">
        <div class="form-group col-xs-6">
            <label for="valor">Data referência (ínicio contribuição)</label>
            <input type="date" class="form-control" id="data_referencia" name="data_referencia">
          </div>
          <div class="form-group col-xs-6">
            <label for="valor">Valor/período em R$</label>
            <input type="number" class="form-control" id="valor_periodo" name="valor_periodo">
          </div>
        </div>
        <div class="row">
          <div style="margin-bottom:  1em" class="form-group col-xs-12 mb-2">
            <label for="valor">Tag</label>
            <a onclick="adicionar_tag()">
							<i class="fas fa-plus w3-xlarge" style="margin-top: 0.75vw"></i>
						</a>
            <select class="form-control" name="tags" id="tags">
            <option value="none" disabled selected>Selecionar tag</option>
            <?php
                  $tags = mysqli_query($conexao, "SELECT * FROM socio_tag");
                  while($row = $tags->fetch_array(MYSQLI_NUM))
                  {
                      echo "<option value=".$row[0].">".$row[1]."</option>";
                  }
           
            ?>
            </select>
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
                <input type="text" id="cep" class="form-control" placeholder="" required>
              </div>
              <div class="status_cep col-xs-12"></div>
              </div>
            </div>
            <div class="row">
              <div class="form-group mb-2 col-xs-8">
                        <label for="nome_cliente">Rua</label>
                        <input type="text" class="form-control" id="rua" name="nome" placeholder="" required>
                    </div>
              <div class="form-group col-xs-4">
                <label for="data_corte">Número</label>
                <input type="number" class="form-control" min="0" id="numero" name="numero" placeholder="" required>
              </div>
            </div>
            <div class="row">
            <div class="form-group mb-2 col-xs-6">
                        <label for="nome_cliente">Complemento</label>
                        <input type="text" class="form-control" id="complemento" name="complemento" placeholder="">
                    </div>
              <div class="form-group col-xs-6">
                <label for="data_corte">Bairro</label>
                <input type="text" class="form-control" id="bairro" name="bairro" placeholder="" required>
              </div>
            </div>
            <div class="row">
            <div class="form-group mb-2 col-xs-6">
                        <label for="nome_cliente">Estado</label>
                        <input type="text" class="form-control" id="estado" name="estado" placeholder="" required>
                    </div>
              <div class="form-group col-xs-6">
                <label for="data_corte">Cidade</label>
                <input type="text" class="form-control" id="cidade" name="cidade" placeholder="" required>
              </div>
            </div>
            </div>
            <!-- /.box-body -->
          </div>
      </div>
      <div class="modal-footer">
      <button id="btn_reset" type="reset" class="btn btn-danger">Resetar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary btn_salvar_socio">Salvar sócio</button>
      </div>
        </form>
            </div>
            <!-- /.box-body -->
            <!-- Loading (remove the following to stop the loading)-->
            
            <!-- end loading -->
          </div>
       
        
    </div>
  </div>
</div>

<!-- modal inserir cobrança -->
<div class="modal fade" id="adicionarCobrancaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nova cobrança</h5>
      </div>
      <div class="modal-body">
      <!-- <div class="callout callout-info">
                <h4>Adicione um novo sócio</h4>
                <p>Preencha os dados corretamente para cadastrar um novo sócio.</p>
              </div> -->
              <div class="box box-info box-solid socioModal">
            <div class="box-header">
              <h3 class="box-title"><i class="fa fa-plus-square"></i> Nova cobrança</h3>
            </div>
            <div class="box-body">
            <form id="frm_nova_cobranca" method="POST">
        <div class="row">
        <div class="form-group mb-2 col-xs-12">
        <?php
            $socios = array();
						$resultado = mysqli_query($conexao,"SELECT *, s.id_socio as socioid FROM socio AS s LEFT JOIN pessoa AS p ON s.id_pessoa = p.id_pessoa LEFT JOIN socio_tipo AS st ON s.id_sociotipo = st.id_sociotipo LEFT JOIN (SELECT id_socio, MAX(data) AS ultima_data_doacao FROM log_contribuicao GROUP BY id_socio) AS lc ON lc.id_socio = s.id_socio");
						while($registro = mysqli_fetch_assoc($resultado)){
							$socios[] = $registro['nome'].'|'.$registro['cpf'].'|'.$registro['socioid'];
						}
        ?>
                  <label for="nome_cliente">Sócio</label>
                  <input type="text" class="form-control" id="socio_nome_ci" name="socio_nome" placeholder="" required>
              </div>
              <script>
                var socios = <?php
                  echo(json_encode($socios));
                ?>;
                  $("#socio_nome_ci").autocomplete({
				            source: socios,
				            response: function(event,ui) {
				            if (ui.content.length == 1)
                      {
                        ui.item = ui.content[0];
                        $(this).val(ui.item.value)
                        $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
						            $("#socio_nome_ci" ).blur();
                      }
			            }
  			        });
                </script>
        <div class="form-group col-xs-12">
          <label id="label_cpf_cnpj" for="valor">Local de recepção</label>
          <input type="text"  class="form-control" id="cpf_cnpj" name="cpf" required>
        </div>
        </div>
        <div class="row">
        <div class="form-group col-xs-6">
          <label for="obs">Receptor</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="">
        </div>
        <div class="form-group col-xs-6">
          <label for="valor">Valor</label>
          <input type="tel" min="0"  class="form-control" id="telefone" name="telefone" required>
        </div>
        </div>
        <div class="row">

          <div class="form-group col-xs-12">
            <label for="valor">Data de recepção</label>
            <input type="date" class="form-control" id="data_nasc" value="<?php echo(date('Y-m-d')); ?>" name="data_nasc" required>
          </div>

        </div>
        
      </div>
      <div class="modal-footer">
      <button id="btn_reset" type="reset" class="btn btn-danger">Resetar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary btn_salvar_socio">Salvar cobrança</button>
      </div>
        </form>
            </div>
            <!-- /.box-body -->
            <!-- Loading (remove the following to stop the loading)-->
            
            <!-- end loading -->
          </div>
       
        
    </div>
  </div>
</div>

<!-- Modal configurações -->
<div class="modal fade" id="configModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Configurações</h4>
              </div>
      <div class="modal-body">
      <a href="../configuracao" class="btn btn-app">
        <i class="fa fa-edit"></i> Editar textos
      </a>
      <a class="btn btn-app">
        <i class="fa fa-sliders"></i> Sistema
      </a>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>


            <!-- Modal bd -->
<div class="modal fade" id="bdModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Banco de dados</h4>
              </div>
      <div class="modal-body">
        <div class="box box-warning box-solid bd_box">
            <div class="box-header">
              <h3 class="box-title">Opções - BD</h3>
            </div>
            <div class="box-body">
            <a id="btn_deletarSocios" class="btn btn-app" >
              <i class="fa fa-user-times"></i> Apagar todos sócios
            </a>
            </div>
            <!-- /.box-body -->
            <!-- Loading (remove the following to stop the loading)-->
            <!-- end loading -->
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

  <!-- Modal importar -->
    <div class="modal fade" id="modal_importar_xlsx" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                  <h4 class="modal-title">Importar sócios</h4>
                </div>
        <div class="modal-body">
        <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-warning"></i> Atenção!</h4>
                A importação pode demorar alguns minutos, não feche a página.
              </div>
        <div class="box box-warning box_xlsx">
            <div class="box-header with-border">
              <h3 class="box-title">Importar sócios através de arquivo .xlsx</h3>
            </div>
            <div class="box-body box_xlsx">
            <form action="" id="form_xlsx" method="post" enctype="multipart/form-data">
            <div class="form-group">
                  <label for="exampleInputFile">Tabela .xlsx</label>
                  <input type="file" id="arquivo_xlsx" accept=".xls,.xlsx, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel" name="arquivo" required>
                  <p class="help-block">Envie um arquivo .xlsx para continuar.</p>
            </div>
            <input type="submit" class="btn btn-primary pull-right" name="btn_envia_xlsx">
            </form>
              <!-- /input-group -->
            </div>
            <div class="progress progress-sm active">
                <div class="progress-bar progress-bar-info progress-bar-striped barra_envio" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                  <span class="sr-only">20% Complete</span>
                </div>
              </div>
            <!-- /.box-body -->
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal importar cobranças -->
  <div class="modal fade" id="modal_importar_xlsx_cobranca" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                  <h4 class="modal-title">Importar cobranças</h4>
                </div>
        <div class="modal-body">
        <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-warning"></i> Atenção!</h4>
                A importação pode demorar alguns minutos, não feche a página.
              </div>
        <div class="box box-warning box_xlsx">
            <div class="box-header with-border">
              <h3 class="box-title">Importar cobranças através de arquivo .xlsx</h3>
            </div>
            <div class="box-body box_xlsx">
            <form action="" id="form_xlsx_cobranca" method="post" enctype="multipart/form-data">
            <div class="form-group">
                  <label for="exampleInputFile">Tabela .xlsx</label>
                  <input type="file" id="arquivo_xlsx_cobranca" accept=".xls,.xlsx, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel" name="arquivo" required>
                  <p class="help-block">Envie um arquivo .xlsx para continuar.</p>
            </div>
            <input type="submit" class="btn btn-primary pull-right" name="btn_envia_xlsx_cobranca">
            </form>
              <!-- /input-group -->
            </div>
            <!-- /.box-body -->
          </div>

          <div class="progress progress-sm active">
                <div class="progress-bar progress-bar-info progress-bar-striped barra_envio" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                  <span class="sr-only">20% Complete</span>
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

   <!-- Modal aniversariantes -->
   <div class="modal fade" id="modal_aniversariantes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                  <h4 class="modal-title">Sócios aniversariantes do mês</h4>
                </div>
        <div class="modal-body">
        <!-- <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-warning"></i> Lista de sócios: </h4>
                Dê os parabéns!
              </div> -->
        <div class="box box-success box_aniversario">
            <div class="box-header with-border">
              <h3 class="box-title">Lista dos sócios aniversariantes</h3>
            </div>
            <div class="box-body box_aniversario">
            <table id="tb_aniversario" class="table table-hover" style="width: 100%">
                  <thead>
                    <tr>
                      <th>Nome</th>
                      <th>Email</th>
                      <th>Telefone</th>
                      <th>Data aniversário</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                          $mes_atual = date("m");
                          $query = mysqli_query($conexao, "SELECT *, s.id_socio as socioid, DATE_FORMAT(p.data_nascimento, '%d/%m') as aniversario FROM socio AS s LEFT JOIN pessoa AS p ON s.id_pessoa = p.id_pessoa  WHERE p.data_nascimento LIKE '%-$mes_atual-%'");
                          while($resultado = mysqli_fetch_array($query)){
                  
                            $id = $resultado['socioid'];
                            $cpf_cnpj = $resultado['cpf'];
                            $aniversario = $resultado['aniversario'];
                            $nome_s = $resultado['nome'];
                            $email = $resultado['email'];
                            $telefone = $resultado['telefone'];
                            $endereco = $resultado['logradouro']." ".$resultado['numero_endereco'].", ".$resultado['bairro'].", ".$resultado['cidade']." - ".$resultado['estado'];
                            if(strlen($telefone) == 14){
                              $tel_url = preg_replace("/[^0-9]/", "", $telefone);
                              $telefone = "<a target='_blank' href='http://wa.me/55$tel_url'>$telefone</a>";
                            }
                            if(strlen($cpf_cnpj) == 14){
                              $pessoa = "fisica";
                              $fisica++;
                            }else{
                              $pessoa = "juridica";
                              $juridica++;
                            } 
                              
                            $del_json = json_encode(array("id"=>$id,"nome"=>$nome_s,"pessoa"=>$pessoa));
                            echo("<tr><td onclick='detalhar_socio($id);' style='cursor: pointer' class='$class'>$nome_s</td><td><a href='mailto:$email'>$email</a></td><td>$telefone</td><td>$aniversario</td></tr>");
                          }
                      ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Nome</th>
                      <th>Email</th>
                      <th>Telefone</th>
                      <th>Data aniversário</th>
                    </tr>
                  </tfoot>
                </table>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

     <!-- Modal graficos -->
     <div class="modal fade" id="modal_graficos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                  <h4 class="modal-title">Sócios aniversariantes do mês</h4>
                </div>
        <div class="modal-body">
        
            

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

  



