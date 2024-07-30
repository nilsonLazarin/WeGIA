
function CadastraCobrancas(carneBoletos, id,valor){
    
    var data = new Date;
    console.log(data)
    var dia = data.getDate();
    var mes = data.getMonth()+1;
    var ano = data.getFullYear();
    var Databr = ano+"-"+mes+"-"+dia;

    for(const [i, boleto] of carneBoletos.entries()){
        
        var arrayDataVencimento = boleto.dueDate.split('/');
        var diaV = arrayDataVencimento[0];
        var mesV = arrayDataVencimento[1];
        var anoV = arrayDataVencimento[2];
        var DataV = anoV+"-"+mesV+"-"+diaV;
        console.log(valor);
        
        $.post("../socio/sistema/cadastro_cobrancas_geracao.php",{
            "codigo": boleto.code,
            "descricao": "O Lar Abrigo Amor a Jesus, agradece sua contribuição ao Projeto Sócio  Amigos do Laje.Deus abençoe!",
            "id_socio": id,
            "data_vencimento": DataV,
            "data_emissao": Databr,
            "data_pagamento": '0000-00-00',
            "valor": valor,
            "valor_pago": 0.00,
            "status": "Aguardando Pagamento",
            "link_cobranca": boleto.checkoutUrl,
            "link_boleto": boleto.installmentLink,
            "linha_digitavel": boleto.billetDetails.barcodeNumber,
        }).done(function(r){
            console.log("k");
        });
    }

}   

function geraBoletoNovo(){
    console.log('Nova geração de boleto.');
    //Enviar um post para ./model/emitirBoleto.php com as informações do CPF e do valor da doação

    let cpfCnpj;
    let url;
    let parcela = 1;
    let dia = 1;

    if($("#op_cpf").prop('checked')){
        cpfCnpj = document.getElementById("dcpf").value;
    }else if($("#op_cnpj").prop('checked')){
        cpfCnpj = document.getElementById("dcnpj").value;
    }

    const boletoCarne = document.getElementById("boleto-carne").value;

    if(boletoCarne == "boleto"){
        url = "./model/emitirBoleto.php";
    }else if(boletoCarne == "carne"){
        url = "./model/carne.php";
        parcela = document.getElementById("input-parcelas").value;
        dia = document.querySelector("input[name='dta']:checked").value;
    }else{
        alert('O valor de boleto ou carne informado não é válido');
    }

    const valor = document.getElementById("v").value;
    
    // Desativar o clique no span
    $('#gerar_boleto').addClass('disabled');
    $('#avanca3').addClass('disabled');

    
    $.post(url, {
        "dcpf": cpfCnpj,
        "valor": valor,
        "parcela": parcela,
        "dia": dia
    }).done(function(r){
        const resposta = JSON.parse(r);
        if(resposta.boletoLink){
            console.log(resposta.boletoLink);
            // Redirecionar o usuário para o link do boleto em uma nova aba
            window.open(resposta.boletoLink, '_blank');
        }else{
            alert("Ops! Ocorreu um problema na geração do seu boleto, tente novamente, se o erro persistir contate o suporte.");
        } 
    });
}

function geraBoleto()
{
    $.post("./php/infoBoletoFacil.php").done(function(data)
    {
        var dado = JSON.parse(data);
        console.log(dado)
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
            console.log(api);
            console.log(dado);
            console.log("dia"+dia);
            console.log(token);
            console.log(agradecimento);
            console.log(dias_venc_unico);
            console.log(dias_venc_mensal);
            console.log(parcelas);
        
        var check;
        var id_socio;
        $.post("./php/buscaIdSocio.php",{
            "cpf": doc,
        }).done(function(resposta){
            var respostas = JSON.parse(resposta);
            id_socio = respostas['id_socio'];

        })
        carneBoletos = [];
            if($("#tipo2").prop("checked"))
            { 
                
                $.get(api+"token="+token+"&description='"+agradecimento+"'&amount="+valor+"&dueDate="+dataV+"&maxOverdueDays="+dias_venc_unico+"&payerName="+nome+"&payerCpfCnpj="+doc+"&payerEmail="+email+"&payerPhone="+telefone+"&billingAddressStreet="+rua+"&billingAddressNumber="+numero+"&billingAddressComplement="+complemento+"&billingAddressNeighborhood="+bairro+"&billingAddressCity="+cidade+"&billingAddressState="+uf+"&billingAddressPostcode="+cep+"&fine="+multa+"&interest="+juros+"&paymentTypes=BOLETO&notifyPayer=TRUE&reference="+nomerefer+numeroRandom)
                .done(function(dados){
                    cad_log(socioTipo,reference);
                    for(var boleto of dados.data.charges)
                    {
                        carneBoletos.push(boleto);
                        var check = boleto.checkoutUrl;
                    
                    }
                    CadastraCobrancas(carneBoletos,id_socio,valor);
                    carneBoletos = [];


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
                    for(var boleto of dados.data.charges)
                    {
                        carneBoletos.push(boleto);
                        var check = boleto.checkoutUrl; 
    
                    }
                    CadastraCobrancas(carneBoletos,id_socio,valor);

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
                var dataV = new Date; 
                dataV.setMonth(now.getMonth() + 2);
                var mes_atual = dataV.getMonth();
                var ano_atual = dataV.getFullYear();
                diaA = 3;
                var DataV = diaA+"/"+mes_atual+"/"+ano_atual;
                // var mesA = now.getMonth() + 2;
                return DataV;
            }
            else{
                var mesA = now.getMonth()+1;
                var anoA = now.getFullYear();
                var DataV = diaA+"/"+mesA+"/"+anoA;
                return DataV;
            }
        

        // return DataV;
    }
        else
        {
            var diaA = now.getDate();
              
                if(dia<=diaA)
                {
                    var dataV = new Date; 
                    dataV.setMonth(now.getMonth() + 2);
                    var mes_atual = dataV.getMonth();
                    var ano_atual = dataV.getFullYear();
                    var DataV = dia+"/"+mes_atual+"/"+ano_atual;
            
                    return DataV;
                    // var mes_atual = now.getMonth() + 2;
                }
                else
                {
                    // var dataV = new Date; 
                    // dataV.setMonth(now.getMonth() +1);
                    var mes_atual = now.getMonth() + 1;

                    // var mes_atual = dataV.getMonth();
                    var ano_atual = now.getFullYear();
                    var DataV = dia+"/"+mes_atual+"/"+ano_atual;
            
                    return DataV;
                    // var mes_atual = now.getMonth() + 1;
                }  
                // if(dia<=diaA)
                // {
                //     var mes_atual = now.getMonth() + 2;
                // }
                // else
                // {
                //     var mes_atual = now.getMonth() + 1;
                // }  
            // var ano_atual = now.getFullYear();
            // var DataV = dia+"/"+mes_atual+"/"+ano_atual;

            // var mes_atual = dataV.getMonth();
            // var ano_atual = dataV.getFullYear();
            // var DataV = dia+"/"+mes_atual+"/"+ano_atual;
    
            // return DataV;
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
                parcelas = (12 - mes)+ 13;
            }

        return parcelas;
}
