
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

function geraFormaContribuicao(){
    //console.log('Nova geração de boleto.');
    //Enviar um post para ./model/emitirBoleto.php com as informações do CPF e do valor da doação

    let cpfCnpj;
    let url;
    let parcela = 1;
    let dia;

    if($("#op_cpf").prop('checked')){
        cpfCnpj = document.getElementById("dcpf").value;
    }else if($("#op_cnpj").prop('checked')){
        cpfCnpj = document.getElementById("dcnpj").value;
    }
    const valor = document.getElementById("v").value;

    const formaContribuicao = document.getElementById("forma-contribuicao").value;

    //Considerar posteriormente a troca para um switch case caso surjam mais formas de contribuição
    if(formaContribuicao == "boleto"){
        url = "./model/emitirBoleto.php";
    }else if(formaContribuicao == "carne"){
        url = "./model/carne.php";
        parcela = document.getElementById("input-parcelas").value;
        dia = document.querySelector("input[name='dta']:checked").value;
    }else if(formaContribuicao == "pix"){
        geraQrCode(cpfCnpj, valor);
        return;
    }else{
        alert('A forma de contribuição informada não é válida.');
        return;
    }
    
    // Desativar o clique no span
    $('#gerar_boleto').addClass('disabled');
    $('#avanca3').addClass('disabled');
    //$('#emitir_qrcode').addClass('disabled');

    
    $.post(url, {
        "dcpf": cpfCnpj,
        "valor": valor,
        "parcela": parcela,
        "dia": dia
    }).done(function(r){
        const resposta = JSON.parse(r);
        if(resposta.link){
            console.log(resposta.link);
            // Redirecionar o usuário para o link do boleto em uma nova aba
            window.open(resposta.link, '_blank');
        }else{
            alert("Ops! Ocorreu um problema na geração da sua forma de pagamento, tente novamente, se o erro persistir contate o suporte.");
        } 
    });
}

function geraQrCode(cpfCnpj, valor){
    const url = "./model/emitirQRCode.php";
    $('#avanca3').addClass('disabled');
    $('#emitir_qrcode').addClass('disabled');

    //const btn = this;
    //setLoader(btn);

    $.post(url, {
        "dcpf": cpfCnpj,
        "valor": valor
    }).done(function(r){
        const resposta = JSON.parse(r);
        if(resposta.qrcode){

            // Criar um div para centralizar o conteúdo
            let qrContainer = document.createElement("div");
            qrContainer.style.textAlign = "center";

            // Adicionar o QR Code como imagem
            let qrcode = document.createElement("img");
            qrcode.src = "data:image/jpeg;base64," + resposta.qrcode;
            qrContainer.appendChild(qrcode);

            // Adicionar um botão abaixo do QR Code
            let copyButton = document.createElement("button");
            copyButton.textContent = "Copiar Código QR";
            copyButton.style.display = "block";
            copyButton.style.marginTop = "10px";
            qrContainer.appendChild(copyButton);

            form3.appendChild(qrContainer);

            // Ajustar a largura do botão após a imagem carregar
            qrcode.onload = function() {
                copyButton.style.width = qrcode.width*(0.75) + "px";
            };

            // Rolar a página para o form3
            window.location.hash = '#form3';

            // Adicionar o evento de clique no botão para copiar o código
            copyButton.addEventListener('click', function() {
                // Criar um elemento temporário para copiar o texto
                let tempInput = document.createElement("input");
                tempInput.value = resposta.qrcode;//substituir pelo código da área de transferência
                document.body.appendChild(tempInput);

                // Selecionar e copiar o texto
                tempInput.select();
                document.execCommand("copy");

                // Remover o elemento temporário
                document.body.removeChild(tempInput);

                alert("Código QR copiado para a área de transferência!");
            });

        }else{
            alert("Ops! Ocorreu um problema na geração da sua forma de pagamento, tente novamente, se o erro persistir contate o suporte.");
        } 
    });

    //resetButton(btn);
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


