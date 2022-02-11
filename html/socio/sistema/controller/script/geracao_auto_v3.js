$(document).ready(function(){
 
    // Geração para sócio único
    function procurar_desejado(id_socio){
        $.post("./controller/query_geracao_auto.php", {
            "query": `SELECT * FROM socio s JOIN pessoa p ON p.id_pessoa = s.id_pessoa WHERE s.id_socio = ${id_socio}`
        })
            .done(function(dados){
                var socios = JSON.parse(dados);
                if(socios){
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

                        $(".detalhes_unico").html("");
                        $("#btn_wpp").off();
                        $("#btn_wpp").css("display", "none");
                        $("#btn_geracao_unica").attr("disabled", false);
                        $("#btn_geracao_unica").text("Confirmar geração");
                        console.log(data_inicial, periodicidade_socio, parcelas, valor);
                        console.log("parcelas:"+parcelas);
                        referenciaAccordion = nome_socio.replace(/[^a-zA-Zs]/g, "") + Math.round(Math.random()*100000000);
                        var tabela = ``;
                        var dataV = data_inicial_br;
                        var dataV_formatada = data_inicial;

                        var arrayDataSegmentsA = dataV_formatada.split('-');
                        var mesAA = arrayDataSegmentsA[1]-1;              
                        var total = 0;
                        console.log("dataInicial"+dataV_formatada);
                        for(i = 0; i < parcelas; i++){
                            tabela += `<tr><td>${i+1}/${parcelas}</td><td>${dataV}</td><td>R$ ${valor}</td></tr>`
                            // var arrayDataSegments = dataV_formatada.split('-');
                            // var mes = arrayDataSegments[1]-1;
                            console.log("mes"+mesAA);
                            var novaData = new Date(arrayDataSegmentsA[0], mesAA, arrayDataSegmentsA[2]);
                            console.log("dataNova"+novaData);
                            novaData.setMonth(novaData.getMonth() + periodicidade_socio);
                            dataV_formatada = `${novaData.getFullYear()}-${novaData.getMonth()}-${novaData.getDate()}`;
                            dataV = `${dataAtualFormatada(novaData)}`;
                            total += valor;
                            console.log("dataBoleto"+dataV);
                            mesAA += periodicidade_socio;
                        }
                        tabela += `<tr><td colspan='2'>Total: </td><td>R$ ${total}</td></tr>`;
                        $(".detalhes_unico").append(`
                        <br>
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
                        `)
                    }

                    function montaTabelaInicialAlterado(data_inicial, data_inicial_br, periodicidade_socio, parcelas, valor, nome_socio){
                        
                        function dataAtualFormatada(data_r){
                            var data = new Date(data_r),
                                dia  = data.getDate().toString(),
                                diaF = (dia.length == 1) ? '0'+dia : dia,
                                mes  = (data.getMonth()+1).toString(), //+1 pois no getMonth Janeiro começa com zero.
                                mesF = (mes.length == 1) ? '0'+mes : mes,
                                anoF = data.getFullYear();
                            return diaF+"/"+mesF+"/"+anoF;
                        }

                        $(".detalhes_unico").html("");
                        $("#btn_wpp").off();
                        $("#btn_wpp").css("display", "none");
                        $("#btn_geracao_unica").attr("disabled", false);
                        $("#btn_geracao_unica").text("Confirmar geração");
                        console.log(data_inicial, periodicidade_socio, parcelas, valor);
                        console.log("parcelas:"+parcelas);
                        referenciaAccordion = nome_socio.replace(/[^a-zA-Zs]/g, "") + Math.round(Math.random()*100000000);
                        var tabela = ``;
                        var dataV = data_inicial_br;
                        var dataV_formatada = data_inicial;

                        var arrayDataSegmentsA = dataV_formatada.split('-');
                        var mesAA = arrayDataSegmentsA[1]-1;              
                        var total = 0;
                        console.log("dataInicial"+dataV_formatada);
                        for(i = 0; i < parcelas; i++){
                            tabela += `<tr><td>${i+1}/${parcelas}</td><td>${dataV}</td><td>R$ ${valor}</td></tr>`
                            // var arrayDataSegments = dataV_formatada.split('-');
                            // var mes = arrayDataSegments[1]-1;
                            console.log("mes"+mesAA);
                            var novaData = new Date(arrayDataSegmentsA[0], mesAA, arrayDataSegmentsA[2]);
                            console.log("dataNova"+novaData);
                            novaData.setMonth(novaData.getMonth() + periodicidade_socio);
                            dataV_formatada = `${novaData.getFullYear()}-${novaData.getMonth()}-${novaData.getDate()}`;
                            dataV = `${dataAtualFormatada(novaData)}`;
                            total += valor;
                            console.log("dataBoleto"+dataV);
                            mesAA += periodicidade_socio;
                        }
                        tabela += `<tr><td colspan='2'>Total: </td><td>R$ ${total}</td></tr>`;
                    }

                    console.log(socios.length, socios);
                    $(".configs_unico").css("display", "block");
                    console.log(socios[0].id_sociotipo);
                    var tipo;
                    
                    $("#tipo_geracao").change(function(){
                        if($(this).val() == 0){
                            $("#num_parcelas").val(1);
                            $("#num_parcelas").prop('disabled', true);
                            // $("#sobrenome").prop('disabled', false);
                        }
                        else{
                            $("#num_parcelas").val();
                            $("#num_parcelas").prop('disabled', false);
                        }
                    })
                    
                    $("#btn_confirma").click(function(){
                           
                            var inputParcelas = $("#num_parcelas").val();
                            var inputData = $("#data_vencimento").val();
                            var inputValor = $("#valor_u").val();
                            var tipo_boleto = $("#tipo_geracao").val();
                            $("#btn_geracao_unica").css("display","inline");

                            tipo = Number(tipo_boleto);
                            periodicidade_socio = 1;
                           
                            var teste = inputData.split('-');
                            var dataTipoBr = teste[2]+"/"+teste[1]+"/"+teste[0];
                            console.log("aaaa"+dataTipoBr);
                            if(inputParcelas <= 0 || inputParcelas == null || inputValor <= 0 || inputValor == null || inputData == '' ){
                                alert("Dados inválidos, tente novamente!");
                            }
                            montaTabelaInicial(inputData, dataTipoBr, tipo, inputParcelas, Number($("#valor_u").val()), socios[0].nome);
                    })                 
                    
                    montaTabelaInicialAlterado('', '', '', '', '' , socios[0].nome);

                    $(".div_btn_gerar").css("display", "block");
                    
                    $("#btn_geracao_unica").click(function(event){
                        $(".box-geracaounica").prepend('<div class="overlay"> <i class="fa fa-refresh fa-spin"></i> </div>');
                        $.post("./controller/query_geracao_auto.php",{
                            "query": `SELECT * FROM doacao_boleto_info AS bi JOIN sistema_pagamento AS sp ON (bi.id_sistema = sp.id) JOIN doacao_boleto_regras AS br ON (br.id = bi.id_regras)  WHERE nome_sistema = 'BOLETOFACIL'`
                        })
                            .done(function(dados_api){
                                $("#num_parcelas").prop('disabled', true);
                                $("#data_vencimento").prop('disabled', true);
                                $("#valor_u").prop('disabled', true);
                                $("#tipo_geracao").prop('disabled', true);
                                $("#num_parcelas").prop('disabled', true);
                                $("#btn_confirma").css("display","none");
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
                                        tabela += `<tr><td>${i+1}/${qtd_parcelas}</td><td>${boleto.dueDate}</td><td><a target='_blank' href='${boleto.checkoutUrl}'>${boleto.checkoutUrl}</a></td><td>${boleto.payNumber}</td><tr>`;
                                        texto += `\nParcela (${i+1}/${qtd_parcelas} - ${boleto.dueDate}): ${boleto.checkoutUrl}`;
                                    }
                                    if(tipo_socio == "mensal"){
                                        tabela += `<tr><td colspan='2'>Link carnê completo:</td><td colspan='2'><a target='_blank' href='${carne[0].link}'>${carne[0].link}</a></td></tr>`;
                                        texto += `\nCarnê completo: ${boleto.checkoutUrl}`;
                                    }
                                    texto = window.encodeURIComponent(texto);
                                    link_wpp = `https://api.whatsapp.com/send?phone=55${telefone.replace(/\D/g, "")}&text=${texto}`;
                                    $(".detalhes_unico").append(`
                                    <br>
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
                                    `)
                                    $("#btn_wpp").click(function(event){
                                        var win = window.open(link_wpp, '_blank');
                                        win.focus();
                                    })
                                }

                                function CadastraCobrancas(carneBoletos, id){
                                    var valor = $("#valor_u").val();

                                    var data = new Date;
                                    console.log(data)
                                    var dia = data.getDate();
                                    var mes = data.getMonth()+1;
                                    var ano = data.getFullYear();
                                    var Databr = ano+"-"+mes+"-"+dia;

                                    var arrayDataVencimento = boleto.dueDate.split('/');
                                    var diaV = arrayDataVencimento[0];
                                    var mesV = arrayDataVencimento[1];
                                    var anoV = arrayDataVencimento[2];
                                    var DataV = anoV+"-"+mesV+"-"+diaV;
                                    console.log(DataV)

                                    
                                    for(const [i, boleto] of carneBoletos.entries()){
                                        // tabela += `<tr><td>${i+1}/${qtd_parcelas}</td><td>${boleto.dueDate}</td><td><a target='_blank' href='${boleto.checkoutUrl}'>${boleto.checkoutUrl}</a></td><td>${boleto.payNumber}</td><tr>`;
                                        // texto += `\nParcela (${i+1}/${qtd_parcelas} - ${boleto.dueDate}): ${boleto.checkoutUrl}`;
                                        // console.log(boleto.checkoutUrl)
                                        
                                        
                                        $.post("./cadastro_cobrancas_geracao.php",{
                                            "codigo": boleto.code,
                                            "descricao": "O Lar Abrigo Amor a Jesus, agradece sua contribuição ao Projeto Sócio  Amigos do Laje.Deus abençoe!",
                                            "id_socio": id,
                                            "data_vencimento": DataV,
                                            "data_emissao": Databr,
                                            "data_pagamento": '0000-00-00',
                                            "valor": valor,
                                            "valor_pago": 0.00,
                                            "status": "Agurdando Pagamento",
                                            "link_cobranca": boleto.checkoutUrl,
                                            "link_boleto": boleto.installmentLink,
                                            "linha_digitavel": boleto.billetDetails.barcodeNumber
                                        })
                                    }

                                }

                                function geraRef(socioNome){
                                    return socioNome.replace(/[^a-zA-Zs]/g, "").replace(" ", "") + Math.round(Math.random()*100000000);
                                }
                                
                                var apiData = JSON.parse(dados_api)[0];
                                
                                for(socio of socios){
                                    switch(tipo){
                                        case 0:
                                           
                                            var inputParcelas = $("#num_parcelas").val();
                                            var inputData = $("#data_vencimento").val();
                                                                                 
                                            var teste = inputData.split('-');
                                            var dataTipoBr = teste[2]+"/"+teste[1]+"/"+teste[0];
                                            
                                            var dataV = dataTipoBr;
                                            var dataV_formatada = inputData;
                                            var parcelas = inputParcelas; 

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
                                            CadastraCobrancas(carneBoletos, socio.id_socio);
                                            montaTabela(socio.nome, carneBoletos, 'casual (avulso)', socio.telefone);
                                            carneBoletos = [];
                                        break;
                                        case 1:

                                            var inputParcelas = $("#num_parcelas").val();
                                            var inputData = $("#data_vencimento").val();
                             
                                            var teste = inputData.split('-');
                                            var dataTipoBr = teste[2]+"/"+teste[1]+"/"+teste[0];
                                            
                                            var dataV = dataTipoBr;
                                            var dataV_formatada = inputData;
                                            var parcelas = inputParcelas; 
                                            
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
                                            CadastraCobrancas(carneBoletos, socio.id_socio);
                                            montaTabela(socio.nome, carneBoletos, 'mensal', socio.telefone);
                                            carneBoletos = [];
                                        break;
                                        case 2:

                                            var inputParcelas = $("#num_parcelas").val();
                                            var inputData = $("#data_vencimento").val();
                                            
                                                                                 
                                            var teste = inputData.split('-');
                                            var dataTipoBr = teste[2]+"/"+teste[1]+"/"+teste[0];
                                            
                                            var dataV = dataTipoBr;
                                            var dataV_formatada = inputData;
                                            var parcelas = inputParcelas; 

                                            var arrayteste = dataV_formatada.split('-');
                                            var meses = arrayteste[1]-1;
                                            var datast = arrayteste[0]+"-"+meses+"-"+arrayteste[2];
                                            
                                            dataV_formatada = datast;
                                            
                                            for(i = 0; i < parcelas; i++){
                                                $.ajax({
                                                    type: "GET",
                                                    url: `${apiData.api}token=${apiData.token_api}&description=${apiData.agradecimento}&amount=${$("#valor_u").val()}&dueDate=${dataV}&maxOverdueDays=${apiData.max_dias_venc}&installments=1&payerName=${socio.nome}&payerCpfCnpj=${socio.cpf}&payerEmail=${socio.email}&payerPhone=${socio.telefone}&billingAddressStreet=${socio.logradouro}&billingAddressNumber=${socio.numero_endereco}&billingAddressComplement=${socio.complemento}&billingAddressNeighborhood=${socio.bairro}&billingAddressCity=${socio.cidade}&billingAddressState=${socio.estado}&billingAddressPostcode=${socio.cep}&fine=${apiData.multa}&interest=${apiData.juros}&paymentTypes=BOLETO&notifyPayer=TRUE&reference=${geraRef(socio.nome)}`,
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
                                                var arrayDataSegments = dataV_formatada.split('-');
                                                // var mesB = arrayDataSegments[1]-1; 
                                                var novaData = new Date(arrayDataSegments[0], arrayDataSegments[1], arrayDataSegments[2]);
                                                novaData.setMonth(novaData.getMonth() + 2);
                                                dataV_formatada = `${novaData.getFullYear()}-${novaData.getMonth()}-${novaData.getDate()}`;
                                                dataV = `${novaData.getDate()}/${novaData.getMonth()+1}/${novaData.getFullYear()}`;
                                                // mesB+=periodicidade_socio;
                                            }
                                            CadastraCobrancas(carneBoletos, socio.id_socio);
                                            montaTabela(socio.nome, carneBoletos, 'bimestral', socio.telefone);
                                            carneBoletos = [];
                                        break;
                                        case 3:

                                            var inputParcelas = $("#num_parcelas").val();
                                            var inputData = $("#data_vencimento").val();
                                                                                 
                                            var teste = inputData.split('-');
                                            var dataTipoBr = teste[2]+"/"+teste[1]+"/"+teste[0];
                                            
                                            var dataV = dataTipoBr;
                                            var dataV_formatada = inputData;
                                            var parcelas = inputParcelas; 

                                            var arrayteste = dataV_formatada.split('-');
                                            var meses = arrayteste[1]-1;
                                            var datast = arrayteste[0]+"-"+meses+"-"+arrayteste[2];
                                            
                                            dataV_formatada = datast;

                                            for(i = 0; i < parcelas; i++){
                                                $.ajax({
                                                    type: "GET",
                                                    url: `${apiData.api}token=${apiData.token_api}&description=${apiData.agradecimento}&amount=${$("#valor_u").val()}&dueDate=${dataV}&maxOverdueDays=${apiData.max_dias_venc}&installments=1&payerName=${socio.nome}&payerCpfCnpj=${socio.cpf}&payerEmail=${socio.email}&payerPhone=${socio.telefone}&billingAddressStreet=${socio.logradouro}&billingAddressNumber=${socio.numero_endereco}&billingAddressComplement=${socio.complemento}&billingAddressNeighborhood=${socio.bairro}&billingAddressCity=${socio.cidade}&billingAddressState=${socio.estado}&billingAddressPostcode=${socio.cep}&fine=${apiData.multa}&interest=${apiData.juros}&paymentTypes=BOLETO&notifyPayer=TRUE&reference=${geraRef(socio.nome)}`,
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
                                                var arrayDataSegments = dataV_formatada.split('-');
                                                var novaData = new Date(arrayDataSegments[0], arrayDataSegments[1], arrayDataSegments[2]);
                                                novaData.setMonth(novaData.getMonth() + 3);
                                                dataV_formatada = `${novaData.getFullYear()}-${novaData.getMonth()}-${novaData.getDate()}`;
                                                dataV = `${novaData.getDate()}/${novaData.getMonth()+1}/${novaData.getFullYear()}`;
                                            }
                                            CadastraCobrancas(carneBoletos, socio.id_socio);
                                            montaTabela(socio.nome, carneBoletos, 'trimestral', socio.telefone);
                                            carneBoletos = [];
                                        break;
                                        case 6:

                                            var inputParcelas = $("#num_parcelas").val();
                                            var inputData = $("#data_vencimento").val();
                                                                                 
                                            var teste = inputData.split('-');
                                            var dataTipoBr = teste[2]+"/"+teste[1]+"/"+teste[0];
                                            
                                            var dataV = dataTipoBr;
                                            var dataV_formatada = inputData;
                                            var parcelas = inputParcelas; 

                                            var arrayteste = dataV_formatada.split('-');
                                            var meses = arrayteste[1]-1;
                                            var datast = arrayteste[0]+"-"+meses+"-"+arrayteste[2];
                                            
                                            dataV_formatada = datast;
                                        
                                            for(i = 0; i < parcelas; i++){
                                                $.ajax({
                                                    type: "GET",
                                                    url: `${apiData.api}token=${apiData.token_api}&description=${apiData.agradecimento}&amount=${$("#valor_u").val()}&dueDate=${dataV}&maxOverdueDays=${apiData.max_dias_venc}&installments=1&payerName=${socio.nome}&payerCpfCnpj=${socio.cpf}&payerEmail=${socio.email}&payerPhone=${socio.telefone}&billingAddressStreet=${socio.logradouro}&billingAddressNumber=${socio.numero_endereco}&billingAddressComplement=${socio.complemento}&billingAddressNeighborhood=${socio.bairro}&billingAddressCity=${socio.cidade}&billingAddressState=${socio.estado}&billingAddressPostcode=${socio.cep}&fine=${apiData.multa}&interest=${apiData.juros}&paymentTypes=BOLETO&notifyPayer=TRUE&reference=${geraRef(socio.nome)}`,
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
                                                var arrayDataSegments = dataV_formatada.split('-');
                                                var novaData = new Date(arrayDataSegments[0], arrayDataSegments[1], arrayDataSegments[2]);
                                                novaData.setMonth(novaData.getMonth() + 6);
                                                dataV_formatada = `${novaData.getFullYear()}-${novaData.getMonth()}-${novaData.getDate()}`;
                                                dataV = `${novaData.getDate()}/${novaData.getMonth()+1}/${novaData.getFullYear()}`;
                                            }
                                            CadastraCobrancas(carneBoletos, socio.id_socio);
                                            montaTabela(socio.nome, carneBoletos, 'semestral', socio.telefone);
                                            carneBoletos = [];
                                        break;

                                    }
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

        $("#btn_voltar").css("display","block");
        $("#btn_gerar_unico").css("display","none");
        $("#btn_voltar").click(function(){
            location.reload();
        })
        // $("#num_parcelas").val("");
        // $("#data_vencimento").val("");
        // $("#valor_u").val("");
        // $("#tipo_geracao").val("7");
        // $("#num_parcelas").prop('disabled', false);
    })
})