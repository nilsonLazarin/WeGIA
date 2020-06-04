$(document).ready(function(){

    function envia_dados_boleto_facil(formulario){
        var dados = new FormData(formulario[0]);
        var requisicao =  new XMLHttpRequest();
        $(".boletofacil_box").append(
            `
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
            `
        );

        requisicao.open('post', './controller/editar_boletofacil.php');
        requisicao.send(dados);
        requisicao.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                var r = JSON.parse(this.response);
                var status_req = this.status;
                console.log(r);
                if(r){
                    setTimeout(function(){
                        $(".boletofacil_box .overlay").remove();
                    }, 500);
                }else{
                    setTimeout(function(){
                        $(".boletofacil_box .overlay").remove();
                        var erro = `
                        <div class="alert alert-danger alert-dismissible animacao2">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Erro!</h4>
                        Não foi possível editar as informações do Boletofacil, tente novamente mais tarde. <br> Status da requisição: ` + status_req + ` 
                    </div>
                    `;
                    $(".boletofacil_box .box-body .alert-danger").remove();
                    $(".boletofacil_box .box-body").prepend(erro);
                    }, 500);
                }
            }
        }
    }

    $(document).on("submit", "#frm_boletofacil", function(e){
        e.preventDefault();
        var formulario = $(this);
        envia_dados_boleto_facil(formulario);
    });
    
});