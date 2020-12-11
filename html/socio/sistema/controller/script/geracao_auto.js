$(document).ready(function(){
    // Iniciando
    // Funcões do expansable
    $("#btn_geracao_auto").attr("disabled", true);
    function procurar_desejados(tipo_desejado){
        switch(Number(tipo_desejado)){
            case 0: var td = "2,3,6,7,8,9,10,11"; break; //Todos
            case 1: var td = "6,7"; break; //Bimestrais
            case 2: var td = "8,9"; break; //Trimestrais
            case 3: var td = "10,11"; break; //Semestrais
            case 4: var td = "2,3"; break; //Mensais
        }
        $.post("./controller/query_geracao_auto.php", {
            "query": `SELECT * FROM socio s JOIN pessoa p ON p.id_pessoa = s.id_pessoa WHERE s.id_sociostatus NOT IN (1,2,3,4) AND s.id_sociotipo in (${td}) AND s.valor_periodo <> '' AND s.data_referencia <> '0000-00-00'`
        })
            .done(function(dados){
                var socios = JSON.parse(dados);
                if(socios){
                    $("#btn_geracao_auto").attr("disabled", false);
                    $("#btn_geracao_auto").click(function(event){
                        $(".box-geracao").prepend('<div class="overlay"> <i class="fa fa-refresh fa-spin"></i> </div>');
                        $.post("./controller/query_geracao_auto.php",{
                            "query": `SELECT * FROM doacao_boleto_info AS bi JOIN sistema_pagamento AS sp ON (bi.id_sistema = sp.id) JOIN doacao_boleto_regras AS br ON (br.id = bi.id_regras)  WHERE nome_sistema = 'BOLETOFACIL'`
                        })
                            .done(function(dados_api){
                                carneBoletos = [];
                                function montaTabela(nome_socio, carne, tipo_socio){
                                    referenciaAccordion = nome_socio.replace(/[^a-zA-Zs]/g, "") + Math.round(Math.random()*100000000);
                                    console.log(nome_socio, tipo_socio, carne);
                                    var tabela = ``;
                                    var qtd_parcelas = carne.length;
                                    for(const [i, boleto] of carne.entries()){
                                        tabela += `<tr><td>${i+1}/${qtd_parcelas}</td><td>${boleto.dueDate}</td><td><a target='_blank' href='${boleto.installmentLink}'>${boleto.installmentLink}</a></td><td>${boleto.payNumber}</td><tr>`;
                                    }
                                    if(tipo_socio == "mensal"){
                                        tabela += `<tr><td colspan='2'>Link carnê completo:</td><td colspan='2'><a target='_blank' href='${carne[0].link}'>${carne[0].link}</a></td></tr>`;
                                    }
                                    $(".detalhes").append(`
                                    <div class="accordion" id="accordionExample">
                                    <div class="card">
                                      <div class="card-header" id="headingThree">
                                        <h2 class="mb-0">
                                          <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse${referenciaAccordion}" aria-expanded="false" aria-controls="collapseThree">
                                            ${nome_socio} - Sócio ${tipo_socio}
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
                                }
                                function geraRef(socioNome){
                                    return socioNome.replace(/[^a-zA-Zs]/g, "").replace(" ", "") + Math.round(Math.random()*100000000);
                                }
                                function gerarDataParcelas(Now, tipo, dia_preferencial){
                                    var NovaData = new Date(Now);
                                    var fimDoAno = new Date(String(Now.getFullYear()), '11', '31');
                                    var proximoAno = new Date(String(Now.getFullYear() + 1), '11', '31');
                                    var retornoDatas = {
                                        dataV: null,
                                        dataV_formatada: null,
                                        parcelas: null
                                    };
                                    if(tipo == 1){
                                        var parcelas = 0;
                                        while((NovaData.getMonth() + 1) % 2 != 0){
                                            NovaData.setMonth(NovaData.getMonth() + 1);
                                        }
                                        
                                        if(Now.getMonth() == NovaData.getMonth() && dia_preferencial <= Now.getDate()){
                                            NovaData.setMonth(NovaData.getMonth() + 2);
                                        }
                                        var Mes = NovaData.getMonth() + 1;
                                        if(Mes <= 6){
                                            parcelas = 7 - Math.floor(Mes/2);
                                        }else{
                                            for(var dataHoje = new Date(NovaData); dataHoje < proximoAno; dataHoje.setMonth(dataHoje.getMonth() + 2)){
                                                parcelas++;
                                            }
                                        }
                                    }else if(tipo == 2){
                                        var parcelas = 0;
                                        while((NovaData.getMonth() + 1) % 3 != 0){
                                            NovaData.setMonth(NovaData.getMonth() + 1);
                                        }
                                        
                                        if(Now.getMonth() == NovaData.getMonth() && dia_preferencial <= Now.getDate()){
                                            NovaData.setMonth(NovaData.getMonth() + 3);
                                        }
                                        var Mes = NovaData.getMonth() + 1;
                                        if(Mes <= 6){
                                            parcelas = 5 - Math.floor(Mes/3);
                                        }else{
                                            for(var dataHoje = new Date(NovaData); dataHoje < proximoAno; dataHoje.setMonth(dataHoje.getMonth() + 3)){
                                                parcelas++;
                                            }
                                        }
                                    }else if(tipo == 3){
                                        var parcelas = 0;
                                        while((NovaData.getMonth() + 1) % 6 != 0){
                                            NovaData.setMonth(NovaData.getMonth() + 1);
                                        }
                                        
                                        if(Now.getMonth() == NovaData.getMonth() && dia_preferencial <= Now.getDate()){
                                            NovaData.setMonth(NovaData.getMonth() + 6);
                                        }
                                        var Mes = NovaData.getMonth() + 1;
                                        if(Mes <= 6){
                                            parcelas = 3 - Math.floor(Mes/6);
                                        }else{
                                            for(var dataHoje = new Date(NovaData); dataHoje < proximoAno; dataHoje.setMonth(dataHoje.getMonth() + 6)){
                                                parcelas++;
                                            }
                                        }
                                    }else{
                                        var parcelas = 0;
                                        if(dia_preferencial <= Now.getDate()){
                                            NovaData.setMonth(NovaData.getMonth() + 1);
                                        }
                                        Mes = NovaData.getMonth() + 1;
                                        if(Mes <= 6){
                                            parcelas = 13 - Mes;
                                        }else{
                                            for(var dataHoje = new Date(Now); dataHoje < proximoAno; dataHoje.setMonth(dataHoje.getMonth() + 1)){
                                                parcelas++;
                                            }
                                        }
                                    }
                                    retornoDatas.dataV = (String(`${dia_preferencial}/${NovaData.getMonth() + 1}/${NovaData.getFullYear()}`));
                                    retornoDatas.dataV_formatada = (String(`${NovaData.getFullYear()}-${NovaData.getMonth()}-${dia_preferencial}`));
                                    retornoDatas.parcelas = parcelas;
                                    return retornoDatas;
                                }
                                var apiData = JSON.parse(dados_api)[0];
                                for(socio of socios){
                                    switch(Number(socio.id_sociotipo)){
                                        case 2: case 3:
                                            var Now = new Date();
                                            var dadosDataParcelas = gerarDataParcelas(Now, 4, socio.data_referencia.split("-")[2]);
                                            var dataV = dadosDataParcelas['dataV'];
                                            var dataV_formatada = dadosDataParcelas['dataV_formatada'];
                                            var parcelas = dadosDataParcelas['parcelas'];
                                            $.ajax({
                                                type: "GET",
                                                url: `${apiData.api}token=${apiData.token_api}&description=${apiData.agradecimento}&amount=${socio.valor_periodo}&dueDate=${dataV}&maxOverdueDays=${apiData.max_dias_venc}&installments=${parcelas}&payerName=${socio.nome}&payerCpfCnpj=${socio.cpf}&payerEmail=${socio.email}&payerPhone=${socio.telefone}&billingAddressStreet=${socio.logradouro}&billingAddressNumber=${socio.numero_endereco}&billingAddressComplement=${socio.complemento}&billingAddressNeighborhood=${socio.bairro}&billingAddressCity=${socio.cidade}&billingAddressState=${socio.estado}&billingAddressPostcode=${socio.cep}&fine=${apiData.multa}&interest=${apiData.juros}&paymentTypes=BOLETO&notifyPayer=TRUE&reference=${geraRef(socio.nome)}`,
                                                async: false,
                                                success : function(dadosBoleto) {
                                                    for(boleto of dadosBoleto.data.charges){
                                                        carneBoletos.push(boleto);
                                                    }
                                                }
                                            });
                                            montaTabela(socio.nome, carneBoletos, 'mensal');
                                            carneBoletos = [];
                                        break;
                                        case 6: case 7:
                                            var Now = new Date();
                                            var dadosDataParcelas = gerarDataParcelas(Now, 1, socio.data_referencia.split("-")[2]);
                                            var dataV = dadosDataParcelas['dataV'];
                                            var dataV_formatada = dadosDataParcelas['dataV_formatada'];
                                            var parcelas = dadosDataParcelas['parcelas'];
                                            for(i = 0; i < parcelas; i++){
                                                $.ajax({
                                                    type: "GET",
                                                    url: `${apiData.api}token=${apiData.token_api}&description=${apiData.agradecimento}&amount=${socio.valor_periodo}&dueDate=${dataV}&maxOverdueDays=${apiData.max_dias_venc}&installments=1&payerName=${socio.nome}&payerCpfCnpj=${socio.cpf}&payerEmail=${socio.email}&payerPhone=${socio.telefone}&billingAddressStreet=${socio.logradouro}&billingAddressNumber=${socio.numero_endereco}&billingAddressComplement=${socio.complemento}&billingAddressNeighborhood=${socio.bairro}&billingAddressCity=${socio.cidade}&billingAddressState=${socio.estado}&billingAddressPostcode=${socio.cep}&fine=${apiData.multa}&interest=${apiData.juros}&paymentTypes=BOLETO&notifyPayer=TRUE&reference=${geraRef(socio.nome)}`,
                                                    async: false,
                                                    success : function(dadosBoleto) {
                                                        for(boleto of dadosBoleto.data.charges){
                                                            carneBoletos.push(boleto);
                                                        }
                                                    }
                                                });
                                                var arrayDataSegments = dataV_formatada.split('-');
                                                var novaData = new Date(arrayDataSegments[0], arrayDataSegments[1], arrayDataSegments[2]);
                                                novaData.setMonth(novaData.getMonth() + 2);
                                                dataV_formatada = `${novaData.getFullYear()}-${novaData.getMonth()}-${novaData.getDate()}`;
                                                dataV = `${novaData.getDate()}/${novaData.getMonth()+1}/${novaData.getFullYear()}`;
                                            }
                                            montaTabela(socio.nome, carneBoletos, 'bimestral');
                                            carneBoletos = [];
                                        break;
                                        case 8: case 9:
                                            var Now = new Date();
                                            var dadosDataParcelas = gerarDataParcelas(Now, 2, socio.data_referencia.split("-")[2]);
                                            var dataV = dadosDataParcelas['dataV'];
                                            var dataV_formatada = dadosDataParcelas['dataV_formatada'];
                                            var parcelas = dadosDataParcelas['parcelas'];
                                            for(i = 0; i < parcelas; i++){
                                                $.ajax({
                                                    type: "GET",
                                                    url: `${apiData.api}token=${apiData.token_api}&description=${apiData.agradecimento}&amount=${socio.valor_periodo}&dueDate=${dataV}&maxOverdueDays=${apiData.max_dias_venc}&installments=1&payerName=${socio.nome}&payerCpfCnpj=${socio.cpf}&payerEmail=${socio.email}&payerPhone=${socio.telefone}&billingAddressStreet=${socio.logradouro}&billingAddressNumber=${socio.numero_endereco}&billingAddressComplement=${socio.complemento}&billingAddressNeighborhood=${socio.bairro}&billingAddressCity=${socio.cidade}&billingAddressState=${socio.estado}&billingAddressPostcode=${socio.cep}&fine=${apiData.multa}&interest=${apiData.juros}&paymentTypes=BOLETO&notifyPayer=TRUE&reference=${geraRef(socio.nome)}`,
                                                    async: false,
                                                    success : function(dadosBoleto) {
                                                        for(boleto of dadosBoleto.data.charges){
                                                            carneBoletos.push(boleto);
                                                        }
                                                    }
                                                });
                                                var arrayDataSegments = dataV_formatada.split('-');
                                                var novaData = new Date(arrayDataSegments[0], arrayDataSegments[1], arrayDataSegments[2]);
                                                novaData.setMonth(novaData.getMonth() + 3);
                                                dataV_formatada = `${novaData.getFullYear()}-${novaData.getMonth()}-${novaData.getDate()}`;
                                                dataV = `${novaData.getDate()}/${novaData.getMonth()+1}/${novaData.getFullYear()}`;
                                            }
                                            montaTabela(socio.nome, carneBoletos, 'trimestral');
                                            carneBoletos = [];
                                        break;
                                        case 10: case 11:
                                            var Now = new Date();
                                            var dadosDataParcelas = gerarDataParcelas(Now, 3, socio.data_referencia.split("-")[2]);
                                            var dataV = dadosDataParcelas['dataV'];
                                            var dataV_formatada = dadosDataParcelas['dataV_formatada'];
                                            var parcelas = dadosDataParcelas['parcelas'];
                                            for(i = 0; i < parcelas; i++){
                                                $.ajax({
                                                    type: "GET",
                                                    url: `${apiData.api}token=${apiData.token_api}&description=${apiData.agradecimento}&amount=${socio.valor_periodo}&dueDate=${dataV}&maxOverdueDays=${apiData.max_dias_venc}&installments=1&payerName=${socio.nome}&payerCpfCnpj=${socio.cpf}&payerEmail=${socio.email}&payerPhone=${socio.telefone}&billingAddressStreet=${socio.logradouro}&billingAddressNumber=${socio.numero_endereco}&billingAddressComplement=${socio.complemento}&billingAddressNeighborhood=${socio.bairro}&billingAddressCity=${socio.cidade}&billingAddressState=${socio.estado}&billingAddressPostcode=${socio.cep}&fine=${apiData.multa}&interest=${apiData.juros}&paymentTypes=BOLETO&notifyPayer=TRUE&reference=${geraRef(socio.nome)}`,
                                                    async: false,
                                                    success : function(dadosBoleto) {
                                                        for(boleto of dadosBoleto.data.charges){
                                                            carneBoletos.push(boleto);
                                                        }
                                                    }
                                                });
                                                var arrayDataSegments = dataV_formatada.split('-');
                                                var novaData = new Date(arrayDataSegments[0], arrayDataSegments[1], arrayDataSegments[2]);
                                                novaData.setMonth(novaData.getMonth() + 6);
                                                dataV_formatada = `${novaData.getFullYear()}-${novaData.getMonth()}-${novaData.getDate()}`;
                                                dataV = `${novaData.getDate()}/${novaData.getMonth()+1}/${novaData.getFullYear()}`;
                                            }
                                            montaTabela(socio.nome, carneBoletos, 'semestral');
                                            carneBoletos = [];
                                        break;

                                    }
                                }
                                $(".box-geracao .overlay").remove();
                            })
                            event.stopPropagation();
                            $(this).off();
                    });
                }else{
                    console.log("SEM SÓCIOS DA CATEGORIA.");
                    $("#btn_geracao_auto").attr("disabled", true);
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

})