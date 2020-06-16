function cartaodunica(){
    $.post("./php/links_unico.php").done(function(data)
		{
			
			var dados = data.split(":");
			var paypal = dados[1];
			var pag = dados[2];
			paypal = paypal.split("//");
			paypal = paypal[1];
			paypal = "https://"+paypal;
			pag = pag.split("//");
			pag = pag[1];
			pag = "https://"+pag;

			console.log(dados);
			$("#paypal").html("<a href="+paypal+"><img width='20%' src='./php/paypal.webp' alt='Faça doações com o PayPal'></a>");
			$("#pagseguro").html("<a href="+pag+"><img width='20%' src='./php/pagseguro.png' alt='Faça doações com o PagSeguro'></a>");
			
		});
}
