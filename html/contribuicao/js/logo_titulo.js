function preenche_campo()
{
   
    $.post("./php/logo_titulo.php").done(function(data){

        var dados = data.split('paragrafo:');
        var img = dados[0];
        var texto = dados[1];
        $("#img_logo").html(img);
        $("#titulo_pag").html(texto);
        
    });
}
