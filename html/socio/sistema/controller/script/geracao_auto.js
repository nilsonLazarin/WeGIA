$(document).ready(function(){
    // Iniciando
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
            "query": `SELECT * FROM socio s JOIN pessoa p ON p.id_pessoa = s.id_pessoa WHERE s.id_sociostatus NOT IN (1,2,3,4) AND s.id_sociotipo in (${td})`
        })
            .done(function(dados){
                var socios = JSON.parse(dados);
                if(socios){
                    $("#btn_geracao_auto").attr("disabled", false);
                    $("#btn_geracao_auto").click(function(){
                        $.post("./controller/query_geracao_auto.php",{
                            "query": `SELECT * FROM doacao_boleto_info AS bi JOIN sistema_pagamento AS sp ON (bi.id_sistema = sp.id) JOIN doacao_boleto_regras AS br ON (br.id = bi.id_regras)  WHERE nome_sistema = 'BOLETOFACIL'`
                        })
                            .done(function(dados_api){
                                carneBoletos = [];
                                function calcula_parcelas(tipo_socio, dia){
                                    switch(tipo_socio){
                                        case 'mensal':
                                            var Now =  new Date();
                                            var Mes = Now.getMonth() + 1;
                                            var proximoAno = new Date(String(Now.getFullYear() + 1), '11', '31');
                                            var parcelas = 0;
                                            if(Mes <= 6){
                                                diaA = Now.getDate();
                                                if(dia <= diaA){
                                                    parcelas = 12 - Mes;
                                                }else parcelas = 13 - Mes;
                                            }else{
                                                diaA = Now.getDate();
                                                console.log(`${dia} - ${diaA}`);
                                                if(dia <= diaA){
                                                    console.log("teste");
                                                    parcelas = (12 - Mes) + 12;
                                                }else{
                                                    for(var dataHoje = Now; dataHoje < proximoAno; dataHoje.setMonth(dataHoje.getMonth() + 1)){
                                                        parcelas++;
                                                    }
                                                }
                                            }
                                        break;
                                        case 'bimestral':
                                            var Now =  new Date();
                                            var Mes = Now.getMonth() + 1;
                                            var proximoAno = new Date(String(Now.getFullYear() + 1), '11', '31');
                                            var parcelas = 0;
                                            if(Mes <= 6){
                                                diaA = Now.getDate();
                                                if(dia <= diaA){
                                                    parcelas = 6 - Mes;
                                                }else parcelas = 7 - Mes;
                                            }else{
                                                diaA = Now.getDate();
                                                console.log(`${dia} - ${diaA}`);
                                                if(dia <= diaA){
                                                    console.log("teste");
                                                    parcelas = (proximoAno.getMonth() - Now.getMonth() + (12 * (proximoAno.getFullYear() - Now.getFullYear())))/2;
                                                }else{
                                                    for(var dataHoje = Now; dataHoje < proximoAno; dataHoje.setMonth(dataHoje.getMonth() + 2)){
                                                        parcelas++;
                                                    }
                                                }
                                            }
                                        break;
                                        case 'trimestral':
                                            var Now =  new Date('2021', '04', '06');
                                            var Mes = Now.getMonth() + 1;
                                            var proximoAno = new Date(String(Now.getFullYear() + 1), '11', '31');
                                            var parcelas = 0;
                                            if(Mes <= 6){
                                                diaA = Now.getDate();
                                                if(dia <= diaA){
                                                    if(Mes == 1){
                                                        parcelas = 4;
                                                    }else parcelas = Math.floor(5 - (Mes/3));
                                                }else parcelas = Math.floor(5 - (Mes/3)) + 4;
                                            }else{
                                                diaA = Now.getDate();
                                                console.log(`${dia} - ${diaA}`);
                                                if(dia <= diaA){
                                                    console.log("teste");
                                                    parcelas = (proximoAno.getMonth() - Now.getMonth() + (12 * (proximoAno.getFullYear() - Now.getFullYear())))/3;
                                                }else{
                                                    for(var dataHoje = Now; dataHoje <= proximoAno; dataHoje.setMonth(dataHoje.getMonth() + 3)){
                                                        parcelas++;
                                                    }
                                                }
                                            }
                                        break;
                                        case 'semestral':
                                            
                                        break;
                                    }
                                    console.log(parcelas);
                                    return parcelas;
                                }
                                function geraRef(socioNome){
                                    return socioNome.replace(/[^a-zA-Zs]/g, "").replace(" ", "") + Math.round(Math.random()*100000000);
                                }
                                function gerarData(Now, tipo, dia_preferencial){
                                    var NovaData = new Date(Now);
                                    console.log(NovaData.getMonth() + 1);
                                    var fimDoAno = new Date(String(Now.getFullYear()), '11', '31');
                                    var retornoDatas = [];
                                    if(tipo == 1){
                                        NovaData.setMonth(NovaData.getMonth() + 2);
                                    }else if(tipo == 2){
                                        if((fimDoAno.getMonth() - Now.getMonth() + (12 * (fimDoAno.getFullYear() - Now.getFullYear()))) % 3 != 0 && dia_preferencial >= Now.getDate()){
                                            console.log(`Até o fim do ano ${fimDoAno.getMonth() - Now.getMonth() + (12 * (fimDoAno.getFullYear() - Now.getFullYear()))} meses`)
                                            while((NovaData.getMonth() + 1) % 3 != 0){
                                                NovaData.setMonth(NovaData.getMonth() + 1);
                                                console.log(`Mês: ${NovaData.getMonth() + 1}`);
                                            }
                                        }else{
                                            if(dia_preferencial > Now.getDate()){
                                                NovaData.setMonth(Now.getMonth());
                                                console.log(`Mês diapref >= Now : ${NovaData.getMonth() + 1}`);
                                            }else{NovaData.setMonth(NovaData.getMonth() + 3);}
                                        }
                                    }else if(tipo == 3){
                                        NovaData.setMonth(NovaData.getMonth() + 6);
                                    }else{
                                        NovaData.setMonth(NovaData.getMonth() + 1);
                                    }
                                    retornoDatas.push(String(`${dia_preferencial}/${NovaData.getMonth() + 1}/${NovaData.getFullYear()}`));
                                    retornoDatas.push(String(`${NovaData.getFullYear()}-${NovaData.getMonth()}-${dia_preferencial}`));
                                    console.log(retornoDatas);
                                    return retornoDatas;
                                }
                                var apiData = JSON.parse(dados_api)[0];
                                console.log(apiData);
                                for(socio of socios){
                                    console.log(socio);
                                    switch(Number(tipo_desejado)){
                                        case 4:
                                            var Now = new Date();
                                            var dataV = Number(dia = socio.data_referencia.split("-")[2]) <= Number(Now.getDate()) ? `${gerarData(Now, tipo_desejado)[0]}}` : `${dia}/${Now.getMonth() + 1}/${Now.getFullYear()}`;
                                            $.get(`${apiData.api}token=${apiData.token_api}&description=${apiData.agradecimento}&amount=${socio.valor_periodo}&dueDate=${dataV}&maxOverdueDays=${apiData.max_dias_venc}&installments=${calcula_parcelas('mensal', dia)}&payerName=${socio.nome}&payerCpfCnpj=${socio.cpf}&payerEmail=${socio.email}&payerPhone=${socio.telefone}&billingAddressStreet=${socio.logradouro}&billingAddressNumber=${socio.numero_endereco}&billingAddressComplement=${socio.complemento}&billingAddressNeighborhood=${socio.bairro}&billingAddressCity=${socio.cidade}&billingAddressState=${socio.estado}&billingAddressPostcode=${socio.cep}&fine=${apiData.multa}&interest=${apiData.juros}&paymentTypes=BOLETO&notifyPayer=TRUE&reference=${geraRef(socio.nome)}`)
                                                .done(function(dadosCarne){
                                                    console.log(dadosCarne);
                                                    // Mostrar tabela do carnê
                                                })
                                            socios = [];
                                        break;
                                        case 1:
                                            var Now = new Date();
                                            var dataV = Number(dia = socio.data_referencia.split("-")[2]) <= Number(Now.getDate()) ? `${gerarData(Now, tipo_desejado, dia)[0]}` : `${dia}/${Now.getMonth() + 1}/${Now.getFullYear()}`;
                                            var dataV_formatada = Number(dia = socio.data_referencia.split("-")[2]) <= Number(Now.getDate()) ? `${gerarData(Now, tipo_desejado, dia)[1]}` : `${Now.getFullYear()}-${Now.getMonth()}-${dia}`;
                                            var quantidadeParcelas = calcula_parcelas('bimestral', dia);
                                            console.log(quantidadeParcelas);
                                            for(i = 0; i < quantidadeParcelas; i++){
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
                                                console.log(`${novaData.getDate()}/${novaData.getMonth()+1}/${novaData.getFullYear()}`);
                                                novaData.setMonth(novaData.getMonth() + 2);
                                                dataV_formatada = `${novaData.getFullYear()}-${novaData.getMonth()}-${novaData.getDate()}`;
                                                dataV = `${novaData.getDate()}/${novaData.getMonth()+1}/${novaData.getFullYear()}`;
                                            }
                                            socios = [];
                                        break;
                                        case 2:
                                            var Now = new Date('2021', '04', '06');
                                            var dataV = Number(dia = socio.data_referencia.split("-")[2]) <= Number(Now.getDate()) ? `${gerarData(Now, tipo_desejado, dia)[0]}` : `${gerarData(Now, tipo_desejado, dia)[0]}`;
                                            var dataV_formatada = Number(dia = socio.data_referencia.split("-")[2]) <= Number(Now.getDate()) ? `${gerarData(Now, tipo_desejado, dia)[1]}` : `${gerarData(Now, tipo_desejado, dia)[1]}`;
                                            var quantidadeParcelas = calcula_parcelas('trimestral', dia);
                                            console.log(quantidadeParcelas);
                                            for(i = 0; i < quantidadeParcelas; i++){
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
                                                console.log(`${novaData.getDate()}/${novaData.getMonth()+1}/${novaData.getFullYear()}`);
                                                novaData.setMonth(novaData.getMonth() + 3);
                                                dataV_formatada = `${novaData.getFullYear()}-${novaData.getMonth()}-${novaData.getDate()}`;
                                                dataV = `${novaData.getDate()}/${novaData.getMonth()+1}/${novaData.getFullYear()}`;
                                            }
                                            socios = [];
                                        break;
                                        case 3:
                                            var Now = new Date();
                                            var dataV = Number(dia = socio.data_referencia.split("-")[2]) <= Number(Now.getDate()) ? `${gerarData(Now, tipo_desejado, dia)[0]}` : `${dia}/${Now.getMonth() + 1}/${Now.getFullYear()}`;
                                            var dataV_formatada = Number(dia = socio.data_referencia.split("-")[2]) <= Number(Now.getDate()) ? `${gerarData(Now, tipo_desejado, dia)[1]}` : `${Now.getFullYear()}-${Now.getMonth()}-${dia}`;
                                            var quantidadeParcelas = calcula_parcelas('semestral', dia);
                                            console.log(quantidadeParcelas);
                                            for(i = 0; i < quantidadeParcelas; i++){
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
                                                console.log(`${novaData.getDate()}/${novaData.getMonth()+1}/${novaData.getFullYear()}`);
                                                novaData.setMonth(novaData.getMonth() + 6);
                                                dataV_formatada = `${novaData.getFullYear()}-${novaData.getMonth()}-${novaData.getDate()}`;
                                                dataV = `${novaData.getDate()}/${novaData.getMonth()+1}/${novaData.getFullYear()}`;
                                            }
                                            socios = [];
                                        break;

                                    }
                                }
                                console.log(carneBoletos);
                            })
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