<html>
 <head>
  <title>Instalador</title>
  <link rel="stylesheet" type="text/css" href="css/theme.css">
 </head>
 <body>

	<form action="instalador.php" method="post">
		<label for="local">Local: </label>
		<input type="text" name="local" value="localhost"> 

		<label for="usuario">Usuario: </label>
		<input type="text" name="usuario" value="root">

		<label for="senha">Senha: </label>
		<input type="password" name="senha">

		
		<p><input type="checkbox" name="reinstalar" value="">Reinstalar base de dados</p>

		<input type="submit" value="enviar">
	</form>
 </body>
</html>