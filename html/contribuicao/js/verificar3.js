
function verifica3()
{

    var cep = $("#cep").val();
    var rua = $("#rua").val();
    var num = $("#numero").val();
    var comp = $("#complemento").val();
    var bairro = $("#bairro").val();
    var cidade = $("#localidade").val();
    var uf = $("#uf").val();
   
    if(rua == '')
    {
        $("#aviso").html('Preencha os campos marcados com "*"');
    }
    else
        {
            if(num == '' || comp == '')
            {
                $("#aviso").html('Preencha os campos marcados com "*"');
            }
            else
            {
                if(bairro == '')
                {
                    $("#aviso").html('Preencha os campos marcados com "*"');
                }
                else
                {
                    if(cidade == '')
                    {
                        $("#aviso").html('Preencha os campos marcados com "*"');
                    }
                    else
                    {
                        if(uf == '')
                        {
                            $("#aviso").html('Preencha os campos marcados com "*"');
                        }
                        else
                        {
                            if(cep == '')
                            {
                                $("#aviso").html('Preencha os campos marcados com "*"');
                                console.log("oi");
                            }else
                                {
                                    //gera_boleto();
                                    recebe_dados()
                                    $("#aviso").html("");
                                }
                          ;
                        }
                    }
                }
            }
        }
}
