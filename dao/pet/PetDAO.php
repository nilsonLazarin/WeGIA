<?php
require_once '../../dao/Conexao.php';

class PetDAO{
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

        /*print_r($nImagem);*/
        echo "feito!";
    }

    
}

?>