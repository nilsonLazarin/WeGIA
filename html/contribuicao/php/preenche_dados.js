function preencher(id)
{
    $("#vazio").html(" ");
    $("#vazio_cartao_mensal").html(" ");
    $("#vazio_cartao_unico").html(" ");
    $("#preenche_bolr1").html("<td><input type='text'  class='form-control' name='minval' id='minval'value=></td><td><input type='text' class='form-control' name='minvalparc' id='minvalparc' value=></td><td><input type='text' class='form-control' name='maivalparc' id='maivalparc' value=></td>");
    $("#preenche_bolr2").html("<td><input type='text' class='form-control' name='unicdiasv' id='unicdiasv' value=></td><td><input type='text' class='form-control' name='mensaldiasv' id='mensaldiasv' value=></td><td><input type='text' class='form-control' name='juros' id='juros' value=></td>");
    $("#preenche_bolr3").html("<td><input type='text' class='form-control' name='multa' id='multa' value=></td><td><textarea class='form-control' name='agradecimento' cols='18'  id='agrad'></textarea></td>");

    $("#preenche_bol1").html("<td><input type='number' class='form-control' name='op01' value=></td><td><input type='number' class='form-control' name='op02' value=></td><td><input type='number' class='form-control' name='op03' value=></td>");
    $("#preenche_bol2").html("<td><input type='number' class='form-control' name='op04' value=></td><td><input type='number' class='form-control' name='op05' value=></td><td><input type='number' class='form-control' name='op06' value=></td>");

    $("#info_bol3").html("<td><input type='text' class='form-control' name='api' value=></td><td><input type='text' class='form-control' name='token_api' value=></td><td><input type='text' class='form-control' name='sandbox' value=></td>");
    $("#info_bol4").html("<td><input type='text' class='form-control' name='token_sandbox' value=></td>");
    
    $.post("atualiza_sistema_boleto.php", {'id_sistema':id})
    .done(function(data){
        var array = data.split('ERR');
        var aviso = array[1];
            if(array.length == 2)
            {
                $("#form1").attr("action", "insere_doacao.php"); 
               
            }else{
                $("#form1").attr("action", "atualizacao_doacao.php"); 
            
            }
        $("#vazio").html(aviso);    
        var dados = JSON.parse(data);
        var cod = dados.cod_regras;
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

        $("#regras_sistema").html("<input type='hidden' id='regras_sistema' name='regras_sistema' value="+cod+">");

        $("#preenche_bolr1").html("<td><input type='text' class='form-control' name='minval' id='minval'value="+minvalunic+"></td><td><input type='text' class='form-control' name='minvalparc' id='minvalparc' value="+minvalparc+"></td><td><input type='text' class='form-control' name='maivalparc' id='maivalparc' value="+maivalparc+"></td>");
        $("#preenche_bolr2").html("<td><input type='text' class='form-control' name='unicdiasv' id='unicdiasv' value="+unicdiasv+"></td><td><input type='text' class='form-control' name='mensaldiasv' id='mensaldiasv' value="+mensaldiasv+"></td><td><input type='text' class='form-control' name='juros' id='juros' value="+juros+"></td>");
        $("#preenche_bolr3").html("<td><input type='text' class='form-control' name='multa' id='multa' value="+multa+"></td><td><textarea class='form-control' name='agradecimento' cols='18'  id='agrad'>"+agrade+"</textarea></td>");

       $("#preenche_bol1").html("<td><input type='number' class='form-control' name='op01' value="+op1+"></td><td><input type='number' class='form-control' name='op02' value="+op2+"></td><td><input type='number' class='form-control' name='op03' value="+op3+"></td>");
       $("#preenche_bol2").html("<td><input type='number' class='form-control' name='op04' value="+op4+"></td><td><input type='number' class='form-control' name='op05' value="+op5+"></td><td><input type='number' class='form-control' name='op06' value="+op6+"></td>");

       $("#info_bol3").html("<td><input type='text' class='form-control' name='api' value="+API+"></td><td><input type='text' class='form-control' name='token_api' value="+token+"></td><td><input type='text' class='form-control' name='sandbox' value="+sandbox+"></td>");
       $("#info_bol4").html("<td><input type='text' class='form-control' name='token_sandbox' value="+token_sandbox+"></td>");
    });
}
    
function preenche_dados_cartao(id)
{
    var id;
    $.post("../php/atualiza_sistema_cartao_unico.php", {'id_sistema':id})
    .done(function(data){
        var aviso = data.split('ERR');
        aviso = aviso[1];
            if(aviso != '')
            {
                $("#form2").attr("action", "insere_doacao.php");
                $("#avulso_link").html("<td><input type='text' class='form-control' name='avulso_link' value=></td>");
            }else{
                $("#form2").attr("action", "atualizacao_doacao.php");
               
            }
        $("#vazio_cartao_unico").html(aviso);
        var dados = JSON.parse(data);    
        var link_avulso = dados.LINK_AVULSO;
        var cod = dados.cod;
        $("#avulso_link").html("<td><input type='text' class='form-control' name='avulso_link' value="+link_avulso+"></td>");
        $("#cod_sistema").html(cod);
    });
    
    $.post("../php/atualiza_sistema_cartao_mensal.php", {'id_sistema':id})
    .done(function(data){
        var array = data.split("ERR");
            if(array.length == 2)
            {
                $("#doacao_mensal").html(array[0]);
                $("#doacao_mensal").html(array[1]);
                $("#insere_doacao_mensal").fadeIn();
                $("#form2").attr("action", "insere_doacao.php");
               
            } else{
                $("#doacao_mensal").html(data);
                $("#insere_doacao_mensal").hide();
                $("#form2").attr("action", "atualizacao_doacao.php");
              
            }
        
            
    });
}