
function geraBoleto()
{
    $.post("./php/infoBoletoFacil.php").done(function(data)
    {
        var dado = JSON.parse(data);
        var api = dado.api;
        var token = dado.token_api;
        var agradecimento = dado.agradecimento;
        var dias_venc_unico = dado.dias_boleto_a_vista;
        var dias_venc_mensal = dado.max_dias_venc;
        var multa = dado.multa;
        var juros = dado.juros;
       
            var dia = retorna_dia();
            var valor = retorna_valor();
            var doc = retorna_doc();
            var nome = retorna_nome(doc);
            var nomerefer = retorna_nomerefer(nome);
            var dataV = retorna_dataV(dia);
            var parcelas = retorna_parecela();
            var socioTipo = tipo_socio();
        var email = $("#email").val();
        var telefone = $("#telefone").val();
        var cep = $("#cep").val();
        var rua = $("#rua").val();
        var bairro = $("#bairro").val();
        var cidade = $("#localidade").val();
        var uf = $("#uf").val();
        var numero = $("#numero").val();
        var complemento = $("#complemento").val();    
        var numeroRandom = Math.round(Math.random()*100000000);
        var reference=nomerefer+numeroRandom;
            /*console.log(api);
            console.log(token);
            console.log(agradecimento);
            console.log(dias_venc_unico);
            console.log(dias_venc_mensal);
            console.log(parcelas);*/
        
        var check;
      
            if($("#tipo2").prop("checked"))
            { 
                
                $.get(api+"token="+token+"&description='"+agradecimento+"'&amount="+valor+"&dueDate="+dataV+"&maxOverdueDays="+dias_venc_unico+"&payerName="+nome+"&payerCpfCnpj="+doc+"&payerEmail="+email+"&payerPhone="+telefone+"&billingAddressStreet="+rua+"&billingAddressNumber="+numero+"&billingAddressComplement="+complemento+"&billingAddressNeighborhood="+bairro+"&billingAddressCity="+cidade+"&billingAddressState="+uf+"&billingAddressPostcode="+cep+"&fine="+multa+"&interest="+juros+"&paymentTypes=BOLETO&notifyPayer=TRUE&reference="+nomerefer+numeroRandom)
                .done(function(dados){
                    cad_log(socioTipo,reference);
                    for(var link of dados.data.charges)
                    {
                        
                        var check = link.checkoutUrl;
                    
                    }
                    $("form").html('<div><h3>Gerado com sucesso!</h3><br><br><br><button class="mala"><a class = "botao" target="_blank" href='+check+'>EMITA SEU BOLETO AQUI</a></button> <button class="mala"><a class="botao" href="../contribuicao/index.php">VOLTAR À PÁGINA INICIAL</a></button></div>');
                    
                })
                .fail(function(){
                    alert("ERRO NO MÓDULO CONTRIBUIÇÃO: Houve um erro na requisição do boleto, entre em contato com o administrador do sistema.");
                })
            }
            else{
                $.get(api+"token="+token+"&description='"+agradecimento+"'&amount="+valor+"&dueDate="+dataV+"&maxOverdueDays="+dias_venc_mensal+"&installments="+parcelas+"&payerName="+nome+"&payerCpfCnpj="+doc+"&payerEmail="+email+"&payerPhone="+telefone+"&billingAddressStreet="+rua+"&billingAddressNumber="+numero+"&billingAddressComplement="+complemento+"&billingAddressNeighborhood="+bairro+"&billingAddressCity="+cidade+"&billingAddressState="+uf+"&billingAddressPostcode="+cep+"&fine="+multa+"&interest="+juros+"&paymentTypes=BOLETO&notifyPayer=TRUE&reference="+nomerefer+numeroRandom)
                .done(function(dados){
                    cad_log(socioTipo, reference);
                    for(var link of dados.data.charges)
                    {
                        
                        var check = link.checkoutUrl; 
    
                    }
                    $("form").html('<div><h3>Gerado com sucesso!</h3><br><br><br><button class="mala"><a class="botao" target="_blank" href='+check+'>EMITA SEU BOLETO AQUI</a></button> <button class="mala"><a class = "botao" href="../contribuicao/index.php">VOLTAR À PÁGINA INICIAL</a></button></div>');
                    
                })
                .fail(function(){
                    alert("ERRO NO MÓDULO CONTRIBUIÇÃO: Houve um erro na requisição do boleto, entre em contato com o administrador do sistema.");
                })
            }
    });
}

function retorna_valor(){

    if ($(".input-donation-method").val() != "") {
        var valor = $(".input-donation-method").val();
    }
    
    if($("#tipo1").prop('checked')) {

        var valor = $("#vm").val();
                
    } else {
        valor = $("#v").val();
    }
    
    return valor;
}

function retorna_doc()
{
    if($("#op_cpf").prop('checked'))
    {
        var doc = $("#dcpf").val();
    }
    else
        {
            doc = $("#dcnpj").val();
        }

        return doc;
}

function retorna_nome(doc){
    doc = doc.replace(/\D/g, '');
        var tam = doc.length;
            if (tam == 11) {
                var nome = $("#nome").val();
            }
            else 
            {
                if (tam == 14) {
                    nome = $("#cnpj_nome").val();
                }
            }
        return nome;
}
function retorna_nomerefer(nome)
{
    var nome = nome.replace(/[^a-zA-Zs]/g, "");
    nome = nome.replace(" ",",");
    return nome;
}

function retorna_dataV(dia)
{
    var dia = dia;
    var now = new Date;
    if($("#tipo2").prop("checked")) 
    {
        var diaA = now.getDate() +3;
            if(dia == 29 || dia == 30 || dia == 31)
            {
                diaA = 3;
                var mesA = now.getMonth() + 2;
            }
        var mesA = now.getMonth()+1;
        var anoA = now.getFullYear();
        var DataV = diaA+"/"+mesA+"/"+anoA;

        return DataV;
    }
        else
        {
            var diaA = now.getDate();
                if(dia<=diaA)
                {
                    var mes_atual = now.getMonth() + 2;
                }
                else
                {
                    var mes_atual = now.getMonth() + 1;
                }  

            var ano_atual = now.getFullYear();
            var DataV = dia+"/"+mes_atual+"/"+ano_atual;
    
            return DataV;
        }
            
}

function retorna_parecela()
{
    var now = new Date;
    var mes = now.getMonth() + 1;
   

    var parcelas = 0;
        if(mes <=6)
        {
            parcelas = 13 - mes;
        }
        else
            {
                parcelas = (12 - mes)+ 12;
            }

        return parcelas;
}
