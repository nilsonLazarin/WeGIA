<?php
$title = 'Emitir boleto';
require_once './templates/header.php';
require_once '../controller/BrandController.php';

$brandController = new BrandController();
$brand = $brandController->getBrand();
?>
<div class="container-contact100">
    <div class="wrap-contact100">

        <span id="logo_img">
            <?php
            if (!is_null($brand)) {
                echo $brand->getImagem()->getHtml();
            }
            ?>
        </span>
        <span class="contact100-form-title" id="titulo_pag">
            <?php
            if (!is_null($brand)) {
                echo $brand->getMensagem();
            }
            ?>
        </span>

        <input type="hidden" name="forma-contribuicao" id="forma-contribuicao" value="boleto">

        <div id="pag1" class="wrap-input100">
            <?php include('./components/contribuicao_valor.php'); ?>
        </div>

        <div id="pag2" class="wrap-input100">
            <?php include('./components/contribuicao_documento.php'); ?>
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