function disableForm(idForm){
    $("#"+idForm+" :input").each(function(){
        var input = $(this);
        if (input.prop('tagName') != "BUTTON"){
            input.prop('disabled', true);
            input.prop('readOnly', true);
        }
    });
}

function enableForm(idForm){
    $("#"+idForm+" :input").each(function(){
        var input = $(this);
        if (input.prop('tagName') != "BUTTON"){
            input.prop('disabled', false);
            input.prop('readOnly', false);
        }
    });
}

function getFormPostParams(idForm){
    var string = "";
    var first = true;
    $("#"+idForm+" :input").each(function(){
        var input = $(this);
        var nome = input.attr('name');
        var value = input.val();
        if ((input.prop('type') == 'radio' && !input.prop('checked')) || !nome){
            false;
        }else{
            if (input.prop('required') && value == )
            string += (first ? "" : "&")+nome+"="+ value || "";
            first = false;
        }
    });
    return string;
}