function socio_cadastrado()
{
    var doc = $("#cpfcnpj").val();
    var data_n = $("#data_n").val();

    $.post("socio_cadastrado.php",{'cpfcnpj':doc, 'data_n':data_n}).done(function(){
        
    });
}