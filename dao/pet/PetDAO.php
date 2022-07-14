<?php
$Conexao_path = "dao/Conexao.php";
if(file_exists($Conexao_path)){
    require_once($Conexao_path);
}else{
    while(true){
        $Conexao_path = "../" . $Conexao_path;
        if(file_exists($Conexao_path)) break;
    }
    require_once($Conexao_path);
}
//require_once '../../dao/Conexao.php';

class PetDAO{

    private $pdo;

    /** $nImagem -> nome original da imagem  */
    public function adicionarPet( $nome, $nascimento, $acolhimento, $sexo, $caracEsp, $especie, 
        $raca, $cor, $imgperfil, $nImagem){
            
        $idFoto;        
        $pdo = Conexao::connect();
        if( $imgperfil != ''){
            $pd = $pdo->prepare("INSERT INTO pet_foto( arquivo_foto_pet, arquivo_foto_pet_nome, 
                arquivo_foto_pet_extensao) VALUES( :conteudo, :nome_foto, :extensao)");
            $pd->bindValue(':conteudo', $imgperfil);
            $pd->bindValue(':nome_foto', $nImagem[0]);
            $pd->bindValue(':extensao', $nImagem[1]);
            $pd->execute();

            $id = $pdo->query("SELECT id_pet_foto FROM pet_foto");
            foreach( $id as $valor){
                $idFoto = $valor['id_pet_foto'];
            }
        }else{
            $idFoto = NULL;
        }
        

        $pd = $pdo->prepare("INSERT INTO pet(nome, data_nascimento, data_acolhimento, sexo,
            caracteristicas_especificas, id_pet_foto, id_pet_especie, id_pet_raca, id_pet_cor) 
            VALUES(:nome, :nascimento, :acolhimento, :sexo, :especificas, :id_foto, 
            :id_especie, :id_raca, :id_cor)");
        $pd->bindValue(':nome', $nome);
        $pd->bindValue(':nascimento', $nascimento);
        $pd->bindValue(':acolhimento', $acolhimento);
        $pd->bindValue(':sexo', $sexo);
        $pd->bindValue(':especificas', $caracEsp);
        $pd->bindValue(':id_foto', $idFoto);
        $pd->bindValue(':id_especie', $especie);
        $pd->bindValue(':id_raca', $raca);
        $pd->bindValue(':id_cor', $cor);
        $pd->execute();

        header('Location: ../../html/pet/informacao_pet.php');
    }
    
    public function listarTodos(){
        $pdo = Conexao::connect();
        $pd = $pdo->prepare("SELECT p.nome AS 'nome', pr.descricao AS 'raca', pe.descricao AS 'especie',
         pc.descricao AS 'cor' FROM pet p JOIN pet_raca pr ON p.id_pet_raca = pr.id_pet_raca JOIN pet_especie pe 
         ON p.id_pet_especie = pe.id_pet_especie JOIN pet_cor pc ON p.id_pet_cor = pc.id_pet_cor");
        $pd->execute();
        $p = $pd->fetchAll();
        return $p;
    }

    /*public function alterarPet($nome, $nascimento, $acolhimento, $sexo, $caracEsp, $especie, 
        $raca, $cor, $id_pet){
        $pdo = Conexao::connect();

        $pd = $pdo->prepare("UPDATE pet SET nome = :nome, data_nascimento = :nascimento, 
              data_acolhimento = :acolhimento, sexo = :sexo,
              caracteristicas_especificas = :especificas, id_pet_especie = :id_especie,
              id_pet_raca = :id_raca, id_pet_cor = :id_cor WHERE id_pet = :id_pet");
        $pd->bindValue(':nome', $nome);
        $pd->bindValue(':nascimento', $nascimento);
        $pd->bindValue(':acolhimento', $acolhimento);
        $pd->bindValue(':sexo', $sexo);
        $pd->bindValue(':especificas', $caracEsp);
        $pd->bindValue(':id_especie', $especie);
        $pd->bindValue(':id_raca', $raca);
        $pd->bindValue(':id_cor', $cor);
        $pd->bindValue(':id_pet', $id_pet);
        $pd->execute();

        header('Location: ');
    }
        echo 'feito';
    
    public function alterarFotoPet(){
        $pdo = Conexao::connect();

        $pd = $pdo->prepare("UPDATE pet_foto set arquivo_foto_pet = :arquivo, 
              arquivo_foto_pet_nome = :nome, arquivo_foto_pet_extensao = :extensao WHERE 
              id_foto_pet = :id_foto");
        $pd->bindValue(':arquivo', $);
        $pd->bindValue(':nome', $);
        $pd->bindValue(':extensao', $);
        $pd->bindValue(':id_foto', $);
        $pd->execute();

        header('Location: ');
    }
    */
    
}
?>

