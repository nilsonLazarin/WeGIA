function preenche_campo()
{
   
    $.post("./php/logo_titulo.php").done(function(data){

        var dados = data.split('paragrafo:');
        var img = dados[0];
       console.log(img);
        var texto = dados[1];
       console.log(texto);
        $("#img_logo").html(img);
        $("#titulo_pag").html(texto);
        
    });
}
