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
		<label for="nomebd">Banco de Dados: </label>
		<input type="text" name="nomebd" value="wegia"> 

		<label for="local">Local: </label>
		<input type="text" name="local" value="localhost"> 

		<label for="usuario">Usuario: </label>
		<input type="text" name="usuario" value="root">

		<label for="senha">Senha: </label>
		<input type="password" name="senha">
		
		<p><input type="checkbox" name="reinstalar" value="">Reinstalar base de dados</p>

		<input type="submit" value="instalar">
	</form>
 </body>
</html>