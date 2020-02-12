<?php

$centro=$_POST['cen'];
$periodo=$_POST['per'];

if($centro=='global') $file = '../datos_junio19/globales/'.$periodo.'/datos_global.csv';
else $file = '../datos_junio19/centros/'.$periodo.'/'.$centro.'/datos_global.csv';

$hl = fopen($file, "r");

$linea='';
if($hl) {
    while (($line = fgets($hl)) !== false) {
       $linea=$line;
    }

} else {
	echo "No hay datos";
} 
fclose($handle);

echo trim($linea);
?>
