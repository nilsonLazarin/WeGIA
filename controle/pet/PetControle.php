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
        session_start();
        $_SESSION['pet']=$pets;
        header('Location: '.$nextPage);
    }

    public function atualizar(){

    }

    public function deletar(){

    }
}

/*$c = new PetControle();
$c->listarTodos();*/
?>