<?php

$config_path = "config.php";
$path = "";
if(file_exists($config_path)){

	require_once($config_path);

}else{
	while(true){
		$path .= "../";
		$config_path = "../" . $config_path;
		if(file_exists($config_path)) break;
	}
	require_once($config_path);

	session_start();
	require_once $path."dao/Conexao.php";

	// Adiciona a Função display_campo($nome_campo, $tipo_campo)
	require_once ROOT."/html/personalizacao_display.php";
}

	$conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$id_pessoa = $_SESSION['id_pessoa'];
	$resultado = mysqli_query($conexao, "SELECT `imagem`, `nome` FROM `pessoa` WHERE id_pessoa=$id_pessoa");
	$cargo = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT c.cargo FROM pessoa p join funcionario f on f.id_pessoa = p.id_pessoa join cargo c on c.id_cargo = f.id_cargo WHERE p.id_pessoa = $id_pessoa"))['cargo'];
	$pessoa = mysqli_fetch_array($resultado);
?>

<header class="header">
	<div class="logo-container">
		<a href="<?php echo WWW;?>html/home.php" class="logo">
			<img src="<?php display_campo("Logo",'file');?>" height="35" alt="Porto Admin" />
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
					<?php
						if(isset($_SESSION['id_pessoa']) and !empty($_SESSION['id_pessoa'])){
							$foto = $pessoa['imagem'];
							if($foto != null and $foto != "")
								$foto = 'data:image;base64,'.$foto;
							else $foto = WWW."img/semfoto.png";
						}
						
					?>
					<img src="<?php echo($foto);?>" alt="Joseph Doe" class="img-circle" />
				</figure>
				<div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
					<span class="name"><?php echo($pessoa['nome']); ?></span>
					<span class="role"><?php echo($cargo); ?></span>
				</div>
				<i class="fa custom-caret"></i>
			</a>
	
			<div class="dropdown-menu">
				<ul class="list-unstyled">
					<li class="divider"></li>
					<li>
						<a role="menuitem" tabindex="-1" href="<?php echo WWW;?>html/alterar_senha.php"><i class="glyphicon glyphicon-lock"></i> Alterar senha</a>
					</li>
					<li>
						<a role="menuitem" tabindex="-1" href="<?php echo WWW;?>html/logout.php"><i class="fa fa-power-off"></i> Sair da sessão</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- end: search & user box -->
</header>