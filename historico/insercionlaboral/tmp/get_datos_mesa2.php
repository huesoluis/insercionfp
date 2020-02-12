<?php

$file = '../datos/mesa2/datos_mesa2.csv';

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
