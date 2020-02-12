<?php

$file = '../datos/mesa3/datos_mesa3.csv';

$hl = fopen($file, "r");

$linea='';
if($hl) {
    while (($line = fgets($hl)) !== false) {
       $linea=$line;
    }

} else {
	echo "fichero vacio";
} 
fclose($handle);

echo trim($linea);
?>
