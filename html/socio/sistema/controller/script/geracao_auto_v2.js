$(document).ready(function(){

    // Geração para sócio único
    function procurar_desejado(id_socio){
        $.post("./controller/query_geracao_auto.php", {
            "query": `SELECT * FROM socio s JOIN pessoa p ON p.id_pessoa = s.id_pessoa WHERE s.id_sociostatus NOT IN (1,2,3,4) AND s.id_socio = ${id_socio}`
        })
            .done(function(dados){
                var socios = JSON.parse(dados);
                console.log(socios[0].nome);
                if(socios){


                    function formatarDataBr(data){
                        var split = data.split('-');
                        data_formatada = split[2] + "/" + split[1] + "/" + split[0];
                        return data_formatada;
                    }

                    $(".configs_unico").css("display", "block");
                    $("#btn_geracao_unica").attr("disabled", false);
                    $(".div_btn_gerar").css("display", "block");
                    $("#btn_geracao_unica").text("Confirmar geração");                    

                    $("#btn_confirma").click(function(){
                        var data_vencimento = $("#data_vencimento").val();
                        var tipo_boleto = $("#tipo_geracao").val();
                        var valor = $("#valor_u").val();
                        var parcelas = $("#num_parcelas").val();

                        if(data_vencimento == null || tipo_boleto == null || valor == null || parcelas == null || parcelas == 0)
                        {
                            alert("Dados Inválidos! Tente Novamente.");
                        }
                        else{
                            // var dataFormatada = data_vencimento.toLocaleDateString('pt-BR', {timeZone: 'UTC'});
                            // console.log(dataFormatada);
                            montaTabelaInicial(data_vencimento, formatarDataBr(data_vencimento), tipo_boleto, parcelas, valor, socios[0].nome);

                        }
                        // montaTabelaInicial('2021-12-20', '20-12-2021', 0, 5, 100, socios[0].nome);
                        
                        // console.log(returnData());
                    })

                    function montaTabelaInicial(data_inicial, data_inicial_br, periodicidade_socio, parcelas, valor, nome_socio){
                            
                        function dataAtualFormatada(data_r){
                            var data = new Date(data_r),
                                dia  = data.getDate().toString(),
                                diaF = (dia.length == 1) ? '0'+dia : dia,
                                mes  = (data.getMonth()+1).toString(), //+1 pois no getMonth Janeiro começa com zero.
                                mesF = (mes.length == 1) ? '0'+mes : mes,
                                anoF = data.getFullYear();
                            return diaF+"/"+mesF+"/"+anoF;
                        }

                        console.log("perio"+periodicidade_socio);
                        valor = parseFloat(valor);
                        $(".detalhes_unico").html("");
                        $("#btn_wpp").off();
                        $("#btn_wpp").css("display", "none");
                        // $("#btn_geracao_unica").attr("disabled", false);
                        // $("#btn_geracao_unica").text("Confirmar geração");
                        console.log(data_inicial, periodicidade_socio, parcelas, valor);
                        console.log("parcelas:"+parcelas);
                        referenciaAccordion = nome_socio.replace(/[^a-zA-Zs]/g, "") + Math.round(Math.random()*100000000);
                        var tabela = ``;
                        var dataV = data_inicial_br;
                        var dataV_formatada = data_inicial;
                        var total = 0;
                        var numero_meses_somar = periodicidade_socio;
                        numero_meses_somar = parseInt(numero_meses_somar);
                        for(i = 0; i < parcelas; i++){
                            tabela += `<tr><td>${i+1}/${parcelas}</td><td>${dataV}</td><td>R$ ${valor}</td></tr>`;
                            var arrayDataSegments = dataV_formatada.split('-');
                            var novaData = new Date(arrayDataSegments[0], arrayDataSegments[1], arrayDataSegments[2]);
                            console.log(arrayDataSegments[1]);
                            if(arrayDataSegments[1] == 12)
                            {
                                novaData.setMonth(novaData.getMonth()+numero_meses_somar-1);
                            }
                            else{
                            novaData.setMonth(novaData.getMonth()+numero_meses_somar);

                            }
                            console.log(novaData);
                            dataV_formatada = `${novaData.getFullYear()}-${novaData.getMonth()}-${novaData.getDate()}`;
                            console.log(dataV_formatada);
                            dataV = `${dataAtualFormatada(novaData)}`;
                            total += valor;
                        }
                        tabela += `<tr><td colspan='2'>Total: </td><td>R$ ${total}</td></tr>`;
                        $(".detalhes_unico").append(`
                        <div class="accordion" id="accordionExample">
                        <div class="card">
                        <div class="card-header" id="headingThree">
                            <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse${referenciaAccordion}" aria-expanded="false" aria-controls="collapseThree">
                                Detalhes parcelas sócio atual: ${nome_socio}
                            </button>
                            </h2>
                        </div>
                        <div id="collapse${referenciaAccordion}" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                            <div class="card-body">
                            <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                <th>Parcela</th>
                                <th>Data de vencimento</th>
                                <th>Valor parcela</td>
                            </tr>
                        </thead>
                        <tbody>${tabela}</tbody>
                        </table>
                                </div>
                            </div>
                            </div>
                        </div>
                        `)
                    }

                    $("#btn_geracao_unica").click(function(event){
                        $(".box-geracaounica").prepend('<div class="overlay"> <i class="fa fa-refresh fa-spin"></i> </div>');
                        $.post("./controller/query_geracao_auto.php",{
                            "query": `SELECT * FROM doacao_boleto_info AS bi JOIN sistema_pagamento AS sp ON (bi.id_sistema = sp.id) JOIN doacao_boleto_regras AS br ON (br.id = bi.id_regras)  WHERE nome_sistema = 'BOLETOFACIL'`
                        })
                            .done(function(dados_api){
                                carneBoletos = [];
                                function montaTabela(nome_socio, carne, tipo_socio, telefone){
                                    console.log(telefone);
                                    $(".detalhes_unico").html("");
                                    $("#btn_wpp").css("display", "inline-block");
                                    referenciaAccordion = nome_socio.replace(/[^a-zA-Zs]/g, "") + Math.round(Math.random()*100000000);
                                    console.log(nome_socio, tipo_socio, carne);
                                    var tabela = ``;
                                    var qtd_parcelas = carne.length;
                                    var link_wpp;
                                    var texto = `Olá ${nome_socio.split(" ")[0]}, obrigado por estar contribuindo com o LAJE, confira seus boletos:`;
                                    for(const [i, boleto] of carne.entries()){
                                        tabela += `<tr><td>${i+1}/${qtd_parcelas}</td><td>${boleto.dueDate}</td><td><a target='_blank' href='${boleto.installmentLink}'>${boleto.installmentLink}</a></td><td>${boleto.payNumber}</td><tr>`;
                                        texto += `\nParcela (${i+1}/${qtd_parcelas} - ${boleto.dueDate}): ${boleto.installmentLink}`;
                                    }
                                    if(tipo_socio == "mensal"){
                                        tabela += `<tr><td colspan='2'>Link carnê completo:</td><td colspan='2'><a target='_blank' href='${carne[0].link}'>${carne[0].link}</a></td></tr>`;
                                        texto += `\nCarnê completo: ${boleto.installmentLink}`;
                                    }
                                    texto = window.encodeURIComponent(texto);
                                    link_wpp = `https://api.whatsapp.com/send?phone=55${telefone.replace(/\D/g, "")}&text=${texto}`;
                                    $(".detalhes_unico").append(`
                                    <div class="accordion" id="accordionExample">
                                    <div class="card">
                                      <div class="card-header" id="headingThree">
                                        <h2 class="mb-0">
                                          <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse${referenciaAccordion}" aria-expanded="false" aria-controls="collapseThree">
                                            ${nome_socio} - Sócio ${tipo_socio} [BOLETOS GERADOS!]
                                          </button>
                                        </h2>
                                      </div>
                                      <div id="collapse${referenciaAccordion}" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                        <div class="card-body">
                                        <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                              <th>Parcela</th>
                                              <th>Data de vencimento</th>
                                              <th>Link parcela</th>
                                              <th>Código de pagamento</th>
                                          </tr>
                                      </thead>
                                      <tbody>${tabela}</tbody>
                                  </table>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                    `)
                                    $("#btn_wpp").click(function(event){
                                        var win = window.open(link_wpp, '_blank');
                                        win.focus();
                                    })
                                }

                                function geraRef(socioNome){
                                    return socioNome.replace(/[^a-zA-Zs]/g, "").replace(" ", "") + Math.round(Math.random()*100000000);
                                }
                                
                                var apiData = JSON.parse(dados_api)[0];
                                
                                for(socio of socios){
                                    var Now = new Date();
                                    // var dadosDataParcelas = gerarDataParcelas(Now, 6, $("#data_vencimento").val().split("-")[2]);
                                    var dataV = $("#data_vencimento").val();
                                    var dataV = formatarDataBr(dataV);
                                    var parcelas = $("#num_parcelas").val();
                                   
                                    //aqui q tem q mudar as parcelas
                                    console.log("teste - "+dataV);
                                    $.ajax({
                                        type: "GET",
                                        url: `${apiData.api}token=${apiData.token_api}&description=${apiData.agradecimento}&amount=${$("#valor_u").val()}&dueDate=${dataV}&maxOverdueDays=${apiData.max_dias_venc}&installments=${parcelas}&payerName=${socio.nome}&payerCpfCnpj=${socio.cpf}&payerEmail=${socio.email}&payerPhone=${socio.telefone}&billingAddressStreet=${socio.logradouro}&billingAddressNumber=${socio.numero_endereco}&billingAddressComplement=${socio.complemento}&billingAddressNeighborhood=${socio.bairro}&billingAddressCity=${socio.cidade}&billingAddressState=${socio.estado}&billingAddressPostcode=${socio.cep}&fine=${apiData.multa}&interest=${apiData.juros}&paymentTypes=BOLETO&notifyPayer=TRUE&reference=${geraRef(socio.nome)}`,
                                        async: false,
                                        success : function(dadosBoleto) {
                                            for(boleto of dadosBoleto.data.charges){
                                                carneBoletos.push(boleto);
                                            }
                                        },
                                        error : function(){
                                            alert(`Houve um erro ao gerar o carnê de ${socio.nome}, verifique se os dados são válidos ou entre em contato com um administrador.`)
                                        }
                                    });
                                    montaTabela(socio.nome, carneBoletos, 'casual (avulso)', socio.telefone);
                                    // carneBoletos = [];
                                    console.log("nome"+socio.nome);
                                }
                                $(".box-geracaounica .overlay").remove();
                            })
                            $(this).off();
                            $(this).attr("disabled", true);
                            $(this).text("Gerado com sucesso, escolha um novo sócio e aperte continuar para gerar mais");
                    });                    
                }else{
                    console.log("SEM SÓCIOS DA CATEGORIA.");
                    alert(`Para gerar carnês/boletos para o sócio desejado você deve completar o cadastro dele primeiro com os seguintes dados: valor por período, data de referência e a periodicidade.`);
                }
            })
            .fail(function(dados){
                alert("Erro na obtenção de dados.");
            })
                
    }
                    
    $("#geracao").change(function(){
        var tipo_desejado = $(this).val();
        procurar_desejados(tipo_desejado);
    })
    $("#btn_gerar_unico").click(function(){
        var id_socio =  $("#id_pesquisa").val().split("|")[2];
        procurar_desejado(id_socio);
        $("#data_vencimento").val("");
        // $("#tipo_geracao").val("");
        $("#valor_u").val("");
        $("#num_parcelas").val("");
    })
})