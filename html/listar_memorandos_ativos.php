<?php
        session_start();
    if(!isset($_SESSION['usuario'])){
        header ("Location: ../index.php");
    }

    include "../memorando/conexao.php";
    $cpf_remetente=$_SESSION['usuario'];
            $comando5="select id_pessoa from pessoa where cpf='$cpf_remetente'";
            $query5=mysqli_query($conexao, $comando5);
            $linhas5=mysqli_num_rows($query5);
            for($i=0; $i<$linhas5; $i++)
            {
                $consulta5=mysqli_fetch_row($query5);
                $remetente=$consulta5[0];
            }
            $memorandos=array();
            $memorandos2=array();
            $comando5="select despacho.id_memorando, despacho.id_destinatario, despacho.texto, memorando.titulo, despacho.data, despacho.id_remetente, memorando.id_status_memorando from despacho join memorando on(despacho.id_memorando=memorando.id_memorando) where (despacho.id_despacho in (select max(id_despacho) from despacho group by id_memorando)) and despacho.id_destinatario=$remetente and memorando.id_status_memorando!='8' order by memorando.data desc";
            $query5=mysqli_query($conexao, $comando5);
            $linhas5=mysqli_num_rows($query5);
            for($i=0; $i<$linhas5; $i++)
            {
                $consulta5=mysqli_fetch_row($query5);
                $num=$i+1;
                if($consulta5[5]==$consulta5[1])
                {
                    $memorandos2[$i]=array('codigo'=>$num, 'memorando'=>$consulta5[3], 'data'=>$consulta5[4], 'id'=>$consulta5[0], 'reme_des'=>$consulta5[5], 'dest_des'=>$consulta5[1], 'arquivar'=>"Arquivar Memorando", 'status'=>$consulta5[6]);
                }
                else
                {
                $memorandos[$i]=array('codigo'=>$num, 'memorando'=>$consulta5[3], 'data'=>$consulta5[4], 'id'=>$consulta5[0], 'reme_des'=>$consulta5[5], 'dest_des'=>$consulta5[1], 'status'=>$consulta5[6]);
            }
            }
            $memorando2=json_encode($memorandos2);
            $memorando=json_encode($memorandos);

            // Adiciona a Função display_campo($nome_campo, $tipo_campo)
    require_once "personalizacao_display.php";

            ?>
<!doctype html>

<html class="fixed">
<head>
    <!-- Basic -->
    <meta charset="UTF-8">

    <title>Caixa de entrada</title>
        
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/vendor/magnific-popup/magnific-popup.css" />
    <link rel="stylesheet" href="../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
    <link rel="icon" href="<?php display_campo("Logo",'file');?>" type="image/x-icon" id="logo-icon">

    <!-- Specific Page Vendor CSS -->
    <link rel="stylesheet" href="../assets/vendor/select2/select2.css" />
    <link rel="stylesheet" href="../assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="../assets/stylesheets/theme.css" />

    <!-- Skin CSS -->
    <link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">

    <!-- Head Libs -->
    <script src="../assets/vendor/modernizr/modernizr.js"></script>
        
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


    <!-- javascript functions -->
    <script src="../Functions/onlyNumbers.js"></script>
    <script src="../Functions/onlyChars.js"></script>
    <script src="../Functions/mascara.js"></script>
        
    <!-- jquery functions -->


    <script>
    $(function(){
        var memorando=<?php echo $memorando?> ;
        var memorando2=<?php echo $memorando2?>;
        $.each(memorando2,function(i,item){
            if(item.status!=6)
            {
            $("#tabela")
                .append($("<tr style='background-color:#FA8F8F;'>")
                    .append($("<td>")
                        .text(item.codigo))
                    .append($("<td>")
                        .html("<a href=../html/teste.php?desp="+item.id+" id=memorando>"+item.memorando+"</a> <a href=../memorando/arquivaMemorando.php?desp="+item.id+">"+item.arquivar+"</a>"))
                    .append($("<td>")
                        .text(item.data)));
            }
            else
            {
                $("#tabela")
                .append($("<tr>")
                    .append($("<td>")
                        .text(item.codigo))
                    .append($("<td>")
                        .html("<a href=../html/teste.php?desp="+item.id+" id=memorando>"+item.memorando+"</a> <a href=../memorando/arquivaMemorando.php?desp="+item.id+">"+item.arquivar+"</a>"))
                    .append($("<td>")
                        .text(item.data)));
            }

        });
        $.each(memorando,function(i,item){
            if(item.status!=6)
            {
            $("#tabela")
                .append($("<tr style='background-color=#FA8F8F;'>")
                    .append($("<td>")
                        .text(item.codigo))
                    .append($("<td>")
                        .html("<a href=../html/teste.php?desp="+item.id+" id=memorando>"+item.memorando+"</a>"))
                    .append($("<td>")
                        .text(item.data)));
            }
            else
            {
                $("#tabela")
                .append($("<tr>")
                    .append($("<td>")
                        .text(item.codigo))
                    .append($("<td>")
                        .html("<a href=../html/teste.php?desp="+item.id+" id=memorando>"+item.memorando+"</a>"))
                    .append($("<td>")
                        .text(item.data)));
            }
        });
        $("#header").load("header.php");
        $(".menuu").load("menu.html");
    });
    </script>
    
    <style type="text/css">
        /*.table{
            z-index: 0;
        }
        .text-right{
            z-index: 1;
        }*/
        .select{
            /*z-index: 2;*/
            /*float: left;*/
            position: absolute;
            width: 235px;
        }*/
        .select-table-filter{
            width: 140px;
            float: left;
        }-->
    </style>
</head>
<body>
    <section class="body">
        <!-- start: header -->
        <div id="header"></div>
        <!-- end: header -->
        <div class="inner-wrapper">
            <!-- start: sidebar -->
            <aside id="sidebar-left" class="sidebar-left menuu"></aside>
            <!-- end: sidebar -->
            <section role="main" class="content-body">
                <header class="page-header">
                    <h2>Caixa de entrada</h2>
                    <div class="right-wrapper pull-right">
                        <ol class="breadcrumbs">
                            <li>
                                <a href="home.php">
                                    <i class="fa fa-home"></i>
                                </a>
                            </li>
                            <li><span>Caixa de Entrada</span></li>
                        </ol>
                        <a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
                    </div>
                </header>
                <!-- start: page -->
                <section class="panel" >
                    <header class="panel-heading">
                        <h2 class="panel-title">Caixa de entrada</h2>
                    </header>
                    <div class="panel-body" >
                        <div class="select" >
                            <select class="select-table-filter form-control mb-md" data-table="order-table">
                                <option selected disabled>Caixa de entrada</option>
                            </select>float:right;"></h5>
                        </div>
                        <button style="float: right;" class="mb-xs mt-xs mr-xs btn btn-default">Imprimir</button>
                        <br><br>
                            
                        <table class="table table-bordered table-striped mb-none" id="datatable-default">
                            <thead>
                                <tr>
                                    <th>codigo</th>
                                    <th>titulo</th>
                                    <th>data</th>
                                </tr>
                            </thead>
                            <tbody id="tabela">
                            </tbody>
                        </table>
                    </div>


                <form action="#" method="post">
            <input type="text" id="assunto" name="assunto" required placeholder="Assunto">
            <input type='submit' value='Criar memorando' name='enviar' id='enviar'>
            <span id='mostra_assunto'></span>;
            </form>
            <?php
                    if(isset($_POST["enviar"]))
                {
                    $assunto=$_POST["assunto"];
                    date_default_timezone_set('America/Sao_Paulo');
                    $data_criacao3=date('Y-m-d H:i:s');
                    $comando2="insert into memorando(id_pessoa, id_status_memorando, titulo, data) values('$remetente', '1', '$assunto', '$data_criacao3')";
                    $query2=mysqli_query($conexao, $comando2);
                    $linhas2=mysqli_affected_rows($conexao);
                    echo "<input type=hidden value='$assunto' id=titulo>";
                    if($linhas2==1)
                    {
            ?>
                        <script>
                            $("#assunto").hide();
                            $("#enviar").hide();
                            $("h4").hide();
                            $(".panel-heading").hide();
                            $(".panel-body").hide();
                            var assunto_memorando=$("#titulo").val();
                            $("#mostra_assunto").html(assunto_memorando);
                            $("table").hide();
                        </script>
                        <?php 
                        $comando3="select id_memorando from memorando where titulo='$assunto'";
                        $query3=mysqli_query($conexao, $comando3);
                        $linhas3=mysqli_num_rows($query3);
                        for($i=0; $i<$linhas3; $i++)
                        {
                            $consulta3=mysqli_fetch_row($query3);
                            $id=$consulta3[0];
                        } 
                        ?>
                        <form action="../memorando/inseredespacho.php?id=<?php echo ($id);?>" method="post" enctype="multipart/form-data">
                        <select name="destinatario" id="destinatario" required>
                        <!--option>Para</option-->
                        <?php
                        $comando="select pessoa.nome, funcionario.id_funcionario from funcionario join pessoa where funcionario.id_funcionario=pessoa.id_pessoa";
                        $query=mysqli_query($conexao, $comando);
                        $linhas=mysqli_num_rows($query);
                        for($i=0; $i<$linhas; $i++)
                        {
                            $consulta = mysqli_fetch_row($query);
                            $nome=$consulta[0];
                            $id=$consulta[1];
                            echo "<option id='$id' value='$id' name='$id'>$nome</option>";
                        }
                        ?>
                        </select><br>
                        <textarea id=despacho name="despacho" required placeholder=Mensagem></textarea><br>
                        <input type="file" name="arquivo" id="arquivo">
                        <input type="submit" value="Criar despacho"> 
                        <?php                           
                    }
                }
                ?>
                </section>
            </section>
        </div>
    </section>
    
    <!-- end: page -->
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