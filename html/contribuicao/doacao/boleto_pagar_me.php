<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta charset="UTF-8">
</head>
<body>
    <form action="model/emitirBoleto.php" method="POST">
        <div id="verifica_socio" class="wrap-input100">
            <input class = "radio" type="radio" id="op_cpf" value="fisica" name="opcao" onblur="fisjur(f2.opcao)" checked><label  class="label" for = "op_cpf">PESSOA FÍSICA</label>
                        
            <div id="cpf" class="wrap-input100 validate-input bg1" data-validate = "Digite um documento válido!">
                <span class="label-input100">Digite um documento CPF*</span>
                <input class="input100" type="text" name="dcpf" id="dcpf" class="text required"placeholder="Ex: 222.222.222-22"  onkeypress="return Onlynumbers(event)" onkeyup="mascara('###.###.###-##',this,event)" required><span id = "avisa_cpf"></span>
            </div>
            <select name="dia">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>

            <input type="number" name="valor" min="30" required>
        
            <input type="submit" value="avançar">
        </div>
    </form>
</body>
</html>


