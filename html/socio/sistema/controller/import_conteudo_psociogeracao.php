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
            <form id="frm_editar_socio" action="processa_contribuicao.php" method="POST">
                <h1>Pesquise o sócio</h1>
                <input type="text" id="input_pessoa" name="socio" autocomplete="off" size="20" class="form-control">
                <script>

                  <?php ?>
                  $("#input_pessoa" ).autocomplete({
				            source: ['teste1|123', 'teste2|1353'],
				            response: function(event,ui) {
				            if (ui.content.length == 1)
                      {
                        ui.item = ui.content[0];
                        $(this).val(ui.item.value)
                        $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                      }
			            }
  			        });
                </script>
            
            

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
