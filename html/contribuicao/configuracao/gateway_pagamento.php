<?php
//adicionar verificação de autenticação
require_once('../php/conexao.php');
$banco = new Conexao;
//require_once('dadosConfig.php');
ini_set('display_errors', 0);
ini_set('display_startup_erros', 0);

session_start();
if(!isset($_SESSION['usuario'])){
    header ("Location: ../../../index.php");
}

$config_path = "config.php";
if(file_exists($config_path)){
    require_once($config_path);
} else {
    while(true) {
        $config_path = "../../../" . $config_path;
        if(file_exists($config_path)) break;
    }
    require_once($config_path);
}

$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$situacao = $mysqli->query("SELECT * FROM situacao");
$cargo = $mysqli->query("SELECT * FROM cargo");
//$beneficios = $mysqli->query("SELECT * FROM beneficios");
//$descricao_epi = $mysqli->query("SELECT * FROM epi");

$conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$id_pessoa = $_SESSION['id_pessoa'];
$resultado = mysqli_query($conexao, "SELECT * FROM funcionario WHERE id_pessoa=$id_pessoa");
if(!is_null($resultado)){
    $id_cargo = mysqli_fetch_array($resultado);
    if(!is_null($id_cargo)){
        $id_cargo = $id_cargo['id_cargo'];
    }
    $resultado = mysqli_query($conexao, "SELECT * FROM permissao WHERE id_cargo=$id_cargo and id_recurso=9");
    if(!is_bool($resultado) and mysqli_num_rows($resultado)){
        $permissao = mysqli_fetch_array($resultado);
        if($permissao['id_acao'] < 3){
            $msg = "Você não tem as permissões necessárias para essa página.";
            header("Location: ../../home.php?msg_c=$msg");
        }
        $permissao = $permissao['id_acao'];
    } else {
        $permissao = 1;
        $msg = "Você não tem as permissões necessárias para essa página.";
        header("Location: ../../home.php?msg_c=$msg");
    }	
} else {
    $permissao = 1;
    $msg = "Você não tem as permissões necessárias para essa página.";
    header("Location: ../../home.php?msg_c=$msg");
}

//Captura mensagem passada na URL como parâmetro
if(isset($_GET['msg'])){
    $msg = trim($_GET['msg']);
}

require_once ('./src/controller/GatewayPagamentoController.php');

$gatewayPagamentoController = new GatewayPagamentoController();
$gateways = $gatewayPagamentoController->buscaTodos();

?>

<!DOCTYPE html>
<html class="fixed">

<head>
    <meta charset="UTF-8">
    <title>Gateway de Pagamento</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.1.1/css/all.css">
    <link rel="stylesheet" href="../../../assets/vendor/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../../../assets/vendor/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="../../../assets/vendor/magnific-popup/magnific-popup.css" />
    <link rel="stylesheet" href="../../../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
    <link rel="stylesheet" href="../../../assets/stylesheets/theme.css" />
    <link rel="stylesheet" href="../../../assets/stylesheets/skins/default.css" />
    <link rel="stylesheet" href="../../../assets/stylesheets/theme-custom.css">
    <link rel="stylesheet" href="../../../css/personalizacao-theme.css" />
    <link rel="stylesheet" href="./assets/css/gateway-pagamento.css">
    <script src="../../../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../../../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
    <script src="../../../assets/vendor/bootstrap/js/bootstrap.js"></script>
    <script src="../../../assets/vendor/nanoscroller/nanoscroller.js"></script>
    <script src="../../../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="../../../assets/vendor/magnific-popup/magnific-popup.js"></script>
    <script src="../../../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
    <script src="../../../assets/vendor/jquery-autosize/jquery.autosize.js"></script>
    <script src="../../../assets/vendor/modernizr/modernizr.js"></script>
    <script src="../../../assets/javascripts/theme.js"></script>
    <script src="../../../assets/javascripts/theme.custom.js"></script>
    <script src="../../../assets/javascripts/theme.init.js"></script>
    
</head>

<body>
    <section class="body">
        <div id="header"></div>
        <div class="inner-wrapper">
            <aside id="sidebar-left" class="sidebar-left menuu"></aside>
            <section role="main" class="content-body">
                <header class="page-header">
                    <h2>Gateway de Pagamento</h2>
                    <div class="right-wrapper pull-right">
                        <ol class="breadcrumbs">
                            <li>
                                <a href="../../home.php">
                                    <i class="fa fa-home"></i>
                                </a>
                            </li>
                            <li><span>Gateway de Pagamento</span></li>
                        </ol>
                        <a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
                    </div>
                </header>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">Cadastro de um novo Gateway</h3>
                                <div class="panel-actions">
                                    <a href="#" class="fa fa-caret-down"></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div id="mensagem">
                                    <?php if(isset($msg) && $msg == 'sucesso'):?>
                                        <div class="alert alert-success text-center alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            Gateway cadastrado com sucesso!
                                        </div>
                                    <?php elseif(isset($msg) && $msg == 'falha'):?>
                                        <div class="alert alert-danger text-center alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            Falha no cadastro do gateway.
                                        </div>
                                    <?php endif;?>
                                </div>
            
                                <form method="POST" action="./src/controller/control.php">
                                   
                                    <div class="form-group">
                                        <div class="col-md-10 col-md-offset-1">
                                            Os campos com <span class="text-danger">*</span> devem ser preenchidos antes de prosseguir.
                                        </div>
                                    </div>
                                    <input type="hidden" name="nomeClasse" value="GatewayPagamentoController">
                                    <input type="hidden" name="metodo" value="cadastrar">
                                    <div class="form-group">
                                        <div class="col-md-10 col-md-offset-1">
                                            <label for="plataforma-nome">Nome da Plataforma <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="plataforma-nome" name="nome" placeholder="Insira aqui o nome da plataforma de gateway ..." required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-10 col-md-offset-1">
                                            <label for="plataforma-endpoint">Endpoint <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="plataforma-endpoint" name="endpoint" placeholder="Insira aqui o endpoint da plataforma de gateway ..." required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-10 col-md-offset-1">
                                            <label for="plataforma-chave">Token API <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="plataforma-chave" name="token" placeholder="Insira aqui o token da API da plataforma de gateway ..." required>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">Gateways do Sistema</h3>
                                <div class="panel-actions">
                                    <a href="#" class="fa fa-caret-down"></a>
                                </div>
                            </div>
                            <div class="panel-body">

                                <?php if(!isset($gateways) || empty($gateways)):?>
                                    <div class="alert alert-warning text-center alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            Não foi possível encontrar nenhum gateway cadastrado no sistema.
                                    </div>
                                <?php else:?>
                                    <table class="table table-hover text-center">
                                        <thead>
                                            <th class="text-center">Plataforma</th>
                                            <th class="text-center">Endpoint</th>
                                            <th class="text-center">Token API</th>
                                            <th class="text-center">Ativo</th>
                                            <th class="text-center">Ação</th>
                                        </thead>
                                        <tbody>
                                            <!--Carrega tabela dinamicamente-->
                                            <?php foreach($gateways as $gateway):?>
                                                <tr>
                                                    <td class="vertical-center"><?=$gateway['plataforma']?></td>
                                                    <td class="vertical-center"><?=$gateway['endPoint']?></td>
                                                    <td class="vertical-center"><?=$gateway['token']?></td>
                                                    <td class="vertical-center">
                                                        <div class="toggle-switch">
                                                            <?php if(isset($gateway['status']) && $gateway['status'] === 1):?>
                                                                <input type="checkbox" id="toggle<?=$gateway['id']?>" class="toggle-input" checked>
                                                            <?php else:?>
                                                                <input type="checkbox" id="toggle<?=$gateway['id']?>" class="toggle-input">
                                                            <?php endif;?>
                                                            <label for="toggle<?=$gateway['id']?>" class="toggle-label" title="Alterar estado"></label>
                                                        </div>
                                                    </td>
                                                    <td class="vertical-center">
                                                        <button type="button" class="btn btn-default" title="Editar" data-id="<?=$gateway['id']?>"><i class="fa fa-edit"></i></button>
                                                        <button type="button" class="btn btn-default" title="Excluir" data-id="<?=$gateway['id']?>"><i class="fa fa-remove text-danger"></i></button>
                                                    </td>
                                                </tr>
                                            <?php endforeach;?>
                                        </tbody>
                                    </table>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
        </div>
    </section>
    <script>
        $(function() {
            $("#header").load("../../header.php");
            $(".menuu").load("../../menu.php");
        });
    </script>
    <div align="right">
	<iframe src="https://www.wegia.org/software/footer/saude.html" width="200" height="60" style="border:none;"></iframe>
	</div>
</body>

</html>