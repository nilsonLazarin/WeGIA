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