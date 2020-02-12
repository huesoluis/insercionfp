<?php 
//genrar csvs con datos de la matrícula por familia
// include configuration
require_once('../config.php');
// instanciate a new DAL
$dal = new ACCESO('../../../../datos/globales/');

#CONSULTAS SIMPLES#########################################################################
#Alumnos inscritos en fcts
$sql_altafct="SELECT count(*) nafct from alumnos where periodo='jun18'";

$raltafct = $dal->query($dal->c,$sql_altafct);
$datafct[]=$raltafct[0]->nafct;
$datafct[]="100%";

#Alumnos que han finalizado FCTs
$sql_finalizado="SELECT count(*) nafct from respuestas r, alumnos a where  r.idalumnofct=a.idalumnofct and r.periodo='jun18' and FCT!='NO'";

$rfinalizado = $dal->query($dal->c,$sql_finalizado);
$datafct[]=$rfinalizado[0]->nafct;
$datafct[]=floor($rfinalizado[0]->nafct/$raltafct[0]->nafct*100).'%';

#Alumnos que han respondido encuestas
$sql_respondido="SELECT count(*) nafct from respuestas r, alumnos a where  r.idalumnofct=a.idalumnofct and r.periodo='jun18' and trabaja!='NSNC'";

$rrespondido = $dal->query($dal->c,$sql_respondido);
$datafct[]=$rrespondido[0]->nafct;
$datafct[]=floor($rrespondido[0]->nafct/$raltafct[0]->nafct*100).'%';

#Alumnos que han finalizado FCTs y han respondido encuestas
$sql_finresp="SELECT count(*) nafct from respuestas r, alumnos a where  r.idalumnofct=a.idalumnofct and r.periodo='jun18' and FCT!='NO' and trabaja!='NSNC'";

$rfinresp = $dal->query($dal->c,$sql_finresp);
$datafct[]=$rfinresp[0]->nafct;
$datafct[]=floor($rfinresp[0]->nafct/$raltafct[0]->nafct*100).'%';

#Alumnos que siguen estudiando
$sql_estudia="SELECT count(*) nafct from respuestas r, alumnos a where  r.idalumnofct=a.idalumnofct and r.periodo='jun18' and FCT='SI' and trabaja='ESTUDIA'";

$restudia = $dal->query($dal->c,$sql_estudia);
$datafct[]=$restudia[0]->nafct;
$datafct[]=floor($restudia[0]->nafct/$rfinresp[0]->nafct*100).'%';

#Alumnos que trabajan
$sql_trabaja="SELECT count(*) nafct from respuestas r, alumnos a where  r.idalumnofct=a.idalumnofct and r.periodo='jun18' and FCT='SI' and trabaja='TRABAJA'";

$rtrabaja = $dal->query($dal->c,$sql_trabaja);
$datafct[]=$rtrabaja[0]->nafct;
$datafct[]=floor($rtrabaja[0]->nafct/$rfinresp[0]->nafct*100).'%';

#Alumnos que trabajan en algo relacionado
$sql_rrelacionado="SELECT count(*) nafct from respuestas r, alumnos a where  r.idalumnofct=a.idalumnofct and r.periodo='jun18' and FCT='SI' and trabaja='TRABAJA' and relacionado='SI'";

$rrelacionado = $dal->query($dal->c,$sql_rrelacionado);
$datafct[]=$rrelacionado[0]->nafct;
$datafct[]=floor($rrelacionado[0]->nafct/$rfinresp[0]->nafct*100).'%';

#Alumnos en desempleo
$sql_desempleo="SELECT count(*) nafct from respuestas r, alumnos a where  r.idalumnofct=a.idalumnofct and r.periodo='jun18' and FCT='SI' and trabaja='EN DESEMPLEO'";

$rdesempleo = $dal->query($dal->c,$sql_desempleo);
$datafct[]=$rdesempleo[0]->nafct;
$datafct[]=floor($rdesempleo[0]->nafct/$rfinresp[0]->nafct*100).'%';

#Alumnos que trabajan respecto al total de alumnos que quieren trabajar (en desempleo + trabajando)
$datafct[]='';
$datafct[]=floor($rtrabaja[0]->nafct/($rdesempleo[0]->nafct+$rtrabaja[0]->nafct)*100).'%';
#Alumnos que trabajan en algo relacionado respecto al total de alumnos que trabaja
$datafct[]='';
$datafct[]=floor($rrelacionado[0]->nafct/($rtrabaja[0]->nafct)*100).'%';
#FIN CONSULTAS SIMPLES#########################################################################


print_r($datafct);

#CONSULTAS COMPLEJAS#########################################################################

#De todos los que quieren trabajar, es decir, quitando los que estudian, cuales están en desempleo y cuales trabajan
 
$global_trabaja_desempleo=
"
 SELECT t2.grado as 'GRADO', t2.des/(t2.des+t3.tra)*100 as 'DESEMPLEO',t3.tra/(t2.des+t3.tra)*100 as 'TRABAJA' from 
( select grado,count(*) as des from respuestas r, alumnos a,ciclos c where c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and  trabaja='EN DESEMPLEO' and FCT!='NO' group by grado ) as t2 
LEFT JOIN 
( select grado,count(*) as tra from respuestas r, alumnos a,ciclos c where c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and trabaja='TRABAJA' and FCT!='NO' group by grado ) as t3 
on t2.grado=t3.grado";

$global_trabaja_relacionado=
"
SELECT t2.grado as 'GRADO', t3.rel/t2.tra*100 as 'TRABAJO RELACIONADO' from 
( select grado,count(*) as tra from respuestas r, alumnos a,ciclos c where c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and  trabaja='TRABAJA' and FCT!='NO' group by grado ) as t2 
LEFT JOIN 
( select grado,count(*) as rel from respuestas r, alumnos a,ciclos c where c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and trabaja='TRABAJA' and FCT!='NO' and relacionado='SI' group by grado ) as t3 
on t2.grado=t3.grado";

$global_trabaja_por_familias=
"
SELECT replace(t1.familia,',','') as 'FAMILIA', t2.des/(t2.des+t1.tra)*100 as 'DESEMPLEOPORFAMILIAS' , t1.tra/(t1.tra+t2.des)*100 as 'TRABAJOPORFAMILIAS' from 
( select familia,count(*) as tra from respuestas r, alumnos a,ciclos c,ciclo_familia cfa where c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and  trabaja='TRABAJA' and FCT!='NO' group by familia) as t1
LEFT JOIN 
( select familia,count(*) as des from respuestas r, alumnos a,ciclos c,ciclo_familia cfa where c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and  trabaja='EN DESEMPLEO' and FCT!='NO' group by familia) as t2 
on t1.familia=t2.familia 
and t1.tra is not null
and t2.des is not null
order by TRABAJOPORFAMILIAS desc";

$global_trabaja_relacionado_por_familias=
"
SELECT replace(t1.familia,',','') as 'FAMILIA', t2.rel/(t1.tra)*100 as 'RELACIONADOPORFAMILIAS' from 
( select familia,count(*) as tra from respuestas r, alumnos a,ciclos c,ciclo_familia cfa where c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and  trabaja='TRABAJA' and FCT!='NO'  group by familia) as t1
LEFT JOIN 
( select familia,count(*) as rel from respuestas r, alumnos a,ciclos c,ciclo_familia cfa where c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and  trabaja='TRABAJA' and FCT!='NO' and relacionado='SI' group by familia) as t2 
on t1.familia=t2.familia 
and t1.tra is not null
and t2.rel is not null
order by RELACIONADOPORFAMILIAS desc";


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
"SELECT t1.gz as 'Grado',t1.nal as 'Zaragoza', t2.nal as 'Huesca', t3.nal as 'Teruel'
from
(SELECT count(*) as nal, grado gz,sf.FAMILIA familia from GIR_MATRICULA gm,GIR_CENTRO gc,SIGAD_FAMILIA sf,INCUAL_TITULO it where sf.CODIGO_FAMILIA=it.CODIGO_FAMILIA and gm.codigo_ciclo=it.CODIGO_TITULO_ARAGON and gm.num_matriculados=gc.iddenomcentro and gc.provincia='Zaragoza' and sf.FAMILIA like '%parametro1%' group by grado,familia) as t1 
LEFT JOIN
(SELECT count(*) as nal, grado gh, sf.FAMILIA familia from GIR_MATRICULA gm,GIR_CENTRO gc,SIGAD_FAMILIA sf,INCUAL_TITULO it where sf.CODIGO_FAMILIA=it.CODIGO_FAMILIA and gm.codigo_ciclo=it.CODIGO_TITULO_ARAGON and gm.num_matriculados=gc.iddenomcentro and gc.provincia='Huesca' and sf.FAMILIA like '%parametro1%'group by grado,familia) as t2 
ON t1.gz=t2.gh 
LEFT JOIN
(SELECT count(*) as nal, grado gt, sf.FAMILIA familia from GIR_MATRICULA gm,GIR_CENTRO gc,SIGAD_FAMILIA sf,INCUAL_TITULO it where sf.CODIGO_FAMILIA=it.CODIGO_FAMILIA and gm.codigo_ciclo=it.CODIGO_TITULO_ARAGON and gm.num_matriculados=gc.iddenomcentro and gc.provincia='Teruel' and sf.FAMILIA like '%parametro1%'group by grado,familia) as t3
ON t1.gz=t3.gt";

$dato='matricula';
$filtro='familia';

#DATOS GLOBALES

$fglobal='../../../../datos/globales/datos_global.csv';

$dal->insertdata($fglobal,$datafct);


#GENERACION GRAFICOS GLOBALES##############################################

$ft='trabaja_desempleo';
$ftr='trabaja_relacionado';
$ftfam='trabaja_por_familias';

$csvs=new CSVS($filtro,$global_trabaja_desempleo,$dal,'',$ft);
$csvs->gen_csv($ft,$global_trabaja_desempleo);

$csvs=new CSVS($filtro,$global_trabaja_relacionado,$dal,'',$ftr);
$csvs->gen_csv($ftr,$global_trabaja_relacionado);

$csvs=new CSVS($filtro,$global_trabaja_por_familias,$dal,'',$ftfam);
$csvs->gen_csv($ftfam,$global_trabaja_por_familias);

$csvs=new CSVS($filtro,$global_trabaja_por_familias,$dal,'',$ftfam);
$csvs->gen_csv($ftfam,$global_trabaja_por_familias);
exit();
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
	//$csvs->gen_csv($f,$sql_base);
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

