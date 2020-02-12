<?php 
//genrar csvs con datos de la matrícula por familia
// include configuration
require_once(dirname(__FILE__) . '/config.php');
// instanciate a new DAL
$dal = new ACCESO();
 
$sql_base="SELECT t1.gz as 'Grado',t1.nal as 'Zaragoza', t2.nal as 'Huesca', t3.nal as 'Teruel'
from
(SELECT count(*) as nal, grado gz,sf.FAMILIA familia from GIR_MATRICULA gm,GIR_CENTRO gc,SIGAD_FAMILIA sf,INCUAL_TITULO it where sf.CODIGO_FAMILIA=it.CODIGO_FAMILIA and gm.codigo_ciclo=it.CODIGO_TITULO_ARAGON and gm.num_matriculados=gc.iddenomcentro and gc.provincia='Zaragoza' and sf.FAMILIA like '%parametro1%' group by grado,familia) as t1,
(SELECT count(*) as nal, grado gh, sf.FAMILIA familia from GIR_MATRICULA gm,GIR_CENTRO gc,SIGAD_FAMILIA sf,INCUAL_TITULO it where sf.CODIGO_FAMILIA=it.CODIGO_FAMILIA and gm.codigo_ciclo=it.CODIGO_TITULO_ARAGON and gm.num_matriculados=gc.iddenomcentro and gc.provincia='Huesca' and sf.FAMILIA like '%parametro1%'group by grado,familia) as t2,
(SELECT count(*) as nal, grado gt, sf.FAMILIA familia from GIR_MATRICULA gm,GIR_CENTRO gc,SIGAD_FAMILIA sf,INCUAL_TITULO it where sf.CODIGO_FAMILIA=it.CODIGO_FAMILIA and gm.codigo_ciclo=it.CODIGO_TITULO_ARAGON and gm.num_matriculados=gc.iddenomcentro and gc.provincia='Teruel' and sf.FAMILIA like '%parametro1%'group by grado,familia) as t3
where 
t1.gz=t2.gh
and
t1.gz=t3.gt";


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

