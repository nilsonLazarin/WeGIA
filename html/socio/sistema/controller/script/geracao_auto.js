$(document).ready(function(){
    function procurar_desejados(tipo_desejado){
        switch(Number(tipo_desejado)){
            case 0: var td = "2,3,6,7,8,9,10,11"; break; //Todos
            case 1: var td = "6,7"; break; //Bimestrais
            case 2: var td = "8,9"; break; //Trimestrais
            case 3: var td = "10,11"; break; //Semestrais
            case 4: var td = "2,3"; break; //Mensais
        }
        $.post("./controller/query_geracao_auto.php", {
            "query": `SELECT * FROM socio s JOIN pessoa p ON p.id_pessoa = s.id_pessoa WHERE s.id_sociostatus NOT IN (1,2,3,4) AND s.id_sociotipo in (${td})`
        })
            .done(function(dados){
                var socios = JSON.parse(dados);
                if(socios){
                    for(socio of socios){
                        console.log(socio.id_sociotipo);
                    }
                }else console.log("SEM SÓCIOS DA CATEGORIA.");
            })
            .fail(function(dados){
                alert("Erro na obtenção de dados.");
            })
    }
    $("#geracao").change(function(){
        var tipo_desejado = $(this).val();
        procurar_desejados(tipo_desejado);
    })

})