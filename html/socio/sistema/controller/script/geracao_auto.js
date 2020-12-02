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
                                var apiData = JSON.parse(dados_api)[0];
                                for(socio of socios){
                                    switch(tipo_desejado){
                                        case 4:
                                            var dataV = 
                                            $.get(`${apiData.api}token=${apiData.token_api}&description=${apiData.agradecimento}&amount=${socio.valor_periodo}&dueDate=<?php echo($dataV); ?>&maxOverdueDays=<?php echo($max_dias_venc); ?>&installments=1&payerName=<?php echo($nome); ?>&payerCpfCnpj=<?php echo($cpf); ?>&payerEmail=<?php echo($email); ?>&payerPhone=<?php echo($telefone); ?>&billingAddressStreet=<?php echo($logradouro); ?>&billingAddressNumber=<?php echo($numero_endereco); ?>&billingAddressComplement=<?php echo($complemento); ?>&billingAddressNeighborhood=<?php echo($bairro); ?>&billingAddressCity=<?php echo($cidade); ?>&billingAddressState=<?php echo($estado); ?>&billingAddressPostcode=<?php echo($cep); ?>&fine=<?php echo($multa); ?>&interest<?php echo($juros); ?>&paymentTypes=BOLETO&notifyPayer=TRUE&reference=${referencia}`)
                                        break;
                                    }
                                }
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