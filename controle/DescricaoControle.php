<?php
include_once(ROOT.'/classes/DescricaoFichamedica.php');
include_once(ROOT.'/dao/DescricaoDAO.php');

class DescricaoControle
{
    private $tamanho = 1000;

    public function incluir($texto){
        extract($_REQUEST);
        $idDescricao = new DescricaoDAO();
        //$tamanho = 1000;
        $textoArray = $this->divideStringEmArrays($texto, $this->tamanho);
        $idDescricao->incluir($textoArray, $nome);

    }  

    function divideStringEmArrays($string, $tamanho) {
        $arrayResultante = [];
        $tamanhoString = strlen($string);
        
        // Verifica se a string é maior que o tamanho definido
        if ($tamanhoString <= $tamanho) {
            $arrayResultante[] = $string;
        } else {
            $numArrays = ceil($tamanhoString / $tamanho);
            
            for ($i = 0; $i < $numArrays; $i++) {
                $inicio = $i * $tamanho;
                $arrayResultante[] = substr($string, $inicio, $tamanho);
            }
        }
        
        return $arrayResultante;
    }

    /**
     * Recebe dois parâmetros, o id da ficha médica que será alterada e o novo texto, instancia um objeto do tipo DescricaoDAO e chama o método alterar, repassando o id informado e um array da string do texto informado.
     */
    public function alterarProntuario($idFicha, $texto){
        $descricaoDAO = new DescricaoDAO();
        $textoArray = $this->divideStringEmArrays($texto, $this->tamanho);
        $descricaoDAO->alterar($idFicha, $textoArray);

    }
}
?>