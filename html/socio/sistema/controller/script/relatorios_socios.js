$(document).ready(function(){
    $(document).on("submit", "#form_relatorio", function(e){
        e.preventDefault();
        var tipo_socio = $("#tipo_socio").val();
        var tipo_pessoa = $("#tipo_pessoa").val();
        var operador = $("#operador").val();
        var valor = $("#valor").val();

        $.get("get_relatorios_socios.php", {
            "tipo_socio": tipo_socio,
            "tipo_pessoa": tipo_pessoa,
            "operador": operador,
            "valor": valor
        })
            .done(function(retorno){
                var socios = JSON.parse(retorno);
                var tabela = "";
                console.log(socios);
                for(socio of socios){
                    tabela += `<tr><td>${socio.nome}</td><td>${socio.cpf}</td><td>${socio.telefone}</td><td>${socio.tipo}</td><td>${socio.valor_periodo}</td></tr>`
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
                        <tr>
                        <th scope="col" width="25%">Nome</th>
                        <th scope="col">CPF/CPNJ</th>
                        <th scope="col">Telefone</th>
                        <th scope="col" width="14%">Tipo Sócio</th>                            
                        <th scope="col" width="12%" class="tot">Valor/Período</th>
                        </tr>
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