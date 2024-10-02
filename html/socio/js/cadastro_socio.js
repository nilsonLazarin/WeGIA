const btnAvancaValor = document.getElementById('avanca-valor');
const btnAvancaCpf = document.getElementById('avanca-cpf');
const btnAvancaContato = document.getElementById('avanca-contato');
const btnAvancaPeriodo = document.getElementById('avanca-periodo');
const btnAvancaEndereco = document.getElementById('avanca-endereco');

btnAvancaValor.addEventListener('click', (ev) => {
    ev.preventDefault();
    trocarPagina('pag2', 'pag1');
});

btnAvancaCpf.addEventListener('click', (ev) => {
    ev.preventDefault();
    trocarPagina('pag3', 'pag2');
});

btnAvancaContato.addEventListener('click', (ev) => {
    ev.preventDefault();
    trocarPagina('pag4', 'pag3');
});

btnAvancaPeriodo.addEventListener('click', (ev) => {
    ev.preventDefault();
    trocarPagina('pag5', 'pag4');
});

btnAvancaEndereco.addEventListener('click', (ev) => {
    ev.preventDefault();
    trocarPagina('pag6', 'pag5');
})

function trocarPagina(idProxima, idAtual){
    const atual = document.getElementById(idAtual);
    const proxima = document.getElementById(idProxima);

    proxima.classList.remove('hidden');
    atual.classList.add('hidden');
}