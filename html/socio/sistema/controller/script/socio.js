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