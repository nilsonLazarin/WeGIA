function valida_email()
{
	var email=$("#email").val();
	var usuario=email.substring(0, email.indexOf("@"));
	var dominio=email.substring(email.indexOf("@") +1, email.length);
	console.log(dominio.indexOf("."));
	if(email!=0)
	{
	if((usuario.length<1) || 
	(dominio.length<3) ||
	(usuario.search("@")!=-1) ||
    (dominio.search("@")!=-1) ||
    (usuario.search(" ")!=-1) ||
    (dominio.search(" ")!=-1) ||
    (dominio.search(".")==-1) ||     
    (dominio.indexOf(".")<1) ||
    (dominio.lastIndexOf(".") >= dominio.length - 1))
	{
		$("#aviso_email").html("Email inválido");
	}
	else
		$("#aviso_email").html("");
}
}