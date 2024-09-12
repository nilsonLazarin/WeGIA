$(function () {//Carrega cabeçalho e menu lateral
    $("#header").load("../../header.php");
    $(".menuu").load("../../menu.php");
});

function confirmarExclusao() {//Trava de segurança para evitar exclusão de itens indesejados
    return confirm("Tem certeza que deseja excluir este item?");
}

document.addEventListener('DOMContentLoaded', function () {
    // Seletor para todos os botões de editar
    const editButtons = document.querySelectorAll('button[title="Editar"]');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const valor = this.closest('tr').querySelector('td:nth-child(4)').textContent;

            // Preenche o modal com os dados do gateway
            document.getElementById('editId').value = id;
            document.getElementById('editValor').value = valor;

            $('#editModal').modal('show');
        });
    });
});