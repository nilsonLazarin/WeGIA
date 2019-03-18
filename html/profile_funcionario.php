<?php
   session_start();
   if(!isset($_SESSION['usuario'])){
    header ("Location: ../index.php");
   }
   
   if (!isset($_SESSION['funcionario'])) {
    $id_funcionario=$_GET['id_funcionario'];
    header('Location: ../controle/control.php?metodo=listarUm&nomeClasse=FuncionarioControle&nextPage=../html/profile_funcionario.php?id_funcionario='.$id_funcionario.'&id_funcionario='.$id_funcionario);
   }
   
      $usuario = "root";
      $senha = "";
      $servidor = "localhost";
      $bddnome = "wegia";
      $mysqli = new mysqli($servidor,$usuario,$senha,$bddnome);
      $calcado = $mysqli->query("SELECT tamanhos FROM calcado");
      $calca = $mysqli->query("SELECT tamanhos FROM calca");
      $jaleco = $mysqli->query("SELECT tamanhos FROM jaleco");
      $camisa = $mysqli->query("SELECT tamanhos FROM camisa");
      $situacao = $mysqli->query("SELECT situacoes FROM situacao");
      $cargo = $mysqli->query("SELECT * FROM cargo");
   
   ?>
<!doctype html>
<html class="fixed">
   <head>
      <!-- Basic -->
      <meta charset="UTF-8">
      <title>Perfil funcionário</title>
      <meta name="keywords" content="HTML5 Admin Template" />
      <meta name="description" content="Porto Admin - Responsive HTML5 Template">
      <meta name="author" content="okler.net">
      <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
      <!-- Web Fonts  -->
      <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
      <!-- Vendor CSS -->
      <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.css" />
      <link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.css" />
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
      <link rel="stylesheet" href="../assets/vendor/magnific-popup/magnific-popup.css" />
      <link rel="stylesheet" href="../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
      <link rel="icon" href="../img/logofinal.png" type="image/x-icon">
      <script src="../assets/vendor/jquery/jquery.min.js"></script>
      <script src="../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
      <script src="../assets/vendor/bootstrap/js/bootstrap.js"></script>
      <script src="../assets/vendor/nanoscroller/nanoscroller.js"></script>
      <script src="../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
      <script src="../assets/vendor/magnific-popup/magnific-popup.js"></script>
      <script src="../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
      <!-- Theme CSS -->
      <link rel="stylesheet" href="../assets/stylesheets/theme.css" />
      <!-- Skin CSS -->
      <link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />
      <!-- Theme Custom CSS -->
      <link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">
      <link rel="stylesheet" href="../css/profile-theme.css"/>
      <!-- Head Libs -->
      <script src="../assets/vendor/modernizr/modernizr.js"></script>
      <script src="../Functions/onlyNumbers.js"></script>
      <script src="../Functions/onlyChars.js"></script>
      <script src="../Functions/enviar_dados.js"></script>
      <script src="../Functions/mascara.js"></script>
      <script src="../Functions/lista.js"></script>
      <!-- jquery functions -->
      <script>
         function editar_informacoes_pessoais()
           {
         
            $("#nomeForm").prop('disabled', false);
            $("#radioM").prop('disabled', false);
            $("#radioF").prop('disabled', false);
         
            $("#telefone").prop('disabled', false);
              
            $("#nascimento").prop('disabled', false);
         
            $("#pai").prop('disabled', false);
         
            $("#mae").prop('disabled', false);
         
            $("#sangue").prop('disabled', false);
         
            $("#botaoEditarIP").html('Cancelar');
            $("#botaoSalvarIP").prop('disabled', false);
            $("#botaoEditarIP").removeAttr('onclick');
            $("#botaoEditarIP").attr('onclick', "return cancelar_informacoes_pessoais()");
         
           }
         
            function cancelar_informacoes_pessoais()
           {
         
            $("#nomeForm").prop('disabled', true);
         
            $("#radioM").prop('disabled', true);
            $("#radioF").prop('disabled', true);
         
         
         
              $("#telefone").prop('disabled', true);
              
         
              $("#nascimento").prop('disabled', true);
         
              $("#pai").prop('disabled', true);
         
              $("#mae").prop('disabled', true);
         
         
              $("#sangue").prop('disabled', true);
         
             $("#botaoEditarIP").html('Editar');
             $("#botaoSalvarIP").prop('disabled', true);
             $("#botaoEditarIP").removeAttr('onclick');
             $("#botaoEditarIP").attr('onclick', "return editar_informacoes_pessoais()");
         
           }
         
           function editar_endereco()
           {
         
            $("#cep").prop('disabled', false);
         
            $("#uf").prop('disabled', false);
         
            $("#cidade").prop('disabled', false);
           
            $("#bairro").prop('disabled', false);
           
            $("#rua").prop('disabled', false);
           
            $("#complemento").prop('disabled', false);
           
            $("#ibge").prop('disabled', false);
           
           
            $("#numResidencial").prop('disabled', false);
           
            if ($('#numResidencial').is(':checked')) {
              $("#numero_residencia").prop('disabled', true);
            }else{
              $("#numero_residencia").prop('disabled', false);
            }
            
         
         
            $("#botaoEditarEndereco").html('Cancelar');
            $("#botaoSalvarEndereco").prop('disabled', false);
            $("#botaoEditarEndereco").removeAttr('onclick');
            $("#botaoEditarEndereco").attr('onclick', "return cancelar_endereco()");
         
           }
         
            function cancelar_endereco()
           {
         
            $("#cep").prop('disabled', true);
         
            $("#uf").prop('disabled', true);
         
            $("#cidade").prop('disabled', true);
           
            $("#bairro").prop('disabled', true);
           
            $("#rua").prop('disabled', true);
           
            $("#complemento").prop('disabled', true);
           
            $("#ibge").prop('disabled', true);
           
           
            $("#numResidencial").prop('disabled', true);
           
            $("#numero_residencia").prop('disabled', true);
         
             $("#botaoEditarEndereco").html('Editar');
             $("#botaoSalvarEndereco").prop('disabled', true);
             $("#botaoEditarEndereco").removeAttr('onclick');
             $("#botaoEditarEndereco").attr('onclick', "return editar_endereco()");
         
           }
         
           function editar_documentacao()
           {
         
            $("#rg").prop('disabled', false);
         
            $("#orgao_emissor").prop('disabled', false);
         
            $("#data_expedicao").prop('disabled', false);
         
            $("#cpf").prop('disabled', false);
         
            $("#data_admissao").prop('disabled', false);
         
            $("#botaoEditarDocumentacao").html('Cancelar');
            $("#botaoSalvarDocumentacao").prop('disabled', false);
            $("#botaoEditarDocumentacao").removeAttr('onclick');
            $("#botaoEditarDocumentacao").attr('onclick', "return cancelar_documentacao()");
         
           }
         
            function cancelar_documentacao()
           {
         
            $("#rg").prop('disabled', true);
         
            $("#orgao_emissor").prop('disabled', true);
         
            $("#data_expedicao").prop('disabled', true);
         
            $("#cpf").prop('disabled', true);
         
            $("#data_admissao").prop('disabled', true);
         
             $("#botaoEditarDocumentacao").html('Editar');
             $("#botaoSalvarDocumentacao").prop('disabled', true);
             $("#botaoEditarDocumentacao").removeAttr('onclick');
             $("#botaoEditarDocumentacao").attr('onclick', "return editar_documentacao()");
         
           }
         
           function editar_outros()
           {
         
           
              $("#radioTransportePossui").prop('disabled', false);
              $("#radioTransporteNaoPossui").prop('disabled', false);
              $("#num_transporte").prop('disabled', false);
              $("#cesta_basicaPossui").prop('disabled', false);
              $("#cesta_basicaNaoPossui").prop('disabled', false);
              $("#pis").prop('disabled', false);
              $("#ctps").prop('disabled', false);
              $("#uf_ctps").prop('disabled', false);
              $("#zona_eleitoral").prop('disabled', false);
              $("#titulo_eleitor").prop('disabled', false);
              $("#secao_titulo_eleitor").prop('disabled', false);
              $("#certificado_reservista_numero").prop('disabled', false);
              $("#certificado_reservista_serie").prop('disabled', false);
              $("#jaleco").prop('disabled', false);
              $("#camisa").prop('disabled', false);
              $("#calcado").prop('disabled', false);
              $("#calca").prop('disabled', false);
              $("#situacao").prop('disabled', false);
              $("#cargo").prop('disabled', false);
         
         
            $("#botaoEditarOutros").html('Cancelar');
            $("#botaoSalvarOutros").prop('disabled', false);
            $("#botaoEditarOutros").removeAttr('onclick');
            $("#botaoEditarOutros").attr('onclick', "return cancelar_outros()");
         
           }
         
            function cancelar_outros()
           {
         
            $("#radioTransportePossui").prop('disabled', true);
              $("#radioTransporteNaoPossui").prop('disabled', true);
              $("#num_transporte").prop('disabled', true);
              $("#cesta_basicaPossui").prop('disabled', true);
              $("#cesta_basicaNaoPossui").prop('disabled', true);
              $("#pis").prop('disabled', true);
              $("#ctps").prop('disabled', true);
              $("#uf_ctps").prop('disabled', true);
              $("#zona_eleitoral").prop('disabled', true);
              $("#titulo_eleitor").prop('disabled', true);
              $("#secao_titulo_eleitor").prop('disabled', true);
              $("#certificado_reservista_numero").prop('disabled', true);
              $("#certificado_reservista_serie").prop('disabled', true);
              $("#jaleco").prop('disabled', true);
              $("#camisa").prop('disabled', true);
              $("#calcado").prop('disabled', true);
              $("#calca").prop('disabled', true);
              $("#situacao").prop('disabled', true);
              $("#cargo").prop('disabled', true);
         
             $("#botaoEditarOutros").html('Editar');
             $("#botaoSalvarOutros").prop('disabled', true);
             $("#botaoEditarOutros").removeAttr('onclick');
             $("#botaoEditarOutros").attr('onclick', "return editar_outros()");
         
           }
         
         function alterardate(data)
           {
            var date=data.split("/")
            return date[2]+"-"+date[1]+"-"+date[0];
           }
         
           $(function(){
            
            var funcionario= <?php echo $_SESSION['funcionario'];?>;
            <?php unset($_SESSION['funcionario']); ?>;
            console.log(funcionario);
            $.each(funcionario,function(i,item){
         
         
              //Informações pessoais
         
         $("#nomeForm").val(item.nome).prop('disabled', true);
         
         if(item.sexo=="m")
          {
         
            $("#radioM").prop('checked',true).prop('disabled', true);
            $("#radioF").prop('checked',false).prop('disabled', true);
            $("#reservista1").show();
            $("#reservista2").show();
          }
          else if(item.sexo=="f")
          {
            $("#radioM").prop('checked',false).prop('disabled', true)
            $("#radioF").prop('checked',true).prop('disabled', true);
          }
           
         
         
          if(item.imagem!="")
          {
            $("#imagem").attr("src","data:image/gif;base64,"+item.imagem);
          }
          else{
            $("#imagem").attr("src","../img/semfoto.jpg");
          }
         
         
              $("#telefone").val(item.telefone).prop('disabled', true);
              
         
              $("#nascimento").val(alterardate(item.data_nascimento)).prop('disabled', true);
         
              $("#pai").val(item.nome_pai).prop('disabled', true);
         
              $("#mae").val(item.nome_mae).prop('disabled', true);
         
         
              $("#sangue").val(item.tipo_sanguineo).prop('disabled', true);
         
         
         
              //Endereço
         
              $("#cep").val(item.cep).prop('disabled', true);
         
              $("#uf").val(item.estado).prop('disabled', true);
         
              $("#cidade").val(item.cidade).prop('disabled', true);
           
              $("#bairro").val(item.bairro).prop('disabled', true);
             
              $("#rua").val(item.logradouro).prop('disabled', true);
             
              $("#complemento").val(item.complemento).prop('disabled', true);
             
              $("#ibge").val(item.ibge).prop('disabled', true);
             
              if (item.numero_endereco=='N?o possui' || item.numero_endereco==null ) {
             
                $("#numResidencial").prop('checked',true).prop('disabled', true);
             
                $("#numero_residencia").prop('disabled', true);
             
              }else{
             
             $("#numero_residencia").val(item.numero_endereco).prop('disabled', true);
             
                $("#numResidencial").prop('disabled', true);  
             
              }
         
         
          //Documentação
            var cpf = item.cpf.substr(0, 3)+"."+item.cpf.substr(3, 3)+"."+item.cpf.substr(6, 3)+"-"+item.cpf.substr(9, 2);
           
                $("#rg").val(item.registro_geral).prop('disabled', true);
         
                $("#orgao_emissor").val(item.orgao_emissor).prop('disabled', true);
         
                $("#data_expedicao").val(alterardate(item.data_expedicao)).prop('disabled', true);
           
                $("#cpf").val(cpf).prop('disabled', true);
         
                $("#data_admissao").val(alterardate(item.data_admissao)).prop('disabled', true);
         
         
                //Outros
         
                if (item.usa_vtp== "Possui") {
           
                  $("#radioTransportePossui").prop('checked',true).prop('disabled', true);
                  $("#radioTransporteNaoPossui").prop('checked',false).prop('disabled', true);
                  $("#esconder_exibir").show();
                  $("#num_transporte").val(item.vale_transporte).prop('disabled', true);
                  
         
           
                }else {
                  
                  $("#radioTransportePossui").prop('checked',false).prop('disabled', true);
                  $("#radioTransporteNaoPossui").prop('checked',true).prop('disabled', true);
         
         
                }
         
         
                if (item.cesta_basica=="Possui") {
                  $("#cesta_basicaPossui").prop('checked',true).prop('disabled', true);
                  $("#cesta_basicaNaoPossui").prop('checked',false).prop('disabled', true);
                }else{
                  $("#cesta_basicaPossui").prop('checked',false).prop('disabled', true);
                  $("#cesta_basicaNaoPossui").prop('checked',true).prop('disabled', true);
                }
         
         
         
           
                $("#pis").val(item.pis).prop('disabled', true);
                $("#ctps").val(item.ctps).prop('disabled', true);
                $("#uf_ctps").val(item.uf_ctps).prop('disabled', true);
           
                $("#zona_eleitoral").val(item.zona).prop('disabled', true);
           
                $("#titulo_eleitor").val(item.numero_titulo).prop('disabled', true);
           
                $("#secao_titulo_eleitor").val(item.secao).prop('disabled', true);
         
         
           
                $("#certificado_reservista_numero").val(item.certificado_reservista_numero).prop('disabled', true);
           
                $("#certificado_reservista_serie").val(item.certificado_reservista_serie).prop('disabled', true);
           
         
                $("#jaleco").val(item.jaleco).prop('disabled', true);
           
                $("#camisa").val(item.camisa).prop('disabled', true);
           
                $("#calcado").val(item.calcado).prop('disabled', true);
           
                $("#calca").val(item.calca).prop('disabled', true);
         
                $("#situacao").val(item.situacao).prop('disabled', true);
         
                $("#cargo").val(item.cargo).prop('disabled', true);
           
           
         
                
         
                //CARGA HORÁRIA
           
                $("#escala").text("Escala: "+item.escala);
           
                $("#tipo").text("Tipo: "+item.tipo);
           
                $("#dias_trabalhados").text("Dias trabalhados: "+item.dias_trabalhados);
           
                $("#dias_folga").text("Dias de folga: "+item.folga);
           
                $("#entrada1").text("Primeira entrada: "+item.entrada1);
           
                $("#saida1").text("Primeira Saída: "+item.saida1);
           
                $("#entrada2").text("Segunda entrada: "+item.entrada2);
           
                $("#saida2").text("Segunda saída: "+item.saida2);
           
                $("#total").text("Carga horária diária: "+item.total);
           
                $("#carga_horaria_mensal").text("Carga horária mensal: "+item.carga_horaria);
            })
           });
      </script>
      <script type="text/javascript" >
         function numero_residencial(){
            if($("#numResidencial").prop('checked')){
              $("#numero_residencia").val('');
               document.getElementById("numero_residencia").disabled = true;
         
            }else {
         
               document.getElementById("numero_residencia").disabled = false;
         
            }
         }
         
         
         function exibir_vale_transporte() {
         
            $("#esconder_exibir").show();
         
         }
         
         function esconder_vale_transporte() {
            
            document.getElementById('num_transporte').value=("");
            $("#esconder_exibir").hide();
         
         }
         
         function exibir_reservista() {
         
            $("#reservista1").show();
            $("#reservista2").show();
         }
         
         function esconder_reservista() {
         
         
            $("#reservista1").hide();
            $("#reservista2").hide();
         }
          
          function limpa_formulário_cep() {
                  //Limpa valores do formulário de cep.
                  document.getElementById('rua').value=("");
                  document.getElementById('bairro').value=("");
                  document.getElementById('cidade').value=("");
                  document.getElementById('uf').value=("");
                  document.getElementById('ibge').value=("");
          }
         
          function meu_callback(conteudo) {
              if (!("erro" in conteudo)) {
                  //Atualiza os campos com os valores.
                  document.getElementById('rua').value=(conteudo.logradouro);
                  document.getElementById('bairro').value=(conteudo.bairro);
                  document.getElementById('cidade').value=(conteudo.localidade);
                  document.getElementById('uf').value=(conteudo.uf);
                  document.getElementById('ibge').value=(conteudo.ibge);
              } //end if.
              else {
                  //CEP não Encontrado.
                  limpa_formulário_cep();
                  alert("CEP não encontrado.");
              }
          }
              
          function pesquisacep(valor) {
         
              //Nova variável "cep" somente com dígitos.
              var cep = valor.replace(/\D/g, '');
         
              //Verifica se campo cep possui valor informado.
              if (cep != "") {
         
                  //Expressão regular para validar o CEP.
                  var validacep = /^[0-9]{8}$/;
         
                  //Valida o formato do CEP.
                  if(validacep.test(cep)) {
         
                      //Preenche os campos com "..." enquanto consulta webservice.
                      document.getElementById('rua').value="...";
                      document.getElementById('bairro').value="...";
                      document.getElementById('cidade').value="...";
                      document.getElementById('uf').value="...";
                      document.getElementById('ibge').value="...";
         
                      //Cria um elemento javascript.
                      var script = document.createElement('script');
         
                      //Sincroniza com o callback.
                      script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';
         
                      //Insere script no documento e carrega o conteúdo.
                      document.body.appendChild(script);
         
                  } //end if.
                  else {
                      //cep é inválido.
                      limpa_formulário_cep();
                      alert("Formato de CEP inválido.");
                  }
              } //end if.
              else {
                  //cep sem valor, limpa formulário.
                  limpa_formulário_cep();
              }
         
          };
         
          function testaCPF(strCPF) { //strCPF é o cpf que será validado. Ele deve vir em formato string e sem nenhum tipo de pontuação.
                  var strCPF = strCPF.replace(/[^\d]+/g,''); // Limpa a string do CPF removendo espaços em branco e caracteres especiais. 
                                                              // PODE SER QUE NÃO ESTEJA LIMPANDO COMPLETAMENTE. FAVOR FAZER O TESTE!!!!
                  var Soma;
                  var Resto;
                  Soma = 0;
                  if (strCPF == "00000000000") return false;
                  
                  for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
                  Resto = (Soma * 10) % 11;
                  
                  if ((Resto == 10) || (Resto == 11))  Resto = 0;
                  if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;
                  
                  Soma = 0;
                  for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
                  Resto = (Soma * 10) % 11;
                  
                  if ((Resto == 10) || (Resto == 11))  Resto = 0;
                  if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
                  return true;
          }
         
          function validarCPF(strCPF){
         
            if (!testaCPF(strCPF)){
               $('#cpfInvalido').show();
               document.getElementById("enviarEditar").disabled = true;
         
            }else{
               $('#cpfInvalido').hide();
         
               document.getElementById("enviarEditar").disabled = false;
            }
         
          }
         
          
      </script>
      <script language="JavaScript">
         var numValidos = "0123456789-()";
         var num1invalido = "78";
         var i;
         function validarTelefone(){
            //Verificando quantos dígitos existem no campo, para controlarmos o looping;
            digitos = document.form1.telefone.value.length;
            
            for(i=0; i<digitos; i++) {
               if (numValidos.indexOf(document.form1.telefone.value.charAt(i),0) == -1) {
                  alert("Apenas números são permitidos no campo Telefone!");
                  document.form1.telefone.select();
                  return false;
               }
               if(i==0){
                  if (num1invalido.indexOf(document.form1.telefone.value.charAt(i),0) != -1) {
                  alert("Número de telefone inválido!");
                  document.form1.telefone.select();
                  return false;
                  }
               }
            } 
            
         }
         
      </script>
   </head>
   <body>
      <section class="body">
         <!-- start: header -->
         <header class="header">
            <div class="logo-container">
               <a href="home.php" class="logo">
               <img src="../img/logofinal.png" height="35" alt="Porto Admin" />
               </a>
               <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
                  <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
               </div>
            </div>
            <!-- start: search & user box -->
            <div class="header-right">
               <span class="separator"></span>
               <div id="userbox" class="userbox">
                  <a href="#" data-toggle="dropdown">
                     <figure class="profile-picture">
                        <img src="../img/semfoto.jpg" alt="Joseph Doe" class="img-circle" data-lock-picture="../assets/images/!logged-user.jpg" />
                     </figure>
                     <div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
                        <span class="name">Usuário</span>
                        <span class="role">Funcionário</span>
                     </div>
                     <i class="fa custom-caret"></i>
                  </a>
                  <div class="dropdown-menu">
                     <ul class="list-unstyled">
                        <li class="divider"></li>
                        <li>
                <a role="menuitem" tabindex="-1" href="../html/alterar_senha.php"><i class="glyphicon glyphicon-lock"></i> Alterar senha</a>
              </li>
                        <li>
                           <a role="menuitem" tabindex="-1" href="../html/logout.php"><i class="fa fa-power-off"></i> Sair da sessão</a>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
            <!-- end: search & user box -->
         </header>
         <!-- end: header -->
         <div class="inner-wrapper">
            <!-- start: sidebar -->
            <aside id="sidebar-left" class="sidebar-left">
               <div class="sidebar-header">
                  <div class="sidebar-title">
                     Navegação
                  </div>
                  <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
                     <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
                  </div>
               </div>
               <div class="nano">
                  <div class="nano-content">
                     <nav id="menu" class="nav-main" role="navigation">
                        <ul class="nav nav-main">
                           <li>
                              <a href="home.php">
                              <i class="fa fa-home" aria-hidden="true"></i>
                              <span>Início</span>
                              </a>
                           </li>
                           <li class="nav-parent nav-expanded nav-active">
                              <a>
                              <i class="fa fa-copy" aria-hidden="true"></i>
                              <span>Cadastros Pessoas</span>
                              </a>
                              <ul class="nav nav-children">
                                 <li>
                                    <a href="cadastro_funcionario.php">
                                    Cadastrar funcionário
                                    </a>
                                 </li>
                                 <li>
                                    <a href="cadastro_interno.php">
                                    Cadastrar interno
                                    </a>
                                 </li>
                                 <li>
                                    <a href="cadastro_voluntario.php">
                                    Cadastrar voluntário
                                    </a>
                                 </li>
                                 <li>
                                    <a href="cadastro_voluntario_judicial.php">
                                    Cadastrar voluntário judicial
                                    </a>
                                 </li>
                              </ul>
                           </li>
                           <li class="nav-parent nav-expanded nav-active">
                              <a>
                              <i class="fa fa-copy" aria-hidden="true"></i>
                              <span>Informação Pessoas</span>
                              </a>
                              <ul class="nav nav-children">
                                 <li>
                                    <a href="../controle/control.php?metodo=listarTodos&nomeClasse=FuncionarioControle&nextPage=../html/informacao_funcionario.php">
                                    Informações funcionarios
                                    </a>
                                 </li>
                              </ul>
                              <ul class="nav nav-children">
                                 <li>
                                    <a href="../controle/control.php?metodo=listarTodos&nomeClasse=InternoControle&nextPage=../html/informacao_interno.php">
                                    Informações interno
                                    </a>
                                 </li>
                              </ul>
                           </li>
                           <li class="nav-parent nav-expanded nav-active">
                              <a>
                              <i class="fa fa-copy" aria-hidden="true"></i>
                              <span>Cadastrar Produtos</span>
                              </a>
                              <ul class="nav nav-children">
                                 <li>
                                    <a href="../html/cadastro_entrada.php">
                                    Cadastrar Produtos
                                    </a>
                                 </li>
                              </ul>
                              <ul class="nav nav-children">
                                 <li>
                                    <a href="../html/cadastro_saida.php">
                                    Saida de Produtos
                                    </a>
                                 </li>
                              </ul>
                           </li>
                           <li class="nav-parent nav-expanded nav-active">
                              <a>
                              <i class="fa fa-copy" aria-hidden="true"></i>
                              <span>Informações Produtos</span>
                              </a>
                              <ul class="nav nav-children">
                                 <li>
                                    <a href="../html/estoque.php">
                                    Estoque
                                    </a>
                                 </li>
                              </ul>
                              <ul class="nav nav-children">
                                 <li>
                                    <a href="../html/listar_almox.php">
                                    Almoxarifados
                                    </a>
                                 </li>
                              </ul>
                           </li>
                        </ul>
                     </nav>
                  </div>
               </div>
               <form id="listarFuncionario" method="POST" action="../controle/control.php">
                  <input type="hidden" name="nomeClasse" value="FuncionarioControle">
                  <input type="hidden" name="metodo" value="listartodos">
                  <input type="hidden" name="nextPage" value="../html/informacao_funcionario.php">
               </form>
               <form id="listarInterno" method="POST" action="../controle/control.php">
                  <input type="hidden" name="nomeClasse" value="InternoControle">
                  <input type="hidden" name="metodo" value="listartodos">
                  <input type="hidden" name="nextPage" value="../html/informacao_interno.php">
               </form>
            </aside>
            <!-- end: sidebar -->
            <section role="main" class="content-body">
               <header class="page-header">
                  <h2>Perfil</h2>
                  <div class="right-wrapper pull-right">
                     <ol class="breadcrumbs">
                        <li>
                           <a href="home.php">
                           <i class="fa fa-home"></i>
                           </a>
                        </li>
                        <li><span>Páginas</span></li>
                        <li><span>Perfil</span></li>
                     </ol>
                     <a class="sidebar-right-toggle" ><i class="fa fa-chevron-left"></i></a>
                  </div>
               </header>
               <!-- start: page -->
               <div class="row">
                  <div class="col-md-4 col-lg-3">
                     <section class="panel">
                        <div class="panel-body">
                           <div class="thumb-info mb-md">
                              <?php
                                 if($_SERVER['REQUEST_METHOD'] == 'POST')
                                 {
                                   if(isset($_FILES['imgperfil']))
                                   {
                                     $image = file_get_contents ($_FILES['imgperfil']['tmp_name']);
                                     session_start();
                                     $_SESSION['imagem']=$image;
                                                 echo '<img src="data:image/gif;base64,'.base64_encode($image).'" class="rounded img-responsive" alt="John Doe">';
                                   } 
                                 }
                                 else
                                 {
                                 ?>
                              <img id="imagem" alt="John Doe">
                              <?php 
                                 }
                                 ?>
                              <i class="fas fa-camera-retro btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"></i>
                              <div class="container">
                                 <div class="modal fade" id="myModal" role="dialog">
                                    <div class="modal-dialog">
                                       <!-- Modal content-->
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                                             <h4 class="modal-title">Adicionar uma Foto</h4>
                                          </div>
                                          <div class="modal-body">
                                             <form class="form-horizontal" method="POST" action="../controle/control.php" enctype="multipart/form-data">
                                                <input type="hidden" name="nomeClasse" value="FuncionarioControle">
                                                <input type="hidden" name="metodo" value="alterarImagem">
                                                <div class="form-group">
                                                   <label class="col-md-4 control-label" for="imgperfil">Carregue nova imagem de perfil:</label>
                                                   <div class="col-md-8">
                                                      <input type="file" name="imgperfil" size="60" id="imgform" class="form-control">
                                                   </div>
                                                </div>
                                          </div>
                                          <div class="modal-footer">
                                          <input type="hidden" name="id_funcionario" value=<?php echo $_GET['id_funcionario'] ?> >
                                          <input type="submit" id="formsubmit" value="Alterar imagem">
                                          </div>
                                       </div>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="widget-toggle-expand mb-md">
                              <div class="widget-header">
                                 <div class="widget-content-expanded">
                                    <ul class="simple-todo-list">
                                    </ul>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </section>
                  </div>
                  <div class="col-md-8 col-lg-8">
                     <div class="tabs">
                        <ul class="nav nav-tabs tabs-primary">
                           <li class="active">
                              <a href="#overview" data-toggle="tab">Visão Geral</a>
                           </li>
                           <li>
                              <a href="#carga_horaria" data-toggle="tab">Carga Horária</a>
                           </li>
                           <li>
                              <a href="#editar_cargaHoraria" data-toggle="tab">Editar carga</a>
                           </li>
                           
                        </ul>
                        <div class="tab-content">
                           <div id="overview" class="tab-pane active">
                              <div>
                                 <form class="form-horizontal" method="post" action="../controle/control.php">
                                    <input type="hidden" name="nomeClasse" value="FuncionarioControle">
                                    <input type="hidden" name="metodo" value="alterarInfPessoal">
                                    <h4 class="mb-xlg">Informações Pessoais</h4>
                                    <fieldset>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" for="profileFirstName">Nome completo</label>
                                       <div class="col-md-8">
                                          <input type="text" class="form-control" name="nome" id="nomeForm" onkeypress="return Onlychars(event)" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" for="profileLastName">Sexo</label>
                                       <div class="col-md-8">
                                          <label><input type="radio" name="gender" id="radioM" id="M" value="m" style="margin-top: 10px; margin-left: 15px;" onclick="return exibir_reservista()" required><i class="fa fa-male" style="font-size: 20px;"></i></label>
                                          <label><input type="radio" name="gender" id="radioF" id="F" value="f" style="margin-top: 10px; margin-left: 15px;" onclick="return esconder_reservista()" ><i class="fa fa-female" style="font-size: 20px;"></i> </label>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" for="profileCompany">Telefone</label>
                                       <div class="col-md-8">
                                          <input type="text" class="form-control" maxlength="14" minlength="14" name="telefone" id="telefone" placeholder="Ex: (22)99999-9999" onkeypress="return Onlynumbers(event)" onkeyup="mascara('(##)#####-####',this,event)" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" for="profileCompany">Nascimento</label>
                                       <div class="col-md-8">
                                          <input type="date" placeholder="dd/mm/aaaa" maxlength="10" class="form-control" name="nascimento" id="nascimento" max=<?php echo date('Y-m-d'); ?> required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" for="profileFirstName">Nome do pai</label>
                                       <div class="col-md-8">
                                          <input type="text" class="form-control" name="nome_pai" id="pai" onkeypress="return Onlychars(event)" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" for="profileFirstName">Nome da mãe</label>
                                       <div class="col-md-8">
                                          <input type="text" class="form-control" name="nome_mae" id="mae" onkeypress="return Onlychars(event)" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" for="inputSuccess">Tipo sanguíneo</label>
                                       <div class="col-md-6">
                                          <select class="form-control input-lg mb-md" name="sangue" id="sangue">
                                             <option selected disabled>Selecionar</option>
                                             <option value="A+">A+</option>
                                             <option value="A-">A-</option>
                                             <option value="B+">B+</option>
                                             <option value="B-">B-</option>
                                             <option value="O+">O+</option>
                                             <option value="O-">O-</option>
                                             <option value="AB+">AB+</option>
                                             <option value="AB-">AB-</option>
                                          </select>
                                       </div>
                                    </div>
                                    <input type="hidden" name="id_funcionario" value=<?php echo $_GET['id_funcionario'] ?> >
                                    <button type="button" class="btn btn-primary" id="botaoEditarIP" onclick="return editar_informacoes_pessoais()">Editar</button>
                                    <input type="submit" class="btn btn-primary" disabled="true"  value="Salvar" id="botaoSalvarIP">
                                 </form>
                                 <br/>
                                 <hr class="dotted short">
                                 <h4 class="mb-xlg">Endereço</h4>
                                 <form class="form-horizontal" method="post" action="../controle/control.php">
                                    <input type="hidden" name="nomeClasse" value="FuncionarioControle">
                                    <input type="hidden" name="metodo" value="alterarEndereco">
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" for="cep">CEP</label>
                                       <div class="col-md-8">
                                          <input type="text" name="cep"  value="" size="10" onblur="pesquisacep(this.value);" class="form-control" id="cep" maxlength="9" placeholder="Ex: 22222-222" onkeypress="return Onlynumbers(event)" onkeyup="mascara('#####-###',this,event)" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" for="uf">Estado</label>
                                       <div class="col-md-8">
                                          <input type="text" name="uf" size="60" class="form-control" id="uf" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" for="cidade">Cidade</label>
                                       <div class="col-md-8">
                                          <input type="text" size="40" class="form-control" name="cidade" id="cidade" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" for="bairro">Bairro</label>
                                       <div class="col-md-8">
                                          <input type="text" name="bairro" size="40" class="form-control" id="bairro" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" for="rua">Logradouro</label>
                                       <div class="col-md-8">
                                          <input type="text" name="rua" size="2" class="form-control" id="rua" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" for="profileCompany">Número residencial</label>
                                       <div class="col-md-4">
                                          <input type="number" min="0" oninput="this.value = Math.abs(this.value)" class="form-control" name="numero_residencia"  id="numero_residencia">
                                       </div>
                                       <div class="col-md-3"> 
                                          <label>Não possuo número
                                          <input type="checkbox" id="numResidencial" name="naoPossuiNumeroResidencial"  style="margin-left: 4px" onclick="return numero_residencial()">
                                          </label>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" for="profileCompany">Complemento</label>
                                       <div class="col-md-8">
                                          <input type="text" class="form-control" name="complemento" id="complemento" id="profileCompany">
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" for="ibge">IBGE</label>
                                       <div class="col-md-8">
                                          <input type="text" size="8" name="ibge" class="form-control"  id="ibge">
                                       </div>
                                    </div>
                                    <br/>
                                    <input type="hidden" name="id_funcionario" value=<?php echo $_GET['id_funcionario'] ?> >
                                    <button type="button" class="btn btn-primary" id="botaoEditarEndereco" onclick="return editar_endereco()">Editar</button>
                                    <input type="submit" class="btn btn-primary" disabled="true"  value="Salvar" id="botaoSalvarEndereco" disabled="true">
                                 </form>
                                 <br/>
                                 <hr class="dotted short">
                                 <h4 class="mb-xlg doch4">Documentação</h4>
                                 <form class="form-horizontal" method="post" action="../controle/control.php">
                                    <input type="hidden" name="nomeClasse" value="FuncionarioControle">
                                    <input type="hidden" name="metodo" value="alterarDocumentacao">
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" for="profileCompany">Número do RG</label>
                                       <div class="col-md-6">
                                          <input type="text" class="form-control" name="rg" id="rg" onkeypress="return Onlynumbers(event)" placeholder="Ex: 22.222.222-2" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" for="profileCompany">Órgão emissor</label>
                                       <div class="col-md-6">
                                          <input type="text" class="form-control" name="orgao_emissor" id="orgao_emissor" onkeypress="return Onlychars(event)" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" for="profileCompany">Data de expedição</label>
                                       <div class="col-md-6">
                                          <input type="date" class="form-control" maxlength="10" placeholder="dd/mm/aaaa" name="data_expedicao" id="data_expedicao" max=<?php echo date('Y-m-d'); ?> required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" for="profileCompany">Número do CPF</label>
                                       <div class="col-md-6">
                                          <input type="text" class="form-control" id="cpf" name="cpfForm" placeholder="Ex: 222.222.222-22" maxlength="14" onblur="validarCPF(this.value)"" onkeypress="return Onlynumbers(event)" onkeyup="mascara('###.###.###-##',this,event)" required>
                                       </div>
                                    </div>
                                    <div class="form-group" id="cpfInvalido" style="display: none;">
                                       <label class="col-md-3 control-label" for="profileCompany"></label>
                                       <div class="col-md-6" >
                                          <p style="color: #b30000">CPF INVÁLIDO!</p>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" for="profileCompany">Data de admissão</label>
                                       <div class="col-md-8">
                                          <input type="date" placeholder="dd/mm/aaaa" maxlength="10" class="form-control" name="data_admissao" id="data_admissao" max=<?php echo date('Y-m-d'); ?>  required>
                                       </div>
                                    </div>
                                    <br/>
                                    <input type="hidden" name="id_funcionario" value=<?php echo $_GET['id_funcionario'] ?> >
                                    <button type="button" class="btn btn-primary" id="botaoEditarDocumentacao" onclick="return editar_documentacao()">Editar</button>
                                    <input type="submit" class="btn btn-primary" disabled="true"  value="Salvar" id="botaoSalvarDocumentacao" disabled="true">
                                 </form>
                                 <hr class="dotted short">
                                 <form class="form-horizontal" method="post" action="../controle/control.php">
                                    <input type="hidden" name="nomeClasse" value="FuncionarioControle">
                                    <input type="hidden" name="metodo" value="alterarOutros">
                                    <h4 class="mb-xlg doch4">Outros</h4>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" for="profileLastName">Vale transporte</label>
                                       <div class="col-md-8">
                                          <label><input type="radio" name="vale_transporte" id="radioTransportePossui" value="Possui" style="margin-top: 10px; margin-left: 15px;"  onclick="return exibir_vale_transporte()" required><i class="fa fa-check" style="font-size: 20px;"></i></label>
                                          <label>  <input type="radio" name="vale_transporte" id="radioTransporteNaoPossui" value="Não possui" class="vale_transporte" style="margin-top: 10px; margin-left: 15px;" onclick="return esconder_vale_transporte()"><i class="fa fa-times" style="font-size: 20px;" ></i> </label>
                                       </div>
                                    </div>
                                    <div class="form-group" id="esconder_exibir" style="display: none;">
                                       <label class="col-md-3 control-label" >Número vale transporte</label>
                                       <div class="col-md-6">
                                          <input type="text" id="num_transporte" name="num_vale_transporte" class="form-control">
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" for="profileLastName">Cesta básica</label>
                                       <div class="col-md-8">
                                          <label> <input type="radio" name="cesta_basica" id="cesta_basicaPossui" value="Possui" style="margin-top: 10px; margin-left: 15px;" required><i class="fa fa-check" style="font-size: 20px;"></i></label>
                                          <label> <input type="radio" name="cesta_basica" id="cesta_basicaNaoPossui" value="Não possui" class="vale_transporte" style="margin-top: 10px; margin-left: 15px;"><i class="fa fa-times" style="font-size: 20px;" ></i> </label>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" >PIS</label>
                                       <div class="col-md-6">
                                          <input type="text" id="pis" name="pis" class="form-control" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" >CTPS</label>
                                       <div class="col-md-6">
                                          <input type="text" id="ctps" name="ctps" class="form-control" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" for="uf">Estado CTPS</label>
                                       <div class="col-md-6">
                                          <input type="text" name="uf_ctps" size="60" class="form-control" id="uf_ctps" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" >Título de eleitor</label>
                                       <div class="col-md-6">
                                          <input type="text" name="titulo_eleitor" id="titulo_eleitor" class="form-control" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" >Zona eleitoral</label>
                                       <div class="col-md-6">
                                          <input type="text" name="zona_eleitoral" id="zona_eleitoral" class="form-control" required>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" >Seção do título de eleitor</label>
                                       <div class="col-md-6">
                                          <input type="text" name="secao_titulo_eleitor" id="secao_titulo_eleitor" class="form-control" required>
                                       </div>
                                    </div>
                                    <div class="form-group" id="reservista1" style="display: none">
                                       <label class="col-md-3 control-label" >Número do certificado reservista</label>
                                       <div class="col-md-6">
                                          <input type="text" id="certificado_reservista_numero" name="certificado_reservista_numero" class="form-control num_reservista">
                                       </div>
                                    </div>
                                    <div class="form-group" id="reservista2" style="display: none">
                                       <label class="col-md-3 control-label" >Série do certificado reservista</label>
                                       <div class="col-md-6">
                                          <input type="text" id="certificado_reservista_serie" name="certificado_reservista_serie" class="form-control serie_reservista">
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" for="inputSuccess">Calçado</label>
                                       <a href="adicionar_calcado.php"><i class="fas fa-plus w3-xlarge" style="margin-top: 0.75vw"></i></a>
                                       <div class="col-md-6">
                                          <select class="form-control input-lg mb-md" name="calcado" id="calcado">
                                             <option selected disabled>Selecionar</option>
                                             <option value="Não utiliza">Não utiliza</option>
                                             <?php 
                                                while($row = $calcado->fetch_array(MYSQLI_NUM))
                                                {
                                                  echo "<option value=".$row[0].">".$row[0]."</option>";
                                                }
                                                ?>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" for="inputSuccess">Calça</label>
                                       <a href="adicionar_calca.php"><i class="fas fa-plus w3-xlarge" style="margin-top: 0.75vw"></i></a>
                                       <div class="col-md-6">
                                          <select class="form-control input-lg mb-md" name="calca" id="calca">
                                             <option selected disabled>Selecionar</option>
                                             <option value="Não utiliza">Não utiliza</option>
                                             <?php 
                                                while($row = $calca->fetch_array(MYSQLI_NUM))
                                                {
                                                  echo "<option value=".$row[0].">".$row[0]."</option>";
                                                }
                                                ?>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" for="inputSuccess">Jaleco</label>
                                       <a href="adicionar_jaleco.php"><i class="fas fa-plus w3-xlarge" style="margin-top: 0.75vw"></i></a>
                                       <div class="col-md-6">
                                          <select class="form-control input-lg mb-md" name="jaleco" id="jaleco">
                                             <option selected disabled>Selecionar</option>
                                             <option value="Não utiliza">Não utiliza</option>
                                             <?php 
                                                while($row = $jaleco->fetch_array(MYSQLI_NUM))
                                                {
                                                  echo "<option value=".$row[0].">".$row[0]."</option>";
                                                }
                                                ?>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" for="inputSuccess">Camisa</label>
                                       <a href="adicionar_camisa.php"><i class="fas fa-plus w3-xlarge" style="margin-top: 0.75vw"></i></a>
                                       <div class="col-md-6">
                                          <select class="form-control input-lg mb-md" name="camisa" id="camisa">
                                             <option selected disabled>Selecionar</option>
                                             <option value="Não utiliza">Não utiliza</option>
                                             <?php 
                                                while($row = $camisa->fetch_array(MYSQLI_NUM))
                                                {
                                                  echo "<option value=".$row[0].">".$row[0]."</option>";
                                                }                           ?>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" for="inputSuccess">Situação</label>
                                       <a href="adicionar_situacao.php"><i class="fas fa-plus w3-xlarge" style="margin-top: 0.75vw"></i></a>
                                       <div class="col-md-6">
                                          <select class="form-control input-lg mb-md" name="situacao" id="situacao">
                                             <option selected disabled>Selecionar</option>
                                             <?php 
                                                while($row = $situacao->fetch_array(MYSQLI_NUM))
                                                {
                                                  echo "<option value=".$row[0].">".$row[0]."</option>";
                                                }                           ?>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" for="inputSuccess">Cargo</label>
                                       <a href="cadastro_cargo.php"><i class="fas fa-plus w3-xlarge" style="margin-top: 0.75vw"></i></a>
                                       <div class="col-md-6">
                                          <select class="form-control input-lg mb-md" name="cargo" id="cargo">
                                             <option selected disabled>Selecionar</option>
                                             <?php 
                                                while($row = $cargo->fetch_array(MYSQLI_NUM))
                                                {
                                                  echo "<option value=".$row[1].">".$row[1]."</option>";
                                                }                           ?>
                                          </select>
                                       </div>
                                    </div>
                                    <input type="hidden" name="id_funcionario" value=<?php echo $_GET['id_funcionario'] ?> >
                                    <button type="button" class="btn btn-primary" id="botaoEditarOutros" onclick="return editar_outros()">Editar</button>
                                    <input type="submit" class="btn btn-primary" disabled="true"  value="Salvar" id="botaoSalvarOutros" disabled="true">

                                 </form>
                              <div class="panel-footer">
                                    <div class="row">
                                       <div class="col-md-9 col-md-offset-3">
                                          <button id="excluir" type="button" class="btn btn-danger" data-toggle="modal" data-target="#exclusao">Excluir</button>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                                 <div class="modal fade" id="exclusao" role="dialog">
                                   <div class="modal-dialog">
                                   <!-- Modal content-->
                                    <div class="modal-content">
                                       <div class="modal-header">
                                           <button type="button" class="close" data-dismiss="modal">×</button>
                                           <h3>Excluir um Funcionário</h3>
                                        </div>
                                        <div class="modal-body">
                                            <p> Tem certeza que deseja excluir esse funcionário? Essa ação não poderá ser desfeita e todas as informações referentes a esse funcionário serão perdidas!</p>
                                            <a href="../controle/control.php?metodo=excluir&nomeClasse=FuncionarioControle&id_funcionario=<?php echo $_GET['id_funcionario']; ?>"><button button type="button" class="btn btn-success">Confirmar</button></a>
                                            <button button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                         </div>
                                      </div>
                                     </div>
                                 </div>
                           <div id="carga_horaria" class="tab-pane">
                              <section class="panel">
                                 <div class="panel-body" style="display: block;">
                                    <ul class="nav nav-children" id="info">
                                       <li id="cap">Carga horária:</li>
                                       </br>
                                       <li id="escala">Escala:</li>
                                       </br>
                                       <li id="tipo">Tipo:</li>
                                       </br>
                                       <li id="dias_trabalhados">Dias trabalhados:</li>
                                       </br>
                                       <li id="dias_folga">Dias de folga:</li>
                                       </br>
                                       <li id="entrada1">Primeira entrada:</li>
                                       </br>
                                       <li id="saida1">Primeira saída</li>
                                       </br>
                                       <li id="entrada2">Segunda entrada:</li>
                                       </br>
                                       <li id="saida2">Segunda saída:</li>
                                       </br>
                                       <li id="total">Carga horária diária:</li>
                                       </br>
                                       <li id="carga_horaria_mensal">Carga horária mensal:</li>
                                    </ul>
                                 </div>
                              </section>
                           </div>
                           <div id="editar_cargaHoraria" class="tab-pane">
                              <section class="panel">
                                 <form class="form-horizontal" method="post" action="../controle/control.php">
                                    <h4 class="mb-xlg doch4">Carga Horária</h4>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" >Escala</label>
                                       <div class="col-md-6">
                                          <select class="form-control input-lg mb-md" name="escala" id="escala">
                                             <option selected disabled>Selecionar</option>
                                             <option value="Plantonista">Plantonista</option>
                                             <option value="Diarista">Diarista</option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" >Tipo</label>
                                       <div class="col-md-6">
                                          <select class="form-control input-lg mb-md" name="tipoCargaHoraria" id="tipoCargaHoraria">
                                             <option selected disabled>Selecionar</option>
                                             <option value="Mensalista">Mensalista</option>
                                             <option value="Diarista">Diarista</option>
                                             <option value="Horista">Horista</option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" >Primeira entrada</label>
                                       <div class="col-md-3">
                                          <input type="time" placeholder="07:25" class="form-control" name="entrada1" id="entrada1" >
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" >Primeira saída</label>
                                       <div class="col-md-3">
                                          <input type="time" placeholder="07:25" class="form-control" name="saida1" id="saida1" >
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" >Segunda entrada</label>
                                       <div class="col-md-3">
                                          <input type="time" placeholder="07:25" class="form-control" name="entrada2" id="entrada2" >
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" >Segunda saída</label>
                                       <div class="col-md-3">
                                          <input type="time" placeholder="07:25" class="form-control" name="saida2" id="saida2" >
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-3 control-label" >Dias trabalhados</label>
                                       <div class="col-md-2"> 
                                          <label>Seg <input type="checkbox" id="diaTrabalhado" name="trabSeg" value="Seg"></label>
                                       </div>
                                       <div class="col-md-2"> 
                                          <label>Ter <input type="checkbox" id="diaTrabalhado" name="trabTer" value="Ter"></label>
                                       </div>
                                       <div class="col-md-2"> 
                                          <label>Qua <input type="checkbox" id="diaTrabalhado" name="trabQua" value="Qua"></label>
                                       </div>
                                       <div class="col-md-2"> 
                                          <label>Qui <input type="checkbox" id="diaTrabalhado" name="trabQui" value="Qui"></label>
                                       </div>
                                       <div class="col-md-2"> 
                                          <label>Sex <input type="checkbox" id="diaTrabalhado" name="trabSex" value="Sex"></label>
                                       </div>
                                       <div class="col-md-2"> 
                                          <label>Sab <input type="checkbox" id="diaTrabalhado" name="trabSab" value="Sab"></label>
                                       </div>
                                       <div class="col-md-2"> 
                                          <label>Dom <input type="checkbox" id="diaTrabalhado" name="trabDom" value="Dom"></label>
                                       </div>
                                       <div class="col-md-2"> 
                                          <label>Plantão 12/36<input type="checkbox" id="diaTrabalhado" name="plantao" value="Plantão 12/36"></label>
                                       </div>
                                    </div>
                                    <div class="form-group" style="margin-top: 20px;">
                                       <label class="col-md-3 control-label" >Dias de folga</label>
                                       <div class="col-md-2"> 
                                          <label>Seg <input type="checkbox" id="diaTrabalhado" name="folgaSeg" value="Seg"></label>
                                       </div>
                                       <div class="col-md-2"> 
                                          <label>Ter <input type="checkbox" id="diaTrabalhado" name="folgaTer" value="Ter"></label>
                                       </div>
                                       <div class="col-md-2"> 
                                          <label>Qua <input type="checkbox" id="diaTrabalhado" name="folgaQua" value="Qua"></label>
                                       </div>
                                       <div class="col-md-2"> 
                                          <label>Qui <input type="checkbox" id="diaTrabalhado" name="folgaQui" value="Qui"></label>
                                       </div>
                                       <div class="col-md-2"> 
                                          <label>Sex <input type="checkbox" id="diaTrabalhado" name="folgaSex" value="Sex"></label>
                                       </div>
                                       <div class="col-md-2"> 
                                          <label>Sab <input type="checkbox" id="diaTrabalhado" name="folgaSab" value="Sab"></label>
                                       </div>
                                       <div class="col-md-2"> 
                                          <label>Dom <input type="checkbox" id="diaTrabalhado" name="folgaDom" value="Dom"></label>
                                       </div>
                                       <div class="col-md-2"> 
                                          <label>Alternado <input type="checkbox" id="diaTrabalhado" name="folgaAlternado" value="Alternado"></label>
                                       </div>
                                    </div>
                                    <hr class="dotted short">
                                    <div class="panel-footer">
                                       <div class="row">
                                          <div class="col-md-9 col-md-offset-3">
                                             <input type="hidden" name="nomeClasse" value="FuncionarioControle">
                                             <input type="hidden" name="metodo" value="alterarCargaHoraria">
                                             <input type="hidden" name="id" value=<?php echo $_GET['id_funcionario'] ?> >
                                             <input id="enviarCarga" type="submit" class="btn btn-primary" value="Alterar carga">
                                             <input type="reset" class="btn btn-default">
                                          </div>
                                       </div>
                                    </div>
                                 </form>
                              </section>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- end: page -->
            </section>
         </div>
      </section>
      <!-- Vendor -->
<script src="../assets/vendor/select2/select2.js"></script>
		<script src="../assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
		<script src="../assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
		<script src="../assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="../assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="../assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="../assets/javascripts/theme.init.js"></script>


		<!-- Examples -->
		<script src="../assets/javascripts/tables/examples.datatables.default.js"></script>
		<script src="../assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
		<script src="../assets/javascripts/tables/examples.datatables.tabletools.js"></script>
	</body>
</html>

