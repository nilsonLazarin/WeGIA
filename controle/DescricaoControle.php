<?php
include_once(ROOT.'/classes/DescricaoFichamedica.php');
include_once(ROOT.'/dao/DescricaoDAO.php');

class DescricaoControle
{
    public function incluir($texto){
        extract($_REQUEST);
        $idDescricao = new DescricaoDAO();
        $tamanho = 1000;
        $textoArray = $this->divideStringEmArrays($texto, $tamanho);
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
}
?>