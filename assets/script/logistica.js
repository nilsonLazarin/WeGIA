$(document).ready(function(){
    // Selecionar o conteúdo da quantidade ao ter foco
    $("#quantidade").focus(function(){
        $(this).select();
    });
    // Transformando enter em Tab
    $('body').on('keydown', 'input, select', function(e) {
        if (e.key === "Enter") {
            var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
            focusable = form.find('input,select,button,textarea').filter(':visible');
            next = focusable.eq(focusable.index(this)+1);
            if (next.length) {
                // dando foco e selecionando o próximo input ao teclar enter
                // if(next[0].id == "incluir"){
                //     console.log("aaa");
                //     $("input_produtos").focus();
                //     $("input_produtos").select();
                // } 
                next.focus();
                next.select();
            } else {
                // caso seja o último input, enter envia o form
                form.submit();
            }
            return false;
        }
    });
    $("#incluir").click(function(){
        $("#input_produtos").focus();
        $("#input_produtos").select();
    });

});