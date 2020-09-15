function dataVencimento()
{
        var dia = retorna_dia();
        var now = new Date;
        var diaA = now.getDate();
        console.log(diaA);
        var mesA = now.getMonth()+1;
        var anoA = now.getFullYear();
            if(dia<diaA)
            {
                var mes_atual = now.getMonth() + 2;
            }
            else
            {
                var mes_atual = now.getMonth() + 1;
            }

        var ano_atual = now.getFullYear();
        var dataV = ano_atual+"-"+mes_atual+"-"+dia;

        return dataV;
}


function recebe_dados()
{
  
  var id_sociotipo = tipo_socio();
 
  var horadata = new Date();
  var horaAtual = horadata.getHours();
  var minutoAtual = horadata.getMinutes();
  var hora = horaAtual+":"+minutoAtual;
      if($("#tipo1").prop('checked'))
        {
            var valor_contribuicao = $("#valores option:selected").val();
                
        }
        else
            {
              valor_contribuicao = $("#v").val();
            }
  var data_vencimento = dataVencimento();
  console.log(data_vencimento);

  var email = $("#email").val();
  var telefone = $("#telefone").val();
  var cep = $("#cep").val();
  var log = $("#rua").val();
  var bairro = $("#bairro").val();
  var cidade = $("#localidade").val();
  var uf = $("#uf").val();
  var num = $("#numero").val();
  var comp = $("#complemento").val(); 
  var sistema = 3;
  var status = 0;
    

    if($("#op_cpf").prop('checked'))
    {
      var nome = $("#nome").val();
      var sobrenome = $("#sbnome").val();
      var fisjur = $("#op_cpf").val();
      var dia = $("#dia_n").val();
      var mes = $("#mes").val();
      var ano = $("#ano").val();
      var doc = $("#cpfcnpj").val();
      var dataN = ano.concat("-",mes,"-",dia);

      $.post("./php/cadastrar.php", {'tipo':fisjur, 'nome':nome, 'sobrenome': sobrenome, 'telefone':telefone, 'cep':cep, 'log':log, 'comp':comp, 'bairro':bairro, 'cidade':cidade, 'uf':uf, 'numero': num, 'doc':doc,'datanascimento':dataN, 'hora':hora, 'sistema':sistema, 'contato':email, 'id_sociotipo': id_sociotipo, 'status': status, 'datavencimento':data_vencimento, 'valor_doacao':valor_contribuicao}).done(function(data){console.log(data)});

      gera_boleto();
    }
    else
    {
      nome = $("#cnpj_nome").val();
      sobrenome = "NULL";
      fisjur = $("#op_cnpj").val();
      doc = $("#cpfcnpj").val();
      console.log(doc);
      dataN = "0000-00-00"

      $.post("./php/cadastrar.php", {'tipo':fisjur, 'nome':nome, 'sobrenome':sobrenome, 'telefone':telefone, 'cep':cep, 'log':log, 'comp':comp, 'bairro':bairro, 'cidade':cidade, 'uf':uf, 'numero': num, 'doc':doc,'datanascimento':dataN, 'hora':hora, 'sistema':sistema, 'contato':email, 'id_sociotipo': id_sociotipo, 'status': status,  'datavencimento':data_vencimento, 'valor_doacao':valor_contribuicao}).done(function(data){});
      
      gera_boleto();
    }
}
