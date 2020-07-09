function valida_telefone()
{
	var telefone=$("#telefone").val().replace(/\D/g, '');
	var validatelefone=/^[1-9]{2}(([2-8]{1}[0-9]{7})|(9[1-9]{1}[0-9]{7}))$/;
	if(telefone.length!=0)
	{
	if(validatelefone.test(telefone))
	{
	}
	else
	{
		$("#telefone").parent().attr("data-validate", "Telefone não encontrado");
		$("#telefone").parent().removeClass("true-validate");
		$("#telefone").parent().addClass("alert-validate");
	}
}
}
