<?php

    // $anexo = $_FILES['arquivos'];
    // echo $teste;
    // var_dump($teste);

    // echo $teste[0]["tmp_name"];

    // echo $total;
	$arq = $_FILES['arquivos'];
    $total = count($arq['name']);
    echo $total;

    $arq['name'] =  array_unique($arq['name']);
    $arq['type'] =  array_unique($arq['type']);
    $arq['tmp_name'] =  array_unique($arq['tmp_name']);
    $arq['error'] =  array_unique($arq['error']);
    $arq['size'] =  array_unique($arq['size']);
    var_dump($arq);
    // $arq = array_unique($arq);
   // var_dump($arq);
    // // print_r($arq);
    // var_dump($arq);
    // $arq = array_unique($arq);
    // print_r($arq);

	// for($x=0; $x<$total; $x++)
    // {
	//     for($j=1; $j<$total; $j++)
    //     {
    //         if($arq['name'][$x] == $arq['name'][$j])
    //         {
    //             // array_splice($arq['name'], $j, 1);
    //             // array_splice($arq['type'], $j, 1);
    //             // array_splice($arq['tmp_name'], $j, 1);
    //             // array_splice($arq['error'], $j, 1);
    //             // array_splice($arq['size'], $j, 1);
    //             unset($arq['name'][$j]);
	// 				unset($arq['type'][$j]);
	// 				unset($arq['tmp_name'][$j]);
	// 				unset($arq['error'][$j]);
	// 				unset($arq['size'][$j]);
    //         }
    //     }
    // }

   
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
    // var_dump($arq);
    // $cont = 0;
    // $array = array(0 => 'blue', 1 => 'red', 2 => 'green', 3 => 'red');
    // for($i=0;$i<count($array);$i++)
    // {
    //     $key = array_search('green', $array);
    //     if($key != false)
    //     {
    //         $cont++;
    //         if($cont>1)
    //         {
    //             array_splice($array, $key, 1); 
    //         }
    //     }
        
    // }

    // echo $cont;
        // var_dump($array);

    






        // for($x=0; $x<$total; $x++)
		// {
		// 	for($j=1; $j<$total; $j++)
		// 	{
		// 		if($arq['name'][$x] === $arq['name'][$j])
		// 		{		
		// 			// $string = $arq['name'][$x];
		// 			// $array = $arq['name'];
		// 			// if(array_search($string, $array))			
		// 			unset($arq['name'][$j]);
		// 			unset($arq['type'][$j]);
		// 			unset($arq['tmp_name'][$j]);
		// 			unset($arq['error'][$j]);
		// 			unset($arq['size'][$j]);

		// 			// array_splice($arq['name'], $j, 1);
		// 			// array_splice($arq['type'], $j, 1);
		// 			// array_splice($arq['tmp_name'], $j, 1);
		// 			// array_splice($arq['error'], $j, 1);
		// 			// array_splice($arq['size'], $j, 1);
					
		// 			// $indice = $arq['name'].indexOf($arqteste['name'][$j]);
					
		// 			// array_splice($arq['name'], $i);
		// 			// array_splice($arq['type'], $indice, 1);
		// 			// array_splice($arq['tmp_name'], $indice, 1);
		// 			// array_splice($arq['error'], $indice, 1);
		// 			// array_splice($arq['size'], $indice, 1);
		// 		}
				
		// 	}
		// }

		// for($x=0; $x<$total; $x++)
		// {
		// 	for($j=1; $j<$total; $j++)
		// 	{
		// 		if($anexo['name'][$x] == $anexo['name'][$j])
		// 		{
		// 			unset($anexo['name'][$j]);
		// 			unset($anexo['type'][$j]);
		// 			unset($anexo['tmp_name'][$j]);
		// 			unset($anexo['error'][$j]);
		// 			unset($anexo['size'][$j]);
					

		// 			// $indice2 = $anexo.indexOf($anexoteste['name'][$j]);
		// 			// array_splice($anexo['name'], $indice2, 1);
		// 			// array_splice($anexo['type'], $indice2, 1);
		// 			// array_splice($anexo['tmp_name'], $indice2, 1);
		// 			// array_splice($anexo['error'], $indice2, 1);
		// 			// array_splice($anexo['size'], $indice2, 1);
		// 			// unset($anexo['name'][$j]);
		// 			// unset($anexo['type'][$j]);
		// 			// unset($anexo['tmp_name'][$j]);
		// 			// unset($anexo['error'][$j]);
		// 			// unset($anexo['size'][$j]);
		// 		}
		// 	}
		// }

		
		// for($j=0; $j<$novo_total; $j++)
		// {
		// 	$tex = $arqteste['name'][$j];
		// 	if(in_array($tex,$arq['name']) == false)
		// 	{
		// 		$tam = count($arq['name'])-1;
		// 		$arq['name'][$tam] = $arqteste['name'][$j];
		// 		$arq['type'][$tam] = $arqteste['type'][$j];
		// 		$arq['tmp_name'][$tam] = $arqteste['tmp_name'][$j];
		// 		$arq['error'][$tam] = $arqteste['error'][$j];
		// 		$arq['size'][$tam] = $arqteste['size'][$j];
		// 		// $arq['type'].push($arqteste['type'][$x]);
		// 		// $arq['tmp_name'].push($arqteste['tmp_name'][$x]);
		// 		// $arq['error'].push($arqteste['error'][$x]);
		// 		// $arq['size'].push($arqteste['size'][$x]);
		// 	}
		// }	
	

	
		// for($j=0; $j<$novo_total; $j++)
		// {
		// 	$tex1 = $anexoteste['name'][$j];
		// 	if(in_array($tex1,$anexo['name']) == false)
		// 	{
		// 		$tam = count($anexo['name'])-1;
		// 		$anexo['name'][$tam] = $anexoteste['name'][$j];
		// 		$anexo['type'][$tam] = $anexoteste['type'][$j];
		// 		$anexo['tmp_name'][$tam] = $anexoteste['tmp_name'][$j];
		// 		$anexo['error'][$tam] = $anexoteste['error'][$j];
		// 		$anexo['size'][$tam] = $anexoteste['size'][$j];
		// 		// $arq['type'].push($arqteste['type'][$x]);
		// 		// $arq['tmp_name'].push($arqteste['tmp_name'][$x]);
		// 		// $arq['error'].push($arqteste['error'][$x]);
		// 		// $arq['size'].push($arqteste['size'][$x]);
		// 	}
		// }	
		
		
		// $arq = $arqteste;
		// $anexo = $anexoteste;


?>