$(document).ready(function(){

    // Geração para sócio único
    var teste;
    function procurar_desejado(id_socio){
        $.post("./controller/query_geracao_auto.php", {
            "query": `SELECT * FROM socio s JOIN pessoa p ON p.id_pessoa = s.id_pessoa WHERE s.id_sociostatus NOT IN (1,2,3,4) AND s.id_socio = ${id_socio}`
        })
            .done(function(dados){
                var socios = JSON.parse(dados);
                console.log(socios[0].nome);
                if(socios){
                    $(".configs_unico").css("display", "block");
                    $("#btn_geracao_unica").attr("disabled", false);
                    $(".div_btn_gerar").css("display", "block");
                    $("#btn_geracao_unica").text("Confirmar geração");
                    $("#btn_geracao_unica").click(function(){
                        var data_vencimento = $("#data_vencimento").val();
                        var tipo_boleto = $("#tipo_geracao").val();
                        var valor = $("#valor_u").val();
                        var parcelas = $("#num_parcelas").val();
                        console.log("data"+data_vencimento);     
                        console.log("tipo"+tipo_boleto);     
                        console.log("valor"+valor);     
                        console.log("parcelas"+parcelas); 
                        // montaTabelaInicial(data_vencimento, '20-12-21', 0, parcelas, valor, socios[0].nome)   
                    })
                    

                    $("#tipo_geracao").change(function(){
                        montaTabelaInicial('2021-12-20', '20-12-2021', 0, 5, 100, socios[0].nome);
                        
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
                        valor = parseFloat(valor);
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
                        var total = 0;
                        for(i = 0; i < parcelas; i++){
                            tabela += `<tr><td>${i+1}/${parcelas}</td><td>${dataV}</td><td>R$ ${valor}</td></tr>`
                            var arrayDataSegments = dataV_formatada.split('-');
                            var novaData = new Date(arrayDataSegments[0], arrayDataSegments[1], arrayDataSegments[2]);
                            novaData.setMonth(novaData.getMonth() + periodicidade_socio);
                            dataV_formatada = `${novaData.getFullYear()}-${novaData.getMonth()}-${novaData.getDate()}`;
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
                    // $("#data_vencimento").change(function(){
                    //     return data_vencimento;
                    // })
                    // console.log(data_vencimento);
                    
                }
            })
                
    }
                    
    $("#geracao").change(function(){
        var tipo_desejado = $(this).val();
        procurar_desejados(tipo_desejado);
    })
    $("#btn_gerar_unico").click(function(){
        var id_socio =  $("#id_pesquisa").val().split("|")[2];
        procurar_desejado(id_socio);
    })
})