function atualiza(){

 
  $("#alerta_boleto").hide();
  $("#alerta_cartao").hide();
  $("#cartao").hide();
  $("#insere_doacao_mensal").hide();
  $("#btn-bol").hide();
  $("#btn-card").hide();
  $("#alerta_cartao").hide();
  $('#foo').hide();

  
  $("#btn-bol").click(function(){
      $('#foo').fadeIn();
      setTimeout(function () {
          $('#foo').hide(); 
      }, 99000);
  });
  $("#btn-card").click(function(){
      $('#foo').fadeIn();
      setTimeout(function () {
          $('#foo').hide(); 
      }, 99000);
  });

  var id = retorna_id("boletofacil");
  $("#header").load("../../header.php");
  $(".menuu").load("../../menu.php");
  $("input").prop("readonly", true);

  $("#editar-bol").click(function(){editando()});
  $("#editar-card").click(function(){editando_card()});
  
  $("#pagseguro").click(function(){ 
      
      var id = retorna_id('pagseguro');
      $("#boleto").hide();
      $("#cartao").fadeIn();
      $("#btn-card").hide();
      $("#alerta_boleto").hide();
      $("#editar-card").fadeIn();
      $("#valor").prop("readonly", true);
      $("#link").prop("readonly", true);
     
     
  });
  $("#boletofacil").click(function(){
     
     var id = retorna_id("boletofacil");
      $("#boleto").fadeIn();
      $("#cartao").hide();
      $("#btn-bol").hide();
      $("#alerta_cartao").hide();
      $("#editar-bol").fadeIn();
  });
  $("#paypal").click(function(){ 

      var id = retorna_id("paypal");
      $("#boleto").hide();
      $("#cartao").fadeIn();
      $("#btn-card").hide();
      $("#alerta_boleto").hide();
      $("#editar-card").fadeIn();
      $("#valor").prop("readonly", true);
      $("#link").prop("readonly", true);

  });
  $("#widepay").click(function(){
      
      var id = retorna_id("widepay");
      $("#boleto").fadeIn();
      $("#cartao").hide();
      $("#alerta_cartao").hide();
      $("#btn-bol").hide();
      $("#editar-bol").fadeIn();
  });


}

function transicoes()
{
  $("#tipo1").prop('checked', true);
			$('input').keypress(function(e) {
			if(e.which == 13) {
			e.preventDefault();
			}
			});
		
			preenche_campo();
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
			$("#sobrenome").show();
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
			$("#sobrenome").hide();
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
		$("#volta_btn").click(function(){$("#verifica_socio").hide(); $("#pag1").fadeIn();
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