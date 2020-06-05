function toReal()
{   
    var valor = $("#v").val();
    var valor = valor.replace(",",".");
    var ponto = valor.indexOf(".");
    var tamanho = valor.length;
        if(ponto == "-1")
        {
            valor = valor+".00";  
        }
    $("#v").val(valor);
    
}