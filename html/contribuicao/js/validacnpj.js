function cnpj() 
{
        var cnpj = $("#dcnpj").val();    
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
            $("#avisa_cnpj").html("");
            $("#doacao_boleto").hide();
            $("#pag2").hide();
            $("#pag3").fadeIn();
        }
 }