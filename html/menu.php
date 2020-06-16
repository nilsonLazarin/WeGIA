<?php
$config_path = "config.php";
if(file_exists($config_path)){
require_once($config_path);
}else{
while(true){
$config_path = "../" . $config_path;
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
						<a href="<?php echo WWW;?>html/home.php">
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
								<a href="<?php echo WWW;?>html/cadastro_funcionario.php">
									 Cadastrar Funcionário
								</a>
							</li>
							<li>
								<a href="<?php echo WWW;?>html/cadastro_interno.php">
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
								<a href="<?php echo WWW;?>controle/control.php?metodo=listarTodos&nomeClasse=FuncionarioControle&nextPage=<?php echo WWW;?>html/informacao_funcionario.php">
									 Informações Funcionários
								</a>
							</li>
							<li>
								<a href="<?php echo WWW;?>controle/control.php?metodo=listarTodos&nomeClasse=InternoControle&nextPage=<?php echo WWW;?>html/informacao_interno.php">
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
								<a href="<?php echo WWW;?>html/cadastro_entrada.php">
									 Cadastrar Produtos
								</a>
							</li>
							<li>
								<a href="<?php echo WWW;?>html/cadastro_saida.php">
									 Saida de Produtos
								</a>
							</li>
							<li>
								<a href="<?php echo WWW;?>html/estoque.php">
									 Estoque
								</a>
							</li>
							<li>
								<a href="<?php echo WWW;?>html/listar_almox.php">
									 Almoxarifados
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
							<li>
								<a href="<?php echo WWW;?>html/memorando/listar_memorandos_ativos.php">
									 Caixa de Entrada
								</a>
							</li>
							<li>
								<a href="<?php echo WWW;?>html/memorando/listar_memorandos_antigos.php">
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
							<li>
								<a href="<?php echo WWW;?>html/personalizacao.php">
									Editar Conteúdos
								</a>
							</li>
							<li>
								<a href="<?php echo WWW;?>html/personalizacao_imagem.php">
									Lista de Imagens
								</a>
							</li>
							<li>
								<a href="<?php echo WWW;?>html/atualizacao_sistema.php">
									Atualização e Backup
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
	</div>
	<form id="listarFuncionario" method="POST" action="<?php echo WWW;?>controle/control.php">
		<input type="hidden" name="nomeClasse" value="FuncionarioControle">
		<input type="hidden" name="metodo" value="listartodos">
		<input type="hidden" name="nextPage" value="<?php echo WWW;?>html/informacao_funcionario.php">
	</form>
	
	<form id="listarInterno" method="POST" action="<?php echo WWW;?>controle/control.php">
		<input type="hidden" name="nomeClasse" value="InternoControle">
		<input type="hidden" name="metodo" value="listartodos">
		<input type="hidden" name="nextPage" value="<?php echo WWW;?>html/informacao_interno.php">
	</form>
		
	<!-- Theme Base, Components and Settings -->
	<script src="<?php echo WWW;?>assets/javascripts/theme.js"></script>
		
	<!-- Theme Custom -->
	<script src="<?php echo WWW;?>assets/javascripts/theme.custom.js"></script>
	
	<!-- Theme Initialization Files -->
	<script src="<?php echo WWW;?>assets/javascripts/theme.init.js"></script>
