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
            if (data.length < 1) {
                //Exibir mensagem de aviso
                //desenharConteudoNaTabela(mensagemBoletosNaoEncontrados());
            } else {
                //Exibir o sócio
                console.log(data);
            }

            //alternarPaginas('pag2');
        })
        .catch(error => {
            console.error('Erro ao realizar a consulta:', error);
        });

    console.log("Consulta realizada");
}

configurarMudancaOpcao(alternarPfPj);
configurarConsulta(buscarSocio);