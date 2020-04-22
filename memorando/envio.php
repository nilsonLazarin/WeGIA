<?php
session_start();
if(!isset($_SESSION['usuario'])){
header ("Location: ../index.php");
}
?>

<!DOCTYPE html>
<html class="fixed">

    <head>
        <title>Memorando</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

        <!-- Basic -->
	<meta charset="UTF-8">

<title>Home</title>

<!-- Mobile Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

<!-- Web Fonts  -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="main.css">

<!-- Vendor CSS -->
<link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.css" />
<link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.css" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<link rel="stylesheet" href="../assets/vendor/magnific-popup/magnific-popup.css" />
<link rel="stylesheet" href="../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

<!--Página Css que não interfere no estilo de oputras páginas do sistema-->
<link rel="stylesheet" href="../css/home-theme.css" />

<!-- Specific Page Vendor CSS -->
<link rel="stylesheet" href="../assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
<link rel="stylesheet" href="../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
<link rel="stylesheet" href="../assets/vendor/morris/morris.css" />

<!-- Theme CSS -->
<link rel="stylesheet" href="../assets/stylesheets/theme.css" />
<link rel="icon" href="../img/logofinal.png" type="image/x-icon">

<!-- Skin CSS -->
<link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />

<!-- Theme Custom CSS -->
<link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">

<!-- Head Libs -->
<script src="../assets/vendor/modernizr/modernizr.js"></script>
<script src="../Functions/lista.js"></script>
<!-- Vendor -->
<script src="../assets/vendor/jquery/jquery.min.js"></script>
    </head>

    <body>
    <section class="body">
    <div id="header">
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
						<a role="menuitem" tabindex="-1" href="./logout.php"><i class="fa fa-power-off"></i> Sair da sessão</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- end: search & user box -->
	</header>
	</div>
	<!-- end: search & user box -->
</header>
    </div>
    <!-- end: header -->
    <div class="inner-wrapper">
	            <!-- start: sidebar -->
	            <aside id="sidebar-left" class="sidebar-left menuu">

                <div class="sidebar-header">
		<div class="sidebar-title">
			Menu
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
						<a href="../html/home.php">
							<i class="fa fa-home" aria-hidden="true"></i>
							<span>Início</span>
						</a>
					</li>
					<li class="nav-parent nav-active">
						<a>
							<i class="fa fa-copy"></i>
							<span>Pessoas</span>
						</a>
						<ul class="nav nav-children">
							<li>
								<a href="cadastro_funcionario.php">
									 Cadastrar Funcionário
								</a>
							</li>
							<li>
								<a href="cadastro_interno.php">
									 Cadastrar Atendido
								</a>
							</li>
							<!--<li>
								<a href="cadastro_voluntario.php">
									 Cadastrar voluntário
								</a>
							</li>
							<li>
								<a href="cadastro_voluntario_judicial.php">
									 Cadastrar voluntário judicial
								</a>
							</li>-->
							<li>
								<a href="../controle/control.php?metodo=listarTodos&nomeClasse=FuncionarioControle&nextPage=../html/informacao_funcionario.php">
									 Informações Funcionários
								</a>
							</li>
							<li>
								<a href="../controle/control.php?metodo=listarTodos&nomeClasse=InternoControle&nextPage=../html/informacao_interno.php">
									 Informações Atendido
								</a>
							</li>
						</ul>
					</li>

					<li class="nav-parent nav-active">
						<a>
							<i class="fa fa-copy" aria-hidden="true"></i>
							<span>Material e Patrimônio</span>
						</a>
						<ul class="nav nav-children">
							<li>
								<a href="../html/cadastro_entrada.php">
									 Cadastrar Produtos
								</a>
							</li>
							<li>
								<a href="../html/cadastro_saida.php">
									 Saida de Produtos
								</a>
							</li>
							<li>
								<a href="../html/estoque.php">
									 Estoque
								</a>
							</li>
							<li>
								<a href="../html/listar_almox.php">
									 Almoxarifados
								</a>
							</li>
						</ul>
					</li>
					<li class="nav-parent nav-active">
						<a>
							<i class="fa fa-cog" aria-hidden="true"></i>
							<span>Configurações</span>
						</a>
						<ul class="nav nav-children">
							<li>
								<a href="../html/personalizacao.php">
									Editar Conteúdos
								</a>
							</li>
							<li>
								<a href="../html/personalizacao_imagem.php">
									Lista de Imagens
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
					<h2>Home</h2>
					<div class="right-wrapper pull-right">
						<ol class="breadcrumbs">
							<li>
								<a href="./home.php">
									<i class="fa fa-home"></i>
								</a>
							</li>
							<li><span>Início</span></li>
						</ol>
						<a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
					</div>
				</header>

        <?php

            include ("conexao.php");
            $cpf_remetente=$_SESSION['usuario'];
            $comando5="select id_pessoa from pessoa where cpf='$cpf_remetente'";
            $query5=mysqli_query($conexao, $comando5);
            $linhas5=mysqli_num_rows($query5);
            for($i=0; $i<$linhas5; $i++)
            {
                $consulta5=mysqli_fetch_row($query5);
                $remetente=$consulta5[0];
            }
        ?>
        <?php
            $comando1="select * from despacho where id_destinatario='$remetente'";
            $query1=mysqli_query($conexao, $comando1);
            $linhas1=mysqli_num_rows($query1);
            for($i=0; $i<$linhas1; $i++)
            {
                $consulta1=mysqli_fetch_row($query1);
			}
			?>
			<form action="#" method="post">
			<input type="text" id="assunto" name="assunto" required placeholder="Assunto">
			<input type='submit' value='Criar memorando' name='enviar' id='enviar'>
			<span id='mostra_assunto'></span>;
			</form>
			<h4>Memorandos novos</h4>
            <table class="table table-hover">
			<thead>
    			<tr>
				<th scope="col"></th>
      			<th scope="col">Memorando</th>
      			<th scope="col">Data</th>
    			</tr>
			  </thead>
			  <tbody>
			  <th class="sorting_asc" tabindex="0" aria-controls="datatable-default" rowspan="1" colspan="1" aria-sort="ascending" aria-label="codigo: activate to sort column ascending" style="width: 215.008px;">codigo</th>
			<?php
            $comando5="select despacho.id_memorando, despacho.id_destinatario, despacho.texto, memorando.titulo, despacho.data, despacho.id_remetente from despacho join memorando on (despacho.id_memorando=memorando.id_memorando)where (despacho.id_despacho in (select max(id_despacho) from despacho group by id_memorando)) and despacho.id_destinatario=$remetente and memorando.id_status_memorando!='8' order by memorando.data desc";
            $query5=mysqli_query($conexao, $comando5);
            $linhas5=mysqli_num_rows($query5);
            for($i=0; $i<$linhas5; $i++)
            {
                $consulta5=mysqli_fetch_row($query5);
                $id_mem=$consulta5[0];
                $titulo_des=$consulta5[3];
                $data_des=$consulta5[4];
                $reme_des=$consulta5[5];
				$dest_des=$consulta5[1];
				$num=$i+1;
				echo "<tr><th scope=row>".$num."</th>";
                echo "<td value=".$id_mem."><a href=../html/listar_despachos.php?desp=".$id_mem.">".$titulo_des."</a></td>";
                echo "<td>$data_des</td>";
                if($reme_des==$dest_des)
                {
                echo "<td value=".$id_mem."><a href=arquivaMemorando.php?desp=".$id_mem.">Arquivar memorando</a></td>";
                }
                echo "</tr>";
			}
			echo "</tbody>";
			echo "</table>";
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
                        <form action="inseredespacho.php?id=<?php echo ($id);?>" method="post">
                        <select id="destinatario" name="destinatario" id="destinatario" required>
						<option>Para</option>
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
                        <input type="submit" value="Criar despacho"> 
                        <?php                           
                    }
                }
                ?>
    </form>
    </section>
    </body>
</html>