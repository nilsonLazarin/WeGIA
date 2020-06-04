
function verifica3()
{
    console.log("Aqui");
    var cep = $("#cep").val();
    var rua = $("#rua").val();
    var num = $("#numero").val();
    var comp = $("#complemento").val();
    var bairro = $("#bairro").val();
    var cidade = $("#localidade").val();
    var uf = $("#uf").val();
    /*
    console.log(rua);
    console.log(num);
    console.log(bairro);
    console.log(cidade);
    console.log(uf);
    */
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
                          //gera_boleto();
                          recebe_dados();
                        }
                    }
                }
            }
        }
}
