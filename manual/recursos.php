<?php
$config_path = "config.php";
if(file_exists($config_path)){
    require_once($config_path);
}else{
    while(true){
        $config_path = "../" . $config_path;
        if(file_exists($config_path)) break;
    }
    require_once($config_path);
}
?>
<!doctype html>
<html class="fixed">
<head>
    <!-- Basic -->
    <meta charset="UTF-8">

    <title>3. Recursos</title>

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
    
    <!-- Theme CSS -->
    <link rel="stylesheet" href="../assets/stylesheets/theme.css" />
    
    <!-- Skin CSS -->
    <link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />
    
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">
    
    <!-- Head Libs -->
    <script src="../assets/vendor/modernizr/modernizr.js"></script>

    <!-- Atualizacao CSS -->
    <link rel="stylesheet" href="../css/atualizacao.css" />

    <!-- Manual CSS -->
    <link rel="stylesheet" href="../css/manual.css">
    
    <!-- Vendor -->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.js"></script>
    <script src="../assets/vendor/nanoscroller/nanoscroller.js"></script>
    <script src="../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="../assets/vendor/magnific-popup/magnific-popup.js"></script>
    <script src="../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
        
    <!-- Specific Page Vendor -->
    <script src="../assets/vendor/jquery-autosize/jquery.autosize.js"></script>
        
    <!-- Theme Base, Components and Settings -->
    <script src="../assets/javascripts/theme.js"></script>
        
    <!-- Theme Custom -->
    <script src="../assets/javascripts/theme.custom.js"></script>
        
    <!-- Theme Initialization Files -->
    <script src="../assets/javascripts/theme.init.js"></script>

    <!-- javascript functions --> <script
    src="../Functions/onlyNumbers.js"></script> <script
    src="../Functions/onlyChars.js"></script> <script
    src="../Functions/mascara.js"></script>

    <!-- jquery functions -->
    <script>
        document.write('<a href="' + document.referrer + '"></a>');
    </script>

    <script>
    function goBack() {
    window.history.back()
    }
    </script>
    
    <!-- javascript tab management script -->


</head>
<body>
    <section class="body">
        <div id="header"></div>
            <!-- end: header -->
        <div class="inner-wrapper" style="padding-top: 50px;">
            <!-- start: sidebar -->
            <aside id="sidebar-left" class="sidebar-left menuu">





                <div class="sidebar-header">
                    <div class="sidebar-title">
                        Índices
                    </div>
                    <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
                        <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
                    </div>
                </div>
                
                <div class="nano">
                    <div class="nano-content">
                        <nav id="menu" class="nav-main" role="navigation">
                            <ul class="nav nav-main">
                                <!-- <li id="0">
                                    <a href="home.php">
                                        <i class="fa fa-home" aria-hidden="true"></i>
                                        <span>Início</span>
                                    </a>
                                </li> -->
                                <li>
                                    <a href="./">
                                        <i class="fas fa-book" aria-hidden="true"></i>
                                        <span>Manual</span>
                                    </a>
                                </li>
                                <li id="0" class="nav-parent nav-active">
                                    <a button type="button" onclick="goBack()">
                                        <i class="fas fa-arrow-left" aria-hidden="true"></i>
                                        <span>Voltar</span>
                                    </a>
                                </li>
                                <li id="0" class="nav-parent nav-active">
                                    <a>
                                        <i class="fas fa-align-justify" aria-hidden="true"></i>
                                        <span>Capítulos</span>
                                    </a>
                                    <ul class="nav nav-children">
                                        <li>
                                            <a href="./introducao.php">
                                                1. Introdução
                                            </a>
                                        </li>
                                        <li>
                                            <a href="./instalacao.php">
                                                2. Instalação
                                            </a>
                                        </li>
                                        <li>
                                            <a href="./recursos.php">
                                                3. Módulos
                                            </a>
                                        </li>
                                        <li>
                                            <a href="./seguranca.php">
                                                4. Segurança
                                            </a>
                                        </li>
                                        <li>
                                            <a href="./atualizacao.php">
                                                5. Atualização
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li id="3" class="nav-parent nav-active">
                                    <a>
                                        <span>3. Módulos</span>
                                    </a>
                                    <ul class="nav nav-children">
                                        <li>
                                            <a href="#_recursos">
                                                3.0 Recursos
                                            </a>
                                        </li>

                                        <li class="sub1">
                                            <a href="rh.php">
                                                3.1. Recursos Humanos
                                            </a>
                                        </li>
                                        <li class="sub2">
                                            <a href="cadastro_funcionarios.php">
                                                3.1.1. Cadastro de Funcionários
                                            </a>
                                        </li>
                                        <li class="sub2">
                                            <a href="#_info_funcionario">
                                                3.1.2. Informações de Funcionários
                                            </a>
                                        </li>
                                        <li class="sub2">
                                            <a href="#_edicao_funcionario">
                                                3.1.3. Edição de dados de funcionários
                                            </a>
                                        </li>
                                        <li class="sub2">
                                            <a href="#_cadastro_interno">
                                                3.1.4. Cadastro de Internos
                                            </a>
                                        </li>
                                        <li class="sub2">
                                            <a href="#_info_interno">
                                                3.1.5. Informações de Internos
                                            </a>
                                        </li>
                                        <li class="sub1">
                                            <a href="#_material_patrimonio">
                                                3.2. Material e Patrimônio
                                            </a>
                                        </li>
                                        <li class="sub1">
                                            <a href="#_memorando">
                                                3.3. Memorando
                                            </a>
                                        </li>
                                        <li class="sub2">
                                            <a href="#_criacao_memorando">
                                                3.3.1. Criação do memorando
                                            </a>
                                        </li>
                                        <li class="sub2">
                                            <a href="#_envio_despacho">
                                                3.3.2. Envio de despacho
                                            </a>
                                        </li>
                                        <li class="sub2">
                                            <a href="#_caixa_de_entrada">
                                                3.3.3. Caixa de entrada
                                            </a>
                                        </li>
                                        <li class="sub2">
                                            <a href="#_opcoes_caixa_de_entrada">
                                                3.3.4. Opções da caixa de entrada
                                            </a>
                                        </li>
                                        <li class="sub2">
                                            <a href="#_memorandos_despachados">
                                                3.3.5. Memorandos despachados
                                            </a>
                                        </li>
                                        <li class="sub2">
                                            <a href="#_lista_despachos">
                                                3.3.6. Leitura de despachos
                                            </a>
                                        </li>
                                        <li class="sub2">
                                            <a href="#_imprimir">
                                                3.3.7. Impressão
                                            </a>
                                        </li>
                                        <li class="sub2">
                                            <a href="#_erros">
                                                3.3.8. Erros
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
                    
                <!-- Theme Base, Components and Settings -->
                <script src="../assets/javascripts/theme.js"></script>
                    
                <!-- Theme Custom -->
                <script src="../assets/javascripts/theme.custom.js"></script>
                
                <!-- Theme Initialization Files -->
                <script src="../assets/javascripts/theme.init.js"></script>








            </aside>
            <!-- end: sidebar -->
            <section role="main" class="content-body">
                <header class="page-header">
                    <h2>Capítulo 3: Módulos</h2>
                    <div class="right-wrapper pull-right">
                        <ol class="breadcrumbs">
                            <li><span>Capítulo 3: Módulos</span></li>
                        </ol>
                        <a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
                    </div>
                </header>
                <!--start: page-->

                <!-- estrutura básica:
                    <dir id="_">
                        <h3></h3><hr>
                        <p></p>
                    </dir>
                -->

                <section id="_recursos">
                    <h3>3. Módulos</h3><hr>
                    <p>O WeGIA oferece diversas ferramentas para gerenciamento de instituições assistenciais, e esse capítulo serve para explicá-los.</p>    
                        
                        <dir id="_info_funcionario">
                            <h3>3.1.2. Informações de Funcionários</h3><hr>
                            <p>Exibe as informações de cada funcionário e possibilita alteração de seus dados. Uma tabela mostrará o Nome, CPF e Cargo, e a coluna Ação oferece a possibilidade de editar os dados.</p>
                            <p>Para acessar as informações de um funcionário no sistema basta acessar <strong><i class="far fa-address-book"></i> Pessoas </strong><i class="fas fa-chevron-right"></i> <a href="<?= WWW?>/html/informacao_funcionario.php">Informações Funcionário</a></p>
                        </dir>
                        <dir id="_edicao_funcionario">
                            <h3>3.1.3. Edição de dados de funcionários</h3><hr>
                            <p>Ao acessar os dados de um funcionário é possível fazer a edição desses dados.</p>
                            <p>
                                Na aba <strong>"Visão Geral"</strong> é possível editar as informações pessoais do funcionário.
                                <p>
                                    Para fazer a edição de algum dado da página, basta verificar em qual seção ele se encontra e clicar no botão "Editar" da seção. Em seguida será possível alterar os dados, depois de alterados basta clicar no botão "Salvar"
                                    Existem algumas seções nessa aba, são elas: 
                                </p>
                                <br>
                                <p><strong>Informações Pessoais</strong></p> 
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/Uqv_jbZqFuA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </p>
                            <br>
                            <p><strong>Endereço</strong></p>
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/vrH0VtOzL9Y" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            <br>
                            <br>
                            <p><strong>Incluir Arquivos</strong></p>
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/eRpzbRlCoLE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            <br>
                            <br>
                            <p><strong>Documentacao</strong></p>
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/E-Wv7-uYgI0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            <br>
                            <br>
                            <p><strong>Alterar Foto</strong></p>
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/TjxcsZmk7FQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            <br>
                            <br>
                             <p><strong>Outras Informações</strong></p>
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/5fFax72v0O8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                <br>
                                <br>
                                <p><strong>Carga Horária</strong></p>
                           <iframe width="560" height="315" src="https://www.youtube.com/embed/TOJwD3fyz1c" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            <br>
                            <br>
                                <p><strong>Incluir Dependentes</strong></p>
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/-RALJuM6H5U" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>



                            <hr>
                            <p>Na aba <strong>"Remuneração"</strong> é possível adicionar e editar a remuneração.</p>
                            <p>
                                Para adicionar a remuneração, basta clicar no botão "Adicionar" no fim da página. Ao clicar nesse botão é aberta uma caixa para adicionar o benefício.
                                <p>
                                    Para adicionar um benefício é necessário selecionar o benefício e o seu status e preencher a data de início, data de fim e o valor do benefício. Caso o benefício desejado não se encontre na listagem basta clicar no símbolo <i class="fas fa-plus w3-xlarge" style="margin-top: 0.75vw"></i> ao seu lado e na nova caixa que será aberta escrever o nome do benefício e clicar em OK para salvá-lo.
                                </p>
                            </p>
                            <p>
                                Na seção de benefícios é possível visualizar a lista de benefícios do funcionário. Nessa lista é exibido o nome do benefício, o status, a data de início, a data de fim e valor. <br>
                            </p>
                            <p>
                                Para <strong>editar</strong> um benefício basta clicar no botão verde ao seu lado, ao clicar o usuário é redirecionado para uma página onde é possível editar os dados desejados. Para editá-los basta clicar no botão "Editar" e após editar clicar no botão "salvar". <br>
                                Para <strong>excluir</strong> um benefício basta clicar no botão vermelho ao lado dos dados do benefício, o benefício será excluído automaticamente.
                            </p>
                            </p>
                            <!--<img src="<?php echo WWW;?>img/beneficio.PNG" class="img-fluid">-->
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/yvGgd2MtduY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            <hr>
                            <p>Na aba <strong>"EPI"</strong> é possível adicionar e editar EPI's.</p>
                            <p>
                            Para adicionar um EPI basta clicar no botão "EPI" no fim da página. Ao clicar nesse botão é aberta uma caixa para adicionar o EPI.
                            Para adicionar um EPI é necessário selecionar o EPI e o seu status e preencher a data. Caso o EPI desejado não se encontre na listagem basta clicar no símbolo <i class="fas fa-plus w3-xlarge" style="margin-top: 0.75vw"></i> ao seu lado e na nova caixa que será aberta escrever o nome do EPI e clicar em OK para salvá-lo.
                            </p>
                            <p>
                                Na seção de EPI é possível visualizar a lista de EPI's do funcionário. Nessa lista é exibido o nome do epi, o status e a data. Para editar um EPI basta clicar no botão verde ao seu lado, ao clicar o usuário é redirecionado para uma página onde é possível ediar os dados desejados. Para editá-los basta clicar no botão "Editar" e após editar clicar no botão "Salvar".
                                Para excluir um EPI basta clicar no botão vermelho ao lado dos dados do EPI, o EPI será excluído automaticamente.
                            </p> 
                            <img src="<?php echo WWW;?>img/epi.PNG" class="img-fluid">
                            <hr>
                            <p>
                                Na aba <strong>"Carga horária"</strong> é possível visualizar as informações da carga horária do funcionário, como escala, dias trabalhados, dias de folga, etc.
                            </p>
                            <hr>
                            <p>
                                Na aba <strong>"Editar carga"</strong> é possível alterar ou cadastrar a carga horária do funcionário. Para alterar/cadastrar a carga horária basta selecionar a escala, o tipo, preencher os horários de entrada e saída e selecionar os dias folga e os dias trabalhados.
                            </p>

                        </dir>
                        <dir id="_cadastro_interno">
                            <h3>3.1.4. Cadastro de Internos</h3><hr>
                            <p>Cadastra uma pessoa como interno no sistema. O formulário apresentado exigirá as seguintes informações para realizar o cadastro:</p>
                            <br>
                            <h5>Informações Pessoais</h5>
                            <ul>
                                <p>1. Nome</p>
                                <p>2. Sobrenome</p>
                                <p>3. Sexo</p>
                                <p>4. Nome de Contato</p>
                                <p>5. 3 Telefones de Contato</p>
                                <p>6. Data de Nascimento</p>
                                <p>7. Nome dos pais</p>
                                <p>8. Tipo Sanguíneo</p>
                            </ul>
                            <h5>Documentação</h5>
                            <ul>
                                <p>1. Número do RG</p>
                                <p>2. Orgão Emissor</p>
                                <p>3. Data de Expedição</p>
                                <p>4. CPF</p>
                                <p>5. Benefícios</p>
                                <p>6. Fotos do RG e CPF</p>
                                <p>7. Observações</p>

                            </ul>
                            <br>
                            <p>Para cadastrar um interno no sistema basta acessar <strong><i class="far fa-address-book"></i> Pessoas </strong><i class="fas fa-chevron-right"></i> <a href="<?= WWW?>/html/cadastro_interno.php">Cadastrar Atendido</a></p>
                        </dir>
                        <dir id="_info_interno">
                            <h3>3.1.5. Informações de Internos</h3><hr>
                            <p>Exibe as informações de cada interno e possibilita alteração de seus dados. Uma tabela mostrará o Nome e CPF, e a coluna Ação oferece a possibilidade de editar os dados.</p>
                            <p>Para acessar as informações de um interno no sistema basta acessar <strong><i class="far fa-address-book"></i> Pessoas </strong><i class="fas fa-chevron-right"></i> <a href="<?= WWW?>/html/informacao_interno.php">Informações Atendido</a></p>
                        </dir>
                    </dir>
                    <dir id="_material_patrimonio">
                        <h3>3.2. Material e Patrimônio</h3><hr>
                        <p>O modulo Material e Patrimônio tem como objetivo ter controle absoluto dos produtos e <strong>almoxarifados</strong> existentes. Dentro dele, poderá ter acesso a <strong>relatórios</strong> completos não só sobre a <strong>entrada</strong> e <strong>saída</strong>, mas também do material presente em estoque.</p>
                      <dir>
                          <h3>3.2.1. Entrada e Saída </h3>

                          <hr>
                          
                        <dir>
                            <h3>Criação da Origem e Destino</h3>
                            <hr>
                            <p>Para criar uma origem ou destino, o funcionário responsável deve já estar na página de <strong><a href="/html/cadastro_entrada.php" style="text-decoration: none">ENTRADA</a> ou <a href="/html/cadastro_saida.php" style="text-descoration: none">SAÍDA</a></strong> e então no campo de <strong>Origem/Destino</strong> clicar no sinal de "+", localizado ao lado do campo de escrever. Logo em seguida, o funcionário será redirecionado para preencher os campos do cadastro da origem do produto. Feito isso, essa <strong>Origem/Destino</strong>, ficará disponivel para seleção e identificação na página de <strong>Entrada/Saída</strong>.
                            <br><br>
                            <img src="<?php echo WWW;?>img/origem.png" class="img-fluid">
                        </dir>
                        <dir>
                            <h3>Criação do Almoxarifado</h3>
                            <hr>
                            <p>Criar um Almoxarifado é ainda mais fácil. Para isso, basta clicar no modulo de <strong>Material e Patrimônio</strong>, em seguida <strong>Adicionar Almoxarifado</strong>. Feito isso, escolha o nome que quiser para ele e clique em enviar. Pronto! Seu almoxarifado foi adicionado e já pode ser consultado. O mesmo pode ser feito, clicando no sinal de "+" pela própria página <strong>Entrada/Saída</strong> no campo de Almoxarifado.
                        </dir>
                        <dir>
                            <h3>Criação Tipos</h3>
                            <hr>
                            <p>Nesse setor, é necessário que o funcionário informe o tipo de entrada ou saída. Como por exemplo, doações, projetos internos ou externos, parcerias. Como nos exemplos acima, basta clicar no sinal de " + " que irá ser redirecionado para criar o nome do tipo de entrada. Então, depois disso o "Tipo" criado estará disponível para seleção.</p>
                        </dir>
                        <dir>
                            <h3>Enviar</h3>
                            <hr>
                            <p>Por fim, selecionamos o produto que será dado entrada/saída, inserindo o nome/código de barras (É possível usar Leitor de Código de barras). Em seguida, selecionamos a quantidade que será designada a entrada/saída e então é preciso clicar em <strong>Incluir</strong>. Feito isso, poderá ser adicionado novos produtos nessa entrada/saída, ou então, caso seja encerrado, clicamos em <strong>enviar</strong>.    
                        </dir>
                      </dir>
                      <br>
                      <dir>
                           <h3>3.2.2. Estoque </h3>
                           <hr>
                           <dir>
                             <p>Aqui podemos visualizar todos os produtos que foram computados como entrada dentro do sistema e ainda não saíram, ou seja, estão presentes no <strong>estoque</strong>. Caso haja mais de um almoxarifado cadastrado no sistema, o funcionário poderá selecionar qual deseja consultar além da categoria. Feito isso, todos os produtos presentes irão aparecer numa lista, ou caso queira ver os que não possuem número no estoque, basta selecionar a caixinha <strong>"exibir produtos fora de estoque"</strong> e então deve aparecer produtos cadastrados que não possuem exemplares presentes no momento.</p>    
                             <img src="<?php echo WWW;?>img/estoque.png" class="img-fluid">
                           </dir>
                      </dir>
                      <dir>
                      <br>
                           <h3>3.3.3. Almoxarifados</h3>
                           <hr>                           
                           <p>Em almoxarifados podemos ter acesso aos almoxarifados criados/existentes e também aos funcionários responsáveis pelo setor. Além disso, poderá excluir o almoxarifado, caso seja necessário.</p>
                           
                      </dir>
                      <dir>
                            <br>
                            <h3>3.3.4. Produtos</h3>
                            <hr>
                            <p>Para que possamos dar entrada, saída ou até mesmo visualizar a quantidade de produto restante no estoque, precisamos antes cadastra-los. Para isso, no modulo de <strong>Material e Patrimonio</strong> selecione a opção <strong>Produtos</strong>. Funcionário poderá preencher todas as áreas designadas ao cadastro do produto como nome, categoria, unidade(Jeito que é medido - Litro, metro, pacote, Quilo), o código que ficará salvo para que funcione como identificação/atalho do produto e o valor. </p>
                             <img src="<?php echo WWW;?>img/produto.png" class="img-fluid">
                      </dir>
                      <dir>
                            <br>
                            <h3>3.3.5. Relatório </h3>
                            <hr>
                            <p>Existe três tipos de relatórios, um para listar a entrada que ficará responsável por detalhar todas as entradas por todos os funcionários responsáveis. Um para a saída, na qual, poderá ver todos os produtos que por algum motivo tiveram saída do estoque. E por fim, um para o estoque que permite poder ver todos os itens presentes e suas informações. </p>
                            <p><strong>1.</strong> Além disso, o sistema de relatório conta com alguns parâmetros, que por sí só vai permitir uma analise de relatório completa e objetiva. Nela, no caso de <strong>ENTRADA</strong> ou <strong>SAÍDA</strong>, pode ser escolhida a forma de origem/destino, o tipo de entrada/saída, o <strong>Responsável</strong> por tal feito, a data e também de qual almoxarifado.</p>
                            <img src="<?php echo WWW;?>img/entrada.png" class="img-fluid">
                            <br>
                            <p><strong>2.</strong> Já o sistema de relatório para estoque, é mais simples, precisando apenas selecionar o <strong>Almoxarifado</strong> que deseja verificar a situação.</p>
                            <img src="<?php echo WWW;?>img/relEstoque.png" class="img-fluid">
                      </dir>
                      <dir>
                            <br>
                            <h3>3.3.6. Informações Entrada</h3>
                            <hr>
                            <p>Nessa sessão, o funcionário poderá ver ainda mais detalhes sobre os produtos que foram dados como entrada. Entre eles o valor total, a data e também as horas. Além disso, também é possível visutalizar o responsável pela entrada.</p>
                            <img src="<?php echo WWW;?>img/infoEntrada.png" class="img-fluid">
                      </dir>
                      <dir>
                            <br>
                            <h3>3.3.7. Informações Saída</h3>
                            <hr>
                            <p>Assim como nas <strong>Informações de Entrada</strong>, aqui é possível ver todos os dados em relação a saída efetuada de um ou mais produtos</p>
                            <img src="<?php echo WWW;?>img/infoSaida.png" class="img-fluid">
                      </dir>         
                    </dir>
                    <dir id="_memorando">
                        <h3>3.3. Memorando</h3><hr>
                        <p>O módulo memorando é destinado à troca de mensagens institucionais entre funcionários da instituição. Essa troca é feita através da criação, por um funcionário, de um <strong>memorando</strong> e de um <strong>despacho</strong>, que serão enviados a outro funcionário. O funcionário que receber esse memorando e este despacho os enviará a um outro funcionário juntamente com outro despacho e assim sucessivamente até que o memorando volte a sua origem e possa ser arquivado.</p>
                        <dir id="_criacao_memorando">
                            <h3>3.3.1. Criação do memorando</h3><hr>
                            <p>Para criar um memorando o funcionário deverá, munido das permissões necessárias, acessar a <a href="<?php echo WWW;?>html/memorando/listar_memorandos_ativos.php">caixa de entrada do módulo memorando</a> e preencher o campo "Assunto", da seção "Criar memorando", com o assunto do memorando e acionar o botão "Criar memorando". Em seguida o funcionário será direcionado automaticamente à página de envio de despachos (leia <a href="#_envio_despacho">3.3.2. Envio de despachos</a>).</p>
                            <img src="<?php echo WWW;?>img/criar_memorando.PNG" class="img-fluid">
                        </dir>
                        <dir id="_envio_despacho">
                            <h3>3.3.2. Envio de despachos</h3><hr>
                            <p>Existem duas possibilidades para o envio de despachos: <i>enviar um despacho em um memorando que foi recebido</i> ou <i>enviar um despacho em um memorando que foi criado naquele momento</i>.</p>
                            <p>Para ambos os casos o procedimento é o mesmo:</p>
                                <p>1. Selecionar, no campo "destino", da seção "Despachar memorando", o nome do funcionário para quem será enviado o despacho.</p>
                                <img src="<?php echo WWW;?>img/destino.PNG" class="img-fluid">
                                <p>2. Selecionar arquivos para anexar ao despacho, clicando no botão "Escolher arquivos" e posteriormente selecionando os arquivos. Podem ser adicionados um ou mais arquivos. <strong>(Esse passo é OPCIONAL, o despacho pode ser enviado sem arquivos anexados)</strong></p>
                                <img src="<?php echo WWW;?>img/arquivo.PNG" class="img-fluid">
                                <p>3. Preencher o campo "Despacho" com as informações que devem ser enviadas no despacho. Na parte superior desse campo é possível alterar a formatação dele com alterações como: negrito, itálico, cor do texto, cor da marcação do texto, etc.</p>
                                <img src="<?php echo WWW;?>img/despacho.PNG" class="img-fluid">
                                <p>4. Acionar o botão "Enviar". Nesse momento o despacho e o memorando serão enviados para o funcionário selecionado e o memorando estará disponível na caixa de entrada desse funcionário. (leia <a href="#_caixa_de_entrada">3.3.3. Caixa de entrada</a>)</p>
                                <img src="<?php echo WWW;?>img/enviar.PNG" class="img-fluid">
                        </dir>
                        <dir id="_caixa_de_entrada">
                            <h3>3.3.3. Caixa de entrada</h3><hr>
                            <p>A <a href="<?php echo WWW;?>html/memorando/listar_memorandos_ativos.php">caixa de entrada do módulo memorando</a> é o espaço destinado ao recebimento de memorandos. Sempre que um despacho for enviado para você, o memorando desse despacho estará disponível na sua caixa de entrada. Nesse espaço é possível visualizar o título do memorando, a data e a hora da sua criação e as opções fornecidas (leia <a href="#_opcoes_caixa">3.3.4. Opções da caixa de entrada</a>). Para acessar um memorando basta clicar no seu título e você será direcionada.</p>
                            <p>Nessa página também é possível criar um novo memorando (leia <a href="#_criacao_memorando">3.3.1. Criação de memorando</a>)</p>
                            <img src="<?php echo WWW;?>img/caixa_de_entrada.PNG" class="img-fluid">
                        </dir>
                        <dir id="_opcoes_caixa_de_entrada">
                            <h3>3.3.4. Opções da caixa de entrada</h3><hr>
                            <p>Os memorandos na <a href="<?php echo WWW;?>html/memorando/listar_memorandos_ativos.php">caixa de entrada</a> possuem algumas opções de configuração, para usá-las basta clicar no seu ícone. As opções são:</p>
                                <p>1. Não lido <img src="<?php echo WWW;?>/img/nao-lido.png" width=25px height= 25px>, opção para marcar um memorando como não lido. <strong>Disponível apenas quando o memorando foi visualizado</strong>. Quando um memorando está marcado com essa opção sua cor fica <strong>azul</strong>.</p>
                                <p>2. Lido <img src="<?php echo WWW;?>/img/lido.png" width=25px height= 25px>, opção para marcar um memorando como lido. <strong>Disponível apenas quando o memorando não foi visualizado</strong>.</p>
                                <p>3. Importante <img src="<?php echo WWW;?>/img/importante.png" width=25px height= 25px>, opção para marcar um memorando como importante. Quando um memorando está marcado com essa opção sua cor fica <strong>vermelha</strong>.</p>
                                <p>4. Pendente <img src="<?php echo WWW;?>/img/pendente.png" width=25px height= 25px>, opção para marcar um memorando como pendente. Quando um memorando está marcado com essa opção sua cor fica <strong>amarela</strong>.</p>
                                <p>5. Arquivar memorando <img src="<?php echo WWW;?>/img/arquivar.png" width=25px height= 25px>, opção para marcar um memorando como arquivado. Quando um memorando está marcado com essa opção ele não fica disponível na caixa de entrada, apenas na lista de memorandos despachados. <strong>Disponível apenas quando o usuário foi o criador do memorando</strong>. Somente o criador de um memorando pode arquivá-lo.</p>
                                <p>Por padrão, ao receber um memorando ele é marcado com a opção "Não lido" e sua cor fica azul</p>
                                <p>Se um memorando estiver marcado como "Não lido" e for aberto ele é marcado com a opção "Lido". Se ele estiver marcado com qualquer outra opção e for aberto ele não perde sua opção permanece a mesma.</p>
                        </dir>
                        <dir id="_memorandos_despachados">
                            <h3>3.3.5. Memorandos despachados</h3><hr>
                            <p>A <a href="<?php echo WWW;?>html/memorando/listar_memorandos_antigos.php">lista de memorandos despachados</a> é um local para visualização dos memorandos que já foram enviados para você, inclusive os que já foram despachados para outras pessoas. Nesse espaço é possível visualizar o título do memorando, a sua origem (funcionário que o criou) e a data e a hora de criação. Para acessar um memorando despachado basta clicar no seu título e você será direcionado para a lista de despachos desse memorando.</p>
                            <p>Se o memorando estiver marcado com a opção <strong>[ARQUIVADO]</strong>, significa que ele foi arquivado pelo seu criador e por esse motivo ele não poderá ser enviado para outros funcionários.</p>
                            <img src="<?php echo WWW;?>img/memorandos_despachados.PNG" class="img-fluid">
                        </dir>
                        <dir id="_lista_despachos">
                            <h3>3.3.6 Leitura de despachos</h3><hr>
                            <p>Ao abrir um memorando o usuário será redirecionado para a lista de despachos desse memorando. Nessa lista é possível ver todos os despachos organizados do mais antigo para o mais recente. É possível ver o remetente do despacho, o destinatário, o texto do despacho e a data e hora do envio. Se houver arquivos anexados ao despacho, a linha <strong>Despacho</strong> estará presente seguida da lista de arquivos.</p>
                            <p>Ao acessar um memorando em que o último despacho foi enviado para você há após a lista de despachos um espaço para escrever um novo despacho nesse memorando e enviá-lo para outro funcionário (leia <a href="#_envio_despacho">3.3.2. Envio de despachos</a>). Caso o último destinatário desse memorando seja outro funcionário, não haverá, na lista de despachos, espaço para enviá-lo para outro funcionário</p>
                            <img src="<?php echo WWW;?>img/lista_despachos.PNG" class="img-fluid">
                            <h3>Acesso aos arquivos</h3>
                                    <p>Para acessar os arquivos anexos ao despacho basta clicar no nome do arquivo e seu download será feito automaticamente</p> 
                        </dir>
                        <dir id="_imprimir">
                            <h3>3.3.7. Impressão de despachos e memorandos</h3><hr>
                            <p>É possível realizar a impressão dos memorandos da caixa de entrada (leia <a href="#_caixa_de_entrada">3.3.3. Caixa de entrada</a>), dos despachos da lista de despachos (leia <a href="#_lista_despachos">3.3.6. Leitura de despachos</a>) e dos memorandos da lista de memorandos despachados (leia <a href="#_memorandos_despachados">3.3.5. Memorandos Despachados</a>) bastando para isso clicar no botão "Imprimir" disponível em cada uma dessas páginas.</p>
                        </dir>
                        <dir id="_erros">
                            <h3>3.3.8. Mensagens de erro</h3><hr>
                            <p>1. <strong>"Desculpe, você não tem acesso a essa página"</strong>: se ao acessar a lista de despachos de um memorando a mensagem <strong>"Desculpe, você não tem acesso a essa página"</strong> for exibida isso significa que você está tentando acessar a lista de despachos de um memorando que nunca foi enviado para você. Para ter acesso a essa página o memorando precisa ter sido enviado para você.</p>
                            <img src="<?php echo WWW;?>img/erro1.PNG" class="img-fluid">
                        </dir>
                    </dir>
                    <dir id="_modulo_socio">
                        <h3>3.4. Módulo Sócio</h3><hr>
                        <p>O módulo sócio é destinado à administração e ao controle de sócios cadastrados no sistema. Nesse módulo é possível fazer cadastro, importação e mudança de status de sócios, além de poder acompanhar informações sobre pagamentos e gráficos sobre a tipologia dos sócios (casuais, mensais, ativos, inativos, pessoas físicas e jurídicas).</p>
                        <p>Para ter acesso às informações do módulo <strong>é necessário que o funcionário logado esteja dotado das permissões adequadas</strong>, já que o módulo contém informações pessoais dos cadastrados.</p>
                        <dir id="_cadastro_socio">
                            <h3>3.4.1 Cadastro de sócios</h3><hr>
                            <p>Para o cadastro de um sócio, o funcionário responsável por esse módulo, deverá acessar a <a href="<?php echo WWW;?>html/socio/">lista de sócios</a> e clicar no botão "Adicionar sócio", presente logo abaixo da lista de sócios.</p>
                            <img src="<?php echo WWW;?>img/cadastro_socio.png" class="img-fluid">
                            <p>Ao clicar nesse botão, uma caixa de diálogo (modal) aparecerá na tela, nesta caixa estará presente um formulário onde deverão ser preenchidos os dados do sócio a ser cadastrado.</p>
                            <img src="<?php echo WWW;?>img/formulario_socio1.png" class="img-fluid">
                            <p>Na primeira parte do formulário deverão ser preenchidos dados pessoais do sócio (nome completo, tipo de pessoa, cpf/cnpj, e-mail, telefone, tipo de contribuinte, status do sócio e sua data de nascimento).</p>
                            <p>Após o preenchimento desses dados você poderá continuar com o preenchimento dos dados subsequentes referentes ao endereço do associado:</p>
                            
                        </dir>
                    </dir>
                    <div class="justify-content-between">
                        <a href="./instalacao.php" type="button" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            2. Instalação
                        </a>
                        <a href="./seguranca.php" type="button" class="btn btn-secondary" style="float: right;">
                            4. Segurança
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </section>

                <!-- estrutura básica:
                        <dir id="_">
                            <h3></h3><hr>
                            <p></p>
                        </dir>
                -->

                <!-- end: page -->
            </section>
        </div>
    </section>
</body>
<script>
    function setLoader(btn) {
        btn.firstElementChild.style.display = "none";
        if (btn.childElementCount == 1) {
            loader = document.createElement("DIV");
            loader.className = "loader";
            btn.appendChild(loader);
        }
        window.location.href = btn.firstElementChild.href;
    }
</script>
</html>