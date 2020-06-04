
function cpfcnpj(doc)
{
    var val = $("#doc").val();
    console.log(val);
    var val = val.replace(/\D+/g, '');
    
        if(val == '')
        {
            
        }
        else{
                if(val.length < 11)
                {
                    $("#cpf").attr("data-validate", "Digite um CPF ou CNPJ válido!");
                    $("#avisa_cpf").html("Digite um documento válido");
                }
                else
                {
                    if(val.length > 11)
                    {
                        $("#doc").attr("data-validate", "Digite um CPF ou CNPJ válido!");
                        $("#avisa_cpf").html("Digite um documento");
                    }
                    else
                    {
                        if(val.length < 14)
                        {
                            $("#doc").attr("data-validate", "Digite um CPF ou CNPJ válido!");
                            $("#avisa_cpf").html("Digite um documento");
                        }
                    }
                }
             }
    
    if(val.length == 11)
    {
        valida(val);
    }
    else 
    {
        if(val.length >= 14)
        validacnpj(val);
    }  
}
    function valida(strcpf)
    {
            var strcpf = $("#doc").val();
            var strcpf = strcpf.replace(/[^\d]+/g,'');

            var soma = 0;
            var resto;

            if(strcpf == '11111111111' || strcpf == '00000000000')
            $("#avisa_cpf").html("Digite um cpf válido");
            

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
                verificarr();
            }
            else
            {
                $("#avisa_cpf").show();
                $("#avisa_cpf").html("Digite um cpf válido");
                
            }
        
    }

    
    function validacnpj(val)
    {

            var strcnpj = val;

            /*if(strcnpj.length > 14)
            {
                alert("Digite um cnpj válido");
            }*/

            var v1 = 0;
            var v2 = 0;
            var aux = false;
            var f = 0;
            var v = 0;

            for (var i = 1; strcnpj.length > i; i++)
            {
                if(strcnpj[i - 1] != strcnpj[i])
                {
                    aux = true;
                }
            }


            //Bloco de verificação

            var p1 = 5;
            var p2 = 13;

            //o for multiplica e soma os digitos
            for(var i = 0; (strcnpj.length - 2) > i; i++)
            {
                p1--;
                p2--;

                if(p1 >= 2)
                {
                    v1+= strcnpj[i] * p1;   
                }
                else
                {
                    v1 += strcnpj[i] * p2;
                }
            }
            
            v1 = (v1 % 11);
            
                if(v1 < 2)
                {
                    v1 = 0;
                }
                else
                {
                    v1 = (11 - v1);    
                }

            if(v1 != strcnpj[12])
            {
                f = 0;
            }
            else
            {
                f = 1;
            }

            //verificacao segundo digito
            
            var p3 = 6;
            var p4 = 14;

            for(var i = 0; (strcnpj.length - 1) > i; i++)
            {
                p3--;
                p4--;

                if(p3 >= 2)
                {
                    v2 += strcnpj[i] * p3;
                }
                else
                {
                    v2 += strcnpj[i] * p4;
                }
            }
        
            v2 = (v2 % 11)
            
                if(v2 < 2)
                {
                    v2 = 0;
                }
                else
                {
                    v2 = (11 - v2);
                }
                
            if(v2 != strcnpj[13])
            {
                f = 0;
            }
            else
            {
                f = 1;
            }

            if(f == 0)
            {
                $("#avisa_cpf").html("Digite um cnpj válido");
            }      
            else
            {
                verificarr();
            }            
    }

        


