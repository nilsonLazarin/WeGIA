
function gera_boleto(){

    $.post("./php/infoboletofacil.php").done(function(data)
    { 
     
        var dado = JSON.parse(data);
        var api = dado['API'];
        var token = dado['token'];
        var agradecimento = dado['agradecimento'];
        var dias_unico = dado['maxOverDays_Unico'];
        var dias_mensal = dado['maxOverDueDays_carne'];

        var dia = retorna_dia();
            if($("#tipo1").prop('checked'))
            {
                var valor2 = $("#valores option:selected").val();
                
            }
            else
            {
                valor2 = $("#v").val();
            }
        var cpf = $("#dcpf").val();
        var cnpj = $("#dcnpj").val();
            if(cpf == '')
            {
                var doc = cnpj;
                var nome = $("#cnpj_nome").val();
            }
            else
            {
                doc = cpf;
                nome = $("#nome").val();
                sobrenome = $("#sobrenome").val();
            }
        var doc = doc.replace(/\D/g, '');
        var email = $("#email").val();
        var telefone = $("#telefone").val();
        var cep = $("#cep").val();
        var log = $("#rua").val();
        var bairro = $("#bairro").val();
        var cidade = $("#localidade").val();
        var uf = $("#uf").val();
        var n = $("#numero").val();
        var comp = $("#complemento").val();    
        var now = new Date;
        var diaA = now.getDate() +3;
        var mesA = now.getMonth()+1;
        var anoA = now.getFullYear();
        var diaAv = diaA+"/"+mesA+"/"+anoA;
    
            if(dia<=diaA)
            {
                var mes_atual = now.getMonth() + 2;
            }
            else
            {
                var mes_atual = now.getMonth() + 1;
            }

        var ano_atual = now.getFullYear();
        var dataV = dia+"/"+mes_atual+"/"+ano_atual;
    
        var parcelas = 0;
            if(mes_atual <=6)
            {
                parcelas = 13 - mes_atual;
            }
            else
            {
                parcelas = (12 - mes_atual)+ 12;
            }
    
        var check;

            if($("#tipo2").prop("checked"))
            {
                $.get(api+"token="+token+"&description="+agradecimento+"&amount="+valor2+"&payerName="+nome+"&payerCpfCnpj="+doc+"&dueDate="+diaAv+"&payerPhone="+telefone+"&payerEmail="+email+"&billingAddressState="+uf+"&billingAddressCity="+cidade+"&billingAddressNeighborhood="+bairro+"&billingAddressPostcode="+cep+"&billingAddressStreet="+log+"&billingAddressNumber="+n+"&billingAddressComplement="+comp+"&paymentTypes=BOLETO&maxOverdueDays="+dias_unico, function(dados){

                for(var link of dados.data.charges)
                {
                    var check = link.checkoutUrl;
                   
                }
                $("form").html('<div><h3>OBRIGADO PELA SUA DOAÇÃO! VOCÊ ESTÁ AJUDANDO A MANTER ESSA INSTITUIÇÃO QUE ABRIGA IDOSOS DESDE 1929!</h3><br>ESSE É O <button class="mala"><a target="_blank" href='+check+'>LINK</a></button> PARA A EMISSÃO DO SEU BOLETO</div>');
                });
            }
            else
            {
                $.get(api+"token="+token+"&description="+agradecimento+"&installments="+parcelas+"&amount="+valor2+"&payerName="+nome+sobrenome+"&payerCpfCnpj="+doc+"&dueDate="+dataV+"&payerPhone="+telefone+"&payerEmail="+email+"&billingAddressState="+uf+"&billingAddressCity="+cidade+"&billingAddressNeighborhood="+bairro+"&billingAddressPostcode="+cep+"&billingAddressStreet="+log+"&billingAddressNumber="+n+"&billingAddressComplement="+comp+"&paymentTypes=BOLETO&maxOverdueDays="+dias_mensal, function(dados){
                for(var link of dados.data.charges)
                {
                   
                    var check = link.checkoutUrl; 
                    
                }
                $("form").html('<div><h3>OBRIGADO PELA SUA DOAÇÃO! OBRIGADO PELA SUA DOAÇÃO! VOCÊ ESTÁ AJUDANDO A MANTER ESSA INSTITUIÇÃO QUE ABRIGA IDOSOS DESDE 1929!</h3><br>ESSE É O <button class="mala"><a target="_blank" href='+check+'>LINK</a></button> PARA A EMISSÃO DO SEU BOLETO</div>');
                });
            }
    });
}