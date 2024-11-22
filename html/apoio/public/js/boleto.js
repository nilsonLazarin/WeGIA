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
                }else{//Enviar para a página de confirmação de geração de boletos
                    alternarPaginas('pag5', 'pag2');
                }
            } else {
                console.log(data.resultado);
            }

            //alternarPaginas('pag2');
        })
        .catch(error => {
            console.error('Erro ao realizar a consulta:', error);
        });

    console.log("Consulta realizada");
}

configurarAvancaValor(verificarValor);
configurarVoltaValor();
configurarMudancaOpcao(alternarPfPj);
configurarConsulta(buscarSocio);