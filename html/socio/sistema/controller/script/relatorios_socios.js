$(document).ready(function(){
    $(document).on("submit", "#form_relatorio", function(e){
        $(".resultado").html("");
        e.preventDefault();
        var tipo_socio = $("#tipo_socio").val();
        var tipo_pessoa = $("#tipo_pessoa").val();
        var operador = $("#operador").val();
        var valor = $("#valor").val();
        var status = $("#status").val();
        var suposicao = $("#sup").val();

        $.get("get_relatorios_socios.php", {
            "tipo_socio": tipo_socio,
            "tipo_pessoa": tipo_pessoa,
            "operador": operador,
            "valor": valor,
            "status": status,
            "suposicao": suposicao,
        })
            .done(function(retorno){
                var socios = JSON.parse(retorno);
                var tabela = "";
                console.log(socios);
                for(socio of socios){
                    if(suposicao === "s"){
                        var estrutura_tab = `<tr>
                        <th scope="col" width="25%">Nome</th>
                        <th scope="col">CPF/CPNJ</th>
                        <th scope="col">Último Vencimento</th>
                        <th scope="col">Telefone</th>
                        <th scope="col" width="14%">Tipo Sócio</th>                            
                        <th scope="col" width="12%" class="tot">Valor/Período</th>
                        </tr>`
                        valor_periodo = socio.valor;
                        if(socio.provavel_periodicidade >= 28 && socio.provavel_periodicidade <= 49){
                            var p_periodicidade = "Mensal";
                        }else if(socio.provavel_periodicidade > 49 && socio.provavel_periodicidade <= 70){
                            var p_periodicidade = "Bimestral";
                        }else if(socio.provavel_periodicidade > 70 && socio.provavel_periodicidade <= 100){
                            var p_periodicidade = "Trimestral";
                        }else if(socio.provavel_periodicidade > 100 && socio.provavel_periodicidade <= 200){
                            var p_periodicidade = "Semestral";
                        }else{
                            p_periodicidade = "sem informação/ocasional";
                        }
                        tipo_socio = `Provalvelmente ${$("#tipo_socio option:selected").text()}`;
                        tabela += `<tr><td>${socio.nome}</td><td>${socio.cpf}</td><td>${socio.data_formatada}</td><td>${socio.telefone}</td><td>Provavelmente ${p_periodicidade}</td><td>${valor_periodo}</td></tr>`
                    }else{
                        valor_periodo = socio.valor_periodo;
                        p_periodicidade = socio.tipo;
                        var estrutura_tab = `<tr>
                        <th scope="col" width="25%">Nome</th>
                        <th scope="col">CPF/CPNJ</th>
                        <th scope="col">Telefone</th>
                        <th scope="col" width="14%">Tipo Sócio</th>                            
                        <th scope="col" width="12%" class="tot">Valor/Período</th>
                        <th scope="col" width="12%" class="tot">Status</th>
                        </tr>`
                        tabela += `<tr><td>${socio.nome}</td><td>${socio.cpf}</td><td>${socio.telefone}</td><td>${socio.tipo}</td><td>${valor_periodo}</td><td>${socio.status}</td></tr>`
                    }
                }
                $(".resultado").html(`
                <div class="tab-content">
                <div class="descricao">
                    <p>
                        </p>
                            <h3>Relatório de Sócios</h3><ul>Sócios: ${$("#tipo_socio option:selected").text()}</ul><ul>Pessoas: ${$("#tipo_pessoa option:selected").text()}</ul><ul>Valor: ${$("#operador option:selected").text()} ${$("#valor").val()}</ul>							</li>
                    <p></p>
                    <button style="float: right;" class="mb-xs mt-xs mr-xs btn btn-default print-button" onclick="window.print();">Imprimir</button>
                </div>
            <h4>Resultado</h4>

                <table class="table table-striped">
                    <thead class="thead-dark">
                        ${estrutura_tab}
                    </thead>
                    <tbody>
                        ${tabela}
                    </tbody>
                </table>
            </div>
                `)
            })
    })
})