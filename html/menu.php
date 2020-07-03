<?php
	$config_path = "config.php";
	$html_dir = "";
	if(file_exists($config_path)){
		require_once($config_path);
	}else{
		while(true){
			$config_path = "../" . $config_path;
			$html_dir .= "../";
			if(file_exists($config_path)) break;
		}
		require_once($config_path);
	}
?>
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
						<a href="<?php echo $html_dir;?>home.php">
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
								<a href="<?php echo $html_dir;?>cadastro_funcionario.php">
									 Cadastrar Funcionário
								</a>
							</li>
							<li>
								<a href="<?php echo $html_dir;?>cadastro_interno.php">
									 Cadastrar Atendido
								</a>
							</li>
							<li>
								<a href="<?php echo $html_dir;?>../controle/control.php?metodo=listarTodos&nomeClasse=FuncionarioControle&nextPage=<?php echo $html_dir;?>html/informacao_funcionario.php">
									 Informações Funcionários
								</a>
							</li>
							<li>
								<a href="<?php echo $html_dir;?>../controle/control.php?metodo=listarTodos&nomeClasse=InternoControle&nextPage=<?php echo $html_dir;?>html/informacao_interno.php">
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
						<li id="23">
								<a href="<?php echo $html_dir;?>cadastro_entrada.php">
									Entrada
								</a>
							</li>
							<li id="25">
								<a href="<?php echo $html_dir;?>cadastro_saida.php">
									Saida
								</a>
							</li>
							<li id="24">
								<a href="<?php echo $html_dir;?>estoque.php">
									Estoque
								</a>
							</li>
							<li id="21">
								<a href="<?php echo $html_dir;?>listar_almox.php">
									Almoxarifados
								</a>
							</li>
							<li id="22">
								<a href="<?php echo $html_dir;?>cadastro_produto.php">
									Produtos
								</a>
							</li>
						</ul>
					</li>
					<li class="nav-parent nav-active">
						<a>
							<i class="fa fa-copy" aria-hidden="true"></i>
							<span>Memorando</span>
						</a>
						<ul class="nav nav-children">
							<li id="31">
								<a href="<?php echo $html_dir;?>memorando/listar_memorandos_ativos.php">
									 Caixa de Entrada
								</a>
							</li>
							<li id="32">
								<a href="<?php echo $html_dir;?>memorando/listar_memorandos_antigos.php">
									 Memorandos despachados
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
						<li id="41">
								<a href="<?php echo $html_dir;?>personalizacao.php">
									Editar Conteúdos
								</a>
							</li>
							<li id="42">
								<a href="<?php echo $html_dir;?>personalizacao_imagem.php">
									Lista de Imagens
								</a>
							</li>
							<li id="43">
								<a href="<?php echo $html_dir;?>atualizacao/atualizacao_sistema.php">
									Atualização e Backup
								</a>
							</li>
							<li id="44">
								<a href="<?php echo $html_dir;?>contribuicao/php/configuracao_doacao.php">
									Contribuição
								</a>
							</li>
							<li id="45">
								<a href="<?php echo $html_dir;?>editar_permissoes.php">
									Permissões
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
	</div>
	<form id="listarFuncionario" method="POST" action="<?php echo $html_dir;?>controle/control.php">
		<input type="hidden" name="nomeClasse" value="FuncionarioControle">
		<input type="hidden" name="metodo" value="listartodos">
		<input type="hidden" name="nextPage" value="<?php echo $html_dir;?>informacao_funcionario.php">
	</form>
	
	<form id="listarInterno" method="POST" action="<?php echo $html_dir;?>controle/control.php">
		<input type="hidden" name="nomeClasse" value="InternoControle">
		<input type="hidden" name="metodo" value="listartodos">
		<input type="hidden" name="nextPage" value="<?php echo $html_dir;?>informacao_interno.php">
	</form>
		
	<!-- Theme Base, Components and Settings -->
	<script src="<?php echo $html_dir;?>../assets/javascripts/theme.js"></script>
		
	<!-- Theme Custom -->
	<script src="<?php echo $html_dir;?>../assets/javascripts/theme.custom.js"></script>
	
	<!-- Theme Initialization Files -->
	<script src="<?php echo $html_dir;?>../assets/javascripts/theme.init.js"></script>
