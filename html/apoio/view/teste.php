<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste modificação</title>
</head>
<body>
    <form action="../controller/control.php" method="post">
        <input type="hidden" name="nomeClasse" value="ContribuicaoLogController">
        <input type="hidden" name="metodo" value="criarCarne">
        <input type="number" name="parcelas" id="parcelas" placeholder="Insira aqui a quantidade de parcelas">
        <input type="number" name="dia-vencimento" id="dia-vencimento" placeholder="Insira aqui o dia de vencimento">
        <input type="number" name="valor" id="valor" placeholder="Insira aqui o valor">
        <input type="text" name="documento_socio" id="documento_socio" placeholder="Insira aqui o documento do sócio">
        <button type="submit">Testar</button>
    </form>
</body>
</html>