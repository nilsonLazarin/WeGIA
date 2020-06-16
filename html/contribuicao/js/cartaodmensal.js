function cartaodmensal(){
	$.post("./php/cartaomensal.php").done(function(data)
		{
			console.log("oi no cartaodmensal");
			var dados = data.split(",");
			var trinta = dados[0];
			var quarenta = dados[1];
			var cinquenta = dados[2];
			var cem = dados[3];

			console.log(dados);
			$("#trinta").html("<a href="+trinta+">R$30,00</a>");
			$("#quarenta").html("<a href="+quarenta+">R$40,00</a>");
			$("#cinquenta").html("<a href="+cinquenta+">R$50,00</a>");
			$("#cem").html("<a href="+cem+">R$100,00</a>");
			
		});
}