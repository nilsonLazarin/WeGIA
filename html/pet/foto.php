<?php
$dao = 'dao/Conexao.php';
if( file_exists($dao)){
    require $dao;
}else{
    while(true){
        $dao = '../'.$dao;
        if( file_exists($dao)){
            break;
        }
    }
    require_once $dao;
}
$post = json_decode(file_get_contents("php://input"));
$arr = [];
foreach($post as $valor){
    $id = $valor;
}
/*$conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$id_pessoa = $_SESSION['id_pessoa'];
$donoimagem = $_GET['id_pet'];
$resultado = mysqli_query($conexao, "SELECT p.id_pet_foto AS id_foto, pf.arquivo_foto_pet AS 'imagem' FROM pet p, pet_foto pf WHERE p.id_pet_foto=pf.id_pet_foto and p.id_pet=$donoimagem");
$petImagem = mysqli_fetch_array($resultado);*/


$pdo = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME.'; charset=utf8',DB_USER,DB_PASSWORD);
$resultado = $pdo->query("SELECT p.id_pet_foto AS id_foto, pf.arquivo_foto_pet AS 'imagem' FROM pet p, 
pet_foto pf WHERE p.id_pet_foto=pf.id_pet_foto and p.id_pet=$id");
$petImagem = $resultado->fetch();

echo json_encode($petImagem);