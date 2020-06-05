
function valida_email()
{
    var e_mail = $("#email").val();

    $.post("./php/server.php",
    {"email":e_mail}).done(function(resultado)
    {
        var r = JSON.parse(resultado);
        
            if(!r.resultado)
            {
                
                $("#avisa_email").html('e-mail inválido');
            }
            else
            {
                
                $("#avisa_email").html('');
            }
    });
}