<?php
require_once('conexao.php');

// Listar os meios de pagamento
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['listar_meios']) && isset($_POST['listar_id_meio'])) {   
    $conexao = new Conexao();

    try {
        $sql_meio = "SELECT id, meio, id_plataforma FROM contribuicao_meioPagamento";
        $stmt_meio = $conexao->pdo->query($sql_meio);
        $retorno_meio = $stmt_meio->fetchAll(PDO::FETCH_ASSOC);

        $sql_id_meio = "SELECT id_meio FROM contribuicao_conjuntoRegras WHERE id_meio IN (SELECT id_meio FROM contribuicao_meioPagamento)";
        $stmt_id_meio = $conexao->pdo->query($sql_id_meio);
        $retorno_id_meio = $stmt_id_meio->fetchAll(PDO::FETCH_COLUMN); 

        $retorno_meio_pagamento = array(
            'meio' => $retorno_meio,
            'id_meio' => $retorno_id_meio
        );

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($retorno_meio_pagamento);
        die();
    } catch (PDOException $e) {
        echo "Houve um erro ao listar os meios de pagamento: " . $e->getMessage();
    }
}

//Listar as regras
if($_SERVER["REQUEST_METHOD"] === "POST" && isset ($_POST['listar_regras'])) {
    $conexao = new Conexao();

    try{
        $sql_regra = "SELECT id, regra FROM contribuicao_regras";
        $stmt_regra = $conexao->pdo->query($sql_regra);
        $retorno_regra = $stmt_regra->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($retorno_regra);
        die();
    } catch(PDOException $e){
        echo ("Houve um erro ao listar as regras." . $e->getMessage());
    }
}

//Listar os dados na tabela
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["listar_tabela"])) {
    $conexao = new Conexao();

    try {
        $sql_cont_regras = "SELECT id_meio, id_regra, value
                            FROM contribuicao_conjuntoRegras;";

        $stmt_listar_cont_regras = $conexao->pdo->query($sql_cont_regras);
        $array_listar_cont_regras = $stmt_listar_cont_regras->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($array_listar_cont_regras)) {
            $listar_regras = array();

            foreach ($array_listar_cont_regras as $linha) {
                $id_meio = $linha['id_meio'];
                $id_regra = $linha['id_regra'];
                $valor = $linha['value'];

                $sql_meio = "SELECT meio FROM contribuicao_meioPagamento WHERE id = :id_meio;";
                $stmt_meio = $conexao->pdo->prepare($sql_meio);
                $stmt_meio->bindParam(':id_meio', $id_meio, PDO::PARAM_INT);
                $stmt_meio->execute();
                $retorno_meio = $stmt_meio->fetch(PDO::FETCH_ASSOC);

                $sql_regra = "SELECT regra FROM contribuicao_regras WHERE id = :id_regra;";
                $stmt_regra = $conexao->pdo->prepare($sql_regra);
                $stmt_regra->bindParam(':id_regra', $id_regra, PDO::PARAM_INT);
                $stmt_regra->execute();
                $retorno_regra = $stmt_regra->fetch(PDO::FETCH_ASSOC);

                $listar_regras[] = array(
                    'meio' => ($retorno_meio) ? $retorno_meio['meio'] : null,
                    'regra' => ($retorno_regra) ? $retorno_regra['regra'] : null,
                    'value' => $valor
                );
            }

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($listar_regras);
            exit();
        } else {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('error' => 'Não foram encontrados dados na tabela'));
            exit();
        }
    } catch (PDOException $e) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(array('error' => 'Houve um erro ao tentar listar os dados: ' . $e->getMessage()));
        exit(); 
    }
}


//Salvar os dados no banco de dados
if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['salvar_dados'])){
    $conexao = new Conexao();

    $meio_nome = $_POST['meio'] ?? NULL;
    $id_regra = $_POST['regras'] ?? NULL;
    $valor = $_POST['valor'] ?? NULL;

    if(empty($meio_nome) || empty ($id_regra) || empty($valor)){
        echo "Preencha todos os campos!";
        exit;
    }

    try{
        //Pega o id de meio
        $sql_id_meio = "SELECT id FROM contribuicao_meioPagamento WHERE meio = :meio";
        $stmt_meio = $conexao->pdo->prepare($sql_id_meio);
        $stmt_meio->bindParam(':meio', $meio_nome);
        $stmt_meio->execute();
        $row_meio = $stmt_meio->fetch(PDO::FETCH_ASSOC);
        $id_meio = $row_meio['id'] ?? null;

        if (!$id_meio) {
            echo "Meio não encontrado.";
            exit;
        }

        $sql_check = "SELECT id_meio, id_regra, value FROM contribuicao_conjuntoRegras
                    WHERE id_meio = :meio
                    AND id_regra = :regras
                    AND value = :valor";
        
        $stmt_check = $conexao->pdo->prepare($sql_check);
        $stmt_check->bindParam(':meio', $id_meio, PDO::PARAM_INT);
        $stmt_check->bindParam(':regras', $id_regra, PDO::PARAM_INT);
        $stmt_check->bindParam(':valor', $valor, PDO::PARAM_INT);
        $stmt_check->execute();

        $existing_data = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if ($existing_data) {
            echo 'conteudo_existente';
            exit;
        } else {
            $sql_insert = "INSERT INTO contribuicao_conjuntoRegras (id_meio, id_regra, value) 
            VALUES (:id_meio, :id_regra, :valor)";

            $stmt_insert = $conexao->pdo->prepare($sql_insert);
            $stmt_insert->bindParam(':id_meio', $id_meio, PDO::PARAM_INT);
            $stmt_insert->bindParam(':id_regra', $id_regra, PDO::PARAM_INT);
            $stmt_insert->bindParam(':valor', $valor, PDO::PARAM_INT);

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
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["excluir_dados"])) {
    $conexao = new Conexao();

    $meio_nome = $_POST["meio"];
    $regra_nome = $_POST["regra"];
    $valor = $_POST["valor"];

    try {
        // Pega o id de meio
        $sql_id_meio = "SELECT id FROM contribuicao_meioPagamento WHERE meio = :meio";
        $stmt_meio = $conexao->pdo->prepare($sql_id_meio);
        $stmt_meio->bindParam(':meio', $meio_nome);
        $stmt_meio->execute();
        $row_meio = $stmt_meio->fetch(PDO::FETCH_ASSOC);
        $id_meio = $row_meio['id'] ?? null;

        if (!$id_meio) {
            echo "Meio não encontrado.";
            exit;
        }

        // Pega o id de regras
        $sql_id_regra = "SELECT id FROM contribuicao_regras WHERE regra = :regra";
        $stmt_regra = $conexao->pdo->prepare($sql_id_regra);
        $stmt_regra->bindParam(':regra', $regra_nome);
        $stmt_regra->execute();
        $row_regra = $stmt_regra->fetch(PDO::FETCH_ASSOC);
        $id_regra = $row_regra['id'] ?? null;

        if (!$id_regra) {
            echo "Regra não encontrada.";
            exit;
        }

        echo "ID do meio: ". $id_meio . "<br>";    
        echo "ID da regra: ". $id_regra . "<br>"; 
        echo $valor . "<br>";    

        $sql_delete = "DELETE FROM contribuicao_conjuntoRegras
                       WHERE id_meio = :meio
                       AND id_regra = :regra
                       AND value = :valor";

        $stmt_delete = $conexao->pdo->prepare($sql_delete);
        $stmt_delete->bindParam(':meio', $id_meio, PDO::PARAM_INT);
        $stmt_delete->bindParam(':regra', $id_regra, PDO::PARAM_INT);
        $stmt_delete->bindParam(':valor', $valor, PDO::PARAM_INT);

        $stmt_delete->execute();

        if ($stmt_delete->rowCount() > 0) {
            echo 'sucesso';
        } else {
            echo 'erro_excluir';
        }
    } catch (PDOException $e) {
        echo 'Erro ao excluir: ' . $e->getMessage();
    }
}

// Lógica para alterar
if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["alterar_dados"])){
    
    $meio_nome = $_POST["meio"];
    $regra_nome = $_POST["regras"];
    $valor_antigo = $_POST["valor"];

    if(empty($meio_nome) || empty($regra_nome)){
        echo "Meio ou regra está vazio.";
    }
    
    // Pega o id de meio
    $sql_id_meio = "SELECT id FROM contribuicao_meioPagamento WHERE meio = :meio";
    $stmt_meio = $conexao->pdo->prepare($sql_id_meio);
    $stmt_meio->bindParam(':meio', $meio_nome);
    $stmt_meio->execute();
    $row_meio = $stmt_meio->fetch(PDO::FETCH_ASSOC);
    $id_meio_antigo = $row_meio['id'] ?? null;

    if (!$id_meio_antigo) {
        echo "Meio não encontrado.";
        exit;
    }

    // Pega o id de regras
    $sql_id_regra = "SELECT id FROM contribuicao_regras WHERE regra = :regra";
    $stmt_regra = $conexao->pdo->prepare($sql_id_regra);
    $stmt_regra->bindParam(':regra', $regra_nome);
    $stmt_regra->execute();
    $row_regra = $stmt_regra->fetch(PDO::FETCH_ASSOC);
    $id_regra_antiga = $row_regra['id'] ?? null;

    if (!$id_regra_antiga) {
        echo "Regra não encontrada.";
        exit;
    }

    echo "ID antigo do meio: ". $id_meio_antigo . "<br>";    
    echo "ID antigo da regra: ". $id_regra_antiga . "<br>"; 
    echo $valor_antigo . "<br>";

    $id_meio_novo = $_POST["id_meio_novo"];
    $id_regra_nova = $_POST["id_regra_nova"];
    $valor_novo = $_POST["valor_novo"];
    $conexao = new Conexao();

    try{
        $sql_alterar = "UPDATE contribuicao_conjuntoRegras
                        SET meio = :id_meio_antigo,
                        AND regras = :id_regra_antiga,
                        AND value = :valor_antigo
                        WHERE meio = :id_meio_novo,
                        AND regras = :id_regra_nova,
                        AND value = :valor_novo";
    
        $stmt_alterar = $conexao->pdo->prepare($sql_alterar);
        $stmt_alterar->bindParam(':id_meio_antigo', $id_meio_antigo, PDO::PARAM_INT);
        $stmt_alterar->bindParam(':id_regra_antiga', $id_regra_antiga, PDO::PARAM_INT);
        $stmt_alterar->bindParam(':valor_antigo', $valor_antigo, PDO::PARAM_INT);

        $stmt_alterar->bindParam(':id_meio_novo', $id_meio_novo, PDO::PARAM_INT);
        $stmt_alterar->bindParam(':id_regra_nova', $id_regra_nova, PDO::PARAM_INT);
        $stmt_alterar->bindParam(':valor_novo', $valor_novo, PDO::PARAM_INT);

        $stmt_alterar->execute();

        if ($stmt_alterar->rowCount() > 0) {
            echo 'sucesso';
        } else {
            echo 'erro_alterar';
        }        

    }catch(PDOException $e){
        echo "Houve um erro na consulta SQL!". $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html class="fixed">
    <head>
        <meta charset="UTF-8">
        <title>Regras de pagamento</title>
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

    </head>
    <style>
    .regras-form {
        display: flex;
        flex-direction: column;
        max-width: 60vw;
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

    .btn-salvar, .btn-atualizar, .btn-novo, .btn-excluir, .btn-editar {
        margin-top: 9px;
        max-width: 5vw;
        padding: 7px;
        background-color: #0088cc;
        color: white;
        border: none;
        border-radius: 7px;
        cursor: pointer;
    }

    .btn-salvar:hover, .btn-atualizar:hover, .btn-novo:hover, .btn-excluir:hover, .btn-editar:hover {
        transition: 0.4 all ease-in;
        background-color: #067cb7;
    }

    .tabela {
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

     .tabela {
        margin-top: 80px;
        background-color: #f2f2f2;
        max-width: 100%;
        overflow-x: auto;
    }

    .tabela table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .tabela th,
    .tabela td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .tabela th {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    .tabela .td-token {
        width: 30%;
    }

    .tabela .btn-editar,
    .tabela .btn-excluir {
        padding: 8px 12px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        font-size: 14px;
    }

    .tabela .btn-editar:hover,
    .tabela .btn-excluir:hover {
        background-color: #0056b3;
    }

    .tabela .td-acao {
        text-align: center;
        vertical-align: middle;
    }
    </style>
    <body>
    <section class="body">
        <div id="header"></div>
        <div class="inner-wrapper">
			
            <aside id="sidebar-left" class="sidebar-left menuu"></aside>
            <section role="main" class="content-body">
            <header class="page-header">
					<h2>Regras de pagamento</h2>
					<div class="right-wrapper pull-right">
						<ol class="breadcrumbs">
							<li>
								<a href="../../home.php">
									<i class="fa fa-home"></i>
								</a>
							</li>
							<li><span>Regras de pagamento</span></li>
						</ol>
						<a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
					</div>
            </header>
            <div class="regras-box" id="regras-box">
            <form action="#" id="regras-form" class="regras-form" method="post">
                <label for="meio">Meio</label>
                <select name="meio" id="meio" disabled>
                    <option value="" class="input-form" id="input-form-meio" selected>Escolha</option>
                </select>
                
                <label for="regras">Regras</label>
                <select name="regras" id="regras" disabled>
                    <option value="" class="input-form" id="input-form-regras" selected>Escolha</option>
                </select>

                <label for="valor">Valor</label>
                <input type="number" name="valor" class="input-form" id="input-form-valor" min="1" required readonly>

                <input type="hidden" name="id_meio_novo" id="id_meio_novo">
                <input type="hidden" name="id_regra_nova" id="id_regra_nova">
                <input type="hidden" name="valor_novo" id="valor_novo">

                <button type="button" class="btn-editar" style="display: none;">Editar</button>
                <button type="button" class="btn-atualizar" style="display: none;">Atualizar</button>
                <input type="submit" name="btn-salvar" id="btn-salvar" class="btn-salvar" value="Salvar" style="display: none;">
            </form>
                <button class="btn-novo" id="btn-novo">Novo</button>
            </div>

            <div class="tabela">
                <table class="table table-bordered table-striped mb-none" id="datatable-editable">
                    <thead>
                        <tr>
                            <th>Meio</th>
                            <th>Regras</th>
                            <th>Valor</th>
                            <th>Ativo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </section>
    </section>

    </body>
    <script>
    $(document).ready(function() {
        atualiza();
        listarDadosNaTabela();

        //Ao clicar no botão novo
        $('#btn-novo').click(function() {
            $('#input-form-valor').removeAttr('readonly');
            $('#input-form-meio').removeAttr('disabled');
            $('#input-form-regras').removeAttr('disabled');
            $('#btn-salvar').css('display', 'inline-block');
            $('#btn-novo').css('display', 'none');

            $('#input-form-valor').val('');
            meiosDePagamento();
            regrasDePagamento();
        });

        //Ao clicar no botão salvar
        $('.regras-form').submit(function(event) {
            event.preventDefault();

            $('#input-form-valor').removeAttr('readonly');
            $('#input-form-meio').removeAttr('disabled');
            $('#input-form-regras').removeAttr('disabled');;

            var meioNome = $('#meio').val();
            var regrasNome = $('#regras').val();
            var valor = $('#input-form-valor').val();

            $.ajax({
                url: 'regras_pagamento.php',
                type: 'POST',
                data: {
                    salvar_dados: true,
                    meio: meioNome,      
                    regras: regrasNome, 
                    valor: valor
                },
                dataType: 'text',
                success: function(response){
                    if(response.includes('sucesso')){
                        alert('Dados inseridos com sucesso!');
                        setTimeout(function(){
                            window.location.reload();
                        }, 100);
                    } else if(response.includes('conteudo_existente')){
                        alert('Conteúdo já inserido no banco de dados.');
                        setTimeout(function(){
                            window.location.reload();
                        }, 100);
                    } else if(response.includes('erro_inserir')){
                        alert('Erro ao inserir dados.');
                        setTimeout(function(){
                            window.location.reload();
                        }, 100);
                    }

                    $('#btn-novo').show();
                    $('#btn-salvar').hide();
                },
                error: function(xhr, status, error) {
                    console.error('Erro na requisição AJAX:', error);
                }
            });
        });

        // Ao clicar no botão excluir
        $(document).on('click', '.btn-excluir', function() {
            var btnExcluir = $(this); 

            var meio = btnExcluir.closest('tr').find('td:eq(0)').text().trim();
            var regra = btnExcluir.closest('tr').find('td:eq(1)').text().trim();
            var valor = btnExcluir.closest('tr').find('td:eq(2)').text().trim();

            if (confirm('Tem certeza que deseja excluir este registro?')) {
                $.ajax({
                    url: 'regras_pagamento.php',
                    type: 'POST',
                    data: {
                        excluir_dados: true,
                        meio: meio,
                        regra: regra,
                        valor: valor
                    },
                    dataType: 'text',
                    success: function(response) {
                        if (response.trim() === 'sucesso') {
                            alert('Registro excluído com sucesso.');
                            setTimeout(function(){
                                window.location.reload();
                            }, 100);
                            btnExcluir.closest('tr').remove(); 
                        } else if (response.trim() === 'erro_excluir') {
                            alert('Houve um erro ao tentar excluir.');
                            setTimeout(function(){
                                window.location.reload();
                            }, 100);
                        } else {
                            alert('Registro excluído com sucesso.');
                            btnExcluir.closest('tr').remove(); 
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro na requisição AJAX:', error);
                        alert('Erro ao excluir registro.');
                    }
                });
            }
        });

        // Lógica para alterar
        $(document).on('click', '.btn-editar', function() {
            meiosDePagamento();
            regrasDePagamento();

            $('.btn-editar').hide();
            $('#btn-salvar').hide();
            $('.btn-novo').hide();
            $('.btn-atualizar').show();
            $('#meio').prop('disabled', false);
            $('#regras').prop('disabled', false);
            $('#input-form-valor').prop('readonly', false);
        });

        $(document).on('click', '.btn-atualizar', function() {
            var meio = $('#meio').val();
            var regra = $('#regras').val();
            var valor = $('#input-form-valor').val();
            var id_meio_novo = $('#id_meio_novo').val();
            var id_regra_nova = $('#id_regra_nova').val();
            var valor_novo = $('#valor_novo').val();

            var dados = {
                meio: meio,
                regras: regra,
                valor: valor,
                id_meio_novo: id_meio_novo,
                id_regra_nova: id_regra_nova,
                valor_novo: valor_novo,
                alterar_dados: true
            };

            $.ajax({
                type: 'POST',
                url: 'regras_pagamento.php',
                data: dados,
                success: function(response) {
                    if (response === 'sucesso') {
                        alert('Dados atualizados com sucesso!');
                        setTimeout(function(){
                                window.location.reload();
                            }, 100);
                    } else {
                        alert('Erro ao atualizar os dados: ' + response);
                        setTimeout(function(){
                                window.location.reload();
                            }, 100);
                    }
                    $('.btn-editar').show();
                    $('.btn-atualizar').hide();
                    $('#btn-salvar').hide();
                },
                error: function(xhr, status, error) {
                    console.error('Erro na requisição AJAX:', status, error);
                    alert('Dados atualizados com sucesso');
                    setTimeout(function(){
                                window.location.reload();
                            }, 100);
                    $('.btn-editar').show();
                    $('.btn-atualizar').hide();
                    $('#btn-salvar').hide();
                }
            });
        });

        // Carrega os meios de pagamento
        function meiosDePagamento() {
            $.ajax({
                url: 'regras_pagamento.php',
                type: 'POST',
                data: { 
                    listar_meios: true,
                    listar_id_meio: true
                },
                dataType: 'json',
                success: function(data) {
                    //console.log(data);

                    var meio = data.meio;
                    var id_meio = data.id_meio;
                    var select = $('#meio');
                    var selectedValue = select.val();    

                    select.children('option:first').remove();

                    for (var i = 0; i < meio.length; i++) {
                        var optionText = meio[i].meio + " - Plataforma: " + meio[i].id_plataforma;
                        select.append($('<option>', {
                            value: meio[i].meio,
                            text: optionText
                        }));
                    }

                    if (!selectedValue && meio.length > 0) {
                        select.val(meio[0].meio);
                    }

                    select.prop('disabled', false);
                },


                error: function(xhr, status, error) {
                    console.error('Erro ao buscar os meios de pagamento:', error);
                    //console.log(xhr.responseText);
                }
            });
        }

        //Carrega as regras de pagamento
        function regrasDePagamento(){
            $.ajax({
                url: 'regras_pagamento.php',
                type: 'POST',
                data: { listar_regras: true },
                dataType: 'json',
                success: function(data){
                    var regras = data;
                    console.log(regras);
                    
                    var select = $('#regras');
                    var selectedValue = select.val();    

                    select.children('option:first').remove();

                    for (var i = 0; i < regras.length; i++) {
                        select.append($('<option>', {
                            value: regras[i].id,
                            text: regras[i].regra
                        }));
                    }

                    if (!selectedValue && regras.length > 0) {
                        select.val(regras[0].id);
                    }

                    select.prop('disabled', false);
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao buscar as regras:', error);
                    //console.log(xhr.responseText);
                }
            })
        }

        function listarDadosNaTabela() {
        $.ajax({
            url: 'regras_pagamento.php',
            type: 'POST',
            data: { listar_tabela: true },
            dataType: 'json',
            success: function(data) {
                var $tbody = $('#datatable-editable tbody');
                $tbody.empty();

                if (data.length > 0) {
                    $.each(data, function(index, item) {
                        var linha = $('<tr>');
                        linha.append($('<td>').text(item.meio || 'N/A'));
                        linha.append($('<td>').text(item.regra || 'N/A'));
                        linha.append($('<td>').text(item.value || 'N/A'));

                        //checkbox
                        var checkbox = $('<input>').attr({
                            type: 'checkbox',
                            id: 'checkbox-table-' + index,
                            class: 'checkbox-table',
                            'data-index': index 
                        });

                        if (index === 0) {
                            checkbox.prop('checked', true);
                        }

                        var tdCheckbox = $('<td>').append(checkbox);
                        linha.append(tdCheckbox);

                        linha.append($('<td>').html('<button class="btn btn-primary btn-editar">Editar</button> <button class="btn btn-primary btn-excluir">Excluir</button>'));

                        $tbody.append(linha);
                    });

                    //Checkboxs
                    var primeiroItem = $('#datatable-editable tbody tr:first');
                    var meio = primeiroItem.find('td:eq(0)').text().trim();
                    var regra = primeiroItem.find('td:eq(1)').text().trim();
                    var valor = primeiroItem.find('td:eq(2)').text().trim();

                    $('#input-form-meio').val(meio);
                    $('#input-form-regras').val(regra);
                    $('#input-form-valor').val(valor);

                    $('#input-form-meio').text(meio);
                    $('#meio').val(meio);

                    $('#input-form-regras').text(regra);
                    $('#regras').val(regra);

                    $('.checkbox-table').on('change', function() {
                        if ($(this).is(':checked')) {
                            var $row = $(this).closest('tr');
                            var meio = $row.find('td:eq(0)').text().trim();
                            var regra = $row.find('td:eq(1)').text().trim();
                            var valor = $row.find('td:eq(2)').text().trim();

                            $('#input-form-meio').val(meio);
                            $('#input-form-regras').val(regra);
                            $('#input-form-valor').val(valor);

                            $('#input-form-meio').text(meio);
                            $('#meio').val(meio);

                            $('#input-form-regras').text(regra);
                            $('#regras').val(regra);

                            $('.btn-novo').hide();
                        } else {
                            $('.btn-novo').show();
                            $('#input-form-meio').val('');
                            $('#input-form-regras').val('');
                            $('#input-form-valor').val('');

                            $('#input-form-meio').text('Escolha');
                            $('#meio').val('');

                            $('#input-form-regras').text('Escolha');
                            $('#regras').val('');
                        }
                    });


                    $('.checkbox-table').on('change', function() {
                        var $checkboxes = $('.checkbox-table');
                        var currentIndex = $(this).data('index');

                        $checkboxes.each(function(index) {
                            if (index !== currentIndex) {
                                $(this).prop('checked', false);
                            }
                        });
                    });

                } else {
                    $tbody.append($('<tr>').append($('<td>').attr('colspan', 5).text('Nenhum dado encontrado')));
                }
            },
            error: function(xhr, status, error) {
                console.error("Houve um erro ao listar os dados na tabela:", error)
            }
        });
    }
});
    </script>
</html>
