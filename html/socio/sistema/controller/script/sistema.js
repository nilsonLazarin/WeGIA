$(document).ready(function(){

    // Função de cadastro de sócios
    function cadastro_socios_xlsx(tabela){
        log = {
            cadastrados: tabela.length,
            html_log: ""
        };
        for(linha of tabela){
            if(valida_cpf_cnpj(linha['CPF/CNPJ'])){
                
                if(linha['CPF/CNPJ'].length == 14){
                    var pessoa = "fisica";
                }else var pessoa = "juridica";
                if (typeof linha['EMAIL'] == 'undefined') {
                    var email = "";
                }else var email = linha['EMAIL'];
                if (typeof linha['COMPLEMENTO'] == 'undefined') {
                    var complemento = "";
                }else var complemento = linha['COMPLEMENTO'];
                var data_nasc = "imp";
                var telefone = linha['TELEFONE'].replace(" ", "");
                

                var dados = {
                    "socio_nome": linha['NOME/RAZÃO SOCIAL'],
                    "pessoa": pessoa,
                    "email": email,
                    "telefone": telefone,
                    "cpf_cnpj": linha['CPF/CNPJ'],
                    "rua": linha['ENDEREÇO'],
                    "numero": linha['NÚMERO'],
                    "complemento": complemento,
                    "bairro": linha['BAIRRO'],
                    "estado": linha['UF'],
                    "cidade": linha['CIDADE'],
                    "status": 4,
                    "contribuinte": null,
                    "data_nasc": data_nasc,
                    "cep":linha['CEP']
                };
                // var dados = JSON.stringify(dados);

                $.ajax({
                    async: false,
                    url: "cadastro_socio.php",
                    data: dados,
                    type: "POST",
                        success: function (resp) {
                            var r = JSON.parse(resp);
                          if (r) {
                            log.html_log += "<p style='margin: 0.2em' class='text-green'> <b>[CADASTRADO]</b> - "+ linha['NOME/RAZÃO SOCIAL'] + "</p> ";
                          } else {
                            log.cadastrados--;
                            log.html_log += "<p style='margin: 0.2em' class='text-danger'> <b>[ERRO: POSSUI CAD/ARQUIVO MAL FORMATADO.]</b> - "+ linha['NOME/RAZÃO SOCIAL'] + " </p>";
                          }
                        },
                        error: function (e) {
                          log.cadastrados--;
                          log.html_log += "<p style='margin: 0.2em' class='danger'> <b>[ERRO: CON.]</b> - "+ linha['NOME/RAZÃO SOCIAL'] + " </p>";
                          console.dir(e);
                        }
                  });
            }else{
                console.log("erro cpf");
                log.cadastrados--;
                log.html_log += "<p style='margin: 0.2em' class='text-danger'> <b>[ERRO: CPF/CNPJ]</b> - "+ linha['NOME/RAZÃO SOCIAL'] + " </p>";
            }
        }
        log.html_log = "Total cadastrados = "+ log.cadastrados +"/"+tabela.length+log.html_log;
        return log;
    }
    // Setando máscaras dos inputs
    if($("#pessoa").val() == "fisica"){
        $("#cpf_cnpj").mask("999.999.999-99");
    }else{
        $("#cpf_cnpj").mask("99.999.999/9999-99");
    }
    $("#cep").mask("99999-999");
    function modalSimples(titulo, msg, tipo){
        switch(tipo){
            case "erro": cor = "danger"; break;
            case "alerta": cor = "warning"; break;
            case "sucesso": cor = "success"; break;
            case "normal": cor = ""; break;
        }
        var id = Math.floor(Math.random() * 10);
        var html = '<div class="modal modal-'+ cor +' fade in" id="modal'+ id +'" style="display: none; padding-right: 17px;"> <div class="modal-dialog"> <div class="modal-content"> <div class="modal-header"> <h4 class="modal-title">'+ titulo +'</h4> </div> <div class="modal-body text-center"><div class="overlay"> <i style="margin: 0 auto; font-size: 40px" class="fa fa-user-plus"></i> </div> <h3>'+ msg +'</h3> </div> <div class="modal-footer"> <button type="button" class="btn btn-outline pull-left .btn_fecharModal'+ id +'" data-dismiss="modal">Fechar</button> </div> </div> <!-- /.modal-content --> </div> <!-- /.modal-dialog --> </div>';
        $("body").append(html);
        $("#modal"+id).modal("toggle");
        // if(tipo == "sucesso"){
        //     setTimeout(function(){
        //         location.reload();
        //     },1000);
        // }
    }
    function resetaForm(form){
        $(form).each (function(){
            this.reset();
          });
    }
    function valida_cpf(cpf_inp){
        var exp = /\.|\-/g;
    
        var cpf = cpf_inp.replace(exp,'').toString();
        
        if(cpf.length == 11 ){
        
        var v = [];
    
        //Calcula o primeiro dígito de verificação.
        v[0] = 1 * cpf[0] + 2 * cpf[1] + 3 * cpf[2];
        v[0] += 4 * cpf[3] + 5 * cpf[4] + 6 * cpf[5];
        v[0] += 7 * cpf[6] + 8 * cpf[7] + 9 * cpf[8];
        v[0] = v[0] % 11;
        v[0] = v[0] % 10;
    
        //Calcula o segundo dígito de verificação.
        v[1] = 1 * cpf[1] + 2 * cpf[2] + 3 * cpf[3];
        v[1] += 4 * cpf[4] + 5 * cpf[5] + 6 * cpf[6];
        v[1] += 7 * cpf[7] + 8 * cpf[8] + 9 * v[0];
        v[1] = v[1] % 11;
        v[1] = v[1] % 10;
    
        //Retorna Verdadeiro se os dígitos de verificação são os esperados.
                
        if ((v[0] != cpf[9]) || (v[1] != cpf[10])) {return false}
        
        else if (cpf[0] == cpf[1] && cpf[1] == cpf[2] && cpf[2] == cpf[3] && cpf[3] == cpf[4] && cpf[4] == cpf[5] && cpf[5] == cpf[6] && cpf[6] == cpf[7] && cpf[7] == cpf[8] && cpf[8] == cpf[9] && cpf[9] == cpf[10])
        {return false}        
              
           else{return true}       
            
        
        }else {return false}    
    }
    $(document).on("submit", "#frm_novo_socio", function(e){
        e.preventDefault();
        var socio_nome = $("#socio_nome").val();
        var pessoa_tipo = $("#pessoa").val();
        var contribuinte = $("#contribuinte").val();
        var status = $("#status").val();
        var email = $("#email").val();
        var telefone = $("#telefone").val();
        var cpf_cnpj = $("#cpf_cnpj").val();
        var rua = $("#rua").val();
        var numero = $("#numero").val();
        var complemento = $("#complemento").val();
        var bairro = $("#bairro").val();
        var estado = $("#estado").val();
        var cidade = $("#cidade").val();
        var data_nasc = $("#data_nasc").val();
        var cep = $("#cep").val();
        // Requisição POST - AJAX
        if(valida_cpf_cnpj(cpf_cnpj)){
            $.post("./cadastro_socio.php",{
                "socio_nome": socio_nome,
                "pessoa": pessoa_tipo,
                "contribuinte": contribuinte,
                "status": status,
                "email": email,
                "telefone": telefone,
                "cpf_cnpj": cpf_cnpj,
                "rua": rua,
                "numero": numero,
                "complemento": complemento,
                "bairro": bairro,
                "estado": estado,
                "cidade": cidade,
                "data_nasc": data_nasc,
                "cep":cep
            }).done(function(resultadoCadastro){
                var resultado = JSON.parse(resultadoCadastro);
                if(resultado){
                    $(".socioModal").append(
                        '<div class="overlay"> <i style="font-size: 72px; color: green;" class="fa fa-refresh fa-spin"></i> </div>'
                    );
                    setTimeout(function(){
                        $("#adicionarSocioModal").modal("toggle");
                        $(".socioModal .overlay").remove();
                        $("#qtd_socios").html(Number($("#qtd_socios").html())+1);
                        resetaForm("#frm_novo_socio");
                    },1000);
                }else{
                    modalSimples("Status", "Erro ao cadastrar sócio, verifique os dados e tente novamente.", "erro");
                }
            });
        }else{
            modalSimples("Status", "O CPF/CNPJ informado é inválido!", "erro");
        }
        
    });
    $(document).on("submit", "#frm_editar_socio", function(e){
        e.preventDefault();
        var id_socio = $("#id_socio").val();
        var socio_nome = $("#socio_nome").val();
        var pessoa_tipo = $("#pessoa").val();
        var contribuinte = $("#contribuinte").val();
        var status = $("#status").val();
        var email = $("#email").val();
        var telefone = $("#telefone").val();
        var cpf_cnpj = $("#cpf_cnpj").val();
        var rua = $("#rua").val();
        var numero = $("#numero").val();
        var complemento = $("#complemento").val();
        var bairro = $("#bairro").val();
        var estado = $("#estado").val();
        var cidade = $("#cidade").val();
        var data_nasc = $("#data_nasc").val();
        var cep = $("#cep").val();
        // Requisição POST - AJAX
        if(valida_cpf_cnpj(cpf_cnpj)){
            $.post("./processa_edicao_socio.php",{
                "id_socio": id_socio,
                "socio_nome": socio_nome,
                "pessoa": pessoa_tipo,
                "contribuinte": contribuinte,
                "status": status,
                "email": email,
                "telefone": telefone,
                "cpf_cnpj": cpf_cnpj,
                "rua": rua,
                "numero": numero,
                "complemento": complemento,
                "bairro": bairro,
                "estado": estado,
                "cidade": cidade,
                "data_nasc": data_nasc,
                "cep":cep
            }).done(function(resultadoCadastro){
                var resultado = JSON.parse(resultadoCadastro);
                if(resultado){
                    $(".socioModal").append(
                        '<div class="overlay"> <i style="font-size: 72px; color: green;" class="fa fa-refresh fa-spin"></i> </div>'
                    );
                    setTimeout(function(){
                        resetaForm("#frm_editar_socio");
                        window.location.replace("./");
                    },1000);
                }else{
                    modalSimples("Status", "Erro ao editar sócio, verifique os dados e tente novamente.", "erro");
                }
            });
        }else{
            modalSimples("Status", "O CPF/CNPJ informado é inválido!", "erro");
        }
        
    });
    // Validação de CEP e API de CEP
    $("#cep").blur(function(){
        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');
        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //simbolo de carregando enquanto consulta webservice.
                $(".endereco").prepend(
                    '<div class="overlay"> <i class="fa fa-refresh fa-spin"></i> </div>'
                );

                setTimeout(function(){
                    $(".endereco .overlay").remove();
                },600);

                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#rua").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#estado").val(dados.uf);
                        $(".status_cep").html('');
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        $("#cep").val("");
                        // modalSimples("Erro", "Cep não encontrado.", "erro");
                        $(".status_cep").html('<p class="text-red animacao2">Cep não encontrado.</p>');
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                $("#cep").val("");
                // modalSimples("Erro", "Cep inválido.", "erro");
                $(".status_cep").html('<p class="text-red animacao2">Cep inválido.</p>');
            }
        }
    });
    $("#pessoa").change(function(){
        if($(this).val() == "juridica"){
            $("#label_cpf_cnpj").html("CNPJ");
            $("#cpf_cnpj").mask("99.999.999/9999-99");
            $("#cpf_cnpj").val("");
            $(".div_nasc").html("");
        }else{
            $("#label_cpf_cnpj").html("CPF");
            $("#cpf_cnpj").mask("999.999.999-99");
            $("#cpf_cnpj").val("");
            $(".div_nasc").append('<div class="form-group col-xs-4 animacao2"> <label for="valor">Data de nascimento</label> <input type="date" class="form-control" id="data_nasc" name="data_nasc" required> </div>');
        }
    })
    // Máscara telefone/celular
    $("#telefone").keydown(function(){
        try {
            $("#telefone").unmask();
        } catch (e) {}
    
        var tamanho = $("#telefone").val().length;
    
        if(tamanho <= 9){
            $("#telefone").mask("(99)9999-9999");

        } else {
            $("#telefone").mask("(99)99999-9999");
        }
    
        // ajustando foco
        var elem = this;
        setTimeout(function(){
            // mudo a posição do seletor
            elem.selectionStart = elem.selectionEnd = 10000;
        }, 0);
        // reaplico o valor para mudar o foco
        var currentValue = $(this).val();
        $(this).val('');
        $(this).val(currentValue);
    });
    // Configuração tabela sócios
    $(document).ready(function() {
        $('#example').DataTable( {
            "processing": true,
            "language": {
                "sEmptyTable": "Nenhum sócio encontrado",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "_MENU_ sócios por página",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum sócio encontrado",
                "sSearch": "Pesquisar",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                }
            }
        } );
    } );
    // Tabela aniversariantes
    $(document).ready(function() {
        $('#tb_aniversario').DataTable( {
            "processing": true,
            "searching": false,
            "language": {
                "sEmptyTable": "Nenhum sócio faz aniversário no mês atual.",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "_MENU_ sócios por página",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum sócio faz aniversário no mês atual.",
                "sSearch": "Pesquisar",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                }
            }
        } );
    } );
    // Modal tabela sócios
    $("#btn_socios").click(function(){
        $("#modalSocios").modal("toggle");
    });
    // Modal opções bd
    $("#btn_bd").click(function(){
        $("#bdModal").modal("toggle");
        $("#bdModal .modal-body").prepend(
            '<div class="alert alert-warning animacao3 alerta_bd" role="alert"> <i class="fa fa-question-circle"></i> Atenção! As modificações feitas aqui são permanentes. </div>'
        );
        setTimeout(function(){
            $(".alerta_bd").hide();
        },5700);
    });
    // Botão deletar sócios
    $("#btn_deletarSocios").click(function(){
        $(".bd_box").prepend('<div class="overlay"> <i class="fa fa-refresh fa-spin"></i> </div>');
        $.get("./controller/deletar_socios.php", {"chave":"h)8^#w4T<HaN-GSc&BM3[<?mvG[R?b"})
        .done(function(resultado){
            var r = JSON.parse(resultado);
            if(r){
                console.log("teste");
                setTimeout(function(){
                    $(".bd_box .overlay").hide();
                },1000);
                $("#bdModal").modal("toggle");
                location.reload();
            }
        });
    });
    $("#btn_add_socio").click(function(){
        $("#adicionarSocioModal").modal("toggle");
    });
    $("#btn_importar_xlsx").click(function(){
        $("#modal_importar_xlsx").modal("toggle");
    });
    var arquivo = document.getElementById('arquivo_xlsx');
    if (typeof arquivo !== 'undefined' && arquivo !== null) {
        arquivo.onchange = function(e){
            var ext = this.value.match(/\.([^\.]+)$/)[1];
            switch (ext) {
                case 'xlsx':
                case 'xls':
                console.log("extensão ok");
                break;
                default:
                modalSimples("Status","Extensão inválida!", "erro");
                this.value = '';
            }
        }
    }


    // Envio do arquivo xlsx
      $(document).on("submit", "#form_xlsx", function(e){
        e.preventDefault();
        var $form = $(this);
        uploadArquivos($form);
        $(".barra_envio").css("width","0"+"%");
      });

      function uploadArquivos($form){
        var dados = new FormData($form[0]);
        var request = new XMLHttpRequest();
        $(".box_xlsx").prepend('<div class="overlay"> <i class="fa fa-refresh fa-spin"></i> </div>');
        request.upload.addEventListener("progress", function(e){
          var porcentagem = e.loaded/e.total *100;
          $(".barra_envio").css("width",porcentagem+"%");
        });

        request.open('post', './controller/controla_xlsx.php');
        request.send(dados);
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var r = JSON.parse(this.response);
                console.log(r);
                /* requisição */
                var url = r.url;
                var oReq = new XMLHttpRequest();
                oReq.open("GET", url, true);
                oReq.responseType = "arraybuffer";

                oReq.onload = function(e) {
                    var arraybuffer = oReq.response;

                    /* convertendo dados para binário */
                    var data = new Uint8Array(arraybuffer);
                    var arr = new Array();
                    for (var i = 0; i != data.length; ++i) arr[i] = String.fromCharCode(data[i]);
                    var bstr = arr.join("");

                    /* chamando api para conveter tabela xlsx */
                    var workbook = XLSX.read(bstr, {
                        type: "binary"
                    });

                //   ----
                    var first_sheet_name = workbook.SheetNames[0];
               
                    var worksheet = workbook.Sheets[first_sheet_name];
                    var tabela = (XLSX.utils.sheet_to_json(worksheet, {
                        raw: true
                    }));
                    console.log(tabela);
                    var log = cadastro_socios_xlsx(tabela);
                    console.log(log.cadastrados+" - "+tabela.length);
                    if(log.cadastrados == tabela.length){
                        $(".box_xlsx .overlay").remove();
                        $("#modal_importar_xlsx").modal("toggle");
                        modalSimples("Status", 'Importação bem sucedida. <div  class="box box-default"> <div class="box-header with-border"> <h3 class="box-title">Log de importação</h3> <div class="box-tools pull-right"> <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button> </div> </div>  <div class="box-body"> <div style="font-size: 12px; color:black; overflow: auto; max-height: 340px; text-justify: left;" class="log">'+ log.html_log +'</div> </div> </div>' , "sucesso");
                        resetaForm("#form_xlsx");
                        $(".barra_envio").css("width","0"+"%");
                        location.reload();
                    }else{
                        $("#modal_importar_xlsx").modal("toggle");
                        $("#qtd_socios").html(Number($("#qtd_socios").html())+log.cadastrados);
                        modalSimples("Status", 'Não foi possível concluir a importação por completo. <div  class="box box-default"> <div class="box-header with-border"> <h3 class="box-title">Log de importação</h3> <div class="box-tools pull-right"> <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button> </div> </div>  <div class="box-body"> <div style="font-size: 12px; color:black; overflow: auto; max-height: 340px; text-justify: left;" class="log">'+ log.html_log +'</div> </div> </div>' , "normal");
                        $(".box_xlsx .overlay").remove();
                        resetaForm("#form_xlsx");
                        $(".barra_envio").css("width","0"+"%");
                    }
                }

                oReq.send();

            }
      }
    }
    $("#btn_perfil").click(function(){
        $("#modalPerfil").modal("toggle");
    });
    $("#btn_Boletofacil").click(function(){
        $("#modalBoletofacil").modal("toggle");
    });
    $("#btn_aniversariantes").click(function(){
        $("#modal_aniversariantes").modal("toggle");
    });
    // teste
});