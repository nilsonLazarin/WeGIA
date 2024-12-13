<?php
$title = 'Escolha sua forma de contribuição';
require_once './templates/header.php';

?>
<div class="container-contact100">
    <div class="wrap-contact100">

        <!--Adiciona a logo e o título ao topo da página-->
        <?php include('./components/contribuicao_brand.php'); ?>

        <div class="doacao_boleto">
            <h3>Escolha sua forma de contribuição</h3>

            <a class="btn btn-secondary m-2" href="./boleto.php" role="button">Boleto Único</a>
            <a class="btn btn-secondary m-2" href="./mensalidade.php" role="button">Carnê de Mensalidades</a>
            <a class="btn btn-secondary m-2" href="./pix.php" role="button">PIX</a>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

<script src="../vendor/select2/select2.min.js"></script>
<script src="../public/js/mascara.js"></script>
<?php
require_once './templates/footer.php';
?>