function isEstoque(is_estoque){
    Display = is_estoque ? 'none' : 'block';
    Hide = is_estoque ? 'block' : 'none';

    document.getElementById('dest').style.display = Display;
    document.getElementById('orig').style.display = Display;
    document.getElementById('resp').style.display = Display;
    document.getElementById('per').style.display = Display;
    document.getElementById('tipo-entrada').style.display = Display;
    document.getElementById('tipo-saida').style.display = Display;
}

function isEntrada(is_entrada){
    Display = is_entrada ? 'block' : 'none';
    Hide = is_entrada ? 'none' : 'block';

    document.getElementById('tipo-entrada').style.display = Display;
    document.getElementById('tipo-saida').style.display = Hide;

    document.getElementById('orig').style.display = Display;
    document.getElementById('dest').style.display = Hide;

    
    document.querySelector("#tipo-entrada > div > select").name = is_entrada ? 'tipo' : '';
    document.querySelector("#tipo-saida > div > select").name = is_entrada ? '' : 'tipo';


}

function changeType(selection){
    if (selection == 'estoque'){
        isEstoque(true);
    }else{
        isEstoque(false);
        isEntrada(selection == 'entrada');
    }
}

$(document).ready(function(){
    tipo_relat = $('#tipo-relat').val()
    changeType(tipo_relat)
});