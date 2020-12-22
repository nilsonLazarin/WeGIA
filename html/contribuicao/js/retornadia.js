function retorna_dia()
{   
    if($("#tipo1").prop('checked'))
    {
        if($("#op0").prop('checked'))
        { var dia = $("#op0").val();}
        else{
            if($("#op1").prop('checked'))
                { var dia = $("#op1").val();}
                else{
                    if($("#op2").prop('checked'))
                        { var dia = $("#op2").val();}
                        else{
                            if($("#op3").prop('checked'))
                                { var dia = $("#op3").val();}
                                else{
                                    if($("#op4").prop('checked'))
                                        { var dia = $("#op4").val();}
                                        else{
                                            if($("#op5").prop('checked'))
                                                { var dia = $("#op5").val();}
                                                   
                                            }
                                    }
                            }   
                    }
            }
    }
    else{
        if($("#tipo2").prop('checked'))
            { 
                var now = new Date();
                var dia = now.getDate();
            }
        }
    
return dia;  
}