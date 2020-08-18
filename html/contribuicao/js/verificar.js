function verificar()
{   
    if($("#tipo1").prop('checked'))
    {
        if($("#op1").prop('checked'))
        { var dia = $("#op1").val();}
        else{
            if($("#op2").prop('checked'))
            {dia = $("#op2").val();} 
                else{
                        if($("#op3").prop('checked'))
                        {dia = $("#op3").val();}
                        else{
                            if($("#op4").prop('checked'))
                            {dia = $("#op4").val();}
                            else{
                                if($("#op5").prop('checked'))
                                { dia = $("#op5").val();}
                                else
                                {
                                    if($("#op6").prop('checked'))
                                    { dia = $("#op6").val();}
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
                    $("#pag2").fadeIn();
                    $("#pag1").hide();
                }
                /*
                $("#forma").hide();
                $("#doacao").hide();*/	                                                    
            }
    }
    else
    {
        if($("#tipo2").prop('checked'))
        {
            var valor = $("#v").val();
            var val_min = $("#valunic").val();
            valor = valor.split('.');
                if(valor[0] == ''|| valor[0] == 0)
                {
                    $("#avisa_valor").html("Digite um valor para doação");
                }
                else
                {
                    if(valor[0] < val_min)
                    {
                        $("#avisa_valor").html("O valor mínimo para doação é <i>R$"+val_min+"</i>"); 
                        
                    }else{
                        
                            $("#avisa_valor").html("");
                            $("#pag2").fadeIn();
                            $("#pag1").hide();
                            $("#forma").hide();
                            $("#doacao_boleto").hide();
                        
                            
                    }
                   
                }
        }
    }
    
    
                
}
