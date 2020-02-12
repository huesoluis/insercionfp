<?php 
//Script para generar csvs con datos estadísticos de inserción laboral en periodos de 6 y 12 meses
require_once('../config.php');

$periodo='dic17';
$periododir='12m';
//Cargamos objeto con directorio de destino de datos
$dal = new ACCESO('../../../../datos/globales/'.$periododir);
require('datos_consultas_globales.php');

#DATOS GLOBALES PERIODO SEPTIEMBRE-DICIEMBRE
$fglobal='../../../../datos/globales/'.$periododir.'/datos_global.csv';

$dal->insertdata($fglobal,$datafct,'global');

#GENERACION GRAFICOS GLOBALES PERIODO SEPTIEMBRE-DICIEMBRE##############################################
$filtro='global';
$ft='trabaja_desempleo';
$ftr='trabaja_relacionado';
$ftfam='trabaja_por_familias';
$ftrfam='trabaja_relacionado_por_familias';
$ftcen='trabaja_por_centros';
$ftrcen='trabaja_relacionado_por_centros';

$dal->gen_csv($global_trabaja_desempleo,'',$ft);
$dal->gen_csv($global_trabaja_relacionado,'',$ftr,'','');
$dal->gen_csv($global_trabaja_por_familias,'',$ftfam,'','');
$dal->gen_csv($global_trabaja_relacionado_por_familias,'',$ftrfam,'','');
$dal->gen_csv($global_trabaja_por_centros,'',$ftcen,'','');
$dal->gen_csv($global_trabaja_relacionado_por_centros,'',$ftrcen,'','');

unset($dal);
unset($datafct);

#DATOS GLOBALES PERIODO MARZO-JUNIO
$periodo='jun18';
$periododir='6m';
//Cargamos objeto con directorio de destino de datos
$dal = new ACCESO('../../../../datos/globales/'.$periododir);
require('datos_consultas.php');

#DATOS GLOBALES PERIODO SEPTIEMBRE-DICIEMBRE
$fglobal='../../../../datos/globales/'.$periododir.'/datos_global.csv';

$dal->insertdata($fglobal,$datafct,'global');

#GENERACION GRAFICOS GLOBALES PERIODO MARZO-JUNIO##############################################
$ft='trabaja_desempleo';
$ftr='trabaja_relacionado';
$ftfam='trabaja_por_familias';
$ftrfam='trabaja_relacionado_por_familias';
$ftcen='trabaja_por_centros';
$ftrcen='trabaja_relacionado_por_centros';

$dal->gen_csv($global_trabaja_desempleo,'',$ft);
$dal->gen_csv($global_trabaja_relacionado,'',$ftr,'','');
$dal->gen_csv($global_trabaja_por_familias,'',$ftfam,'','');
$dal->gen_csv($global_trabaja_relacionado_por_familias,'',$ftrfam,'','');
$dal->gen_csv($global_trabaja_por_centros,'',$ftcen,'','');
$dal->gen_csv($global_trabaja_relacionado_por_centros,'',$ftrcen,'','');
?>

