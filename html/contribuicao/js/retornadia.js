function retorna_dia()
{
    if($("#tipo1").prop('checked'))
    {
        if($("#op1").prop('checked'))
        { var dia = $("#op1").val();}
            else{
                if($("#op2").prop('checked'))
                    {dia =$("#op2").val();} 
                else{
                        if($("#op3").prop('checked'))
                        {dia = $("#op3").val();}
                        else{
                            if($("#op4").prop('checked'))
                            {dia =$("#op4").val();}
                            else{
                                if($("#op5").prop('checked'))
                                {dia=$("#op5").val();}
                                else
                                {
                                    if($("#op6").prop('checked'))
                                    {dia =$("#op6").val();}
                                    else
                                    {
                                        dia = "";
                                    }
                                }  
                            }
                        }
                    }
            }
        }
        return dia;
}