function retorna_id(nome_sistema)
{
    var nome_sistema = nome_sistema.toUpperCase();
    $.post("./php/id_sistema.php",{'nome_sistema':nome_sistema}).done
    (function(data)
    {   
        var id = data; 
        $("#cod_cartao").html("<input type='hidden' name='cod_cartao' value='"+id+"'>");
        $("#id_sistema").html("<input type='hidden' id='id_sistema' name='id_sistema' value='"+id+"'>");
        $("#nome_sistema").val(nome_sistema);
        preencher(id);
        preenche_dados_cartao(id);
        //inserir(id);

        return id;
    });

   
    
}