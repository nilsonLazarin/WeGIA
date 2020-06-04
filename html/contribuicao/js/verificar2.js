function verifica2()
{   
    if($("#op_cpf").prop('checked'))
    {
        
       var nome = $("#nome").val();
       var dia = $("#dia").val();
       var mes = $('#mes').val();
       var ano = $("#ano").val();
       var tel = $("#telefone").val();
       var email = $("#e_mail").val();
       var cpf = $("#dcpf").val();
       /*alert(nome);
       alert(snome);
       alert(dia);
       alert(mes);
       alert(ano);
       alert(tel);
       alert(email);*/
        if(nome == '' || dia == '' || mes == '' || ano == '' || tel == '' || email == '' ||cpf == '')
        {
                $("#avisoPF").html('Preencha todos os campos marcados com "*"');
        }
        else
        {
            validacpf();
            $("#avisoPF").html("");
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
                $("#avisoPJ").html('Preencha todos os campos marcados com "*"');
                
            }
            else
            {
                cnpj();
                $("#avisoPJ").html("");  
            }
        }
    }
}
