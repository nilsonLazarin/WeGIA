document.addEventListener('DOMContentLoaded', function () {
    // Seletor para todos os botões de editar
    const editButtons = document.querySelectorAll('button[title="Editar"]');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
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

    //Checkbox de ativar/desativar um gateway
    const toggles = document.querySelectorAll('.toggle-input');

    toggles.forEach(toggle => {
        toggle.addEventListener('change', function (ev) {
            const toggleId = ev.target.id; // ID do toggle clicado
            const isChecked = ev.target.checked; // Verifica se está marcado ou não

            // Usando expressão regular para extrair o número
            const idNumber = toggleId.match(/\d+/)[0]; // Extrai o número após 'toggle'
            // Montar os dados para enviar no POST

            data = new URLSearchParams();
            data.append('id', idNumber);
            data.append('status', isChecked);
            data.append('nomeClasse', 'GatewayPagamentoController');
            data.append('metodo', 'alterarStatus');
            /*const data = {
                id: idNumber,
                status: isChecked,
                nomeClasse: 'GatewayPagamentoController',
                metodo: 'alterarStatus'
            };*/

            // Enviar dados via fetch (POST)
            fetch('./src/controller/control.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: data.toString() // Converte o objeto em uma string URL-encoded
            })
                .then(response => {
                    if (response.ok) {
                        return response.json(); // Se necessário, processa a resposta
                    } else {
                        return response.json().then(errData => {
                            // Lança o erro com a mensagem extraída do backend
                            throw new Error(errData.Erro || 'Erro desconhecido no servidor');
                        });
                    }
                })
                .then(result => {
                    console.log('Resultado:', result); // Processa a resposta do servidor, se houver
                })
                .catch(error => {
                    alert(error);
                });
        });
    });

});