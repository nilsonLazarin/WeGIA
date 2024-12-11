let acao = 'mensalidade';

async function decidirAcao() {
    switch (acao) {
        case 'mensalidade': gerarMensalidade(); break;
        case 'cadastrar': await cadastrarSocio(); gerarMensalidade(); break;//colocar chamada para função de cadastrar sócio
        case 'atualizar': await atualizarSocio(); gerarMensalidade(); break;//colocar chamada para função de atualizar sócio
        default: console.log('Ação indefinida');
    }
}

function gerarMensalidade() {
    const form = document.getElementById('formulario');
    const formData = new FormData(form);

    const documento = pegarDocumento();

    formData.append('nomeClasse', 'ContribuicaoLogController');
    formData.append('metodo', 'criarCarne');
    formData.append('documento_socio', documento);

    fetch("../controller/control.php", {
        method: "POST",
        body: formData
    })
        .then(response => {
            if (!response.ok) {
                throw new Error("Erro na requisição: " + response.status);
            }
            return response.json(); // Converte a resposta para JSON
        })
        .then(resposta => {
            if (resposta.link) {
                console.log(resposta.link);
                // Redirecionar o usuário para o link do boleto em uma nova aba
                window.open(resposta.link, '_blank');
            } else {
                alert("Ops! Ocorreu um problema na geração da sua forma de pagamento, tente novamente, se o erro persistir contate o suporte.");
            }

        })
        .catch(error => {
            console.error("Erro:", error);
        });
}

function verificarValorMensalidade(valor, parcelas, diaVencimento){
    //Substituir para fazer uma busca dinâmica sobre o valor mínimo de uma doação
    if (!valor || valor < 30) {
        alert('O valor informado está abaixo do mínimo permitido.');
        return false;
    }

    if(!parcelas || parcelas < 2 || parcelas > 12){
        alert('A quantidade de parcelas deve ser um número entre 2 e 12.');
        return false;
    }

    const diasValidos = [1, 5, 10, 15, 20, 25];

    if(undefined === diasValidos.find((dia) => {return dia == diaVencimento})){
        alert('O dia de vencimento escolhido não é válido');
        return false;
    }

    return true;
}

function configurarAvancaValorMensalidade(funcao) {
    const btnAvancaValor = document.getElementById('avanca-valor');

    btnAvancaValor.addEventListener('click', (ev) => {
        const valor = document.getElementById('valor').value;
        const parcelas = document.getElementById('parcelas').value;
        const diaVencimentoObject = document.querySelector("input[name='dia']:checked");

        if(!diaVencimentoObject){
            alert('Selecione um dia de vencimento');
            return;
        }

        const diaVencimento = diaVencimentoObject.value;

        ev.preventDefault();
        if (!funcao(valor, parcelas, diaVencimento)) {
            return;
        }

        alternarPaginas('pag2', 'pag1');
    });
}

configurarAvancaValorMensalidade(verificarValorMensalidade);
configurarVoltaValor();
configurarVoltaCpf();
configurarVoltaContato();
configurarAvancaEndereco(verificarEndereco);
configurarAvancaContato(verificarContato);
configurarAvancaTerminar(decidirAcao);
configurarMudancaOpcao(alternarPfPj);
configurarConsulta(buscarSocio);