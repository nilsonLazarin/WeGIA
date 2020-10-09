<?php
require_once('conexao.php');
$banco = new Conexao();

	session_start();
	if(!isset($_SESSION['usuario'])){
		header ("Location: ../../../index.php");
    }
$sistemas = [];

    $banco->querydados("SELECT id FROM sistema_pagamento WHERE nome_sistema= 'BOLETOFACIL'");
    $dados = $banco->result();
    $sistemas[0] = $dados['id'];
    
    $banco->querydados("SELECT id FROM sistema_pagamento WHERE nome_sistema= 'PAGSEGURO'");
    $dados = $banco->result();
    $sistemas[1] = $dados['id'];
        
    $banco->querydados("SELECT id FROM sistema_pagamento WHERE nome_sistema= 'PAYPAL'");
    $dados = $banco->result();
    $sistemas[2] = $dados['id'];
        

//dados do boleto...

    $banco->querydados("SELECT * FROM doacao_boleto_regras as regras JOIN doacao_boleto_info as info ON (info.id_regras = regras.id) WHERE info.id_sistema = '$sistemas[0]'");
    $linhasboleto = $banco->rows();
    $dadosBoleto = $banco->result();
        if($linhasboleto != 0)
        {
            $valMinUni = $dadosBoleto['min_boleto_uni'];
            $valMinParc = $dadosBoleto['min_parcela'];
            $valMaxParc = $dadosBoleto['max_parcela']; 
            $carenciaUni = $dadosBoleto['dias_boleto_a_vista'];
            $carenciaMen = $dadosBoleto['max_dias_venc'];
            $juros = $dadosBoleto['juros'];
            $multa = $dadosBoleto['multa'];
            $agradecimento = $dadosBoleto['agradecimento'];
            $op1 =  $dadosBoleto['dias_venc_carne_op1'];
            $op2 = $dadosBoleto['dias_venc_carne_op2'];
            $op3 = $dadosBoleto['dias_venc_carne_op3'];
            $op4 =  $dadosBoleto['dias_venc_carne_op4'];
            $op5 = $dadosBoleto['dias_venc_carne_op5'];
            $op6 = $dadosBoleto['dias_venc_carne_op6'];
            $api =  $dadosBoleto['api'];
            $token = $dadosBoleto['token_api'];
            $sandbox = $dadosBoleto['sandbox'];
            $tokenSand = $dadosBoleto['token_sandbox'];
        }else{
            $valMinUni = '';
            $valMinParc = '';
            $valMaxParc = '';
            $carenciaUni = '';
            $carenciaMen = '';
            $juros = '';
            $multa = '';
            $agradecimento = '';
            $op1 =  '';
            $op2 = '';
            $op3 ='';
            $op4 =  '';
            $op5 ='';
            $op6 = '';
            $api =  '';
            $token = '';
            $sandbox = '';
            $tokenSand = '';
        }
    
// dados do cartao paypal... 
    $banco->querydados("SELECT * FROM doacao_cartao_mensal WHERE id_sistema = $sistemas[2]");
    $dadosiniciais = $banco->result();
    $dadospaypal = $banco->arraydados();
    $linhaspaypal = $banco->rows();

    $banco->querydados("SELECT url FROM doacao_cartao_avulso WHERE id_sistema = $sistemas[2]");
    $linhaspaypal = $linhaspaypal + $banco->rows();
    $linkAvulso = $banco->result();
    $linkAvulsoPay = $linkAvulso['url'];

// dados do cartao pagseguro...  
    $banco->querydados("SELECT * FROM doacao_cartao_mensal WHERE id_sistema = $sistemas[1]");
    $dadoinicial = $banco->result();
    $dadospagseguro = $banco->arraydados();
    $linhaspagseguro = $banco->rows();

    $banco->querydados("SELECT url FROM doacao_cartao_avulso WHERE id_sistema = $sistemas[1]");
    $linhaspagseguro = $linhaspagseguro + $banco->rows();
    $linkAvulsoResult = $banco->result();
    $linkAvulsoPag = $linkAvulsoResult['url'];


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
        <script type="text/javascript" src="../js/preenche_dados.js"></script>
        <script type="text/javascript" src="../js/id_sistema.js"></script>
        <script type="text/javascript" src="../js/transicoes.js"></script>

    </head>
    <style>
        .alerta
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
                    <div class='alerta'>Faltam dados para o sistema selecionado :(</div>
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
                            <div id='divpaypal'>
                                <form action="dadosCartao.php?idSistema=<?php echo $sistemas[2];?>&dados=<?php echo $linhaspaypal;?>" method='POST' id="form2" name="PAYPAL">
                                    <input type='hidden' id="dadopay" value='<?php echo $linhaspaypal;?>'>
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
                                                        <th>VALOR</th><th>LINK</th>
                                                    </tr>
                                                    <?php
                                                        if($linhaspaypal == 0){
                                                            echo"<tr>";
                                                            echo"<td><input type='number' class='form-control' readonly='true' name='valor_extra' id='valor_extra' value=></td>";
                                                            echo"<td><input type='text' class='form-control' readonly='true' name='link_extra' id='link_extra' value= ></td>";
                                                            echo"</tr>";
                                                        } 
                                                        else{
                                                            echo"<tr>";
                                                            echo("<td><input type='number' name='valores[]' readonly= 'true' class='form-control' value=".$dadosiniciais['valor']."></td>");
                                                            echo("<td><input type='text' class='form-control' readonly='true' name='link_doacao[]' value=".$dadosiniciais['link']."></td>"); 
                                                            echo("<input type='hidden' name='id[]' value=".$dadosiniciais['id'].">");
                                                            echo"</tr>";
                                                            foreach($dadospaypal as $dados)
                                                            {
                                                                echo"<tr>";
                                                                echo("<td><input type='number' name='valores[]' readonly= 'true' class='form-control' value=".$dados['valor']."></td>");
                                                                echo("<td><input type='text' class='form-control' readonly='true' name='link_doacao[]' value=".$dados['link']."></td>"); 
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
                                <form action="dadosBoleto.php?idSistema=<?php echo $sistemas[0];?>$idRegras=<?php echo $dadosBoleto['id_regras']; ?>&dados=<?php echo $linhasboleto; ?>" method = "POST" id="form1" name="BOLETO">
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
                                                    <th scope="col" width="5%">Link SANDBOX</th>
                                                </tr>
                                                <tr>
                                                    <td><input type='text' class="form-control" name='api' id='api' value="<?php echo $api ?>"></td>
                                                    <td><input type='text' class="form-control" name='token_api' id='token_api' value="<?php echo $token; ?>"></td>
                                                    <td><input type='text' class="form-control" name='sandbox' id='sandbox' value="<?php echo $sandbox; ?>"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="col" width="5%">TOKEN SANDBOX</th>
                                                </tr>
                                                <tr>
                                                    <td><input type='text' class="form-control" name='token_sandbox' id='token_sandbox' value="<?php echo $tokenSand;  ?>"></td>
                                                </tr>
                                        </table>
                                
                                        <input type='button' class="btn btn-primary" id="editar-bol" value="Editar">
                                        <input type='submit' class="btn btn-primary" id="btn-bol" value='Salvar'>
                                        <a href="../index.php"><input type="button" class="btn btn-primary" value="Ir à Página de Contribuição"></a>
                                    </div>
                                    
                                </form> 
                            </div> 
                            <div id='divpagseguro'>
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
                                                        <th>VALOR</th><th>LINK</th>
                                                    </tr>
                                                    <?php
                                                        if($linhaspagseguro == 0){
                                                            echo"<tr>";
                                                            echo"<td><input type='number' class='form-control' readonly='true' name='valor_extra' id='valor_extra' value=></td>";
                                                            echo"<td><input type='text' class='form-control' readonly='true' name='link_extra' id='link_extra' value= ></td>";
                                                            echo"</tr>";
                                                        } 
                                                        else{
                                                            echo"<tr>";
                                                            echo("<td><input type='number' name='valores[]' readonly= 'true' class='form-control' value=".$dadosiniciais['valor']."></td>");
                                                            echo("<td><input type='text' class='form-control' readonly='true' name='link_doacao[]' value=".$dadosiniciais['link']."></td>"); 
                                                            echo("<input type='hidden' name='id[]' value=".$dadosiniciais['id'].">");
                                                            echo"</tr>";
                                                            foreach($dadospaypal as $dados)
                                                            {
                                                                echo"<tr>";
                                                                echo("<td><input type='number' name='valores[]' readonly= 'true' class='form-control' value=".$dados['valor']."></td>");
                                                                echo("<td><input type='text' class='form-control' readonly='true' name='link_doacao[]' value=".$dados['link']."></td>"); 
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