//Neste código estão as funções para: verificar se há documento referente ao sócio doador cadastrado no Banco de Dados, editar as informações do sócio no Banco de Dados caso já haja cadastro, e cadastrar um novo sócio caso seja a primeira vez de sua doação. Estão aqui também algumas funções complementares para: verificar a data de vencimento da doação e o tipo de sócio contribuinte. 

function doc_cadastrado()
{
        if($("#op_cpf").prop('checked'))
        {
            var doc = $("#dcpf").val();
        }else{
            doc = $("#dcnpj").val();
        }

    cpf_cnpj(doc);
        
}

function socio_cadastrado(doc)
{
    var doc = doc;
    doc = formata_cpf_cnpj(doc);
        $.post("./php/socioCadastrado.php", {'doc':doc}).done(function(data){
                if(data == 0)
                {
                    $("#verifica_socio_btn").hide();
                    $("#verifica_socio").hide();
                    $("#pag2").fadeIn();
                }else
                    {
                     
                        var dados = JSON.parse(data);
                        var data_n = dados.data_nascimento;
                        if(data_n != null)
                        {
                            data_n = data_n.split("-");
                        }else{
                            data_n[2] = 00;
                            data_n[1] = 00;
                            data_n[0] = 0000;
                        }
                       
                        $("#nome").val(dados.nome);
                        $("#cnpj_nome").val(dados.nome);
                        $("#dia_n").val(data_n[2]);
                        $("#mes").val(data_n[1]);
                        $("#ano").val(data_n[0]);
                        $("#telefone").val(dados.telefone);
                        $("#email").val(dados.email);
                        $("#cep").val(dados.cep);
                        $("#rua").val(dados.logradouro);
                        $("#numero").val(dados.numero_endereco);
                        $("#complemento").val(dados.complemento);
                        $("#bairro").val(dados.bairro);
                        $("#localidade").val(dados.cidade);
                        $("#uf").val(dados.estado);

                        $("#verifica_socio").hide();
                        $("#pag2").hide();
                        $("#pag3").hide();
                        $("#form2").fadeIn();
                        $("#form2").html('<h3>Obrigado por contribuir mais uma vez, '+dados.nome+'!</h3><br><br><div class="container-contact100-form-btn"><span class="contact100-form-btn" id = "gerar_boleto"><i style="margin-right: 15px; " class="fa fa-long-arrow-right m-l-7"aria-hidden="true"></i>GERAR BOLETO</span></div><div class="container-contact100-form-btn"><span class="contact100-form-btn" id = "editar_infos"><i style="margin-right: 15px; " class="fa fa-long-arrow-left m-l-7"aria-hidden="true"></i>EDITAR DADOS CADASTRADOS</span></div><div class="container-contact100-form-btn"><span class="contact100-form-btn"><i style="margin-right: 15px; " aria-hidden="true"></i><a class= "botao" href="../contribuicao/index.php">VOLTAR A PÁGINA INICIAL</a></span></div>');

                        $("#gerar_boleto").click(function(){geraBoleto();});
                        $("#editar_infos").click(function(){
                            
                            $("#form2").hide();
                            $("#pag2").fadeIn();
                            $("#avanca3").hide();
                            $("#salvar_infos").fadeIn();
                        });
                        $("#salvar_infos").click(function(){ editar_informacoes();});
                    }
        });
}

function editar_informacoes()
{
    if($("#op_cpf").prop('checked'))
    {
        var doc = $("#dcpf").val();
    }else{
        doc = $("#dcnpj").val();
    }
    var nome = $("#nome").val();
    var cnpj_nome = $("#cnpj_nome").val();
    var data_n = $("#ano").val()+"-"+$("#mes").val()+"-"+$("#dia_n").val();
    var tel = $("#telefone").val();
    var email = $("#email").val();
    var cep = $("#cep").val();
    var rua = $("#rua").val();
    var numero = $("#numero").val();
    var compl = $("#complemento").val();
    var bairro = $("#bairro").val();
    var cidade = $("#localidade").val();
    var uf = $("#uf").val();
    if(nome == ''){
        nome = cnpj_nome;
    }
        $.post("./php/editaSocio.php",{'nome':nome, 'telefone':tel, 'email':email, 'doc':doc, 'datanascimento':data_n, 'cep': cep, 'log':rua, 'numero':numero, 'comp':compl, 'bairro':bairro, 'cidade':cidade, 'uf':uf}).done(function(data){
                $("#form2").fadeIn();
                $("#form2").html('<h3> Dados atualizados com sucesso!</h3><br><br><div class="container-contact100-form-btn"><span class="contact100-form-btn" id = "dados_atualizados"><i style="margin-right: 15px; " class="fa fa-long-arrow m-l-7"aria-hidden="true"></i>OK</span></div>')
                $("#pag3").hide();
                        $("#dados_atualizados").click(function(){$("#form2").html('<h3>Obrigado por contribuir mais uma vez, '+nome+'!</h3><br><br><div class="container-contact100-form-btn"><span class="contact100-form-btn" id = "gerar_boleto"><i style="margin-right: 15px; " class="fa fa-long-arrow-right m-l-7"aria-hidden="true"></i>GERAR BOLETO</span></div><div class="container-contact100-form-btn"><span class="contact100-form-btn" id = "editar_infos"><i style="margin-right: 15px; " class="fa fa-long-arrow-left m-l-7"aria-hidden="true"></i>EDITAR DADOS CADASTRADOS</span></div><div class="container-contact100-form-btn"><span class="contact100-form-btn"><i style="margin-right: 15px; " aria-hidden="true"></i><a class= "botao" href="../contribuicao/index.php">VOLTAR A PÁGINA INICIAL</a></span></div>');
                        $("#gerar_boleto").click(function(){geraBoleto();});
                        $("#editar_infos").click(function(){
                            
                            $("#form2").hide();
                            $("#pag2").fadeIn();
                            $("#avanca3").hide();
                            $("#salvar_infos").fadeIn();
                        });
                        $("#salvar_infos").click(function(){ editar_informacoes();});
                });
                        
        });
                        
}
function cadastra_socio()
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
  

  var email = $("#email").val();
  var telefone = $("#telefone").val();
  var cep = $("#cep").val();
  var log = $("#rua").val();
  var bairro = $("#bairro").val();
  var cidade = $("#localidade").val();
  var uf = $("#uf").val();
  var num = $("#numero").val();
  var comp = $("#complemento").val(); 
  var sistema = $("#id_sistema").val();
  var status = 0;    

    if($("#op_cpf").prop('checked'))
    {
      var nome = $("#nome").val();
      var sobrenome = $("#sbnome").val();
      var fisjur = $("#op_cpf").val();
      var dia = $("#dia_n").val();
      var mes = $("#mes").val();
      var ano = $("#ano").val();
      var doc = $("#dcpf").val();
      doc = formata_cpf_cnpj(doc);
      var dataN = ano.concat("-",mes,"-",dia);

      $.post("./php/cadastrarSocio.php", {'tipo':fisjur, 'nome':nome, 'sobrenome': sobrenome, 'telefone':telefone, 'cep':cep, 'log':log, 'comp':comp, 'bairro':bairro, 'cidade':cidade, 'uf':uf, 'numero': num, 'doc':doc,'datanascimento':dataN, 'hora':hora, 'sistema':sistema, 'contato':email, 'id_sociotipo': id_sociotipo, 'status': status, 'datavencimento':data_vencimento, 'valor_doacao':valor_contribuicao}).done(function(data){console.log(data)
    geraBoleto();
    });

      
    }
    else
    {
      nome = $("#cnpj_nome").val();
      sobrenome = "NULL";
      fisjur = $("#op_cnpj").val();
      doc = $("#dcnpj").val();
      doc = formata_cpf_cnpj(doc);
      dataN = "0000-00-00"

      $.post("./php/cadastrarSocio.php", {'tipo':fisjur, 'nome':nome, 'sobrenome':sobrenome, 'telefone':telefone, 'cep':cep, 'log':log, 'comp':comp, 'bairro':bairro, 'cidade':cidade, 'uf':uf, 'numero': num, 'doc':doc,'datanascimento':dataN, 'hora':hora, 'sistema':sistema, 'contato':email, 'id_sociotipo': id_sociotipo, 'status': status,  'datavencimento':data_vencimento, 'valor_doacao':valor_contribuicao}).done(function(data){console.log(data);
    geraBoleto();
    });
      
      
    }
}

function cad_log(socioTipo)
{
    var id_sistema = $("#id_sistema").val();

    var socioTipo = socioTipo;
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
  var email = $("#email").val();
  if($("#op_cpf").prop('checked'))
    {
        var doc = $("#dcpf").val();
    }else{
        doc = $("#dcnpj").val();
    }
    $.post("./php/cadastroLog.php",{'hora':hora, 'valor_doacao':valor_contribuicao, 'dataV':data_vencimento, 'email':email, 'doc':doc, 'sistema':id_sistema, 'socioTipo': socioTipo}).done(function(data){console.log(data);});
}

function dataVencimento()
{       
        var now = new Date;
        var diaA = now.getDate();
        var dia = retorna_dia();
          if(dia == diaA)
          {
            dia = now.getDate()+3;
          }
        
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

function tipo_socio(){
    
    if($("#tipo1").prop('checked') && $("#op_cpf").prop('checked')){
        var tipo_doacao = 2;
    }else
        {
            if($("#tipo2").prop('checked') && $("#op_cpf").prop('checked')){
                tipo_doacao = 0;
            }else
                {
                    if($("#tipo1").prop('checked') && $("#op_cnpj").prop('checked')){
                        tipo_doacao = 3;
                    }else
                        {
                            if($("#tipo2").prop('checked') && $("#op_cnpj").prop('checked')){
                                tipo_doacao = 1;
                            }
                        }

                }
        }

        return tipo_doacao;
}
