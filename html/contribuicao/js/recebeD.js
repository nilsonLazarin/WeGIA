function recebe_dados()
{
  var id_sociotipo = tipo_socio();
 
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
  var sistema = 3;
  var status = 0;
    

    if($("#op_cpf").prop('checked'))
    {
      var nome = $("#nome").val();
      var sobrenome = $("#sbnome").val();
      var fisjur = $("#op_cpf").val();
      var dia = $("#dia").val();
      var mes = $("#mes").val();
      var ano = $("#ano").val();
      var doc = $("#dcpf").val();
      var dataN = ano.concat("/",mes,"/",dia);

      $.post("./php/cadastrar.php", {'tipo':fisjur, 'nome':nome, 'sobrenome': sobrenome, 'telefone':telefone, 'cep':cep, 'log':log, 'comp':comp, 'bairro':bairro, 'cidade':cidade, 'uf':uf, 'numero': num, 'doc':doc,'datanascimento':dataN, 'hora':hora, 'sistema':sistema, 'contato':email, 'id_sociotipo': id_sociotipo, 'status': status}).done(function(data){console.log(data)});

      gera_boleto();
    }
    else
    {
      nome = $("#cnpj_nome").val();
      sobrenome = "NULL";
      fisjur = $("#op_cnpj").val();
      doc = $("#dcnpj").val();
      dataN = "0000-00-00"

      $.post("./php/cadastrar.php", {'tipo':fisjur, 'nome':nome, 'sobrenome':sobrenome, 'telefone':telefone, 'cep':cep, 'log':log, 'comp':comp, 'bairro':bairro, 'cidade':cidade, 'uf':uf, 'numero': num, 'doc':doc,'datanascimento':dataN, 'hora':hora, 'sistema':sistema, 'contato':email, 'id_sociotipo': id_sociotipo, 'status': status}).done(function(data){});
      gera_boleto();
    }
}
