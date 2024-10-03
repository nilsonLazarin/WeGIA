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

//Definição do comportamento de avançar
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

//Definição do comportamento de voltar
bntVoltaValor.addEventListener('click', (ev) =>{
    ev.preventDefault();
    trocarPagina('pag1', 'pag2');
});

btnVoltaCpf.addEventListener('click', (ev) =>{
    ev.preventDefault();
    trocarPagina('pag2', 'pag3');
});

btnVoltaContato.addEventListener('click', (ev) =>{
    ev.preventDefault();
    trocarPagina('pag3', 'pag4');
});

bntVoltaPeriodo.addEventListener('click', (ev) =>{
    ev.preventDefault();
    trocarPagina('pag4', 'pag5');
});

bntVoltaEndereco.addEventListener('click', (ev) =>{
    ev.preventDefault();
    trocarPagina('pag5', 'pag6');
});

/**
 * Recebe como parâmetros a página para qual se deseja ir e a página atual,
 * alterando qual das divs está visível no momento. 
 * @param {*} idProxima 
 * @param {*} idAtual 
 */
function trocarPagina(idProxima, idAtual){
    const atual = document.getElementById(idAtual);
    const proxima = document.getElementById(idProxima);

    proxima.classList.remove('hidden');
    atual.classList.add('hidden');
}