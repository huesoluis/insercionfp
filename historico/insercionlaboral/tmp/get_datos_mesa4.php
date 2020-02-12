<?php

$file = '../datos/mesa4/datos_mesa4.csv';

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
