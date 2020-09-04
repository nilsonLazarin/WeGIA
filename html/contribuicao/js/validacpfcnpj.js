function cpf_cnpj(doc) 
{
    var doc = doc;
    var documento = doc.replace(/\D+/g, '');
    var tam = documento.length;
    if (tam >= 11) {
        validacpf(doc);
    }
    else {
        if (tam >= 14) {
            cnpj(doc);
        }
    }
}

function validacpf(doc)
    {
           
            var strcpf = doc;
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
                socio_cadastrado(doc);
                /*$("#doacao_boleto").hide();
                $("#pag2").hide();
                $("#pag3").fadeIn();*/
                
            }
            else
            {
                $("#avisa_cpf").show();
                $("#avisa_cpf").html("Digite um cpf válido");
            }
        
    }
    function cnpj(doc) 
    {
            var cnpj = doc;   
            cnpj = cnpj.replace(/\./g, '');
            cnpj = cnpj.replace('-', '');
            cnpj = cnpj.replace('/', ''); 
            //cnpj = cnpj.split(''); 
            //console.log(cnpj);
            
            var v1 = 0;
            var v2 = 0;
            var aux = false;
            var d1 = 1;
            var d2 = 1;
            if(cnpj == '')
            {
    
            }
            if(cnpj.length > 1 || cnpj.length <14)
            {
                $("#avisa_cnpj").html("Digite um documento cnpj válido, por favor");
            }
            
            for (var i = 1; cnpj.length > i; i++) { 
                if (cnpj[i - 1] != cnpj[i]) {  
                    aux = true;   
                } 
            } 
            
            if (aux == false) {  
               $("#avisa_cnpj").html("Digite um documento cnpj válido, por favor");
            }
    
            //verifica primeiro digito
    
            var p1 = 5;
            var p2 = 13;
            for (var i = 0; (cnpj.length - 2) > i; i++, p1--, p2--) {
                if (p1 >= 2) {  
                    v1 += cnpj[i] * p1;  
                } else {  
                    v1 += cnpj[i] * p2;  
                } 
            } 
            
            v1 = (v1 % 11);
            
            if (v1 < 2) { 
                v1 = 0; 
            } else { 
                v1 = (11 - v1); 
            } 
            
            if (v1 != cnpj[12]) {  
                  d1 = 0;
            } 
            
    
            var p1 = 6;
            var p2 = 14;
            for (var i = 0; (cnpj.length - 1) > i; i++, p1--, p2--) { 
                if (p1 >= 2) {  
                    v2 += cnpj[i] * p1;  
                } else {   
                    v2 += cnpj[i] * p2; 
                } 
            }
            
            v2 = (v2 % 11); 
            
            if (v2 < 2) {  
                v2 = 0;
            } else { 
                v2 = (11 - v2); 
            } 
            
            if (v2 != cnpj[13])
            {   
                d2 = 0;
            }
               
    
            if((d1+d2) != 2)
            {
               
            }
            else
            {
                /*$("#avisa_cnpj").html("");
                $("#doacao_boleto").hide();
                $("#pag2").hide();
                $("#pag3").fadeIn();*/
                socio_cadastrado(doc);
            }
     }