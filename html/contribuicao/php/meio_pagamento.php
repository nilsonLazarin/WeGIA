<?php
require_once('conexao.php');

//Listar os itens da tabela e o nome da plataforma
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['listar_dados']) && isset($_POST['listar_plataforma'])){
    require_once('conexao.php');
    $conexao = new Conexao();

    try {
        $sql_list = "SELECT meio, id_plataforma FROM contribuicao_meioPagamento";
        $stmt_list = $conexao->pdo->query($sql_list);
        $dados = $stmt_list->fetchAll(PDO::FETCH_ASSOC);

        $sql_select = "SELECT plataforma FROM contribuicao_gatewayPagamento";
        $stmt_select = $conexao->pdo->query($sql_select);
        $plataformas = $stmt_select->fetchAll(PDO::FETCH_ASSOC);

        $retorno = array(
            'dados' => $dados,
            'plataformas' => $plataformas
        );

        header('Content-Type: application/json');
        echo json_encode($retorno);
        exit;
    } catch (PDOException $e) {
        echo json_encode(['erro' => 'Erro ao buscar dados: ' . $e->getMessage()]);
        exit;
    }
}

// Salvar dados no banco de dados
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salvar_dados'])) {
    $plataforma = $_POST['plataforma'] ?? '';
    $meio = $_POST['meio'] ?? '';

    if (empty($plataforma) || empty($meio)) {
        echo 'Campos não podem estar vazios.';
        exit;
    }

    $conexao = new Conexao();

    try {
        $sql_get_id = "SELECT id FROM contribuicao_gatewayPagamento WHERE plataforma = :plataforma";
        $stmt_get_id = $conexao->pdo->prepare($sql_get_id);
        $stmt_get_id->bindParam(':plataforma', $plataforma, PDO::PARAM_STR);
        $stmt_get_id->execute();
        $result = $stmt_get_id->fetch(PDO::FETCH_ASSOC);
        
        if (!$result) {
            echo 'Plataforma selecionada inválida.';
            exit;
        }
        
        $id_plataforma = $result['id'];        

        $sql_check = "SELECT id_plataforma, meio FROM contribuicao_meioPagamento 
                      WHERE id_plataforma = :id_plataforma 
                      AND meio = :meio";

        $stmt_check = $conexao->pdo->prepare($sql_check);
        $stmt_check->bindParam(':id_plataforma', $id_plataforma, PDO::PARAM_INT);
        $stmt_check->bindParam(':meio', $meio, PDO::PARAM_STR);
        $stmt_check->execute();

        $existing_data = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if ($existing_data) {
            echo 'conteudo_existente';
            exit;
        } else {
            $sql_insert = "INSERT INTO contribuicao_meioPagamento (id_plataforma, meio) 
            VALUES (:id_plataforma, :meio)";

            $stmt_insert = $conexao->pdo->prepare($sql_insert);
            $stmt_insert->bindParam(':id_plataforma', $id_plataforma, PDO::PARAM_INT);
            $stmt_insert->bindParam(':meio', $meio, PDO::PARAM_STR);

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

// Lógica para excluir
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir_dados'])) {
    require_once('conexao.php');

    $meioExcluir = $_POST['meio'];
    $plataformaExcluir = intval($_POST['plataforma']);
    echo ($meioExcluir). "<br>";
    echo ($plataformaExcluir). "<br>";

    $conexao = new Conexao();

    try {
        $sql_delete = "DELETE FROM contribuicao_meioPagamento 
                       WHERE meio = :meio
                       AND id_plataforma = :id_plataforma";

        
        $stmt_delete = $conexao->pdo->prepare($sql_delete);
        $stmt_delete->bindParam(':meio', $meioExcluir, PDO::PARAM_STR);
        $stmt_delete->bindParam(':id_plataforma', $plataformaExcluir, PDO::PARAM_STR);
        
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

// Lógica para editar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['alterar_dados'])) {
    require_once('conexao.php');

    echo "<pre>";
    print_r($_POST); 
    echo "</pre>";
    echo "<br>";
    $meio_antigo = $_POST['meio'] ?? "";
    $plataforma_antiga = $_POST['plataforma'] ?? "";
    $meio_novo = $_POST['meio_novo'] ?? '';
    $plataforma_nova_nome = $_POST['plataforma_nova'] ?? '';

    if (empty($meio_antigo) || empty($plataforma_antiga) || empty($meio_novo) || empty($plataforma_nova_nome)) {
        echo 'Campos não podem estar vazios.';
        exit;
    }

    $conexao = new Conexao();

    try {
        $stmt_verifica_plataforma = $conexao->pdo->prepare("SELECT id FROM contribuicao_gatewayPagamento WHERE plataforma = ?");
        $stmt_verifica_plataforma->execute([$plataforma_nova_nome]);
        $plataforma_nova_id = $stmt_verifica_plataforma->fetchColumn();

        if (!$plataforma_nova_id) {
            echo "Erro: A plataforma especificada não existe na tabela contribuicao_gatewayPagamento.";
            exit;
        }

        $sql_alterar = "UPDATE contribuicao_meioPagamento
                        SET meio = :meio_novo,
                            id_plataforma = :plataforma_nova_id
                        WHERE meio = :meio_antigo
                        AND id_plataforma = :plataforma_antiga";

        $stmt_alterar = $conexao->pdo->prepare($sql_alterar);
        $stmt_alterar->bindParam(':meio_antigo', $meio_antigo, PDO::PARAM_STR);
        $stmt_alterar->bindParam(':plataforma_antiga', $plataforma_antiga, PDO::PARAM_INT);
        $stmt_alterar->bindParam(':meio_novo', $meio_novo, PDO::PARAM_STR);
        $stmt_alterar->bindParam(':plataforma_nova_id', $plataforma_nova_id, PDO::PARAM_INT);

        $stmt_alterar->execute();

        if ($stmt_alterar->rowCount() > 0) {
            echo 'sucesso';
        } else {
            echo 'erro_alterar';
        }

        echo "<br>". "Plataforma Nova ID: " . $plataforma_nova_id . "<br>"; 

    } catch (PDOException $e) {
        echo "Erro ao executar a consulta SQL: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html class="fixed">
<head>
    <meta charset="UTF-8">
    <title>Meio de pagamento</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../../assets/vendor/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../../../assets/vendor/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.1.1/css/all.css">
    <link rel="stylesheet" href="../../../assets/vendor/magnific-popup/magnific-popup.css" />
    <link rel="stylesheet" href="../../../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
    <link rel="stylesheet" href="../../../assets/stylesheets/theme.css" />
    <link rel="stylesheet" href="../../../assets/stylesheets/skins/default.css" />
    <link rel="stylesheet" href="../../../assets/stylesheets/theme-custom.css">
    <script src="../../../assets/vendor/modernizr/modernizr.js"></script>
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
    .meio-form {
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
    </style>

</head>
<body>
    <section class="body">
        <div id="header"></div>
        <div class="inner-wrapper">
            <aside id="sidebar-left" class="sidebar-left menuu"></aside>
            <section role="main" class="content-body">
                <header class="page-header">
                    <h2>Meio de pagamento</h2>
                    <div class="right-wrapper pull-right">
                        <ol class="breadcrumbs">
                            <li>
                                <a href="../../home.php">
                                    <i class="fa fa-home"></i>
                                </a>
                            </li>
                            <li><span>Meio de pagamento</span></li>
                        </ol>
                        <a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
                    </div>
                </header> 
                <div class="meio-box" id="meio-box">
                    <form action="#" class="meio-form" id="meio-form">
                    <div class="mensagem success" id="mensagem-sucesso"></div>
                    <div class="mensagem-erro2" id="mensagem-erro2"></div>
                        <label for="meio">Meio</label>
                        <input type="text" class="input-form" id="input-meio" name="meio" readonly required>
                        
                        <label for="plataforma">Plataforma</label>
                        <select name="plataforma" id="plataforma" disabled>
                            <option value="Escolha" selected>Escolha</option>
                        </select>
                        <input type="hidden" id="plataforma_antiga" name="plataforma_antiga" value="ID_PLATAFORMA_ATUAL">

                        <input type="submit" name="btn-salvar" id="btn-salvar" class="btn-salvar" value="Salvar">
                        <button type="submit" class="btn-salvar" id="btn-salvar" style="display: none;" disabled>Salvar</button>
                        <button type="submit" class="btn-atualizar" id="btn-atualizar" style="display: none;" >Atualizar</button>
                    </form>
                    <button class="btn-novo" id="btn-novo">Novo</button>
                </div>

                <div class="resultado-teste">
                    <table class="table table-bordered table-striped mb-none" id="datatable-editable">
                        <thead>
                            <tr>
                                <th>Meio</th>
                                <th>Plataforma</th>
                                <th>Ativo</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
    </section>
<script defer>
$(document).ready(function() {   
    atualiza();
    carregarDadosTabela();
    carregarPlataformas();

    $('#plataforma').prop('disabled', true);
    $('#btn-novo').click(function() {
        var meioPagamento = $('#input-meio').val('');
        var plataformaSelecionada = $('#plataforma').val('');
        $('.input-form').prop('readonly', false);
        $('#plataforma').prop('disabled', false);
        $('#btn-salvar').show();
        $(this).hide();
    });

    $('form.meio-form').submit(function(event) {
        event.preventDefault();

        var meioPagamento = $('#input-meio').val();
        var plataformaSelecionada = $('#plataforma').val();

        if (!meioPagamento || plataformaSelecionada === '') {
            alert('Por favor, preencha todos os campos.');
            return;
        }

        var url = 'meio_pagamento.php';

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                salvar_dados: true,
                meio: meioPagamento,
                plataforma: plataformaSelecionada
            },
            dataType: 'text',
            success: function(response) {
                if (response.includes('sucesso')) {
                    alert('Dados inseridos com sucesso!');
                    setTimeout(function() {
                        window.location.reload();
                    }, 100);
                    $('.input-form').val('').prop('readonly', true);
                    $('#plataforma').prop('disabled', true);
                } else if (response.includes('conteudo_existente')) {
                    $('#mensagem-erro2').html('Conteúdo já inserido anteriormente.');
                    $('#mensagem-erro2').addClass('mensagem error').fadeIn();
                    fadeInAndOut('mensagem-erro2', 'error');
                } else {
                    $('#mensagem-erro2').html('Erro ao inserir dados.');
                    $('#mensagem-erro2').addClass('mensagem error').fadeIn();
                    fadeInAndOut('mensagem-erro2', 'error');
                }
                $('#btn-novo').show();
                $('#btn-salvar').hide();
            },
            error: function(xhr, status, error) {
                console.error('Erro na requisição AJAX:', error);
                $('#mensagem-erro2').html('Erro ao inserir dados.');
                $('#mensagem-erro2').addClass('mensagem error').fadeIn();
                fadeInAndOut('mensagem-erro2', 'error');
            }
        });
    });

    //Lógica para excluir
    $(document).on('click', '.btn-excluir', function() {
        var meio = $(this).closest('tr').find('td:eq(0)').text().trim();
        var plataforma = $(this).closest('tr').find('td:eq(1)').text().trim();

        if (confirm('Tem certeza que deseja excluir este registro?')) {
            $.ajax({
                url: 'meio_pagamento.php',
                type: 'POST',
                data: {
                    excluir_dados: true,
                    meio: meio,
                    plataforma: plataforma
                },
                dataType: 'text',
                success: function(response) {
                    if (response.trim() === 'sucesso') {
                        alert('Registro excluído com sucesso.');
                        setTimeout(function() {
                            window.location.reload();
                        }, 10);
                    } else {
                        setTimeout(function() {
                            window.location.reload();
                        }, 10);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erro na requisição AJAX:', error);
                    alert('Erro ao excluir registro.');
                }
            });
        }
    });

//Logica para editar
$(document).on('click', '.btn-editar', function() {
    var meio = $(this).closest('tr').find('td:eq(0)').text().trim();
    var plataforma = $(this).closest('tr').find('td:eq(1)').text().trim();
    carregarPlataformas();

    $('#input-meio').val(meio).prop('readonly', false);
    $('#plataforma').val(plataforma).prop('disabled', false);

    $('#btn-salvar').hide();
    $('#btn-novo').hide();
    $('#btn-atualizar').show();

    $('#btn-atualizar').click(function(event) {
        event.preventDefault();

        var meioAntigo = meio;
        var plataformaAntiga = plataforma;
        var meioNovo = $('#input-meio').val();
        var plataformaNova = $('#plataforma').val();

        $.ajax({
            url: 'meio_pagamento.php',
            type: 'POST',
            data: {
                alterar_dados: true,
                meio: meioAntigo,
                plataforma: plataformaAntiga,
                meio_novo: meioNovo,
                plataforma_nova: plataformaNova
            },
            dataType: 'text',
            success: function(response) {
                if (response === 'sucesso') {
                    alert('Erro ao atualizar registro.');
                } else {
                    alert('Registro atualizado com sucesso.');
                    setTimeout(function() {
                        window.location.reload();
                    }, 100);
                }
            },
            error: function(xhr, status, error) {
                console.error('Erro na requisição AJAX:', error);
                alert('Erro ao atualizar registro.');
            }
        });
    });
});

//Carrega os dados da plataforma
function carregarPlataformas() {
    $.ajax({
        url: 'meio_pagamento.php',
        type: 'POST',
        data: {
            listar_dados: true,
            listar_plataforma: true
        },
        dataType: 'json',
        success: function(data) {
            console.log(data);

            var plataformas = data.plataformas;
            var select = $('#plataforma');
            var selectedValue = select.val();

            select.children('option:not(:first)').remove();

            $.each(plataformas, function(index, item) {
                select.append($('<option>', {
                    value: item.plataforma,
                    text: item.plataforma
                }));
            });

            if (!selectedValue && plataformas.length > 0) {
                select.val(plataformas[0].plataforma);
            }

            select.prop('disabled', false);
        },
        error: function(xhr, status, error) {
            console.error('Erro ao buscar plataformas:', error);
        }
    });
}

//Carrega os dados da tabela
function carregarDadosTabela() {
    $.ajax({
        url: 'meio_pagamento.php',
        type: 'POST',
        data: {
            listar_plataforma: true,
            listar_dados: true
        },
        dataType: 'json',
        success: function(data) {
            var tbody = $('#datatable-editable tbody');
            var dados = data.dados;
            var plataformas = data.plataformas;
            //console.log("Plataformas:", plataformas);

            tbody.empty();

            if (dados && dados.length > 0) {
                $.each(dados, function(index, item) {
                    var tr = $('<tr>');
                    tr.append('<td>' + item.meio + '</td>');

                    if(plataformas && plataformas.length > 0){
                        $.each(plataformas, function(index, item) {
                            tr.append('<td id="nome_da_plataforma">' + item.plataforma + '</td>');
                        })
                    }
                    tr.append('<td><input type="checkbox" class="checkbox-table"></td>');
                    tr.append('<td><button class="btn-editar">Editar</button> <button class="btn-excluir">Excluir</button></td>');
                    tbody.append(tr);
                });


                var firstCheckbox = $('.checkbox-table:first');
                firstCheckbox.prop('checked', true);

                var firstCheckedRow = firstCheckbox.closest('tr');
                var meio = firstCheckedRow.find('td:eq(0)').text().trim();
                var idPlataforma = firstCheckedRow.find('td:eq(1)').text().trim();

                var plataformasNovaPosicao = {};
                for (var i = 0; i < plataformas.length; i++) {
                    plataformasNovaPosicao[i + 1] = plataformas[i];
                }

                var plataforma_nome = '';
                for (var key in plataformasNovaPosicao) {
                    if (key == idPlataforma) {
                        plataforma_nome = plataformasNovaPosicao[key].plataforma;
                        break;
                    }
                }

                $('#input-meio').val(meio);
                var nome_da_plataforma = $('#nome_da_plataforma').text();
                console.log("Nome da plataforma:", nome_da_plataforma);
                $('#plataforma').val(nome_da_plataforma);

                $('.checkbox-table').on('change', function() {
                    var isChecked = $(this).prop('checked');

                    if (isChecked) {
                        $('.checkbox-table').not(this).prop('checked', false);

                        var row = $(this).closest('tr');
                        var meio = row.find('td:eq(0)').text().trim();
                        var idPlataforma = row.find('td:eq(1)').text().trim();

                        var plataformasNovaPosicao = {};
                        for (var i = 0; i < plataformas.length; i++) {
                            plataformasNovaPosicao[i + 1] = plataformas[i];
                        }

                        var plataforma_nome = '';
                        for (var key in plataformasNovaPosicao) {
                            if (key == idPlataforma) {
                                plataforma_nome = plataformasNovaPosicao[key].plataforma;
                                break;
                            }
                        }

                        $('#input-meio').val(meio);
                        var nome_da_plataforma = $('#nome_da_plataforma').text();
                        $('#plataforma').val(nome_da_plataforma);

                        $('#btn-novo').hide();
                    } else {
                        $('#btn-novo').show();

                        $('#input-meio').val('');
                        $('#plataforma').val('');
                    }
                });

                if (firstCheckbox.prop('checked')) {
                    $('#btn-novo').hide();
                }

            } else {
                var tr = $('<tr><td colspan="4">Nenhum resultado encontrado.</td></tr>');
                tbody.append(tr);
            }
        },
        error: function(xhr, status, error) {
            console.error('Erro ao carregar dados da tabela:', status, error);
            var tbody = $('#datatable-editable tbody');
            tbody.empty();
            var tr = $('<tr><td colspan="4">Erro ao carregar dados.</td></tr>');
            tbody.append(tr);
        }
    });
}

});
</script>
</body>
</html>
