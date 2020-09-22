function preencher(id)
{
    $("#preenche_bolr1").html("<td><input type='text'  class='form-control' readonly='true' name='minval' id='minval'  value=></td><td><input type='text' class='form-control' readonly='true' name='minvalparc' id='minvalparc' value=></td><td><input type='text' class='form-control' readonly='true' name='maivalparc' id='maivalparc' value=></td>");
    $("#preenche_bolr2").html("<td><input type='text' class='form-control'  readonly='true' name='unicdiasv' id='unicdiasv' value=></td><td><input type='text' class='form-control' readonly='true' name='mensaldiasv' id='mensaldiasv' value=></td><td><input type='text' class='form-control'readonly='true' name='juros' id='juros' value=></td>");
    $("#preenche_bolr3").html("<td><input type='text' class='form-control' readonly='true' name='multa' id='multa' value=></td><td><textarea class='form-control' readonly='true' name='agradecimento' cols='18'  id='agrad'></textarea></td>");

    $("#preenche_bol1").html("<td><input type='number' class='form-control' readonly='true' id='op01' name='op01' value=></td><td><input type='number' class='form-control' readonly='true' id='op02' name='op02' value=></td><td><input type='number' class='form-control' readonly='true' id='op03' name='op03' value=></td>");
    $("#preenche_bol2").html("<td><input type='number' class='form-control' readonly='true' id='op04' name='op04' value=></td><td><input type='number' class='form-control' readonly='true' id='op05' name='op05' value=></td><td><input type='number' class='form-control' readonly='true' id='op06' name='op06' value=></td>");

    $("#info_bol3").html("<td><input type='text' class='form-control' readonly='true' id='api' name='api' value=></td><td><input type='text' class='form-control' readonly='true' id='token_api' name='token_api' value=></td><td><input type='text' class='form-control' readonly='true' id='sandbox' name='sandbox' value=></td>");
    $("#info_bol4").html("<td><input type='text' class='form-control' readonly='true' id='token_sandbox' name='token_sandbox' value=></td>");
    
    $.post("atualiza_sistema_boleto.php", {'id_sistema':id})
    .done(function(data){
        
        var array = data.split('ERR');
            if(array.length == 2)
            {
                $("#form1").attr("action", "insere_doacao.php"); 
                $("#alerta_boleto").fadeIn();
                   
            }else{
                $("#form1").attr("action", "atualizacao_doacao.php"); 
                $("#alerta_boleto").hide();
            
            }
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

        $("#preenche_bolr1").html("<td><input type='text' class='form-control' name='minval' id='minval' readonly='true' value="+minvalunic+"></td><td><input type='text' readonly='true' class='form-control' name='minvalparc' id='minvalparc' value="+minvalparc+"></td><td><input type='text' readonly='true' class='form-control' name='maivalparc' id='maivalparc' value="+maivalparc+"></td>");
        $("#preenche_bolr2").html("<td><input type='text' readonly='true' class='form-control' name='unicdiasv' id='unicdiasv' value="+unicdiasv+"></td><td><input type='text' readonly='true' class='form-control' name='mensaldiasv' id='mensaldiasv' value="+mensaldiasv+"></td><td><input type='text' readonly='true' class='form-control' name='juros' id='juros' value="+juros+"></td>");
        $("#preenche_bolr3").html("<td><input type='text' readonly='true' class='form-control' name='multa' id='multa' value="+multa+"></td><td><textarea readonly='true' class='form-control' name='agradecimento' cols='18'  id='agrad'>"+agrade+"</textarea></td>");

       $("#preenche_bol1").html("<td><input type='number' readonly='true' class='form-control' id='op01' name='op01' value="+op1+"></td><td><input type='number' readonly='true' class='form-control' id='op02' name='op02' value="+op2+"></td><td><input type='number'  readonly='true' class='form-control' id='op03' name='op03' value="+op3+"></td>");
       $("#preenche_bol2").html("<td><input type='number' readonly='true' class='form-control' id='op04' name='op04' value="+op4+"></td><td><input type='number' readonly='true' class='form-control' id='op05' name='op05' value="+op5+"></td><td><input type='number' readonly='true' class='form-control' id='op06' name='op06' value="+op6+"></td>");

       $("#info_bol3").html("<td><input type='text' readonly='true' class='form-control' id='api' name='api' value="+API+"></td><td><input type='text' readonly='true' class='form-control' id='token_api' name='token_api' value="+token+"></td><td><input type='text' readonly='true' class='form-control' id='sandbox' name='sandbox' value="+sandbox+"></td>");
       $("#info_bol4").html("<td><input type='text' readonly='true' class='form-control' id='token_sandbox' name='token_sandbox' value="+token_sandbox+"></td>");
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
                $("#avulso_link_tr").html("<td><input type='text' id='avulso_link' class='form-control' readonly='true' name='avulso_link' value=></td>");
                $("#alerta_cartao").fadeIn();
                
                
            }else{
                $("#form2").attr("action", "atualizacao_doacao.php");
                $("#avulso_link_tr").html("<td><input type='text' id='avulso_link' class='form-control' readonly='true' name='link_avulso' value=></td>");
                $("#alerta_cartao").hide();
                
            }
        var dados = JSON.parse(data);    
        var link_avulso = dados.LINK_AVULSO;
        var cod = dados.cod;
        $("#avulso_link_tr").html("<td><input type='text' class='form-control' name='link_avulso' id='avulso_link' readonly='true' value="+link_avulso+"></td>");
        $("#cod_cartao").html(cod);

    });
       
    $.post("../php/atualiza_sistema_cartao_mensal.php", {'id_sistema':id})
    .done(function(data){
       
        var array = data.split("ERR");
            if(array.length == 2)
            {
                 $("#alerta_cartao").fadeIn();
                $("#doacao_mensal").html(array[0]);
                $("#insere_doacao_mensal").fadeIn();
                $("#form2").attr("action", "insere_doacao.php");
               
  
            } else{
                $("#alerta_cartao").hide();   
                $("#doacao_mensal").html(data);
                $("#insere_doacao_mensal").hide();
                $("#form2").attr("action", "atualizacao_doacao.php");
                
                
            }        
    });
        
}

function verificar_form()
{

}

function editando(){
    $("#btn-bol").fadeIn();
    $("#editar-bol").hide();

    $("input").prop("readonly", false);
    $("textarea").prop("readonly", false);
    
}

function editando_card()
{
    $("#btn-bol").hide();
    $("#editar-bol").hide();
    $("#editar-card").hide();
    $("#btn-card").fadeIn();

    $("input").prop("readonly", false);
    $("#valor").prop("readonly", false);
    $("#link").prop("readonly", false);
   
}