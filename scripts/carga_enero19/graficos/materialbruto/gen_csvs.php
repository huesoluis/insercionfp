<?php 
//genrar csvs con datos de la matrícula por familia
// include configuration
require_once(dirname(__FILE__) . '/config.php');
// instanciate a new DAL
$dal = new ACCESO();


$sql_altafct="select count(*) from alumnos where periodo='jun18'";
$sql_altafct_centro="select count(*) from alumnos a, centros cen where cen.idcentrofct=a.idcentro and periodo='jun18' and idcentro='%param_centro%'";


$sql_respondido="select count(*) from respuestas r, alumnos a where  r.idalumnofct=a.idalumnofct and r.periodo='jun18' and fct is not null and trabaja!='NSNC'";
$sql_respondido_centro="select count(*) from respuestas r, alumnos a,centros cen where cen.idcentro=a.idcentrofct and  r.idalumnofct=a.idalumnofct and r.periodo='jun18' and fct is not null and trabaja!='NSNC'";


$sql_finfct="select count(*) from respuestas r, alumnos a where  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and FCT='SI'";
$sql_finfct_centro="select count(*) from respuestas r, alumnos a centros cen where cen.idcentrofct=a.idcentro and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and FCT='SI'";

 
$global_trabaja=
"
 SELECT t1.grado as 'GRADO',t1.est/(t1.est+t2.des+t3.tra)*100 as 'ESTUDIA', t2.des/(t1.est+t2.des+t3.tra)*100 as 'DESEMPLEO',t3.tra/(t1.est+t2.des+t3.tra)*100 as 'TRABAJA' from 
( select grado,count(*) est from respuestas r, alumnos a,ciclos c where c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and  trabaja='ESTUDIA' and FCT!='NO' group by grado ) as t1 
LEFT JOIN 
( select grado,count(*) as des from respuestas r, alumnos a,ciclos c where c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and  trabaja='EN DESEMPLEO' and FCT!='NO' group by grado ) as t2 
on t1.grado=t2.grado 
LEFT JOIN 
( select grado,count(*) as tra from respuestas r, alumnos a,ciclos c where c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and trabaja='TRABAJA' and FCT!='NO' group by grado ) as t3 
on t2.grado=t3.grado";

$centros_trabaja=
"
 SELECT t1.grado as 'GRADO',t1.est/(t1.est+t2.des+t3.tra)*100 as 'ESTUDIA', t2.des/(t1.est+t2.des+t3.tra)*100 as 'DESEMPLEO',t3.tra/(t1.est+t2.des+t3.tra)*100 as 'TRABAJA' from 
( select grado,count(*) est from respuestas r, alumnos a,ciclos c,centros cen where cen.idcentrofct='%param_centro%' and cen.idcentrofct=a.idcentro and  c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and  trabaja='ESTUDIA' and FCT!='NO' group by grado ) as t1 
LEFT JOIN 
( select grado,count(*) as des from respuestas r, alumnos a,ciclos c,centros cen where cen.idcentrofct='%param_centro%' and cen.idcentrofct=a.idcentro and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and  trabaja='EN DESEMPLEO' and FCT!='NO' group by grado ) as t2 
on t1.grado=t2.grado 
LEFT JOIN 
( select grado,count(*) as tra from respuestas r, alumnos a,ciclos c, centros cen where cen.idcentrofct='%param_centro%' and cen.idcentrofct=a.idcentro and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and trabaja='TRABAJA' and FCT!='NO' group by grado ) as t3 
on t2.grado=t3.grado";




//consulta de estado laboral para cada centro
$centros_sitlaboral="SELECT t1.nombrecentro as 'CENTRO',t1.est/(t1.est+t2.des+t3.tra)*100 as 'ESTUDIA', t2.des/(t1.est+t2.des+t3.tra)*100 as 'DESEMPLEO',t3.tra/(t1.est+t2.des+t3.tra)*100 as 'TRABAJA' from ( select nombrecentro,count(*) est from respuestas r, alumnos a,ciclos c,centros cen where cen.idcentrofct=a.idcentro and  c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and  trabaja='ESTUDIA' and FCT!='NO' group by idcentro ) as t1 LEFT JOIN ( select nombrecentro,count(*) as des from centros cen,respuestas r, alumnos a,ciclos c where cen.idcentrofct=a.idcentro and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and  trabaja='EN DESEMPLEO' and FCT!='NO' group by idcentro ) as t2 on t1.nombrecentro=t2.nombrecentro LEFT JOIN ( select nombrecentro,count(*) as tra from centros cen , respuestas r, alumnos a,ciclos c where cen.idcentrofct=a.idcentro and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and trabaja='TRABAJA' and FCT!='NO' group by idcentro  ) as t3 on t2.nombrecentro=t3.nombrecentro order by TRABAJA desc";





$sql_base_matsexo=
"
SELECT t1.cc as 'Grado',t1.nal as 'MUJERES', t2.nal as 'HOMBRES'
from
(SELECT count(*) as nal, codigo_ciclo cc,sf.FAMILIA familia from GIR_MATRICULA gm,GIR_CENTRO gc,SIGAD_FAMILIA sf,INCUAL_TITULO it where sf.CODIGO_FAMILIA=it.CODIGO_FAMILIA and gm.codigo_ciclo=it.CODIGO_TITULO_ARAGON and gm.cod_centro=gc.iddenomcentro  and sf.FAMILIA like '%parametro1%' and fecha='9042018' and sexo='M' group by cc,familia) as t1 
LEFT JOIN
(SELECT count(*) as nal, codigo_ciclo cc ,sf.FAMILIA familia from GIR_MATRICULA gm,GIR_CENTRO gc,SIGAD_FAMILIA sf,INCUAL_TITULO it where sf.CODIGO_FAMILIA=it.CODIGO_FAMILIA and gm.codigo_ciclo=it.CODIGO_TITULO_ARAGON and gm.cod_centro=gc.iddenomcentro  and sf.FAMILIA like '%parametro1%' and fecha='9042018' and sexo='H' group by cc,familia) as t2 
ON t1.cc=t2.cc
";

$sql_base0=
"

SELECT t1.gz as 'Grado',t1.nal as 'Zaragoza', t2.nal as 'Huesca', t3.nal as 'Teruel'
from
(SELECT count(*) as nal, grado gz,sf.FAMILIA familia from GIR_MATRICULA gm,GIR_CENTRO gc,SIGAD_FAMILIA sf,INCUAL_TITULO it where sf.CODIGO_FAMILIA=it.CODIGO_FAMILIA and gm.codigo_ciclo=it.CODIGO_TITULO_ARAGON and gm.num_matriculados=gc.iddenomcentro and gc.provincia='Zaragoza' and sf.FAMILIA like '%parametro1%' group by grado,familia) as t1 
LEFT JOIN
(SELECT count(*) as nal, grado gh, sf.FAMILIA familia from GIR_MATRICULA gm,GIR_CENTRO gc,SIGAD_FAMILIA sf,INCUAL_TITULO it where sf.CODIGO_FAMILIA=it.CODIGO_FAMILIA and gm.codigo_ciclo=it.CODIGO_TITULO_ARAGON and gm.num_matriculados=gc.iddenomcentro and gc.provincia='Huesca' and sf.FAMILIA like '%parametro1%'group by grado,familia) as t2 
ON t1.gz=t2.gh 
LEFT JOIN
(SELECT count(*) as nal, grado gt, sf.FAMILIA familia from GIR_MATRICULA gm,GIR_CENTRO gc,SIGAD_FAMILIA sf,INCUAL_TITULO it where sf.CODIGO_FAMILIA=it.CODIGO_FAMILIA and gm.codigo_ciclo=it.CODIGO_TITULO_ARAGON and gm.num_matriculados=gc.iddenomcentro and gc.provincia='Teruel' and sf.FAMILIA like '%parametro1%'group by grado,familia) as t3
ON t1.gz=t3.gt


";




$dato='matricula';
$filtro='familia';

//ESTADISTICA POR CENTROS
$csvs=new CSVS($filtro,$sql_base,$dal,$dato);
$sql_cen="SELECT idcentro from centros"; 
// cycle through the makes
//foreach ($makes as $make){
  $centros = $dal->query($dal->c,$sql_cen);
   // cycle through results
  foreach ($centros as $cen){
	//generamos un fichero csv con los datos de cada familia 
	$f=$cen->CENTRO;
	//print($f);
	$csvs->gen_csv($f,$sql_base);
    	//break;
	}

//ESTADISTICA POR FAMILIAS
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

