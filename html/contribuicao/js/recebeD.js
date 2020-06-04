function recebe_dados()
{
  var horadata = new Date();
  var horaAtual = horadata.getHours();
  var minutoAtual = horadata.getMinutes();

  var hora = horaAtual+":"+minutoAtual;
  

  var email = $("#email").val();
  var telefone = $("#telefone").val();
  var cep = $("#cep").val();
  var log = $("#rua").val();
  var bairro = $("#bairro").val();
  var cidade = $("#localidade").val();
  var uf = $("#uf").val();
  var num = $("#numero").val();
  var comp = $("#complemento").val(); 
  var sistema = $("#forma2").val();
    

    if($("#op_cpf").prop('checked'))
    {
      var nome = $("#nome").val();
      var fisjur = $("#op_cpf").val();
      var dia = $("#dia").val();
      var mes = $("#mes").val();
      var ano = $("#ano").val();
      var doc = $("#dcpf").val();
      var dataN = dia.concat("/",mes,"/",ano);

      $.post("./php/cadastrar.php", {'tipo':fisjur, 'nome':nome, 'telefone':telefone, 'cep':cep, 'log':log, 'comp':comp, 'bairro':bairro, 'cidade':cidade, 'uf':uf, 'numero': num, 'doc':doc,'datanascimento':dataN, 'hora':hora, 'sistema':sistema, 'contato':email}).done(function(data){console.log(data)});

      //gera_boleto();
    }
    else
    {
      nome = $("#cnpj_nome").val();
      fisjur = $("#op_cnpj").val();
      doc = $("#dcnpj").val();
      dataN = "00/00/0000"

      $.post("./php/cadastrar.php", {'tipo':fisjur, 'nome':nome, 'telefone':telefone, 'cep':cep, 'log':log, 'comp':comp, 'bairro':bairro, 'cidade':cidade, 'uf':uf, 'numero': num, 'doc':doc,'datanascimento':dataN, 'hora':hora, 'sistema':sistema, 'contato':email}).done(function(data){});

      //gera_boleto();
    }
}