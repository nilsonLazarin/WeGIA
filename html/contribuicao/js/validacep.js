function valida_cep(){
	var url="https://viacep.com.br/ws/";
	var saida="";
	function limpaformulario() {
		$("#cep").val("");
		$("#rua").val("");
		$("#complemento").val("");
		$("#bairro").val("");
		$("#localidade").val("");
		$("#uf").val("");
		}
	function limpaavisos() {
		$("#lista").html("");
		$("#aviso").html("");
		$("#aviso2").html("");
	}
	limpaavisos();
	//elimina tudo que não é dígito
	var cep=$("#cep").val().replace(/\D/g, '');
	if(cep!="")
	{
		var validacep=/^[0-9]{8}$/;

		if(validacep.test(cep))
		{
			$.get(url+cep+"/json/", function(dados){
				if(!("erro" in dados))
				{
					console.log(dados.logradouro);
					$("#rua").val(dados.logradouro);
					$("#rua").attr("info", dados.logradouro);
					$("#complemento").val(dados.complemento);
					$("#complemento").attr("info", dados.complemento);
					$("#bairro").val(dados.bairro);
					$("#bairro").attr("info", dados.bairro);
					$("#localidade").val(dados.localidade);
					$("#localidade").attr("info", dados.localidade);
					$("#uf").val(dados.uf);
					$("#uf").attr("info", dados.uf);
				}
				else
				{
					$("#cep").parent().attr("placeholder", "CEP não encontrado");
					$("#cep").parent().removeClass("true-validate");
					$("#cep").parent().addClass("alert-validate");
					$("#cep").after("<span class='btn-hide-validate'></span>");
					limpaformulario();
				}
			});
		}
		else
		{
			$("#cep").parent().attr("placeholder", "Formato do CEP inválido");
			$("#cep").parent().removeClass("true-validate");
			$("#cep").parent().addClass("alert-validate");
			$("#cep").after("<span class='btn-hide-validate'></span>");
			limpaformulario();
		}
	}
	else
	{
		limpaformulario();
	}
}

function valida_endereco(){
	console.log("1");
	var saida="";
	var url="http://viacep.com.br/ws/";
	/*function limpaformulario() {
		$("#cep").val("");
		$("#rua").val("");
		$("#complemento").val("");
		$("#bairro").val("");
		$("#localidade").val("");
		$("#uf").val("");
	}
	function limpaavisos() {
		$("#lista").html("");
	}
	limpaavisos();*/
	var rua=$("#rua").val();
	var rua_info=$("#rua").attr("info");
	var localidade=$("#localidade").val();
	var localidade_info=$("#localidade").attr("info");
	var uf=$("#uf").val();
	var uf_info=$("#uf").attr("info");
	if(rua!="" && localidade!="" && uf!="" && (uf!=uf_info || rua!=rua_info || localidade!=localidade_info))
	{
		console.log("2");
		console.log("oi");
		if(rua.length>=3 && localidade.length>=3)
		{
		console.log("3");
		console.log("oi");
		var teste=url+uf+"/"+localidade+"/"+rua+"/json/";
		//console.log(teste);
		$.get(url+uf+"/"+localidade+"/"+rua+"/json/", function(ceps){
			console.log("4");
			if(ceps=='')
			{
				console.log("5");
				$("#rua").parent().attr("data-validate", "Endereço não encontrado");
				$("#rua").parent().removeClass("true-validate");
				$("#rua").parent().addClass("alert-validate");
				//console.log($("#rua").parent());

				//$("#rua").after("<span class='btn-hide-validate'></span>");
			}
			/*for(var cep of ceps)
			{
				console.log("6");
				//limpaformulario();
				var logradouro_atributo=cep.logradouro.replace(/ /g, '_');
				var bairro_atributo=cep.bairro.replace(/ /g, '_');
				var localidade_atributo=cep.localidade.replace(/ /g, '_');
				var uf_atributo=cep.uf.replace(/ /g, '_');
				console.log(logradouro_atributo);
				saida+="<div class=endereco val_cep="+cep.cep+" val_rua="+logradouro_atributo+" val_bairro="+bairro_atributo+" val_localidade="+localidade_atributo+" val_uf="+uf_atributo+">";
				saida+="<span class=cep>CEP: "+cep.cep+"</span><br>";
				saida+="<span class=rua>Rua: "+cep.logradouro+"</span><br>";
				saida+="<span class=bairro>Bairro: "+cep.bairro+"</span><br>";
				saida+="<span class=localidade>Cidade: "+cep.localidade+"</span><br>";
				saida+="<span class=uf>UF: "+cep.uf+"</span><br><br>";
				saida+="</div>"

				$("#lista").html(saida);
				$("#cep").removeAttr("data-validate");
			}*/
			$(".endereco").click(function(){
				console.log("7");
				var rua_saida=$(this).attr("val_rua");
				var rua_final=rua_saida.replace(/_/g," ");
				var bairro_saida=$(this).attr("val_bairro");
				var bairro_final=bairro_saida.replace(/_/g," ");
				var localidade_saida=$(this).attr("val_localidade");
				var localidade_final=localidade_saida.replace(/_/g," ");
				var uf_saida=$(this).attr("val_uf");
				var uf_final=uf_saida.replace(/_/g," ");
				$("#cep").val($(this).attr("val_cep"));
				$("#rua").val(rua_final);
				$("#bairro").val(bairro_final);
				$("#localidade").val(localidade_final);
				$("#uf").val(uf_final);
				$("#lista").text("");
			});
		});
		}
		else{
			console.log("8");
		$("#rua").parent().attr("data-validate", "Especifique mais pos seus dados");
		$("#rua").parent().removeClass("true-validate");
		$("#rua").parent().addClass("alert-validate");
		//console.log($("#rua").parent());
		//$("#rua").after("<span class='btn-hide-validate'></span>");
		}
	}
}
