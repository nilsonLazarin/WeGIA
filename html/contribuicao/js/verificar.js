function verificar()
{   
    if($("#tipo1").prop('checked'))
    {
        var dia=0;
        if($("#op0").prop('checked'))
        { dia = $("#op0").val();}
        else{
            if($("#op1").prop('checked'))
            {dia = $("#op1").val();} 
                else{
                        if($("#op2").prop('checked'))
                        {dia = $("#op2").val();}
                        else{
                            if($("#op3").prop('checked'))
                            {dia = $("#op3").val();}
                            else{
                                if($("#op4").prop('checked'))
                                { dia = $("#op4").val();}
                                else
                                {
                                    if($("#op5").prop('checked'))
                                    { dia = $("#op5").val();}
                                    else
                                    {
                                        dia = "";
                                    }
                                }
                                
                            }
                        }
                    }
            }
         
        var valor = $("#valores option:selected").val();
        if(valor == '')
        {
            $("#avisa_valor2").html("Selecione um valor");
            
        }
            else
            {
                $("#avisa_valor2").html("");
                if(dia == "")
                {
                    $("#info_data").html("Escolha a melhor data de vencimento");
                }else{
                    $("#info_data").html("");
                    $("#verifica_socio").fadeIn();
                    $("#pag1").hide();
                }
                                                                  
            }
    }
    else
    {
        if($("#tipo2").prop('checked'))
        {
            var valor = $("#v").val();
            var val_min = $("#valunic").val(); //vem do bd
            val_min = val_min.split('.');
            valor = valor.split('.');
            val_min = parseInt(val_min);
            valor = parseInt(valor); 
           
                if(isNaN(valor) || valor[0] == 0)
                {
                    $("#avisa_valor").html("Digite um valor para doação");
                   
                }
                else
                {
                    if(valor < val_min)
                    {
                        
                        $("#avisa_valor").html("O valor mínimo para doação é <i>R$"+val_min+"</i>"); 
                        
                    }else{
                            
                        $("#avisa_valor").html("");
                        $("#verifica_socio").fadeIn();
                        $("#pag1").hide();      
                    }
                   
                }
        }
    }              
}
function verifica2()
{   
    if($("#op_cpf").prop('checked'))
    {
        
       var nome = $("#nome").val();
       var dia = $("#dia_n").val();
       var mes = $('#mes').val();
       var ano = $("#ano").val();
       var tel = $("#telefone").val();
       var email = $("#e_mail").val();
    
        if(nome == '' || dia == '' || mes == '' || ano == '' || tel == '' || email == '' ||cpf == '')
        {
                $("#avisoPf").fadeIn();
                $("#avisoPf").html('Preencha todos os campos marcados com "*"');
        }
        else
        {
                $("#avisoPf").hide();
                $("#doacao_boleto").hide();
                $("#pag2").hide();
                $("#pag3").fadeIn();

        }
    
    }
    else
    {
    if($("#op_cnpj").prop('checked'))
        {
            var nome = $("#cnpj_nome").val();
            var tel = $("#telefone").val();
            var email = $("#email").val();
          
            if(nome ==  ''||tel == ''||email == '')
            {
                $("#avisoPj").fadeIn();
                $("#avisoPj").html('Preencha todos os campos marcados com "*"');
                
            }
            else
            {
                $("#avisoPj").hide();
                $("#avisoPj").html("");
                $("#doacao_boleto").hide();
                $("#pag2").hide();
                $("#pag3").fadeIn();  
            }
        }
    }
}

function verifica3()
{

    var cep = $("#cep").val();
    var rua = $("#rua").val();
    var num = $("#numero").val();
    //var comp = $("#complemento").val();
    var bairro = $("#bairro").val();
    var cidade = $("#localidade").val();
    var uf = $("#uf").val();
   
    if(rua == '')
    {
        $("#aviso").fadeIn();
        $("#aviso").html('Preencha os campos marcados com "*"');
    }
    else
        {
            if(num == '')
            {
                $("#aviso").fadeIn();
                $("#aviso").html('Preencha os campos marcados com "*"');
            }
            else
            {
                if(bairro == '')
                {
                    $("#aviso").fadeIn();
                    $("#aviso").html('Preencha os campos marcados com "*"');
                }
                else
                {
                    if(cidade == '')
                    {
                        $("#aviso").fadeIn();
                        $("#aviso").html('Preencha os campos marcados com "*"');
                    }
                    else
                    {
                        if(uf == '')
                        {
                            $("#aviso").fadeIn();
                            $("#aviso").html('Preencha os campos marcados com "*"');
                        }
                        else
                        {
                            if(cep == '')
                            {
                                $("#aviso").fadeIn();
                                $("#aviso").html('Preencha os campos marcados com "*"');
                              
                            }else
                                {
                                    
                                    cadastra_socio();
                                    $("#aviso").hide();
                                    $("#aviso").html("");
                                }
                          
                        }
                    }
                }
            }
        }
}
