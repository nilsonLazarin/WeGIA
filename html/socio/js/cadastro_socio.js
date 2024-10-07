//Div de mensagens
const mensagemDiv = document.getElementById('mensagem');

//acao
const acao = document.getElementById('acao');

//Botões de avançar
const btnAvancaValor = document.getElementById('avanca-valor');
const btnAvancaCpf = document.getElementById('avanca-cpf');
const btnAvancaContato = document.getElementById('avanca-contato');
const btnAvancaPeriodo = document.getElementById('avanca-periodo');
const btnAvancaEndereco = document.getElementById('avanca-endereco');

//Botões de voltar
const bntVoltaValor = document.getElementById('volta-valor');
const btnVoltaCpf = document.getElementById('volta-cpf');
const btnVoltaContato = document.getElementById('volta-contato');
const bntVoltaPeriodo = document.getElementById('volta-periodo');
const bntVoltaEndereco = document.getElementById('volta-endereco');

//Formulário
const formCadastro = document.getElementById('form-cadastro');

//Definição do comportamento de avançar
btnAvancaValor.addEventListener('click', (ev) => {
    ev.preventDefault();
    if (!validarValor()) {
        return;
    }
    mensagemDiv.innerHTML = '';
    trocarPagina('pag2', 'pag1');
});

btnAvancaCpf.addEventListener('click', (ev) => {
    ev.preventDefault();
    if (!validarCpf()) {
        return;
    }

    //verificar se existe algum sócio com aquele cpf

    const cpf = document.getElementById('cpf').value;

    // Realiza a requisição com o fetch
    fetch(`./sistema/processa_socio.php?cpf=${cpf}&acao=buscarPorCpf`, {
        method: 'GET',
    })
        .then(response => response.json()) // Converte a resposta para JSON
        .then(data => {
            if (data.erro) {
                alert(`Erro: ${data.erro}`);//trocar para o alert do bootstrap posteriormente
            } else {

                const socio = data.retorno;

                if(!socio || socio.length < 1){
                    acao.value = "cadastrar";
                    alert ('Sócio não encontrado');//remover
                }else{
                    //adicionar preenchimento dos campos automático
                    console.log(socio);
                    alert(`Sucesso: ${data.retorno}`);//remover
                }
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Ocorreu um erro ao processar o cadastro.');//trocar para o alert do bootstrap posteriormente
        });

    mensagemDiv.innerHTML = '';
    trocarPagina('pag3', 'pag2');
});

btnAvancaContato.addEventListener('click', (ev) => {
    ev.preventDefault();
    if (!validarContato()) {
        return;
    }
    mensagemDiv.innerHTML = '';
    trocarPagina('pag4', 'pag3');
});

btnAvancaPeriodo.addEventListener('click', (ev) => {
    ev.preventDefault();
    if (!validarPeriodicidade()) {
        return;
    }
    mensagemDiv.innerHTML = '';
    trocarPagina('pag5', 'pag4');
});

btnAvancaEndereco.addEventListener('click', (ev) => {
    ev.preventDefault();
    if (!validarEndereco()) {
        return;
    }
    mensagemDiv.innerHTML = '';
    trocarPagina('pag6', 'pag5');
});

//Definição do comportamento do formulário
formCadastro.addEventListener('submit', (ev) => {
    ev.preventDefault();

    // Dados do formulário
    const formData = new FormData(formCadastro);

    // Realiza a requisição com o fetch
    fetch('./sistema/processa_socio.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json()) // Converte a resposta para JSON
        .then(data => {
            if (data.erro) {
                alert(`Erro: ${data.erro}`);//trocar para o alert do bootstrap posteriormente
            } else {
                alert(`Sucesso: ${data.retorno}`);//trocar para o alert do bootstrap posteriormente
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Ocorreu um erro ao processar o cadastro.');//trocar para o alert do bootstrap posteriormente
        });
});

//Definição do comportamento de voltar
bntVoltaValor.addEventListener('click', (ev) => {
    ev.preventDefault();
    mensagemDiv.innerHTML = '';
    trocarPagina('pag1', 'pag2');
});

btnVoltaCpf.addEventListener('click', (ev) => {
    ev.preventDefault();
    mensagemDiv.innerHTML = '';
    trocarPagina('pag2', 'pag3');
});

btnVoltaContato.addEventListener('click', (ev) => {
    ev.preventDefault();
    mensagemDiv.innerHTML = '';
    trocarPagina('pag3', 'pag4');
});

bntVoltaPeriodo.addEventListener('click', (ev) => {
    ev.preventDefault();
    mensagemDiv.innerHTML = '';
    trocarPagina('pag4', 'pag5');
});

bntVoltaEndereco.addEventListener('click', (ev) => {
    ev.preventDefault();
    mensagemDiv.innerHTML = '';
    trocarPagina('pag5', 'pag6');
});

/**
 * Recebe como parâmetros a página para qual se deseja ir e a página atual,
 * alterando qual das divs está visível no momento. 
 * @param {*} idProxima 
 * @param {*} idAtual 
 */
function trocarPagina(idProxima, idAtual) {
    const atual = document.getElementById(idAtual);
    const proxima = document.getElementById(idProxima);

    proxima.classList.remove('hidden');
    atual.classList.add('hidden');
}

/**
 * Valida as informações do campo valor
 */
function validarValor() {
    const valor = document.getElementById('valor').value;
    if (!valor || valor < 30) {//Posteriormente pegar dinamicamente
        mensagemDiv.innerHTML = `<div class="alert alert-danger text-center" role="alert">` +
            `O valor mínimo de uma doação é de 30 reais.`
            + `</div>`;
        return false;
    }

    return true;
}

/**
 * Valida se o CPF está no formato correto e se é válido
 * @returns 
 */
function validarCpf() {
    const cpf = document.getElementById('cpf').value;
    if (!testaCPF(cpf)) {
        mensagemDiv.innerHTML = `<div class="alert alert-danger text-center" role="alert">` +
            `O CPF informado não é valido.`
            + `</div>`;
        return false;
    }

    return true;
}

/**
 * Valida se todos os campos de contato foram preenchidos
 * @returns 
 */
function validarContato() {
    //problemas detectados
    let problemas = [];

    //validar nome
    const nome = document.getElementById('nome').value;

    if (!nome || nome.length < 3) {
        problemas.push('Nome: não pode ter menos que 3 letras.');
    }

    //validar data
    const data = document.getElementById('data_nascimento').value;

    if (!data) {
        problemas.push('Data de nascimento: não pode ser vazia');
    }

    //validar email
    const email = document.getElementById('email').value;

    if (!email || email.length < 1) {
        problemas.push('E-mail: não pode ser vazio');
    }

    //validar telefone
    const telefone = document.getElementById('telefone').value;

    if (!telefone || telefone.length < 1) {
        //mensagem para telefone vazio
        problemas.push('Telefone: não pode ser vazio');
    } else if (telefone.length != 14) {
        //mensagem para telefone fora do formato correto
        problemas.push('Telefone: o número informado não possuí a quantidade de dígitos certa');
    }

    //verifica se algum problema foi detectado
    if (problemas.length > 0) {
        let mensagem = `<div class="alert alert-danger text-center" role="alert"> Corrija os seguintes problemas antes de prosseguir: `;
        problemas.forEach(problema => {
            mensagem += `<p>${problema}</p>`
        })
        mensagem += `</div>`;

        mensagemDiv.innerHTML = mensagem;
        window.location.hash = '#mensagem';
        return false;
    }

    return true;
}

/**
 * Valida se todos os campos referentes ao período de uma contribuição foram preenchidos
 */
function validarPeriodicidade() {
    //problemas
    let problemas = [];

    //validar periodicidade
    const periodicidade = document.getElementById('periodicidade').value;

    if (!periodicidade) {
        problemas.push('Periodicidade: é necessário selecionar uma opção');
    }

    //data de vencimento
    const datasVencimento = document.getElementsByName("data_vencimento");
    let vencimentoSelecionado = false;

    for (let i = 0; i < datasVencimento.length; i++) {
        if (datasVencimento[i].checked) {
            vencimentoSelecionado = true;
            break;
        }
    }

    if (!vencimentoSelecionado) {
        problemas.push('Data de vencimento: é necessário marcar uma opção');
    }

    //verifica se algum problema foi detectado
    if (problemas.length > 0) {
        let mensagem = `<div class="alert alert-danger text-center" role="alert"> Corrija os seguintes problemas antes de prosseguir: `;
        problemas.forEach(problema => {
            mensagem += `<p>${problema}</p>`
        })
        mensagem += `</div>`;

        mensagemDiv.innerHTML = mensagem;
        window.location.hash = '#mensagem';
        return false;
    }

    return true;
}

/**
 * Valida se todos os campos obrigatórios referentes a um endereço foram preenchidos
 * @returns 
 */
function validarEndereco() {
    //problemas detectados
    let problemas = [];

    //validar cep
    const cep = document.getElementById('cep').value;

    if (!cep || cep.length < 1) {
        problemas.push('CEP: o cep não pode estar vazio.');
    } else if (cep.length != 9) {
        problemas.push('CEP: o cep não está no formato válido');
    }

    //validar rua
    const rua = document.getElementById('rua').value;

    if (!rua || rua.length < 1) {
        problemas.push('Rua: a rua não pode estar vazia');
    }

    //validar número
    const numero = document.getElementById('numero').value;

    if (!numero || numero.length < 1) {
        problemas.push('Número: o número da residência não pode estar vazio');
    }

    //validar bairro
    const bairro = document.getElementById('bairro').value;

    if (!bairro || bairro.length < 1) {
        problemas.push('Bairro: o bairro não pode estar vazio');
    }

    //validar estado
    const uf = document.getElementById('uf').value;

    if (!uf) {
        problemas.push('Estado: selecione um dos estados da federação');
    }

    //validar cidade
    const cidade = document.getElementById('cidade').value;

    if (!cidade || cidade.length < 1) {
        problemas.push('Cidade: a cidade não pode estar vazia');
    }

    //verifica se algum problema foi detectado
    if (problemas.length > 0) {
        let mensagem = `<div class="alert alert-danger text-center" role="alert"> Corrija os seguintes problemas antes de prosseguir: `;
        problemas.forEach(problema => {
            mensagem += `<p>${problema}</p>`
        })
        mensagem += `</div>`;

        mensagemDiv.innerHTML = mensagem;
        window.location.hash = '#mensagem';
        return false;
    }

    return true;
}