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

class MedicamentoControle{
    public function adicionarMedicamento(){
        var_dump($_REQUEST);
        extract($_REQUEST);
        $c = new SaudePetDAO();
        
        $c->adicionarMedicamento( $nomeMedicamento, $descricaoMedicamento, $aplicacaoMedicamento);
        if($id){
           header("Location: ../../html/pet/profile_pet.php?id_pet=".$id);
        }else{
            header("Location: ../../html/pet/cadastrar_medicamento.php");
        }
    }

    public function listarMedicamento(){
        $c = new SaudePetDAO();
        return $c->listarMedicamento();
    }
}