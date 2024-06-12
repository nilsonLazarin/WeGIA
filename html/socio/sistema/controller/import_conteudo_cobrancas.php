<?php
$locale = (isset($_COOKIE['locale'])) ? filter_var($_COOKIE['locale'], FILTER_SANITIZE_STRING) : filter_var($_SERVER['HTTP_ACCEPT_LANGUAGE'], FILTER_SANITIZE_STRING);
setlocale(LC_ALL, $locale);
?>

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
            <h2>Cobranças</h2>
            
            <div class="right-wrapper pull-right">
                <ol class="breadcrumbs">
                    <li>
                        <a href="../../home.php">
                            <i class="fa fa-home"></i>
                        </a>
                    </li>
                    <li><span>Páginas</span></li>
                    <li><span>Cobranças</span></li>
                </ol>
            
                <a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
            </div>
        </header>

        <!-- start: page -->
        <div class="row">
<div class="box box-warning">
    <div class="box-header with-border">
      <h3 class="box-title">Controle de cobranças</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
      </div>
      <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body box_tabela_cobranca" style="">
    <?php
									if(isset($_GET['msg_c'])){
										$msg = htmlspecialchars($_GET['msg_c']);
										echo('<div class="alert alert-success" role="alert">
										'. $msg .'
									  </div>');
									}else if(isset($_GET['msg_e'])){
										$msg = htmlspecialchars($_GET['msg_e']);
										echo('<div class="alert alert-danger" role="alert">
										'. $msg .'
									  </div>');
									}
							?>
              
              <div class='alert alert-info'>
                  Você pode clicar no nome do sócio para mais detalhes.
              </div>
        <table id="tbCobrancas" class="table table-hover" style="width: 100%">
          <thead>
            <tr>
              <th>Cod.</th>
              <th>N. Sócio</th>
              <th>D. emissão</th>
              <th>D. vencimento</th>
              <th>D. pagamento</th>
              <th>Valor</th>
              <th>Valor pago</th>
              <th>Status</th>
              <th>Opções</th>
            </tr>
          </thead>
          <tbody>
            
          </tbody>
          <tfoot>
            <tr>
            <th>Cod.</th>
              <th>N. Sócio</th>
              <th>D. emissão</th>
              <th>D. vencimento</th>
              <th>D. pagamento</th>
              <th>Valor</th>
              <th>Valor pago</th>
              <th>Status</th>
              <th>Opções</th>
            </tr>
          </tfoot>
        </table>
        <?php $num_socios = mysqli_num_rows(mysqli_query($conexao,"select * from socio")); ?>
        <div class="row">
          <a id="btn_importar_xlsx_cobranca" class="btn btn-app">
        <i class="fa fa-upload"></i> Importar Cobranças
      </a> 
      <a id="btn_atualizar_pag" class="btn btn-app"> 
        <i class="fa fa-download"></i> Importar Pagamentos 
      </a>
        <a id="btn_cadastro_cobranca" class="btn btn-app">
        <i class="fa fa-plus-square"></i> Novo recebimento de cobrança
      </a>
      
      <a onclick=location.reload() class="btn btn-app"> 
        <i class="fa fa-refresh"></i> Atualizar 
      </a>
     
        </div>
     

    </div>
    <!-- /.box-body -->
  </div>
        </div>
    <!-- end: page -->
    </section>
</div>	
<aside id="sidebar-right" class="sidebar-right">
    <div class="nano">
        <div class="nano-content">
            <a href="#" class="mobile-close visible-xs">
                Collapse <i class="fa fa-chevron-right"></i>
            </a>
        </div>
    </div>
</aside>
</section>
</body>
<script>
	  	$(document).ready(function(){
		setTimeout(function(){
			$(".box_tabela_cobranca .alert").fadeOut();
			window.history.replaceState({}, document.title, window.location.pathname);
		}, 3000);
	});
	  </script>
<script>
function gerarCargo(){
  url = '../../dao/exibir_cargo.php';
  $.ajax({
  data: '',
  type: "POST",
  url: url,
  success: function(response){
    var cargo = response;
    $('#cargo').empty();
    $('#cargo').append('<option selected disabled>Selecionar</option>');
    $.each(cargo,function(i,item){
      $('#cargo').append('<option value="' + item.id_cargo + '">' + item.cargo + '</option>');
    });
  },
  dataType: 'json'
});
}

function adicionar_cargo(){
url = '../../dao/adicionar_cargo.php';
var cargo = window.prompt("Cadastre um Novo Cargo:");
if(!cargo){return}
situacao = cargo.trim();
if(cargo == ''){return}              

  data = 'cargo=' +cargo; 
  console.log(data);
  $.ajax({
  type: "POST",
  url: url,
  data: data,
  success: function(response){
    gerarCargo();
  },
  dataType: 'text'
})
}

function verificar_recursos_cargo(cargo_id){
  url = '../../dao/verificar_recursos_cargo.php';              
  data = 'cargo=' +cargo_id; 
  console.log(data);
  $.ajax({
  type: "POST",
  url: url,
  data: data,
  success: function(response){
    var recursos = JSON.parse(response);
    console.log(response);
    $(".recurso").prop("checked",false ).attr("disabled", false);
    for(recurso of recursos){
        $("#recurso_"+recurso).prop("checked",true ).attr("disabled", true);
    }
  },
  dataType: 'text'
})
}

$(document).ready(function(){
$("#cargo").change(function(){
    verificar_recursos_cargo($(this).val());
});
});
</script>
<?php

    require_once "../../../dao/Conexao.php";
    $pdo = Conexao::connect();
       
    $token = $pdo->query("SELECT token_api FROM doacao_boleto_info")->fetchAll(PDO::FETCH_ASSOC);
    $token = json_encode($token);
    $url = $pdo->query("SELECT api FROM doacao_boleto_info")->fetchAll(PDO::FETCH_ASSOC);
    $url = json_encode($url);
?>
<script>
    
    $("#btn_atualizar_pag").click(function(){
        
        var tokenAPI = <?= $token ?>;
        var urlAPI = <?= $url ?>;
        var token = "";
        var url = "";

        $.each(tokenAPI,function(i,item){
             token = item.token_api;
        });
        $.each(urlAPI,function(i,item){
             url = item.api;
        });
        
        var data = new Date;
        var diaAtual = data.getDate();
        var mesAtual = data.getMonth()+1;
        var anoAtual = data.getFullYear();
        data.setDate(data.getDate()-4);
        var diaAnterior = data.getDate();
        var mesAnterior = data.getMonth()+1;
        var anoAnterior = data.getFullYear();
        var dataBR = diaAnterior + "/" + mesAnterior + "/" + anoAnterior;
        var dataAtual = anoAtual + "-" + mesAtual + "-" + diaAtual;

        var urlMod = url.replace("issue","list");
        var urlModificado = urlMod.replace("charge","charges");
        urlModificado = urlModificado+'token='+token+'&beginPaymentDate='+dataBR;
       
        $.ajax({
          data: '',
          type: "POST",
          url: urlModificado,
          success: function(response){
            var resposta = response;
            $.each(resposta,function(i,item){
              $.each(item.charges, function(i1,item1){
                console.log(item1.payments)
                $.each(item1.payments, function(i2,item2){
                    console.log(item2.amount)
                    console.log(item1.code)
                    var dataE = item2.date;
                    var AdataArray = dataE.split("/");
                    var data = AdataArray[2] + "-" + AdataArray[1] + "-" + AdataArray[0];
                    console.log(data)
                    $.post("./atualiza_pagamentos.php",{
                      "codigo": item1.code,
                      "data": data,
                      "valor": item2.amount,
                    }).done(function(resultadoCadastro){
                        if(resultadoCadastro){
                           window.location="cobrancas.php?msg_c=Status de Pagamentos Atualizados!";
                        }
                    });
                });
              });
            });
          },
          dataType: 'json'
        });
    })


</script>

   
    <!-- /.box-body -->

