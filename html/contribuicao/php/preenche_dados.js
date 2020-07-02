function preencher(id)
{
    $("#preenche_bolr1").html("<td><input type='text' name='minval' id='minval'value=></td><td><input type='text' name='minvalparc' id='minvalparc' value=></td><td><input type='text' name='maivalparc' id='maivalparc' value=></td>");
    $("#preenche_bolr2").html("</td><td><input type='text' name='unicdiasv' id='unicdiasv' value=></td><td><input type='text' name='mensaldiasv' id='mensaldiasv' value=></td><td><input type='text' name='juros' id='juros' value=></td>");
    $("#preenche_bolr3").html("<td><input type='text' name='multa' id='multa' value=></td><td><input type='text' name='agradecimento' id='agrad' value=></td>");

    $("#preenche_bol2").html("<td><input type='number' name='op1' value=></td><td><input type='number' name='op2' value=></td><td><input type='number' name='op3' value=></td>");
    $("#preenche_bol2.2").html("<td><input type='number' name='op4' value=></td><td><input type='number' name='op5' value=></td><td><input type='number' name='op6' value=></td>");

    $("#info_bol").html("<td><input type='text' name='api' value=></td><td><input type='text' name='token_api' value=></td><td><input type='text' name='sandbox' value=></td>");
    $("#info_bol2").html("<td><input type='text' name='token_sandbox' value=></td>");
    var id;
    
        if(id == '')
        {
            id =3;
           
        }
    $.post("../php/atualiza_sistema_boleto.php", {'id_sistema':id})
    .done(function(data){
        var dados = JSON.parse(data);
        var cod = dados.cod;
        var minvalunic = dados.MinValUnic;
        var mensaldiasv = dados.MensalDiasV;
        var juros = dados.juros;
        var multa = dados.multa;
        var maivalparc = dados.MaiValParc;
        var minvalparc = dados.MinValParc;
        var agrade = dados.agradecimento;
        var unicdiasv = dados.UnicDiasV;
        var op1 = dados.opVenc0;
        var op2 = dados.opVenc1;
        var op3 = dados.opVenc2;
        var op4 = dados.opVenc3;
        var op5 = dados.opVenc4;
        var op6 = dados.opVenc5
        var API = dados.API;
        var token = dados.token;
        var sandbox = dados.sandbox;
        var token_sandbox = dados.token_sandbox;

        $("#cod_sistema").html("<input type='hidden' id='cod_sistema' name='cod_sistema' value="+cod+">");

        $("#preenche_bolr1").html("<td><input type='text' name='minval' id='minval'value="+minvalunic+"></td><td><input type='text' name='minvalparc' id='minvalparc' value="+minvalparc+"></td><><input type='text' name='maivalparc' id='maivalparc' value="+maivalparc+">");
        $("#preenche_bolr2").html("</td><td><input type='text' name='unicdiasv' id='unicdiasv' value="+unicdiasv+"></td><td><input type='text' name='mensaldiasv' id='mensaldiasv' value="+mensaldiasv+"></td><td><input type='text' name='juros' id='juros' value="+juros+"></td>");
        $("#preenche_bolr3").html("<td><input type='text' name='multa' id='multa' value="+multa+"></td><td><input type='text' name='agradecimento' id='agrad' value="+agrade+"></td>");

       $("#preenche_bol2").html("<td><input type='number' name='op1' value="+op1+"></td><td><input type='number' name='op2' value="+op2+"></td><td><input type='number' name='op3' value="+op3+"></td>");
       $("#preenche_bol2.2").html("<td><input type='number' name='op4' value="+op4+"></td><td><input type='number' name='op5' value="+op5+"></td><td><input type='number' name='op6' value="+op6+"></td>");

       $("#info_bol").html("<td><input type='text' name='api' value="+API+"></td><td><input type='text' name='token_api' value="+token+"></td><td><input type='text' name='sandbox' value="+sandbox+"></td>");
       $("#info_bol2").html("<td><input type='text' name='token_sandbox' value="+token_sandbox+"></td>");
    });
}
    
function preenche_dados_cartao(id)
{
    var id;
    $.post("../php/atualiza_sistema_cartao_unico.php", {'id_teste':id})
    .done(function(data){
        var dados = JSON.parse(data);     
        var link_avulso = dados.LINK_AVULSO;
        var cod = dados.cod;

        $("#avulso_link").html("<td><input type='text' name='avulso_link' value="+link_avulso+"></td>");
        $("#cod_sistema").html(cod);
    });
    
    $.post("../php/atualiza_sistema_cartao_mensal.php", {'id_teste':id})
    .done(function(data){
       
        $("#doacao_mensal").html(data);
    });
}