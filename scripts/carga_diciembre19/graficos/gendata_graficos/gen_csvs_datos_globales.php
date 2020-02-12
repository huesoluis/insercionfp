<?php 
//Script para generar csvs con datos estadísticos de inserción laboral en periodos de 6 y 12 meses
require_once('../config.php');
$dir_convocatoria='../../../../datos_diciembre19/globales/';

$fecha_fct='jun19';
$periodo='6m';
//Cargamos objeto con directorio de destino de datos
$dal = new ACCESO($dir_convocatoria.$periodo);
require('datos_consultas_globales.php');

#DATOS GLOBALES BRUTOS COMPLETOS
$fcompletos=$dir_convocatoria.'/datos_alumnos_respuestas.csv';
$dal->gen_brutos($sql_brutos_respuestas,$fcompletos);



#DATOS GLOBALES PERIODO 
$fglobal=$dir_convocatoria.$periodo.'/datos_global.csv';

$dal->insertdata($fglobal,$datafct,'global');
#GENERACION GRAFICOS GLOBALES PERIODO SEPTIEMBRE-DICIEMBRE##############################################
$filtro='global';
$ft='trabaja_desempleo';
$ftr='trabaja_relacionado';
$ftfam='trabaja_por_familias';
$ftrfam='trabaja_relacionado_por_familias';
$ftcen='trabaja_por_centros';
$ftrcen='trabaja_relacionado_por_centros';

print("CONSULTA: trabaja-desempleo".PHP_EOL);
$dal->gen_csv($global_trabaja_desempleo,'',$ft);
print("CONSULTA: trabaja-relacionado".PHP_EOL);
$dal->gen_csv($global_trabaja_relacionado,'',$ftr,'','');
print("CONSULTA: trabaja-porfamilias".PHP_EOL);
$dal->gen_csv($global_trabaja_por_familias,'',$ftfam,'','');
$dal->gen_csv($global_trabaja_relacionado_por_familias,'',$ftrfam,'','');
$dal->gen_csv($global_trabaja_por_centros,'',$ftcen,'','');
$dal->gen_csv($global_trabaja_relacionado_por_centros,'',$ftrcen,'','');
unset($dal);
unset($datafct);

#DATOS GLOBALES PERIODO MARZO-JUNIO 2018
$fecha_fct='dic18';
$periodo='12m';
//Cargamos objeto con directorio de destino de datos
$dal = new ACCESO($dir_convocatoria.$periodo);
require('datos_consultas_globales.php');

#DATOS GLOBALES PERIODO
$fglobal=$dir_convocatoria.$periodo.'/datos_global.csv';

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

