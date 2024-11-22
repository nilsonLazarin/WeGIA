/**
 * Pega o campo radio com nome de opcao marcado na página 
 * @returns string
 */
function opcaoSelecionada() {
    const opcao = document.querySelector("input[name='opcao']:checked").value;
    return opcao;
}

/**
 * Configura a função passada como parâmetro como ação padrão para a mudança 
 * de marcação dos inputs radio com nome de opcao na página
 * @param {*} funcao 
 */
function configurarMudancaOpcao(funcao) {
    const opcoes = document.querySelectorAll("input[name='opcao']");
    opcoes.forEach(opcao => {
        opcao.addEventListener("change", function () {
            if (this.checked) {
                funcao();
            }
        });
    });
}

/**
 * Configura a função passada como parâmetro como ação padrão para 
 * o clique do botão com id de consultar-btn
 * @param {*} funcao 
 */
function configurarConsulta(funcao) {
    const btnConsulta = document.getElementById("consultar-btn");
    btnConsulta.addEventListener("click", function () {
        funcao();
    })
}

/**
 * Alterna a exibição das divs de Pessoa Física e Pessoa Jurídica
 */
function alternarPfPj() {
    const opcao = opcaoSelecionada();

    const divFisica = document.getElementById('cpf');
    const divJuridica = document.getElementById('cnpj');

    if (opcao == "fisica") {
        divFisica.classList.remove('hidden');
        divJuridica.classList.add('hidden');
    } else if (opcao == "juridica") {
        divJuridica.classList.remove('hidden');
        divFisica.classList.add('hidden');
    }
}

/**
 * Pega o documento informado na página, se a opção fisica estiver marcada o CPF é retornado,
 * se a opção jurídica estiver marcada o CNPJ é retornado.
 * @returns string
 */
function pegarDocumento() {
    const opcao = opcaoSelecionada();
    let documento;

    if (opcao == "fisica") {
        documento = document.getElementById('dcpf').value;
    } else if (opcao == "juridica") {
        documento = document.getElementById('dcnpj').value;
    }

    return documento;
}

/**
 * Valida a string de documento informada
 * @param string documento 
 * @returns boolean
 */
function validarDocumento(documento) {
    const documentoSemEspacos = documento.trim();
    if (!documentoSemEspacos) {
        return false;
    }

    const documentoSomenteNumeros = documentoSemEspacos.replace(/[^0-9]/g, '');
    const opcao = opcaoSelecionada();

    if (opcao == 'fisica') {
        if (documentoSomenteNumeros.length != 11) {
            return false;
        }
    } else if (opcao == 'juridica') {
        if (documentoSomenteNumeros.length != 14) {
            return false;
        }
    }

    return true;
}

/**
 * Recebe como parâmetros a página para qual se deseja ir e a página atual,
 * alterando qual das divs está visível no momento. 
 * @param {*} idProxima 
 * @param {*} idAtual 
 */
function alternarPaginas(idProxima, idAtual) {
    const atual = document.getElementById(idAtual);
    const proxima = document.getElementById(idProxima);

    proxima.classList.remove('hidden');
    atual.classList.add('hidden');
}

/**
 * Configura a função passada como parâmetro como ação padrão para 
 * o clique do botão com id de consultar-btn
 * @param {*} funcao 
 */
function configurarConsulta(funcao) {
    const btnConsulta = document.getElementById("consultar-btn");
    btnConsulta.addEventListener("click", function () {
        funcao();
    })
}

/**
 * Verifica se o valor passado como parâmetro está dentro dos limites estipulados para uma doação
 * @param {*} valor 
 * @returns 
 */
function verificarValor(valor) {
    //Substituir para fazer uma busca dinâmica sobre o valor mínimo de uma doação
    if (!valor || valor < 30) {
        return false;
    }

    return true;
}

/**
 * Recebe como parâmetro uma função de validação de números e atribuí a sua execução como processo do comportamento do botão avanca-valor
 * @param {*} funcao 
 */
function configurarAvancaValor(funcao) {
    const btnAvancaValor = document.getElementById('avanca-valor');

    btnAvancaValor.addEventListener('click', () => {
        const valor = document.getElementById('valor').value;

        if (!funcao(valor)) {
            alert('O valor informado está abaixo do mínimo permitido.');
            return;
        }

        alternarPaginas('pag2', 'pag1');
    });
}

/**
 * Configura o comportamento do botão volta-valor
 */
function configurarVoltaValor(){
    const btnVoltaValor = document.getElementById('volta-valor');

    btnVoltaValor.addEventListener('click', ()=>{
        alternarPaginas('pag1', 'pag2');
    });
}

/**
 * Verifica se alguma propriedade de um objeto do tipo Socio está vazia
 */
function verificarSocio({bairro, cep, cidade, complemento, documento, email, estado, id, logradouro, nome, numeroEndereco, telefone}){
    //verificar propriedades
    if(!bairro || bairro.length < 1){
        return false;
    }

    if(!cep || cep.length < 1){
        return false;
    }

    if(!cidade || cidade.length < 1){
        return false;
    }

    /*if(!complemento || complemento.length < 1){
        return false;
    }*/

    if(!documento || documento.length < 1){
        return false;
    }

    if(!email || email.length < 1){
        return false;
    }

    if(!estado || estado.length < 1){
        return false;
    }

    if(!id || id.length < 1){
        return false;
    }

    if(!logradouro || logradouro.length < 1){
        return false;
    }

    if(!nome || nome.length < 1){
        return false;
    }

    if(!numeroEndereco || numeroEndereco.length < 1){
        return false;
    }

    if(!telefone || telefone.length < 1){
        return false;
    }

    return true;
}