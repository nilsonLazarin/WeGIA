function opcao_genero(genero){
	if($("#outro").prop("checked")){
		$("#nome_genero").html("<input type=text id=input_genero onblur=verifica(f2.inputgenero)>");
	}
	else{
		$("#nome_genero").html("");
	}
}

function fisjur(){
	if($("#op_cnpj").prop("checked")){
		$("#resul_opcao").html("CNPJ:");
		$("#resul_cnpj").hide();
	}
	else{
		$("#resul_opcao").html("CPF:");
		$("#resul_cnpj").show();
	}

}


