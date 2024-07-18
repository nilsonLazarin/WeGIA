<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta charset="UTF-8">
</head>
<body>
    <form action="model/carne.php" method="POST">
        <div id="verifica_socio" class="wrap-input100">
            <input class = "radio" type="radio" id="op_cpf" value="fisica" name="opcao" onblur="fisjur(f2.opcao)" checked><label  class="label" for = "op_cpf">PESSOA FÍSICA</label>
                        
            <div id="cpf" class="wrap-input100 validate-input bg1" data-validate = "Digite um documento válido!">
                <span class="label-input100">Digite um documento CPF*</span>
                <input class="input100" type="text" name="dcpf" id="dcpf" class="text required"placeholder="Ex: 222.222.222-22"  onkeypress="return Onlynumbers(event)" onkeyup="mascara('###.###.###-##',this,event)" required><span id = "avisa_cpf"></span>
            </div>
            <label for="d">Dia</label>
            <input type="number" name="dia" min="1" max=20>
            <br>

            <label for="">valor</label>
            <input type="number" name="valor" min="30" required>
            <br>

            <label for="parce">Mensalidades</label>
            <input type="number" name="parcela" min="1" max="24">
            <input type="submit" value="avançar">
        </div>
    </form>
</body>
</html>


