<?php

    // $anexo = $_FILES['arquivos'];
    // echo $teste;
    // var_dump($teste);

    // echo $teste[0]["tmp_name"];

    // echo $total;
	$arq = $_FILES['arquivos'];
    $total = count($arq['name']);
    echo $total;
   // var_dump($arq);
    // // print_r($arq);
    // var_dump($arq);
    // $arq = array_unique($arq);
    // print_r($arq);

	for($x=0; $x<$total; $x++)
    {
	    for($j=1; $j<$total; $j++)
        {
            if($arq['name'][$x] == $arq['name'][$j])
            {
                array_splice($arq['name'], $j, 1);
                array_splice($arq['type'], $j, 1);
                array_splice($arq['tmp_name'], $j, 1);
                array_splice($arq['error'], $j, 1);
                array_splice($arq['size'], $j, 1);
            }
        }
    }

   
    // echo "<br>" .    count($arq['name']);


    // $vetor = [];

	// for($i=0; $i<$total; $i++)
	// {
	//     // $arquivo = file_get_contents($anexo_tmpName[$i]);
    //     $anexo_tmpName = $arq['tmp_name'];
	// 	$arquivo = file_get_contents($anexo_tmpName[$i]);
	// 	$arquivo1 = $arq['name'][$i];
    //     $vetor[$i] = $arquivo1;
    //     // echo $arquivo1 . "<br>";

    // }
    // $vetor = array_unique($vetor);
    // var_dump($vetor);


?>