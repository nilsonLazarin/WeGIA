function doc_cadastrado()
{
    var doc = $("#cpfcnpj").val();
   
    cpf_cnpj(doc);
        
}

function socio_cadastrado(doc)
{
    var doc = doc;
        $.post("./php/socio_cadastrado.php", {'doc':doc}).done(function(data){
                if(data == 0)
                {
                    $("#verifica_socio_btn").hide();
                    $("#verifica_socio").hide();
                    $("#pag2").fadeIn();
                }else
                    {
                        var dados = JSON.parse(data);
                        var data_n = dados.data_n;
                        var data_n = data_n.split("-");


                        $("#nome").val(dados.nome);
                        $("#cnpj_nome").val(dados.nome);
                        $("#sbnome").val(dados.sobrenome);
                        $("#dia").val(data_n[2]);
                        $("#mes").val(data_n[1]);
                        $("#ano").val(data_n[0]);
                        $("#telefone").val(dados.tel);
                        $("#email").val(dados.email);
                        $("#cep").val(dados.cep);
                        $("#rua").val(dados.rua);
                        $("#numero").val(dados.numero);
                        $("#complemento").val(dados.compl);
                        $("#bairro").val(dados.bairro);
                        $("#localidade").val(dados.cidade);
                        $("#uf").val(dados.uf);

                        $("#verifica_socio").hide();
                        $("#pag2").hide();
                        $("#pag3").hide();
                        $("#form2").fadeIn();
                        $("#form2").html('<h3>Obrigado por contribuir mais uma vez, '+dados.nome+'!</h3><br><br><div class="container-contact100-form-btn"><span class="contact100-form-btn" id = "gerar_boleto"><i style="margin-right: 15px; " class="fa fa-long-arrow-right m-l-7"aria-hidden="true"></i>GERAR BOLETO</span></div><div class="container-contact100-form-btn"><span class="contact100-form-btn" id = "editar_infos"><i style="margin-right: 15px; " class="fa fa-long-arrow-left m-l-7"aria-hidden="true"></i>EDITAR DADOS CADASTRADOS</span></div><div class="container-contact100-form-btn"><span class="contact100-form-btn"><i style="margin-right: 15px; " aria-hidden="true"></i><a href="../contribuicao/index.php">VOLTAR A PÁGINA INICIAL</a></span></div>');

                        $("#gerar_boleto").click(function(){ gera_boleto();});
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
    var doc = $("#cpfcnpj").val();
    var nome = $("#nome").val();
    var cnpj_nome = $("#cnpj_nome").val();
    var sbnome = $("#sbnome").val();
    var data_n = $("#ano").val()+"-"+$("#mes").val()+"-"+$("#dia").val();
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
        $.post("./php/edita_socio.php",{'nome':nome, 'sobrenome':sbnome, 'telefone':tel, 'email':email, 'doc':doc, 'datanascimento':data_n, 'cep': cep, 'log':rua, 'numero':numero, 'comp':compl, 'bairro':bairro, 'cidade':cidade, 'uf':uf}).done(function(data){
                $("#form2").fadeIn();
                $("#form2").html('<h3> Dados atualizados com sucesso!</h3><br><br><div class="container-contact100-form-btn"><span class="contact100-form-btn" id = "dados_atualizados"><i style="margin-right: 15px; " class="fa fa-long-arrow m-l-7"aria-hidden="true"></i>OK</span></div>')
                $("#pag3").hide();
                        $("#dados_atualizados").click(function(){$("#form2").html('<h3>Obrigado por contribuir mais uma vez, '+nome+'!</h3><br><br><div class="container-contact100-form-btn"><span class="contact100-form-btn" id = "gerar_boleto"><i style="margin-right: 15px; " class="fa fa-long-arrow-right m-l-7"aria-hidden="true"></i>GERAR BOLETO</span></div><div class="container-contact100-form-btn"><span class="contact100-form-btn" id = "editar_infos"><i style="margin-right: 15px; " class="fa fa-long-arrow-left m-l-7"aria-hidden="true"></i>EDITAR DADOS CADASTRADOS</span></div><div class="container-contact100-form-btn"><span class="contact100-form-btn"><i style="margin-right: 15px; " aria-hidden="true"></i><a href="../contribuicao/index.php">VOLTAR A PÁGINA INICIAL</a></span></div>');});
                        
        });
                        
}