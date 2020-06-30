<html>
 <head>
 	<meta charset="UTF-8">
  	<title>Instalador</title>
  	<link rel="stylesheet" type="text/css" href="css/theme.css">
  	<script type="text/javascript">
  		function validarForm(){
  			var nomebd = document.getElementsByName("nomebd")[0].value.trim();
  			var local = document.getElementsByName("local")[0].value.trim();
  			var usuario = document.getElementsByName("usuario")[0].value.trim();

  			if(nomebd == ''){alert("campo 'banco de dados' não preenchido");return false};
  			if(local== ''){alert("campo 'Local' não preenchido");return false};
  			if(usuario == ''){alert("campo 'Usuario' não preenchido");return false};
  	
  			nomebd = nomebd.replace(/ /g, '_');
  			document.getElementsByName("nomebd")[0].value = nomebd;
  			document.getElementsByName("local")[0].value = local;
  			//document.getElementsByName("usuario")[0].value = usuario;
  			return true;
  		}

  	</script>
 </head>
 <body>
	<form action="instalador.php" onsubmit="return validarForm()" method="post">
		<h5 class="required">Campos Obrigatórios: (*)</h5>
		<label for="nomebd"><span class="required">*</span>Banco de Dados: </label>
		<input type="text" name="nomebd" value="wegia" required> 

		<label for="local"><span class="required">*</span>Local: </label>
		<input type="text" name="local" value="localhost" required> 

		<label for="backup"><span class="required">*</span>Local de Backup: </label>
		<input type="text" name="backup" placeholder="/pasta/de/backup/" required> 

		<label for="usuario"><span class="required">*</span>Usuario: </label>
		<input type="text" name="usuario" value="root" required>

		<label for="senha"><span class="required"></span>Senha: </label>
		<input type="password" name="senha">
		
		<p><input type="checkbox" name="reinstalar" value="">Reinstalar base de dados</p>

		<input type="submit" value="Instalar">
	</form>
 </body>
</html>