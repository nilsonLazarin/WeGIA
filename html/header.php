<?php

	require_once "/home/anniefb/htdocs/WeGIA/dao/Conexao.php";

	// Adiciona a Função display_campo($nome_campo, $tipo_campo)
	require_once "personalizacao_display.php";
?>

<header class="header">
	<div class="logo-container">
		<a href="home.php" class="logo">
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
					<img src="<?php echo $caminho2;?>img/semfoto.jpg" alt="Joseph Doe" class="img-circle" data-lock-picture="../assets/images/!logged-user.jpg" />
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
						<a role="menuitem" tabindex="-1" href="<?php echo $caminho2;?>html/alterar_senha.php"><i class="glyphicon glyphicon-lock"></i> Alterar senha</a>
					</li>
					<li>
						<a role="menuitem" tabindex="-1" href="<?php echo $caminho2;?>html/logout.php"><i class="fa fa-power-off"></i> Sair da sessão</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- end: search & user box -->
</header>