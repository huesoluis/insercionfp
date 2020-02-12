<?php 
//genrar csvs con datos de la matrícula por familia
// include configuration
require_once(dirname(__FILE__) . '/config.php');
// instanciate a new DAL
$dirdestino='csvs_empresa_familia/';


$dal = new ACCESO($dirdestino);
 
$sql_base=
"
SELECT t1.cc as Grado, t1.nal/(t1.nal+t2.nal)*100 as '% Mujeres', t2.nal/(t1.nal+t2.nal)*100 as '% Hombres'
from
(SELECT count(*) as nal, grado cc,sf.FAMILIA familia from GIR_MATRICULA gm,GIR_CENTRO gc,SIGAD_FAMILIA sf,INCUAL_TITULO it where sf.CODIGO_FAMILIA=it.CODIGO_FAMILIA and gm.codigo_ciclo=it.CODIGO_TITULO_ARAGON and gm.cod_centro=gc.iddenomcentro  and sf.FAMILIA like '%parametro1%' and fecha='9042018' and sexo='M' group by grado,familia) as t1 
LEFT JOIN
(SELECT count(*) as nal, grado cc,sf.FAMILIA familia from GIR_MATRICULA gm,GIR_CENTRO gc,SIGAD_FAMILIA sf,INCUAL_TITULO it where sf.CODIGO_FAMILIA=it.CODIGO_FAMILIA and gm.codigo_ciclo=it.CODIGO_TITULO_ARAGON and gm.cod_centro=gc.iddenomcentro  and sf.FAMILIA like '%parametro1%' and fecha='9042018' and sexo='H' group by grado,familia) as t2 
ON t1.cc=t2.cc
";

$dato='matricula';
$filtro='familia';

$csvs=new CSVS($filtro,$sql_base,$dal,$dato);
$sql_fam="SELECT FAMILIA from SIGAD_FAMILIA"; 
// cycle through the makes
//foreach ($makes as $make){
  $familias = $dal->query($dal->c,$sql_fam);
   // cycle through results
  foreach ($familias as $fam){
	//generamos un fichero csv con los datos de cada familia 
	$f=$fam->FAMILIA;
	//print($f);
	$csvs->gen_csv($f,$sql_base);
    	//break;
	}


?>

