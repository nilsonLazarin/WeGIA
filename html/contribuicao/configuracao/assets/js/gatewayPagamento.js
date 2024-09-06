$(function() {//Carrega cabeçalho e menu lateral
    $("#header").load("../../header.php");
    $(".menuu").load("../../menu.php");
});

function confirmarExclusao() {//Trava de segurança para evitar exclusão de itens indesejados
    return confirm("Tem certeza que deseja excluir este item?");
}

document.addEventListener('DOMContentLoaded', function() {
    // Seletor para todos os botões de editar
    const editButtons = document.querySelectorAll('button[title="Editar"]');

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nome = this.closest('tr').querySelector('td:nth-child(1)').textContent;
            const endpoint = this.closest('tr').querySelector('td:nth-child(2)').textContent;
            const token = this.closest('tr').querySelector('td:nth-child(3)').textContent;

            // Preenche o modal com os dados do gateway
            document.getElementById('editId').value = id;
            document.getElementById('editNome').value = nome;
            document.getElementById('editEndpoint').value = endpoint;
            document.getElementById('editToken').value = token;

            // Exibe o modal
            $('#editModal').modal('show');
        });
    });
});