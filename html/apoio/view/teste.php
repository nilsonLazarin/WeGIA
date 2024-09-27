<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste sócio por documento</title>
</head>
<body>
    <form action="../controller/control.php" method="get">
        <input type="hidden" name="nomeClasse" value="SocioController">
        <input type="hidden" name="metodo" value="buscarPorDocumento">
        <input type="text" name="documento" id="documento" placeholder="Insira aqui o documento do sócio">
        <button type="submit">Testar</button>
    </form>
</body>
</html>