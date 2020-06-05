function verificar()
{   
    if($("#tipo1").prop('checked'))
    {
        if($("#dia1").prop('checked'))
        { var dia = 1;}
        else{
            if($("#dia5").prop('checked'))
            {dia = 5;} 
                else{
                        if($("#dia10").prop('checked'))
                        {dia = 10;}
                        else{
                            if($("#dia15").prop('checked'))
                            {dia = 15}
                            else{
                                if($("#dia20").prop('checked'))
                                {dia=20;}
                                else
                                {
                                    if($("#dia25").prop('checked'))
                                    {dia =25;}
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
            valor = valor.split('.');
                if(valor[0] == ''|| valor[0] == 0)
                {
                    $("#avisa_valor").html("Digite um valor para doação");
                }
                else
                {
                    if(valor[0] < 10)
                    {
                        $("#avisa_valor").html("Desculpe, o valor mínimo para doação é <i>R$10,00</i>"); 
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
