function validacpf()
    {
            var strcpf = $("#dcpf").val();
            var strcpf = strcpf.replace(/[^\d]+/g,'');

            var soma = 0;
            var resto;
            var aux = false;

            for (var i = 1; strcpf.length > i; i++) { 
            if (strcpf[i - 1] != strcpf[i]) {  
                aux = true;   
            } 
        } 
        
        if (aux == false) {  
           $("#avisa_cpf").html("Digite um documento cpf válido, por favor");
        }
            
        if(strcpf.length != 11)
        {
            $("#avisa_cpf").html("Digite um documento cpf válido, por favor");
        }

            //primeiro dígito
            for(var i = 0; i <= 9; i++)
            {
                soma = soma + parseInt((strcpf.substring(i-1, i)) * (11 - i));
            }
            resto = (soma*10)%11;
            if(resto == 10 || resto == 11)
            resto = 0;

            if(resto == strcpf.charAt(9))
            {
                var ok = 1;
            }
            // fim verificacao primeiro digito

            //verificacao segundo digito

            var soma2 = 0;
            var resto2;
            for(var j = 0; j <=10; j++)
            {
                soma2 = soma2 + parseInt((strcpf.substring(j-1, j))* (12 - j));
            }
            resto2 = (soma2*10)%11;
            if(resto2 == 10 || resto2 == 11)
            resto2 = 0;

            if(resto2 == strcpf.charAt(10))
            {
                var ok2 = 1;
            }
            
            // fim verificacao segundo digito


            var verificador = parseInt(ok+ok2);
            
        
            if(verificador == 2)
            {
                
                $("#avisa_cpf").hide();
                $("#doacao_boleto").hide();
                $("#pag2").hide();
                $("#pag3").fadeIn();
            }
            else
            {
                $("#avisa_cpf").show();
                $("#avisa_cpf").html("Digite um cpf válido");
                
            }
        
    }
