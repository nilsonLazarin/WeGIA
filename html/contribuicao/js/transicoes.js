function atualiza(){

    var cod_regras
    var id_sistema
    var cod_cartao
    var link_avulso
    var valor
    var link 
    var id
    var MinValUnic
    var DiasV
    var juros
    var multa
    var MaiValParc
    var MinValParc
    var agrad
    var UnicDiasV
    var opVenc0
    var opVenc1
    var opVenc2
    var opVenc3
    var opVenc4
    var opVenc5
    var API
    var token
    var sandbox
    var token_sandbox

        var inputs = $('input[id="valor"]');
        var values = [];
        for(var i = 0; i < inputs.length; i++){
          values.push($(inputs[i]).val());
        }
        console.log(values);
      
}