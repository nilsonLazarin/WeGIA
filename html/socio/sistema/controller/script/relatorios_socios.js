$(document).ready(function(){
    $(document).on("submit", "#form_relatorio", function(e){
        e.preventDefault();
        alert($("#valor").val());
    })
})