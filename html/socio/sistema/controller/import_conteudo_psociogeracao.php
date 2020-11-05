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
							<li><span>Gerar boleto/carnê</span></li>
						</ol>
					
						<a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
					</div>
				</header>

				<!-- start: page -->
				<div class="row">
        <div class="box box-info box-solid socioModal">
            <div class="box-header">
              <h3 class="box-title"><i class="far fa-list-alt"></i> Gerar boleto/carnê</h3>
            </div>
            <div class="box-body">
            <form action="gerar_contribuicao.php" method="POST">
                <h1>Pesquise o sócio</h1>
                <input type="text" id="id_pesquisa" name="id_pesquisa" placeholder="Digite o nome do sócio ou o cpf/cnpj" autocomplete="off" size="20" class="form-control">
                <?php 
						$socios = array();
						$resultado = mysqli_query($conexao,"SELECT *, s.id_socio as socioid FROM socio AS s LEFT JOIN pessoa AS p ON s.id_pessoa = p.id_pessoa LEFT JOIN socio_tipo AS st ON s.id_sociotipo = st.id_sociotipo LEFT JOIN (SELECT id_socio, MAX(data) AS ultima_data_doacao FROM log_contribuicao GROUP BY id_socio) AS lc ON lc.id_socio = s.id_socio");
						while($registro = mysqli_fetch_assoc($resultado)){
							$socios[] = $registro['nome'].'|'.$registro['cpf'].'|'.$registro['socioid'];
						}
					?>
				
				<script>
					var socios = <?php
						echo(json_encode($socios));
					?>;
                  $("#id_pesquisa" ).autocomplete({
				            source: socios,
				            response: function(event,ui) {
				            if (ui.content.length == 1)
                      {
                        ui.item = ui.content[0];
                        $(this).val(ui.item.value)
                        $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
						$("#id_pesquisa" ).blur();
                      }
			            }
  			        });
                </script>
             <div style="margin-top: 2em" class="pull-right mt-2">
							<button type="submit" class="btn btn-primary">Próximo</button>
						</div>
					  </form>
            </div>
            </div>

          <!-- /.box -->
        </div>  
      </div>
			<!-- end: page -->
			</section>
		</div>	
	</section>
</body>
