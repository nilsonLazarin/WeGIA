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

session_start();
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
		<div class="nano-content" tabindex="0" style="right: -17px;display: flex;flex-direction: column;justify-content: space-between; padding-bottom: 0;">
			<nav id="menu" class="nav-main" role="navigation">
				<ul class="nav nav-main">
					<li>
						<a href="<?= WWW ?>html/home.php">
							<i class="fa fa-home" aria-hidden="true"></i>
							<span>Início</span>
						</a>
					</li>
					<li class="nav-parent nav-active">
						<a>
							<i class="far fa-address-book"></i>
							<span>Pessoas</span>
						</a>
						
						<ul class="nav nav-children">
							<li>

								<a>
								<i class="far fa-address-book"></i>
								<span>RH</span>
								</a>

							</li>

							<li>
								<a href="<?= WWW ?>html/cadastro_funcionario.php">
									 Cadastrar Funcionário
								</a>

							</li>
							<li>
								<a href="<?= WWW ?>controle/control.php?metodo=listarTodos&nomeClasse=FuncionarioControle&nextPage=<?= WWW ?>html/informacao_funcionario.php">
									 Informações Funcionários
								</a>
							</li>
							<li>

								<a>
								<i class="far fa-address-book"></i>
								<span>Atendidos</span>

								</a>
							</li>
							<li>
								<a href="<?= WWW ?>html/atendido/Cadastro_Atendido.php">
									 Cadastrar Atendido
								</a>
							</li>

							<li>
							<a href="<?= WWW ?>controle/control.php?metodo=listarTodos&nomeClasse=AtendidoControle&nextPage=<?= WWW ?>html/atendido/Informacao_Atendido.php">
									 Informações Atendido
								</a>
							</li>
						</ul>
					</li>

					<li class="nav-parent nav-active" id="2">
						<a>
							<i class="fa fa-copy" aria-hidden="true"></i>
							<span>Material e Patrimônio</span>
						</a>
						<ul class="nav nav-children">
							<li id="23">
								<a href="<?= WWW ?>html/cadastro_entrada.php">
									Entrada
								</a>
							</li>
							<li id="25">
								<a href="<?= WWW ?>html/cadastro_saida.php">
									Saida
								</a>
							</li>
							<li id="24">
								<a href="<?= WWW ?>html/estoque.php">
									Estoque
								</a>
							</li>
							<li id="21">
								<a href="<?= WWW ?>html/listar_almox.php">
									Almoxarifados
								</a>
							</li>
							<li id="22">
								<a href="<?= WWW ?>html/cadastro_produto.php">
									Produtos
								</a>
							</li>
							<li id="26">
								<a href="<?= WWW ?>html/relatorio.php">
									Relatórios
								</a>
							</li>
							<li id="21">
								<a href="<?= WWW ?>html/listar_entrada.php">
									Informações Entrada
								</a>
							</li>
							<li id="22">
								<a href="<?= WWW ?>html/listar_saida.php">
									Informações Saída
								</a>
							</li>
							<li id="26">
								<a href="<?= WWW ?>html/adicionar_almoxarifado.php">
									Adicionar Almoxarifado
								</a>
							</li>
						</ul>
					</li>
					<li class="nav-parent nav-active">
						<a>
							<i class="fa fa-book" aria-hidden="true"></i>
							<span>Memorando</span>
						</a>
						<ul class="nav nav-children">
							<li id="31">
								<a href="<?= WWW ?>html/memorando/listar_memorandos_ativos.php">
									 Caixa de Entrada
									 
								</a>
							</li>

							<li id="31">
								<a href="<?= WWW ?>html/memorando/novo_memorandoo.php">
									 Criar Memorando
								</a>
							</li>

							<li id="32">
								<a href="<?= WWW ?>html/memorando/listar_memorandos_antigos.php">
									 Memorandos despachados
								</a>
							</li>
						</ul>
					</li>
					<li class="nav-parent nav-active">
						<a>
							<i class="fa fa-users" aria-hidden="true"></i>
							<span>Sócios</span>
						</a>
						<ul class="nav nav-children">
							<li id="31">
								<a href="<?= WWW ?>html/socio/">
									 Lista de sócios
								</a>
								<a href="<?= WWW ?>html/socio/sistema/psocio_geracao.php">
									 Gerar carnê/boleto para sócio
								</a>
								<a href="<?= WWW ?>html/socio/sistema/cobrancas.php">
									 Cobranças
								</a>
								<a href="<?= WWW ?>html/socio/sistema/tags.php">
									 Tags (grupos)
								</a>
								<a href="<?= WWW ?>html/socio/sistema/relatorios_socios.php">
									 Relatórios Sócios
								</a>
							</li>
						</ul>
					</li>
					<li class="nav-parent nav-active">
						<a>
							<i class="fa fa-ambulance" aria-hidden="true"></i>
							<span>Saúde</span>
						</a>
						<ul class="nav nav-children">
							<li id="31">
								<a href="<?= WWW ?>html/saude/cadastro_ficha_medica.php">
									 Cadastrar ficha médica
								</a>
								<a href="<?= WWW ?>html/saude/profile_paciente.php">
									 Informações do paciente
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
								<a href="<?= WWW ?>html/personalizacao.php">
									Editar Conteúdo
								</a>
							</li>
							<li id="42">
								<a href="<?= WWW ?>html/personalizacao_imagem.php">
									Lista de Imagens
								</a>
							</li>
							<li id="43">
								<a href="<?= WWW ?>html/configuracao/configuracao_geral.php">
									Configurações Gerais
								</a>
							</li>
							<li id="44">
								<a href="<?= WWW ?>html/contribuicao/php/configuracao_doacao.php">
									Contribuição
								</a>
							</li>
							<li id="45">
								<a href="<?= WWW ?>html/geral/editar_permissoes.php">
									Permissões
								</a>
							</li>
							<li id="47">
								<a href="<?= WWW ?>html/geral/cargos.php">
									Cargos
								</a>
							</li>
							<li id="46">
								<a href="<?= WWW ?>html/configuracao/debug_info.php">
									Informações de debug
								</a>
							</li>
						</ul>
					</li>
					<li id="5">
						<a href="<?= WWW ?>manual/index.php">
							<i class="fas fa-book" aria-hidden="true"></i>
							<span>Manual</span>
						</a>
					</li>
				</ul>
			</nav>
			<p style="text-align: center;"><?= "Release instalada:<br> ".$_SESSION['local_release']?></p>
		</div>
	</div>
	<form id="listarFuncionario" method="POST" action="<?= WWW ?>controle/control.php">
		<input type="hidden" name="nomeClasse" value="FuncionarioControle">
		<input type="hidden" name="metodo" value="listartodos">
		<input type="hidden" name="nextPage" value="<?= WWW ?>html/informacao_funcionario.php">
	</form>
	
	<form id="listarAtendido" method="POST" action="<?= WWW ?>controle/control.php">
		<input type="hidden" name="nomeClasse" value="AtendidoControle">
		<input type="hidden" name="metodo" value="listartodos">
		<input type="hidden" name="nextPage" value="<?= WWW ?>html/Informacao_Atendido.php">
	</form>
		
	<!-- Theme Base, Components and Settings -->
	<script src="<?= WWW ?>assets/javascripts/theme.js"></script>
		
	<!-- Theme Custom -->
	<script src="<?= WWW ?>assets/javascripts/theme.custom.js"></script>
	
	<!-- Theme Initialization Files -->
	<script src="<?= WWW ?>assets/javascripts/theme.init.js"></script>

