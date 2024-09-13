$(function() {//Carrega cabeçalho e menu lateral
    $("#header").load("../../header.php");
    $(".menuu").load("../../menu.php");
});

function confirmarExclusao() {//Trava de segurança para evitar exclusão de itens indesejados
    return confirm("Tem certeza que deseja excluir este item?");
}