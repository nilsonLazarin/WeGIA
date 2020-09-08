modal = "";
function modalSimples(titulo, msg, tipo){
  switch(tipo){
      case "erro": cor = "danger"; break;
      case "alerta": cor = "warning"; break;
      case "sucesso": cor = "success"; break;
      case "normal": cor = ""; break;
  }
  var id = Math.floor(Math.random() * 10);
  var html = '<div class="modal modal-'+ cor +' fade in" id="modal'+ id +'" style="display: none; padding-right: 17px;"> <div class="modal-dialog"> <div class="modal-content"> <div class="modal-header"> <h4 class="modal-title">'+ titulo +'</h4> </div> <div class="modal-body text-center"><div class="overlay"> <i style="margin: 0 auto; font-size: 40px" class="fa fa-user-plus"></i> </div> <h3>'+ msg +'</h3> </div> <div class="modal-footer"> <button type="button" class="btn btn-outline pull-left .btn_fecharModal'+ id +'" data-dismiss="modal">Fechar</button> </div> </div> <!-- /.modal-content --> </div> <!-- /.modal-dialog --> </div>';
  $("body").append(html);
  $("#modal"+id).modal("toggle");
  // if(tipo == "sucesso"){
  //     setTimeout(function(){
  //         location.reload();
  //     },1000);
  // }
}
function deletar_socio(id,pessoa){
    $.ajax({
        url: "processa_deletar_socio.php",
        data: {"id_socio":id, "pessoa":pessoa},
        type: "POST",
            success: function (resp) {
                var r = JSON.parse(resp);
              if (r) {
                modalSimples("Status", "Sócio deletado com sucesso.", "sucesso");
                setTimeout(function(){
                  location.reload();
                }, 1000);
              } else {
                modalSimples("Status", "Não foi possível deletar o sócio.", "erro");
              }
            },
            error: function (e) {
              console.dir(e);
            }
      });
}
function deletar_socio_modal(del_obj){
    console.log(del_obj);
    modal = `
    <div class="modal fade" id="excluirModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                  <h4 class="modal-title">Deletar sócio</h4>
                </div>
        <div class="modal-body">
            <div class="alert alert-warning alert-dismissible">
            <h4><i class="icon fa fa-warning"></i> Atenção!</h4>
            Você quer realmente deletar o sócio `+ del_obj.nome +`? Ao confirmar essa ação você deletará todos os dados pertencentes a este sócio do sistema.
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
          <button type="button" onclick="deletar_socio(`+ del_obj.id+`,`+ `'`+del_obj.pessoa+ `'` +`);" class="btn btn-primary">Sim</button>
        </div>
      </div>
    </div>
  </div>
    `;
    $(modal).modal("toggle");

}

function detalhar_socio(dados){
  var dados_socio = null;
   $.post("get_detalhes_socio.php",{"id_socio": dados}).done(function(resultadoBusca){
    dados_socio = JSON.parse(resultadoBusca);
    console.log(dados_socio);

    if(dados_socio.cpf == 14){
      pessoa = "Física";
    }else pessoa = "Jurídica";
    let status;
    if(dados_socio.id_sociostatus == 0){
      status = "Ativo";
    }else if(dados_socio.id_sociostatus == 1){
      status = "Inativo";
    }else if(dados_socio.id_sociostatus == 2){
      status = "Inadimplente";
    }else if(dados_socio.id_sociostatus == 3){
      status = "Inativo temporariamente";
    }else if(dados_socio.id_sociostatus == 4){
      status = "Sem informações";
    }
    console.log(status);


    var modal_detalhes_html = `
  <div class="modal fade" id="detalharSocioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detalhes Sócio</h5>
      </div>
      <div class="modal-body">
      <!-- <div class="callout callout-info">
                <h4>Adicione um novo sócio</h4>
                <p>Preencha os dados corretamente para cadastrar um novo sócio.</p>
              </div> -->
              <div class="box box-info box-solid boxDetalhes">
            <div class="box-header">
              <h3 class="box-title"><i class="fa fa-list" aria-hidden="true"></i> Detalhes sócio</h3>
            </div>
            <div class="box-body">
            <form id="frm_novo_socio" method="POST">
        <div class="row">
        <div class="form-group mb-2 col-xs-4">
                  <label for="nome_cliente">Nome sócio</label>
                  <input type="text" class="form-control" id="socio_nome" value="`+ dados_socio.nome +`" name="socio_nome" placeholder="" required disabled>
              </div>
       
        <div class="form-group col-xs-4 cpf_div">
          <label id="label_cpf_cnpj" for="valor">CPF/CNPJ</label>
          <input type="text"  class="form-control" id="cpf_cnpj" name="cpf" value="`+ dados_socio.cpf +`"  required disabled>
        </div>
        <div class="form-group col-xs-4">
            <label for="valor">Data de nascimento</label>
            <input type="date" class="form-control" id="data_nasc" value="`+ dados_socio.data_nascimento +`" name="data_nasc" required disabled>
          </div>
        </div>
        <div class="row">
        <div class="form-group col-xs-6">
          <label for="obs">E-mail</label>
          <input type="email" class="form-control" id="email" name="email" value="`+ dados_socio.email +`" placeholder="" disabled>
        </div>
        <div class="form-group col-xs-6">
          <label for="valor">Telefone</label>
          <input type="tel" min="0"  class="form-control" id="telefone" value="`+ dados_socio.telefone +`" name="telefone" required disabled>
        </div>
        </div>
        <div class="row">
        <div class="form-group col-xs-7">
          <label for="pessoa">Tipo de sócio</label>
          <input type="text" class="form-control" name="pessoa" value="`+ dados_socio.tipo +`" id="pessoa" disabled>
        </div>
        <div class="form-group col-xs-5">
          <label for="pessoa">Status</label>
          <input type="text" class="form-control" name="pessoa" value="`+ status +`" id="pessoa" disabled>
        </div>
        </div>
        <div class="box box-info endereco">
            <div class="box-header with-border">
              <h3 class="box-title">Endereço</h3>
            </div>
            <div class="box-body">
            <div class="row">
            <div class="form-group mb-2 col-xs-6">
              <label for="cep">CEP</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                <input type="text" id="cep" value="`+ dados_socio.cep +`" class="form-control" placeholder="" required disabled>
              </div>
              <div class="status_cep col-xs-12"></div>
              </div>
            </div>
            <div class="row">
              <div class="form-group mb-2 col-xs-8">
                        <label for="nome_cliente">Rua</label>
                        <input type="text" class="form-control" id="rua" value="`+ dados_socio.logradouro +`" name="nome" placeholder="" required disabled>
                    </div>
              <div class="form-group col-xs-4">
                <label for="data_corte">Número</label>
                <input type="number" class="form-control" min="0" id="numero" value="`+ dados_socio.numero_endereco +`" name="numero" placeholder="" required disabled>
              </div>
            </div>
            <div class="row">
            <div class="form-group mb-2 col-xs-6">
                        <label for="nome_cliente">Complemento</label>
                        <input type="text" class="form-control" id="complemento" value="`+ dados_socio.complemento +`" name="complemento" placeholder="" disabled>
                    </div>
              <div class="form-group col-xs-6">
                <label for="data_corte">Bairro</label>
                <input type="text" class="form-control" id="bairro" name="bairro" value="`+ dados_socio.bairro +`" placeholder="" required disabled>
              </div>
            </div>
            <div class="row">
            <div class="form-group mb-2 col-xs-6">
                        <label for="nome_cliente">Estado</label>
                        <input type="text" class="form-control" id="estado" value="`+ dados_socio.estado +`" name="estado" placeholder="" required disabled>
                    </div>
              <div class="form-group col-xs-6">
                <label for="data_corte">Cidade</label>
                <input type="text" class="form-control" id="cidade" name="cidade" value="`+ dados_socio.cidade +`" placeholder="" required disabled>
              </div>
            </div>
            </div>
            <!-- /.box-body -->
          </div>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
        </form>
            </div>
            <!-- /.box-body -->
            <!-- Loading (remove the following to stop the loading)-->
            
            <!-- end loading -->
          </div>
       
        
    </div>
  </div>
</div>
  `;
  // inputs = $(modal_detalhes_html).find("input");
  // console.log(inputs);
  // for(input of inputs){
  //   console.log(input);
  // }
  $(".boxDetalhes").prepend(
    '<div class="overlay"> <i class="fa fa-refresh fa-spin"></i> </div>'
);

setTimeout(function(){
    $(".boxDetalhes .overlay").remove();
},600);
  $(modal_detalhes_html).modal("toggle");

  })

}
  