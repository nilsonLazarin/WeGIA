function doc_cadastrado()
{
    var doc = $("#cpfcnpj").val();
   
    cpf_cnpj(doc);
        
}

function socio_cadastrado(doc)
{
    var doc = doc;
        $.post("./php/socio_cadastrado.php", {'doc':doc}).done(function(data){
            console.log(data);
                /*if(data == 0)
                {
                    $("#verifica_socio_btn").hide();
                    $("#verifica_socio").hide();
                    $("#pag2").fadeIn();
                }else
                    {
                        var dados = JSON.parse(data);
                        console.log(dados);
                    }*/
        });
}