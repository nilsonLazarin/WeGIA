function atualiza(){
 
  $("#alerta").hide();
  $("#divpagseguro").hide();
  $("#divpaypal").hide();
  $("#btn-bol").hide();
  $('#foo').hide();
  $(".alerta_bol").hide();
  $(".alerta_pay").hide(); 
  $(".alerta_pag").hide();

  $("submit").click(function(){
	$('#foo').fadeIn();
	setTimeout(function () {
		$('#foo').hide(); 
	}, 99000);
});
	if($("#dadoBol").val() == 0)
		{
			$(".alerta_bol").fadeIn();
		}else{
			$(".alerta_bol").hide();
		}
 
  $("#header").load("../../header.php");
  $(".menuu").load("../../menu.php");
  $("input").prop("readonly", true);
  $("textarea").prop("readonly", true);

  $("#editar-bol").click(function(){editando()});
  $("#editar-pay").click(function(){editando_card()});
  $("#editar-pag").click(function(){editando_card()});

  
  $("#pagseguro").click(function(){
	$(".alerta_bol").hide();
	$(".alerta_pay").hide(); 
	$(".alerta_pag").hide();
	  if($("#dadoPag").val() == 0)
	  {
		  $(".alerta_pag").fadeIn();
	  }else{
		$(".alerta_pag").hide();
	  }
	  $("#divpagseguro").fadeIn();
	  $("#divboleto").hide();
	  $("#divpaypal").hide();
      $("#btn-card-pag").hide();
      $("#alerta_boleto").hide();
      $("#editar-pag").fadeIn();
	  $("input").prop("readonly", true);
	
     
     
  });
  $("#boletofacil").click(function(){
	$(".alerta_bol").hide();
	$(".alerta_pay").hide(); 
	$(".alerta_pag").hide();
	  if($("#dadoBol").val() == 0)
	  {
		  $(".alerta_bol").fadeIn();
	  }else{
		$(".alerta_bol").hide();
	  }

      $("#divboleto").fadeIn();
	  $("#divpagseguro").hide();
	  $("#divpaypal").hide();
      $("#btn-bol").hide();
      $("#alerta_cartao").hide();
	  $("#editar-bol").fadeIn();
	  $("input").prop("readonly", true);
	  $("textarea").prop("readonly", true);
	
  });
  $("#paypal").click(function(){
	$(".alerta_bol").hide();
	$(".alerta_pay").hide(); 
	$(".alerta_pag").hide();
	  if($("#dadoPay").val() == 0)
	  {
		  $(".alerta_pay").fadeIn();
	  }else{
		$(".alerta_pay").hide();
	  }
	  $("#divpaypal").fadeIn();
	  $("#divboleto").hide();
	  $("#divpagseguro").hide();
      $("#btn-card-pay").hide();
      $("#alerta_boleto").hide();
      $("#editar-pay").fadeIn();
      $("input").prop("readonly", true);

  });

}
function editando(){
    $("#btn-bol").fadeIn();
    $("#editar-bol").hide();

    $("input").prop("readonly", false);
    $("textarea").prop("readonly", false);
    
}

function editando_card()
{
    $("#btn-bol").hide();
    $("#editar-bol").hide();
    $("#editar-pay").hide();
	$("#btn-card-pay").fadeIn();
	$("#btn-card-pag").fadeIn();
	$("#editar-pag").hide();

    $("input").prop("readonly", false);
    $("#valor").prop("readonly", false);
    $("#link").prop("readonly", false);
   
}

function transicoes()
{
  			$("#tipo1").prop('checked', true);
			$('input').keypress(function(e) {
			if(e.which == 13) {
			e.preventDefault();
			}
			});
			
			
			$("#verifica_socio").hide();
			$("#tipo_cartao").hide();
			$("#cartao_mensal").hide();
			$("#cartao_unica").hide();
			$("#input").hide();
			$("#pag2").hide();
			$("#pag3").hide();
			$("#cnpj").hide();
			$("#info_valor").hide();
			$("#nc").show();
			$("#jnome").hide();
			$("#form2").hide();
			$("#salvar_infos").hide();
			$("#avisoPF").hide();
			$("#avisoPJ").hide();
			
			$("#aviso").hide();
			
			
		
	    $("#cartao").click(function()
		{
			$("#doacao_boleto").hide();
			$("#tipo_cartao").fadeIn();
			$("#cartao_mensal").fadeIn();
			$("#tipoc2").prop("checked", false);
			$("#tipoc1").prop("checked", true);
			

		});
		$("#mensal_cartao").click(function(){
			$("#cartao_unica").hide();
			$("#cartao_mensal").fadeIn();
			$("#tipoc2").prop("checked", false);
			$("#tipoc1").prop("checked", true);
			
		});
		$("#unica_cartao").click(function(){
			$("#cartao_unica").fadeIn();
			$("#cartao_mensal").hide();
			$("#tipoc2").prop("checked", true);
			$("#tipoc1").prop("checked", false);
		});

		$("#dinheiro").click(function()
		{
			$("#tipo_cartao").hide();
			$("#cartao_mensal").hide();
			$("#cartao_unica").hide();
			$("#doacao_boleto").fadeIn();
			$("#tipo1").prop('checked', true);
			

		});

		$("#op_cpf").click(function()
		{
			$("#nc").show();
			$("#jnome").hide();
		    $("#cpf").fadeIn();
		    $("#cnpj").hide();  
			$("#nascimento").show();
			$("#dia").show();
			$("#mes").show();
			$("#ano").show();
			$("#avisoPF").show();
			$("#avisoPJ").hide();
			
			
		});

		$("#op_cnpj").click(function()
		{
		    $("#cpf").hide(); 
		    $("#cnpj").fadeIn();
			$("#dia").hide();
			$("#mes").hide();
			$("#ano").hide();
			$("#nascimento").hide(); 
			$("#avisoPF").hide();
			$("#avisoPJ").show();
			$("#nc").hide();
			$("#jnome").show();
		
		});  

		$("#u").click(function()
		{
		    $("#valores").hide();
			$("#input").fadeIn();
			$("#venci").hide();
			
		});


		$("#m").click(function()
		{
		    $("#valores").show();
		    $("#venci").show();
			$("#input").hide();
			
		});

		$("#avanca").click(function()
		{
			verificar();

		});

		$("#avanca2").click(function()
		{
			verifica2();
			
		});
		$("#avanca3").click(function()
		{
			verifica3();
			
		});
		$("#volta_btn").click(function(){
			$("#verifica_socio").hide(); 
			$("#pag1").fadeIn();
			$("#doacao_boleto").fadeIn();
			$("#forma").fadeIn();});

		$("#volta").click(function(){

			$("#pag2").hide();
			$("#verifica_socio").fadeIn();
			$("#verifica_socio_btn").fadeIn();
			
		});

		$("#volta2").click(function()
		{
			
			$("#pag3").hide();
			$("#pag2").fadeIn();
			
		});

}