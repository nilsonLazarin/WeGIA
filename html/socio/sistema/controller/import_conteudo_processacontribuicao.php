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
            <input type="hidden" id="id_socio" name="id_socio" value="<?php echo($_GET['socio']); ?>">
        
        <div class="box box-info resultado">
            <?php
                $resultado = mysqli_query($conexao,"SELECT * FROM doacao_boleto_info AS bi JOIN sistema_pagamento AS sp ON (bi.id_sistema = sp.id) JOIN doacao_boleto_regras AS br ON (br.id = bi.id_regras)  WHERE nome_sistema = 'BOLETOFACIL'");
                $dados_sistema = mysqli_fetch_assoc($resultado);
                $token_api = $dados_sistema['token_api'];
                echo($token_api);
                extract($dados_sistema);
                extract(json_decode($_REQUEST ['dados_contrib'], 1));
                extract($_REQUEST);
                
            ?>
            
            

            </div>
            </div>

            <div style="margin-top: 2em" class="box box-info mt-3">
            <div class="box-header with-border">
              <h3 class="box-title">Datas</h3>
            </div>
            <div class="box-body">
            <!-- <div class="row">
                teste
            </div> -->
            <div class="datas"></div>

            <div class="pull-right">
            <a href="./" id="btn_reset" type="reset" class="btn btn-danger">Cancelar</a>
        <button type="submit" class="btn btn-primary btn_salvar_socio">Gerar</button>
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

      var nome = <?php echo("'$nome'"); ?>.replace(/[^a-zA-Zs]/g, "");
      nome = nome.replace(" ",",");
      referencia = nome + Math.round(Math.random()*100000000);

      var api = ""+<?php echo("'$api'"); ?>;

      $.get(api+`token=<?php echo($token_api); ?>&description=<?php echo($agradecimento); ?>&amount=<?php echo($valor); ?>&dueDate=<?php echo($dataV); ?>&maxOverdueDays=<?php echo($max_dias_venc); ?>&installments=12&payerName=<?php echo($nome); ?>&payerCpfCnpj=<?php echo($cpf); ?>&payerEmail=<?php echo($email); ?>&payerPhone=<?php echo($telefone); ?>&billingAddressStreet=<?php echo($logradouro); ?>&billingAddressNumber=<?php echo($numero_endereco); ?>&billingAddressComplement=<?php echo($complemento); ?>&billingAddressNeighborhood=<?php echo($bairro); ?>&billingAddressCity=<?php echo($cidade); ?>&billingAddressState=<?php echo($estado); ?>&billingAddressPostcode=<?php echo($cep); ?>&fine=<?php echo($multa); ?>&interest<?php echo($juros); ?>&paymentTypes=BOLETO&notifyPayer=TRUE&reference=${referencia}`).done(function(dados){
                    cad_log(socioTipo, reference);
                    console.log(dados);
                    for(var link of dados.data.charges)
                    {
                        
                        var check = link.checkoutUrl;
                        console.log(check);
    
                    }
        })

    });
</script>
