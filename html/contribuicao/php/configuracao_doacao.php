<?php
    require_once('conexao.php');
    $banco = new Conexao;
    include('dadosConfig.php');

ini_set('display_errors', 0);
ini_set('display_startup_erros', 0);

	session_start();
	if(!isset($_SESSION['usuario'])){
		header ("Location: ../../../index.php");
    }
?>
<!DOCTYPE html>
<html class="fixed">
    <head>
        <meta charset="UTF-8">
        <title>Configuração Contribuição</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="stylesheet" href="../../../assets/vendor/bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" href="../../../assets/vendor/font-awesome/css/font-awesome.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
        <link rel="stylesheet" href="../../../assets/vendor/magnific-popup/magnific-popup.css" />
        <link rel="stylesheet" href="../../../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
        <link rel="stylesheet" href="../../../assets/stylesheets/theme.css" />
        <link rel="stylesheet" href="../../../assets/stylesheets/skins/default.css" />
        <link rel="stylesheet" href="../../../assets/stylesheets/theme-custom.css">
        <script src="../../../assets/vendor/modernizr/modernizr.js"></script>
        <link rel="stylesheet" href="../../../css/personalizacao-theme.css" />
        <link rel="stylesheet" type="text/css" href="../outros/css/config.css">
        <script src="../../../assets/vendor/jquery/jquery.min.js"></script>
        <script src="../../../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
        <script src="../../../assets/vendor/bootstrap/js/bootstrap.js"></script>
        <script src="../../../assets/vendor/nanoscroller/nanoscroller.js"></script>
        <script src="../../../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script src="../../../assets/vendor/magnific-popup/magnific-popup.js"></script>
        <script src="../../../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
        <script src="../../../assets/vendor/jquery-autosize/jquery.autosize.js"></script>
        <script src="../../../assets/javascripts/theme.js"></script>
        <script src="../../../assets/javascripts/theme.custom.js"></script>  
        <script src="../../../assets/javascripts/theme.init.js"></script>
       
        <script type="text/javascript" src="../js/transicoes.js"></script>

    </head>
    <style>
        .alerta_pay, .alerta_pag, .alerta_bol
        {
            padding: 2%;
            border: 1px solid gray;
            border-radius: 3px;
            margin: 10px;
            font-size: 15px;
            border-color: #e8273b;
            color: black;
            background-color: rgb(237, 85, 101);
            opacity: 60%;
        }
        a:hover{
				color: white;
				text-decoration:none;
			}
		a{ 
				font-weight: normal;	
				color: white;

			}
    </style>

    <body>

    <section class="body">
        <div id="header"></div>
        <div class="inner-wrapper">
			
            <aside id="sidebar-left" class="sidebar-left menuu"></aside>
            <section role="main" class="content-body">
            <header class="page-header">
					<h2>Configuração de Contribuição</h2>
					<div class="right-wrapper pull-right">
						<ol class="breadcrumbs">
							<li>
								<a href="../../home.php">
									<i class="fa fa-home"></i>
								</a>
							</li>
							<li><span>Páginas</span></li>
							<li><span>Configuração Contribuição</span></li>
						</ol>
						<a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
					</div>
            </header>
            <div class="row">
                <div class="col-md-4 col-lg-2"></div>
                <div class="col-md-8 col-lg-8">
                    <div id='foo'>Dados atualizados com sucesso!</div>
                    
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
							<li class="nav-item active">
								<a class="nav-link active" id="boletofacil" data-toggle="tab" href="#img-tab" role="tab" aria-controls="img" aria-selected="true">BOLETOFACIL</a>
							</li>
                            <li class="nav-item">
								<a class="nav-link" id="pagseguro" data-toggle="tab" href="#img-tab" role="tab" aria-controls="img" aria-selected="false">PAGSEGURO</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="paypal" data-toggle="tab" href="#img-tab" role="tab" aria-controls="img" aria-selected="false">PAYPAL</a>
							</li>
                        </ul>
                        <div class="tab-content" id="myTabContent" width = "50%">
                        <div class='alerta_pay'>Faltam dados para o sistema selecionado :(</div>
                            <div id='divpaypal'>
                                <form action="dadosCartao.php?idSistema=<?php echo $sistemas[2];?>&dados=<?php echo $linhaspaypal;?>" method='POST' id="form2" name="PAYPAL">
                                    <input type='hidden' id="dadoPay" value='<?php echo $linhaspaypal;?>'>
                                    <div class="tab-pane active" id="img-tab" role="tabpanel" aria-labelledby="img-tab">
                                        <table class="table table-bordered mb-none">
                                            <h3>DOAÇÃO AVULSA</h3>
                                            <br>
                                            <tr>
                                                <th>LINK</th>
                                            </tr>
                                            <tr>
                                                <td><input type='text' class="form-control" readonly= 'true' id='avulso' name='avulso' value="<?php echo$linkAvulsoPay; ?>"></td>
                                            </tr>
                                        </table>
                                            <h3>DOAÇÃO MENSAL</h3>
                                            <br>
                                            <div id='doacao_mensal'>
                                                <table class="table table-bordered mb-none">
                                                    <tr>
                                                        <th>VALOR</th><th>LINK</th><th>DELETAR</th>
                                                    </tr>
                                                    <?php
                                                        if($linhaspaypal == 0){
                                                            echo"<tr>";
                                                            echo"<td><input type='number' class='form-control' readonly='true' name='valor_extra' id='valor_extra' value=></td>";
                                                            echo"<td><input type='text' class='form-control' readonly='true' name='link_extra' id='link_extra' value= ></td>";
                                                            echo("<td><button class= 'btn btn-danger'><a class='fas fa-trash-alt icon'></button></td>");
                                                            echo"</tr>";
                                                         
                                                     
                                                        }  
                                                        else{
                                                            echo"<tr>";
                                                            echo("<td><input type='number' name='valores[]' readonly= 'true' class='form-control' value=".$dadosiniciais['valor']."></td>");
                                                            echo("<td><input type='text' class='form-control' readonly='true' name='link_doacao[]' value=".$dadosiniciais['link']."></td>"); 
                                                            echo("<td><button class= 'btn btn-danger'><a href = 'deleteValor.php?idValor=$dadosiniciais[id]&idSistema=$sistemas[2]' type='button' class='fas fa-trash-alt icon'></button></td>");
                                                            echo("<input type='hidden' name='id[]' value=".$dadosiniciais['id'].">");
                                                            echo"</tr>";
                                                            foreach($dadospaypal as $dados)
                                                            {
                                                                echo"<tr>";
                                                                echo("<td><input type='number' name='valores[]' readonly= 'true' class='form-control' value=".$dados['valor']."></td>");
                                                                echo("<td><input type='text' class='form-control' readonly='true' name='link_doacao[]' value=".$dados['link']."></td>"); 
                                                                echo("<td><button class= 'btn btn-danger'><a href = 'deleteValor.php?idValor=$dados[id]&idSistema=$sistemas[2]' type='button' class='fas fa-trash-alt icon'></button></td>");
                                                                echo("<input type='hidden' name='id[]' value=".$dados['id'].">");
                                                                echo"</tr>";
                                                            }
                                                        
                                                            echo"<tr>";
                                                            echo"<td><input type='number' class='form-control' readonly='true' name='valor_extra' id='valor_extra' value=></td>";
                                                            echo"<td><input type='text' class='form-control' readonly='true' name='link_extra' id='link_extra' value= ></td>";
                                                            echo"</tr>";
                                                        }     
                                                    ?> 
                                                </table>
                                            </div>
                                            <br><br>
                                        <input type="button" class= "btn btn-primary" id="editar-pay" value="Editar">
                                        <input type="submit" class="btn btn-primary" id="btn-card-pay" value='Salvar'>
                                        <a href="../index.php"><input type="button" class="btn btn-primary" value="Ir à Página de Contribuição"></a>
                                    </div>
                                </form>
                            </div>
                            <div id='divboleto'> 
                            <div class='alerta_bol'>Faltam dados para o sistema selecionado :(</div>
                                <form action="dadosBoleto.php?idSistema=<?php echo $sistemas[0];?>&idRegras=<?php echo $dadosBoleto['id_regras']; ?>&dados=<?php echo $linhasboleto; ?>" method = "POST" id="form1" name="BOLETO">
                                    <input type='hidden' id="dadoBol" value='<?php echo $linhasboleto;?>'>
                                    <div class="tab-pane active" id="img-tab" role="tabpanel" aria-labelledby="img-tab">
                                        <table class="table table-bordered mb-none">
                                            <!--table class="table table-hover"-->
                                            <thead>
                                                <h3>Regras Para Doação</h3>
                                                <br>
                                                <tr style= "width: 50px;">
                                                    <th scope="col" width="5%">Valor Mínimo Boleto Único</th>
                                                    <th scope="col" width="5%">Valor Mínimo Doação Mensal</th>
                                                    <th scope="col" width="5%">Valor Máximo Doação Mensal:</th>
                                                </tr>
                                                <tr>
                                                    <td><input id='minval' class="form-control" type='number'  name='minval' autocomplete="on" size="10" readonly='true' value="<?php echo$valMinUni; ?>"></td>
                                                    <td><input type='number' class="form-control" name='minvalparc' id='minvalparc' value="<?php echo $valMinParc; ?>"></td>
                                                    <td><input type='number' class="form-control"name='maivalparc' id='maivalparc' value="<?php echo$valMaxParc;?>"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="col">Pagamento Após vencimento Boleto Único:</th>
                                                    <th scope="col">Pagamento Após Vencimento Doação Mensal:</th>
                                                    <th scope="col">Juros:</th>
                                                </tr>
                                                <tr>
                                                    <td><input type='text' class="form-control" name='unicdiasv' id='unicdiasv' value="<?php echo $carenciaUni; ?>"></td>
                                                    <td><input type='text' class="form-control" name='mensaldiasv' id='mensaldiasv' value="<?php echo $carenciaMen; ?>"></td>
                                                    <td><input type='text' class="form-control" name='juros' id='juros' value="<?php echo $juros; ?>"></td>
                                                </tr>
                                                <tr>
                                                    <th>Multa:</th>
                                                    <th>Agradecimentos</th>
                                                </tr>
                                                <tr>
                                                    <td><input type='number' class="form-control" name='multa' id='multa' value="<?php echo $multa; ?>"></td>
                                                    <td><textarea name='agradecimento' class="form-control" cols='18'  id='agradecimento'><?php echo $agradecimento; ?></textarea></td>
                                                </tr>
                                            <thead>
                                        </table>
                                        <!--table class="table table-hover"-->
                                        <table class="table table-bordered mb-none">
                                            <thead>
                                                <h3>Datas de Vencimento Para Boleto Mensal</h3>
                                                <br>
                                                <tr>
                                                    <th scope="col" width="5%">opção 1</th>
                                                    <th scope="col" width="5%">opção 2</th>
                                                    <th scope="col" width="5%">opcão 3</th>
                                                </tr>
                                                <tr>
                                                    <td><input type='number' class="form-control" name='op01' id='op01' value="<?php echo $op1; ?>"></td>
                                                    <td><input type='number' class="form-control" name='op02' id='op02' value="<?php echo $op2; ?>"></td>
                                                    <td><input type='number' class="form-control" name='op03' id='op03' value="<?php echo $op3; ?>"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="col" width="5%">opção 4</th>
                                                    <th scope="col" width="5%">opção 5</th>
                                                    <th scope="col" width="5%">opção 6</th>
                                                </tr>
                                                <tr>
                                                    <td><input type='number' class="form-control" name='op04' id='op04' value="<?php echo $op4; ?>"></td>
                                                    <td><input type='number' class="form-control" name='op05' id='op05' value="<?php echo $op5; ?>"></td>
                                                    <td><input type='number' class="form-control" name='op06' id='op06' value="<?php echo $op6; ?>"></td>
                                                </tr>
                                            </thead>
                                        </table>
                                        <!--table class="table table-hover"-->
                                        <table class="table table-bordered mb-none">
                                            <h3>Configuração de Sistema</h3>
                                            <br>
                                                <tr>
                                                    <th scope="col" width="5%">Link API</th>
                                                    <th scope="col" width="5%">TOKEN API</th>
                                                    
                                                </tr>
                                                <tr>
                                                    <td><input type='text' class="form-control" name='api' id='api' value="<?php echo $api ?>"></td>
                                                    <td><input type='text' class="form-control" name='token_api' id='token_api' value="<?php echo $token; ?>"></td>
                                                    
                                                </tr>
                                                
                                        </table>
                                
                                        <input type='button' class="btn btn-primary" id="editar-bol" value="Editar">
                                        <input type='submit' class="btn btn-primary" id="btn-bol" value='Salvar'>
                                        <a href="../index.php"><input type="button" class="btn btn-primary" value="Ir à Página de Contribuição"></a>
                                    </div>
                                    
                                </form> 
                            </div> 
                            <div id='divpagseguro'>
                            <div class='alerta_pag'>Faltam dados para o sistema selecionado :(</div>
                                <form action="dadosCartao.php?idSistema=<?php echo $sistemas[1];?>&dados=<?php echo $linhaspagseguro;?>" method='POST' id="form2" name="PAGSEGURO">
                                    <input type='hidden' id="dadoPag" value='<?php echo $linhaspagseguro;?>'>
                                    <div class="tab-pane active" id="img-tab" role="tabpanel" aria-labelledby="img-tab">
                                        <table class="table table-bordered mb-none">
                                            <h3>DOAÇÃO AVULSA</h3>
                                            <br>
                                            <tr>
                                                <th>LINK</th>
                                            </tr>
                                            <tr>
                                                <td><input type='text' class="form-control" readonly= 'true' id='avulso' name='avulso' value="<?php echo$linkAvulsoPag;?>"></td>
                                            </tr>
                                        </table>
                                        <h3>DOAÇÃO MENSAL</h3>
                                        <br>
                                        <div id='doacao_mensal'>
                                                <table class="table table-bordered mb-none">
                                                    <tr>
                                                        <th>VALOR</th><th>LINK</th><th>DELETAR</th>
                                                    </tr>
                                                    <?php
                                                        if($linhaspagseguro == 0){
                                                            
                                                            echo"<tr>";
                                                            echo"<td><input type='number' class='form-control' readonly='true' name='valor_extra' id='valor_extra' value=></td>";
                                                            echo"<td><input type='text' class='form-control' readonly='true' name='link_extra' id='link_extra' value= ></td>";
                                                            echo("<td><button class= 'btn btn-danger'><a class='fas fa-trash-alt icon'></button></td>");
                                                            echo"</tr>";
                                                         
                                                     
                                                        }  
                                                        else{
                                                            
                                                            echo"<tr>";
                                                            echo("<td><input type='number' name='valores[]' readonly= 'true' class='form-control' value=".$dadoinicial['valor']."></td>");
                                                            echo("<td><input type='text' class='form-control' readonly='true' name='link_doacao[]' value=".$dadoinicial['link']."></td>"); 
                                                            echo("<td><button class= 'btn btn-danger'><a href = 'deleteValor.php?idValor=$dadoinicial[id]&idSistema=$sistemas[1]' type='button' class='fas fa-trash-alt icon'></button></td>");
                                                            echo("<input type='hidden' name='id[]' value=".$dadoinicial['id'].">");
                                                            echo"</tr>";
                                                            foreach($dadospagseguro as $dados)
                                                            {
                                                                echo"<tr>";
                                                                echo("<td><input type='number' name='valores[]' readonly= 'true' class='form-control' value=".$dados['valor']."></td>");
                                                                echo("<td><input type='text' class='form-control' readonly='true' name='link_doacao[]' value=".$dados['link']."></td>"); 
                                                                echo("<td><button class= 'btn btn-danger'><a href = 'deleteValor.php?idValor=$dados[id]&idSistema=$sistemas[1]' type='button' class='fas fa-trash-alt icon'></button></td>");
                                                                echo("<input type='hidden' name='id[]' value=".$dados['id'].">");
                                                                echo"</tr>";
                                                            }
                                                        
                                                            echo"<tr>";
                                                            echo"<td><input type='number' class='form-control' readonly='true' name='valor_extra' id='valor_extra' value=></td>";
                                                            echo"<td><input type='text' class='form-control' readonly='true' name='link_extra' id='link_extra' value= ></td>";
                                                            echo"</tr>";
                                                        }     
                                                    ?> 
                                                </table>
                                            </div>
                                            <br><br>
                                        <input type="button" class= "btn btn-primary" id="editar-pag" value="Editar">
                                        <input type="submit" class="btn btn-primary" id="btn-card-pag" value='Salvar'>
                                        <a href="../index.php"><input type="button" class="btn btn-primary" value="Ir à Página de Contribuição"></a>  
                                    </div> 
                                </form>
                            </div>     
                        </div>
                </div>
            </div>
        </section>
    </section>
    </body>
    <script>
        $(document).ready(function() 
        {   
            atualiza();
        });
	
    </script>
</html>