function valida_data(){
	
	var now = new Date();
	var year=now.getFullYear();
	var month=now.getMonth() +1;
	var day=now.getDate();
	function limpaAviso()
	{
		$("#aviso_data").text("");
	}
	limpaAviso();
		var dia=$("#dia").val();
		var mes=$("#mes").val();
		var ano=$("#ano").val();
			if(ano==year)
			{
				if(mes>month)
				{
					$("#aviso_data").text("Insira uma data válida");
					
				}
				else
				{
					if(mes==month)
					{
						if(dia>day)
						{
							$("#aviso_data").html("Insira uma data válida");
						}
					}
				}
			}
		}
