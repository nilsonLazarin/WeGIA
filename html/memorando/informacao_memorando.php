<!DOCTYPE html>
<html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
<style>
table {
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid black;
}
th {
    text-align: left;
}
th, td {
    padding: 15px;
    text-align: left;
}
tr:hover {background-color: #C1CDCD;}
</style>
<body>
	<h1>Meus memorandos</h1>
	<h2></h2>
	<br>
	<br>
	<form id="formularioId">
	<p>Observação:Preencha os dados e clique em editar na tabela.</p>
		Titulo:<input type="text" id="nome" >
		Data: <input type="text" id="uf">
		Status Memorando: <input type="text" id="renda">
		<button type="button" id="criarId" >Novo Memorando</button>
	

		<?php 
			require_once '../../dao/Conexao.php';
			$pdo=Conexao :: connect();
				session_start();
			if(!isset($_SESSION['usuario'])){
				header ("Location: ../../index.php");
			}
			/* $id = $_POST['id_pessoa']; */
			$busca=$pdo->query("SELECT * FROM memorando WHERE id_pessoa='$id'");
			?>
 
 <!--
$descricao = $dado['descricao'];
$valor = $dado['valor_unitario'];
 
echo "Descrição: ".$descricao. " Valor: ".$valor;
	-->
	<br>
	<br>

	
<br><br>
	<!--<button type="button" id=tabela>Tabela de Clientes</button> --> 
<br><br>
	Resultado:<br>
	<p id="listaCliente" ></p>
	<!-- Pagination -->
  <div class="w3-center w3-padding-32"> 
    <div class="w3-bar">
       <a href="index.html" class="w3-bar-item w3-button w3-hover-black">«</a>
       <a href="index.html" class="w3-bar-item w3-button w3-hover-black">1</a>
       <a href="clienteTabela.html" class="w3-bar-item w3-black w3-button">2</a>
       <a href="produtoTabela.html" class="w3-bar-item w3-button w3-hover-black">3</a>
      <a href="produtoTabela.html" class="w3-bar-item w3-button w3-hover-black">»</a>
      </div>
  </div>
<script>
	var url="httpEndereço";
	$(document).ready(function(){
		$("#tabela").click(function(){

			$.get("https://clienteweb2017.000webhostapp.com/crud_ajax_json/getDadosClientes.php")
				.done(function(data,status){
				var obj = JSON.parse(data);
				console.log(obj);
				montarTabela(obj);
		
				})
			
				.fail(function(){
				alert("Problema de conexão");
				});
		
		
		});
function montarTabela(obj){
  var i;  
 
  var table="<table border=1  style=border-collapse:'collapse';><tr><th>Id</th><th>Nome</th><th>uf</th><th>Renda Mensal</th><th>editar</th><th>remover</th></tr>";
  


  for (n of obj.data) { 
    table += "<tr><td>" + n.id +"</td><td>" +n.nome +
	"</td><td>" + n.uf +"</td><td>" + n.rendamensal+"</td><td><a href='#'class='atualizar'>editar</a></td><td><a href='#'class='excluir'>remover</a></td></tr>";
  }
  $("#listaCliente").html(table);
  }
    
   $("body").on("click", ".atualizar",function(){
		var id=$(this).parent().siblings(0).html();
		var nome=$("#nome").val();
		var uf=$("#uf").val();
		var renda=$("#renda").val();
		$.get("https://clienteweb2017.000webhostapp.com/crud_ajax_json/updateCliente.php?id="+id+"&nome="+nome+"&uf="+uf+"&rendamensal="+renda)
		.done(function(){
			alert("Editado!!!");
			})
			
		.fail(function(){
		alert("Problema de conexão");
		});
   });
  
  $("body").on("click", "#criarId",function(){
		var nome=$("#nome").val();
		var uf=$("#uf").val();
		var renda=$("#renda").val();
		
		
		$.get("https://clienteweb2017.000webhostapp.com/crud_ajax_json/createCliente.php?nome="+nome+"&uf="+uf+"&rendamensal="+renda)
		.done(function(){
			
			alert("Inserido!!!");
			})
			
		.fail(function(){
		alert("Problema de conexão");
		});
  
  });
  
  $("body").on("click", ".excluir",function(){
	
		var Cid=$(this).parent().siblings(0).html();
		$.get("https://clienteweb2017.000webhostapp.com/crud_ajax_json/deleteCliente.php?id="+Cid)
		.done(function(){
			alert("Removido!!!");
			})
			
		.fail(function(){
		alert("Problema de conexão");
		});
   });
   
  });//Fim da Ready
  
</script>
</body>
</html>