function retorna_dia()
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
        }
        return dia;
}