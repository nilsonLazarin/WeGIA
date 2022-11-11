<?php 

$PetDAO_path = "dao/pet/SaudePetDAO.php";
if(file_exists($PetDAO_path)){
    require_once($PetDAO_path);
}else{
    while(true){
        $PetDAO_path = "../" . $PetDAO_path;
        if(file_exists($PetDAO_path)) break;
    }
    require_once($PetDAO_path);
}

class AtendimentoControle{

    public function registrarAtendimento(){
        extract($_REQUEST);
        $vrfcr = 0;

        if( empty($dataAtendimento) || !isset($dataAtendimento) ){
            $vrfcr = 1;
        }

        if( empty($descricaoAtendimento) || !isset($descricaoAtendimento) ){
            $vrfcr = 1;
        }

        if( empty($medics) || !isset($medics) ){
            $vrfcr = 1;
        }

        if( empty($id_pet) || !isset($id_pet)){
            $vrfcr = 1;
        }

        if( $vrfcr == 1){
            header("Location: ../../html/pet/profile_pet.php?id_pet=".$id_pet);
        }else{
            $c = new SaudePetDAO();
            $c->registrarAtendimento();
            header("Location: ../../html/pet/profile_pet.php?id_pet=".$id_pet);
        }

    }

}