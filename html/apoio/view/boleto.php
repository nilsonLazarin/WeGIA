<?php
$title = 'Emitir boleto';
require_once './templates/header.php';

?>
<div class="container-contact100">
    <div class="wrap-contact100">

        <!--Adiciona a logo e o título ao topo da página-->
        <?php include('./components/contribuicao_brand.php'); ?>

        <input type="hidden" name="forma-contribuicao" id="forma-contribuicao" value="boleto">

        <div id="pag1" class="wrap-input100">
            <!--Adiciona a página de valor de contribuição-->
            <?php include('./components/contribuicao_valor.php'); ?>
        </div>

        <div id="pag2" class="wrap-input100">
            <!--Adiciona a página para identificação de Sócios PJ e PF-->
            <?php include('./components/contribuicao_documento.php'); ?>
        </div>

        <div id="pag3" class="wrap-input100">
            <!--Adiciona a página para coleta do nome, data de nascimento, telefone e e-mail-->
            <?php include('./components/contribuicao_contato.php'); ?>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <script src="../vendor/select2/select2.min.js"></script>
    <script src="../public/js/mascara.js"></script>
    <script src="../public/js/util.js"></script>
    <script src="../public/js/boleto.js"></script>
    <?php
    require_once './templates/footer.php';
    ?>