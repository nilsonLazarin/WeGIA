<?php
$PetDAO_path = "dao/pet/PetDAO.php";
if(file_exists($PetDAO_path)){
    require_once($PetDAO_path);
}else{
    while(true){
        $PetDAO_path = "../" . $PetDAO_path;
        if(file_exists($PetDAO_path)) break;
    }
    require_once($PetDAO_path);
}
//require_once '../../dao/pet/PetDAO.php';

$Pet_path = "classes/pet/Pet.php";
if(file_exists($Pet_path)){
    require_once($Pet_path);
}else{
    while(true){
        $Pet_path = "../" . $Pet_path;
        if(file_exists($Pet_path)) break;
    }
    require_once($Pet_path);
}
//require_once '../../classes/pet/Pet.php';

class PetControle{
    private $petDAO;
    private $petClasse;

    public function __construct(){
       $this->petDAO = new PetDAO();
       $this->petClasse = new PetClasse();
    }

    public function incluir(){
        
        extract($_REQUEST);
        $imgperfil = base64_encode($_SESSION['imagem']);
        $nomeImagem = $_SESSION['nome_imagem'];
        $sexo = strtoupper($gender);

        if(!isset($nome) || empty($nome)){
            $msg = "Nome não informado!";
            header("Location: ../../html/pet/cadastro_pet.php?msg=".$msg);
            return;
        }

        if(!isset($nascimento) || empty($nascimento)){
            $msg = "Data de nascimento não informada!";
            header("Location: ../../html/pet/cadastro_pet.php?msg=".$msg);
            return;
        }

        if(!isset($acolhimento) || empty($acolhimento)){
            $msg = "Data de acolhimento não informada!";
            header("Location: ../../html/pet/cadastro_pet.php?msg=".$msg);
            return;
        }

        if(!isset($sexo) || empty($sexo)){
            $msg = "Sexo não informado!";
            header("Location: ../../html/pet/cadastro_pet.php?msg=".$msg);
            return;
        }

        if(!isset($especie) || empty($especie)){
            $msg = "Especie não informada!";
            header("Location: ../../html/pet/cadastro_pet.php?msg=".$msg);
            return;
        }

        if(!isset($raca) || empty($raca)){
            $msg = "Raca não informado!";
            header("Location: ../../html/pet/cadastro_pet.php?msg=".$msg);
            return;
        }

        if(!isset($cor) || empty($cor)){
            $msg = "Cor não informada!";
            header("Location: ../../html/pet/cadastro_pet.php?msg=".$msg);
            return;
        }
        
        if(!isset($caracEsp) || empty($caracEsp)){
            $caracEsp = '';
        }

        if(!isset($imgperfil) || empty($imgperfil)){
            $imgperfil = '';
            $nomeImagem = ['', ''];
        }else{
            $nomeImagem = explode('.', $nomeImagem);
            unset($_SESSION['imagem']);
            unset($_SESSION['nome_imagem']);
        }


        $this->petClasse->setNome($nome);
        $this->petClasse->setNascimento($nascimento);
        $this->petClasse->setAcolhimento($acolhimento);
        $this->petClasse->setSexo($sexo);
        $this->petClasse->setCaracteristicasEspecificas($caracEsp);
        $this->petClasse->setEspecie($especie);
        $this->petClasse->setRaca($raca);
        $this->petClasse->setCor($cor);
        $this->petClasse->setImgPerfil($imgperfil);
        $this->petClasse->setNomeImagem($nomeImagem);


        $this->petDAO->adicionarPet( 
            $this->petClasse->getNome(),
            $this->petClasse->getNascimento(),
            $this->petClasse->getAcolhimento(),
            $this->petClasse->getSexo(),
            $this->petClasse->getCaracteristicasEspecificas(),
            $this->petClasse->getEspecie(),
            $this->petClasse->getRaca(),
            $this->petClasse->getCor(),
            $this->petClasse->getImgPerfil(),
            $this->petClasse->getNomeImagem()
        );
        
    }

    public function listarTodos(){
        extract($_REQUEST);
        $PetDAO= new PetDAO();
        $pets = $PetDAO->listarTodos();
        $_SESSION['pet']=$pets;
    }

    public function listarUm(){
        extract($_REQUEST);
        try {
            $petDAO = new PetDAO();
            $pet=$petDAO->listarUm($id_pet);
            session_start();
            $_SESSION['pet']=$pet;
            header('Location:'.$nextPage);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function alterarImagem(){
        extract($_REQUEST);
        $imgPet = base64_encode(file_get_contents($_FILES['imgperfil']['tmp_name']));
        $imgNome = $_FILES['imgperfil']['name'];
        $imgNome = explode('.', $imgNome);  
        
        try{
            $petDAO = new PetDAO();
            $petDAO->alterarFotoPet($imgPet, $imgNome[0], $imgNome[1], $id_foto, $id_pet);
            header('Location: ../../html/pet/profile_pet.php?id_pet='.$id_pet);            
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function alterarPetDados(){
        /* ["nome"]=> string(12) "Coala Alegre" ["gender"]=> string(1) "m" 
        ["nascimento"]=> string(10) "2022-06-26" ["acolhimento"]=> string(10) "2022-07-01" 
        ["cor"]=> string(2) "31" ["especie"]=> string(1) "7" ["raca"]=> string(1) "1" 
        ["especificas"]=> string(7) "Risonho" ["id_pet"]=> string(2) "37"*/
        extract($_REQUEST);

        $sexo = strtoupper($gender);
        try{
            $petDAO = new PetDAO();
            $petDAO->alterarPet($nome, $nascimento, $acolhimento, $sexo, $especificas, $especie, $raca, $cor, $id_pet);
            header('Location: ../../html/pet/profile_pet.php?id_pet='.$id_pet);   
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function deletar(){

    }
}

/*$c = new PetControle();
$c->listarUm();*/
?>