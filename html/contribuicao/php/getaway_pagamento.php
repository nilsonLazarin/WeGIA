<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salvar_dados'])) {
    require_once('conexao.php');

    $plataforma = $_POST['plataforma'] ?? '';
    $endpoint = $_POST['endpoint'] ?? '';
    $token = $_POST['token'] ?? '';

    $conexao = new Conexao();

    try {
        $sql_check = "SELECT plataforma, endpoint, token FROM contribuicao_gatewayPagamento 
                      WHERE plataforma = :plataforma 
                      AND endpoint = :endpoint 
                      AND token = :token";
    
        $stmt_check = $conexao->pdo->prepare($sql_check);
        $stmt_check->bindParam(':plataforma', $plataforma, PDO::PARAM_STR);
        $stmt_check->bindParam(':endpoint', $endpoint, PDO::PARAM_STR);
        $stmt_check->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt_check->execute();
    
        $existing_data = $stmt_check->fetch(PDO::FETCH_ASSOC);
    
        if ($existing_data) {
            if ($existing_data['plataforma'] === $plataforma &&
                $existing_data['endpoint'] === $endpoint &&
                $existing_data['token'] === $token) {
                echo 'conteudo_existente';
                exit; 
            }
        } else {
            $sql_insert = "INSERT INTO contribuicao_gatewayPagamento (plataforma, endpoint, token) 
                           VALUES (:plataforma, :endpoint, :token)";
           
            $stmt_insert = $conexao->pdo->prepare($sql_insert);
            $stmt_insert->bindParam(':plataforma', $plataforma, PDO::PARAM_STR);
            $stmt_insert->bindParam(':endpoint', $endpoint, PDO::PARAM_STR);
            $stmt_insert->bindParam(':token', $token, PDO::PARAM_STR);
           
            $stmt_insert->execute();
        
            if ($stmt_insert->rowCount() > 0) {
                echo 'sucesso';
            } else {
                echo 'erro_inserir';
            }
        }
    } catch (PDOException $e) {
        echo 'erro: ' . $e->getMessage();
    }
}

try {
    if (!isset($conexao)) {
        require_once('conexao.php');
        $conexao = new Conexao();
    }

    $sql_select = "SELECT plataforma, endpoint, token FROM contribuicao_gatewayPagamento";
    $stmt_select = $conexao->pdo->query($sql_select);
    $resultados = $stmt_select->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'erro ao buscar dados: ' . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir_dados'])) {
    require_once('conexao.php');

    $plataforma = $_POST['plataforma'] ?? '';
    $endpoint = $_POST['endpoint'] ?? '';
    $token = $_POST['token'] ?? '';

    $conexao = new Conexao();

    try {
        $sql_delete = "DELETE FROM contribuicao_gatewayPagamento 
                       WHERE plataforma = :plataforma 
                       AND endpoint = :endpoint 
                       AND token = :token";
        
        $stmt_delete = $conexao->pdo->prepare($sql_delete);
        $stmt_delete->bindParam(':plataforma', $plataforma, PDO::PARAM_STR);
        $stmt_delete->bindParam(':endpoint', $endpoint, PDO::PARAM_STR);
        $stmt_delete->bindParam(':token', $token, PDO::PARAM_STR);
        
        $stmt_delete->execute();

        if ($stmt_delete->rowCount() > 0) {
            echo 'sucesso';
        } else {
            echo 'erro_excluir';
        }
    } catch (PDOException $e) {
        echo 'erro: ' . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['alterar_dados'])) {
    require_once('conexao.php');

    $plataforma_antiga = $_POST['plataforma_antiga'] ?? '';
    $endpoint_antigo = $_POST['endpoint_antigo'] ?? '';
    $token_antigo = $_POST['token_antigo'] ?? '';

    $plataforma_nova = $_POST['plataforma_nova'] ?? '';
    $endpoint_novo = $_POST['endpoint_novo'] ?? '';
    $token_novo = $_POST['token_novo'] ?? '';

    $conexao = new Conexao();

    try {
        $sql_alterar = "UPDATE contribuicao_gatewayPagamento
                        SET plataforma = :plataforma_nova,
                            endpoint = :endpoint_novo,
                            token = :token_novo
                        WHERE plataforma = :plataforma_antiga
                        AND endpoint = :endpoint_antigo
                        AND token = :token_antigo";

        $stmt_alterar = $conexao->pdo->prepare($sql_alterar);
        $stmt_alterar->bindParam(':plataforma_antiga', $plataforma_antiga, PDO::PARAM_STR);
        $stmt_alterar->bindParam(':endpoint_antigo', $endpoint_antigo, PDO::PARAM_STR);
        $stmt_alterar->bindParam(':token_antigo', $token_antigo, PDO::PARAM_STR);
        $stmt_alterar->bindParam(':plataforma_nova', $plataforma_nova, PDO::PARAM_STR);
        $stmt_alterar->bindParam(':endpoint_novo', $endpoint_novo, PDO::PARAM_STR);
        $stmt_alterar->bindParam(':token_novo', $token_novo, PDO::PARAM_STR);

        $stmt_alterar->execute();

        if ($stmt_alterar->rowCount() > 0) {
            echo 'sucesso';
            header('Refresh: 0.1; URL=getaway_pagamento.php');
            exit;
        } else {
            echo 'erro_alterar';
        }
    } catch (PDOException $e) {
        echo "Erro ao executar a consulta SQL: " . $e->getMessage();
    }
}
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
    <link rel="stylesheet" type="text/css" href="../outros/css/config.css">
    <script src="../../../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../../../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
    <script src="../../../assets/vendor/bootstrap/js/bootstrap.js"></script>
    <script src="../../../assets/vendor/nanoscroller/nanoscroller.js"></script>
    <script src="../../../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="../../../assets/vendor/magnific-popup/magnific-popup.js"></script>
    <script src="../../../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
    <script src="../../../assets/vendor/jquery-autosize/jquery.autosize.js"></script>
    <script src="../../../assets/javascripts/theme.js"></script>
    <script src="../../../assets/javascripts/theme.custom.js"></script>  
    <script src="../../../assets/javascripts/theme.init.js"></script>
    <script type="text/javascript" src="../js/transicoes.js"></script>

    <style>
    .getaway-form {
        display: flex;
        flex-direction: column;
        max-width: 100vw;
    }

    .input-form {
        width: 100%;
        padding: 3px;
        margin-bottom: 10px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    .btn-novo {
        margin-top: 9px;
        max-width: 5vw;
        padding: 7px;
        background-color: #0088cc;
        color: white;
        border: none;
        border-radius: 7px;
        cursor: pointer;
    }

    .btn-salvar {
        display: none;
        margin-top: 9px;
        max-width: 5vw;
        padding: 7px;
        background-color: #0088cc;
        color: white;
        border: none;
        border-radius: 7px;
        cursor: pointer;
    }

    .btn-editar{
        padding: 5px;
        background-color: #0088cc;
        color: white;
        border: none;
        border-radius: 7px;
        cursor: pointer;
    }

    .btn-atualizar{
        padding: 5px;
        max-width: 5vw;
        background-color: #0088cc;
        color: white;
        border: none;
        border-radius: 7px;
        cursor: pointer
    }
    .btn-novo:hover, .btn-salvar:hover, .btn-editar:hover, .btn-atualizar:hover {
        transition: 0.4s all ease-in;
        background-color: #067cb7;
    }

    .resultado-teste {
        margin-top: 80px;
        background-color: gainsboro;
        display: flex;
        flex-direction: column;
        max-width: 60vw;
    }

    .mensagem {
        display: none;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        width: 100%;
        text-align: center;
    }

    .mensagem.success {
        background-color: #4CAF50;
        color: white;
    }

    .mensagem-erro2 {
        background-color: #f44336;
        color: white;
    }

     .resultado-teste {
        margin-top: 80px;
        background-color: #f2f2f2;
        max-width: 100%;
        overflow-x: auto;
    }

    .resultado-teste table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .resultado-teste th,
    .resultado-teste td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .resultado-teste th {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    .resultado-teste .td-token {
        width: 30%;
    }

    .resultado-teste .btn-editar,
    .resultado-teste .btn-excluir {
        padding: 8px 12px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        font-size: 14px;
    }

    .resultado-teste .btn-editar:hover,
    .resultado-teste .btn-excluir:hover {
        background-color: #0056b3;
    }

    .resultado-teste .td-acao {
        text-align: center;
        vertical-align: middle;
    }
    
    .table-checkbox {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
    }
    </style>
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
            <div class="getaway-box" id="getaway-box">
            <form id="form-salvar" class="getaway-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="hidden" name="alterar_dados">
                <div class="mensagem success" id="mensagem-sucesso"></div>
                <div class="mensagem-erro2" id="mensagem-erro2"></div>

                <label for="plataforma">Plataforma</label>
                <input type="text" class="input-form" name="plataforma_nova" id="plataforma" readonly required>

                <label for="endpoint">Endpoint</label>
                <input type="text" class="input-form" name="endpoint_novo" id="endpoint" readonly required>

                <label for="token">Token</label>
                <input type="text" class="input-form" name="token_novo" id="token" readonly required>

                <!-- Campos ocultos para os valores antigos -->
                <input type="hidden" name="plataforma_antiga" id="plataforma_antiga">
                <input type="hidden" name="endpoint_antigo" id="endpoint_antigo">
                <input type="hidden" name="token_antigo" id="token_antigo">

                <button type="button" class="btn-novo" id="btn-novo" onclick="novoDados()">Novo</button>
                <button type="submit" class="btn-salvar" id="btn-salvar" style="display: none;" disabled>Salvar</button>
                <button type="submit" class="btn-atualizar" id="btn-atualizar" style="display: none;" >Atualizar</button>

                <?php
                foreach ($resultados as $resultado) {
                    echo "<input type='hidden' name='plataformas[]' value='" . htmlspecialchars($resultado['plataforma']) . "'>";
                    echo "<input type='hidden' name='endpoints[]' value='" . htmlspecialchars($resultado['endpoint']) . "'>";
                    echo "<input type='hidden' name='tokens[]' value='" . htmlspecialchars($resultado['token']) . "'>";
                }
                ?>
            </form>
                <div class="resultado-teste">
                <table class="table table-bordered table-striped mb-none" id="datatable-editable">
                <thead>
                    <tr>
                        <th>Plataforma</th>
                        <th>Endpoint</th>
                        <th>Token</th>
                        <th>Ativo</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultados as $resultado) : ?>
                        <tr>
                            <td><?= $resultado['plataforma']; ?></td>
                            <td><?= $resultado['endpoint']; ?></td>
                            <td class="td-token"><?= $resultado['token']; ?></td>
                            <td class="table-checkbox">
                                <input type="checkbox" class="selecionar-checkbox" data-plataforma="<?= htmlspecialchars($resultado['plataforma']); ?>"
                                    data-endpoint="<?= htmlspecialchars($resultado['endpoint']); ?>"
                                    data-token="<?= htmlspecialchars($resultado['token']); ?>"
                                    data-selecionado="true">
                            </td>
                            <td class="td-acao">
                                <button type="button" class="btn-editar" data-plataforma="<?= htmlspecialchars($resultado['plataforma']); ?>"
                                        data-endpoint="<?= htmlspecialchars($resultado['endpoint']); ?>"
                                        data-token="<?= htmlspecialchars($resultado['token']); ?>">Editar</button>
                                <button type="button" class="btn-excluir" data-plataforma="<?= htmlspecialchars($resultado['plataforma']); ?>"
                                        data-endpoint="<?= htmlspecialchars($resultado['endpoint']); ?>"
                                        data-token="<?= htmlspecialchars($resultado['token']); ?>">Excluir</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
                </div>
            </div>
        </section>
    </div>
</section>
<script>
$(document).ready(function() {   
    atualiza();
});

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('btn-novo').addEventListener('click', function() {
        var inputForms = document.querySelectorAll('.input-form');
        inputForms.forEach(function(input) {
            input.removeAttribute('readonly');
            input.value = '';
            input.classList.remove('input-error');
        });
        
        document.getElementById('btn-salvar').style.display = 'block';
        this.style.display = 'none';
    });

    document.getElementById('btn-salvar').addEventListener('click', function() {
        var plataforma = document.getElementById('plataforma').value;
        var endpoint = document.getElementById('endpoint').value;
        var token = document.getElementById('token').value;

        if (!plataforma || !endpoint || !token) {
            alert('Por favor, preencha todos os campos.');
            document.getElementById('plataforma').classList.add('input-error');
            document.getElementById('endpoint').classList.add('input-error');
            document.getElementById('token').classList.add('input-error');
            return;
        }

        var xhr = new XMLHttpRequest();
        var url = ''; 

        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = xhr.responseText;
                    if (response.includes('sucesso')) {
                        alert("Dados inseridos com sucesso!");
                        setTimeout(function(){
                                window.location.reload();
                            }, 100);
                        document.querySelectorAll('.input-form').forEach(function(input) {
                            input.value = '';
                        });
                    } else if (response.includes('conteudo_existente')) {
                        alert("Dados já inseridos anteriormente.");
                        setTimeout(function(){
                                window.location.reload();
                            }, 100);
                    } else {
                        alert("Erro ao inserir dados!");
                        setTimeout(function(){
                                window.location.reload();
                            }, 100);
                    }
                }
                document.getElementById('btn-novo').style.display = 'block';
                document.getElementById('btn-salvar').style.display = 'none';
                var inputs = document.getElementsByClassName('input-form');
                for (var i = 0; i < inputs.length; i++) {
                    inputs[i].setAttribute('readonly', 'true');
                }
            }
        };


function fadeInAndOut(elementId, type) {
    var element = document.getElementById(elementId);
    element.style.display = 'block';
    if (type === 'success') {
        element.classList.add('success');
    } else if (type === 'error') {
        element.classList.add('error');
    }

    setTimeout(function() {
        element.style.display = 'none';
        element.classList.remove('success', 'error');
    }, 7000); 
}

        var params = 'salvar_dados=true&plataforma=' + encodeURIComponent(plataforma) + '&endpoint=' + encodeURIComponent(endpoint) + '&token=' + encodeURIComponent(token);
        xhr.send(params);
    });
});

function novoDados() {
    document.getElementById("plataforma").readOnly = false;
    document.getElementById("endpoint").readOnly = false;
    document.getElementById("token").readOnly = false;
    
    document.getElementById("btn-novo").style.display = "none";
    document.getElementById("btn-salvar").style.display = "block";
    document.getElementById("btn-salvar").disabled = false;
}

document.getElementById("form-salvar").addEventListener("submit", function(event) {
    event.preventDefault();

    var plataforma = document.getElementById('plataforma').value;
    var endpoint = document.getElementById('endpoint').value;
    var token = document.getElementById('token').value;

    var plataformas = document.getElementsByName('plataformas[]');
    var endpoints = document.getElementsByName('endpoints[]');
    var tokens = document.getElementsByName('tokens[]');

    var dadosDuplicados = false;

    for (var i = 0; i < plataformas.length; i++) {
        if (plataformas[i].value === plataforma && endpoints[i].value === endpoint && tokens[i].value === token) {
            dadosDuplicados = true;
            break;
        }
    }

    if (dadosDuplicados) {
        document.getElementById("mensagem-erro").style.display = "block";
        document.getElementById("mensagem-sucesso").style.display = "none";
    } else {
        this.submit();
    }
});

$(document).ready(function() {
    $('.selecionar-checkbox').change(function() {
        if ($(this).is(':checked')) {
            var plataforma = $(this).data('plataforma');
            var endpoint = $(this).data('endpoint');
            var token = $(this).data('token');
            
            $('.selecionar-checkbox').not(this).prop('checked', false);
            
            document.getElementById('plataforma').value = plataforma;
            document.getElementById('endpoint').value = endpoint;
            document.getElementById('token').value = token;
            
            document.getElementById('btn-novo').style.display = 'none';
            document.getElementById('btn-salvar').style.display = 'none';
        } else {
            document.getElementById('plataforma').value = '';
            document.getElementById('endpoint').value = '';
            document.getElementById('token').value = '';
            
            document.getElementById('btn-novo').style.display = 'block';
            document.getElementById('btn-salvar').style.display = 'none';
            
            document.getElementById('plataforma').readOnly = true;
            document.getElementById('endpoint').readOnly = true;
            document.getElementById('token').readOnly = true;
        }
    });
});

$(document).ready(function() {
    $('.selecionar-checkbox:first').prop('checked', true).change();

        $('.selecionar-checkbox').change(function() {
            if ($(this).is(':checked')) {
                var plataforma = $(this).data('plataforma');
                var endpoint = $(this).data('endpoint');
                var token = $(this).data('token');
                
                document.getElementById('plataforma').value = plataforma;
                document.getElementById('endpoint').value = endpoint;
                document.getElementById('token').value = token;
                
                document.getElementById('btn-novo').style.display = 'none';
                document.getElementById('btn-salvar').style.display = 'none';
            } else {
                document.getElementById('plataforma').value = '';
                document.getElementById('endpoint').value = '';
                document.getElementById('token').value = '';
                
                document.getElementById('btn-novo').style.display = 'block';
                document.getElementById('btn-salvar').style.display = 'none';
                
                document.getElementById('plataforma').readOnly = true;
                document.getElementById('endpoint').readOnly = true;
                document.getElementById('token').readOnly = true;
            }
        });
});

$(document).ready(function() {
    $('.btn-excluir').click(function() {
        var plataforma = $(this).data('plataforma');
        var endpoint = $(this).data('endpoint');
        var token = $(this).data('token');

        if (confirm('Tem certeza que deseja excluir este registro?')) {
            var xhr = new XMLHttpRequest();
            var url = '';

            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var response = xhr.responseText;
                        if (response.includes('sucesso')) {
                            alert('Registro excluído com sucesso.');
                            location.reload(); 
                        } else {
                            alert('Erro ao excluir registro.');
                        }
                    } else {
                        alert('Erro ao excluir registro.');
                    }
                }
            };

            var params = 'excluir_dados=true&plataforma=' + encodeURIComponent(plataforma) + '&endpoint=' + encodeURIComponent(endpoint) + '&token=' + encodeURIComponent(token);
            xhr.send(params);
        }
    });
});

$(document).ready(function() {
    $('.btn-editar').click(function() {
        var plataforma = $(this).data('plataforma');
        var endpoint = $(this).data('endpoint');
        var token = $(this).data('token');
        var id_registro = $(this).data('id');

        $('#plataforma').val(plataforma).prop('readonly', false);
        $('#endpoint').val(endpoint).prop('readonly', false);
        $('#token').val(token).prop('readonly', false);

        $('#plataforma_antiga').val(plataforma);
        $('#endpoint_antigo').val(endpoint);
        $('#token_antigo').val(token);

        $('#id_registro').val(id_registro);

        $('#btn-novo').hide();
        $('#btn-salvar').hide();
        $('#btn-atualizar').show().prop('disabled', false);
    });
});

</script>
</body>
</html>