<?php 
//Script para generar csvs con datos estadísticos de inserción laboral en periodos de 6 y 12 meses ENERO 2019
require_once('../config.php');

$periodo='dic17';
$periododir='12m';
//Cargamos objeto con directorio de destino de datos
$dal = new ACCESO('../../../../historico/datos_enero19/globales/'.$periododir,$periodo);
require('datos_consultas_globales.php');

print($sql_brutos_respuestas);
#DATOS GLOBALES BRUTOS COMPLETOS
#$fcompletos='../../../../historico/datos_enero19/globales/datos_alumnos_respuestas.csv';
#if(file_exists('/home/fpleaks/tmp/brutos.csv')) unlink('/home/fpleaks/tmp/brutos.csv');

#$dal->gen_brutos($sql_brutos_respuestas,$fcompletos);

#DATOS GLOBALES PERIODO SEPTIEMBRE-DICIEMBRE de 2017
$fglobal='../../../../historico/datos_enero19/globales/'.$periododir.'/datos_global.csv';
$dal->insertdata($fglobal,$datafct,'global');

/*
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
*/
unset($dal);
unset($datafct);



#DATOS GLOBALES PERIODO MARZO-JUNIO
$periodo='jun18';
$periododir='6m';
//Cargamos objeto con directorio de destino de datos
$dal = new ACCESO('../../../../historico/datos_enero19/globales/'.$periododir,$periodo);
require('datos_consultas_globales.php');

#DATOS GLOBALES PERIODO SEPTIEMBRE-DICIEMBRE
$fglobal='../../../../historico/datos_enero19/globales/'.$periododir.'/datos_global.csv';

$dal->insertdata($fglobal,$datafct,'global');

exit();
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

