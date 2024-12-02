let acao = 'boleto';

function buscarSocio() {
    const documento = pegarDocumento();

    if (!validarDocumento(documento)) {
        alert("O documento informado não está em um formato válido");
        return;
    }

    console.log("Buscando sócio ...");

    const url = `../controller/control.php?nomeClasse=SocioController&metodo=buscarPorDocumento&documento=${encodeURIComponent(documento)}`;

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro na consulta: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            // Manipula os dados recebidos do back-end
            //verificar se existem elementos no data
            if (data.resultado && typeof data.resultado === 'object') {

                //Autocompletar campos do formulário
                if (!verificarSocio(data.resultado)) {
                    //Exibir o sócio
                    console.log(data);
                    formAutocomplete(data.resultado);
                    acao = 'atualizar';
                    alternarPaginas('pag3', 'pag2');
                } else {//Enviar para a página de confirmação de geração de boletos
                    alternarPaginas('pag5', 'pag2');
                }
            } else {
                console.log(data.resultado);
                acao = 'cadastrar';
                alternarPaginas('pag3', 'pag2');
            }

            //alternarPaginas('pag2');
        })
        .catch(error => {
            console.error('Erro ao realizar a consulta:', error);
        });

    console.log("Consulta realizada");
}

function decidirAcao() {
    switch (acao) {
        case 'boleto': gerarBoleto(); break;
        case 'cadastrar': cadastrarSocio(); break;//colocar chamada para função de cadastrar sócio
        case 'atualizar': atualizarSocio(); break;//colocar chamada para função de atualizar sócio
        default: console.log('Ação indefinida');
    }
}

function gerarBoleto() {
    const form = document.getElementById('formulario');
    const formData = new FormData(form);

    const documento = pegarDocumento();

    formData.append('nomeClasse', 'ContribuicaoLogController');
    formData.append('metodo', 'criarBoleto');
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

configurarAvancaValor(verificarValor);
configurarVoltaValor();
configurarVoltaCpf();
configurarVoltaContato();
configurarAvancaEndereco(verificarEndereco);
configurarAvancaContato(verificarContato);
configurarAvancaTerminar(decidirAcao);
configurarMudancaOpcao(alternarPfPj);
configurarConsulta(buscarSocio);