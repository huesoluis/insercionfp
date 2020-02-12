<?php 
//genrar csvs con datos de la matrícula por familia
// include configuration
require_once('../config.php');
// instanciate a new DAL
$dal = new ACCESO('../../../../datos/');
/*
#CONSULTAS SIMPLES#########################################################################

#Alumnos inscritos en fcts
$sql_altafct="SELECT count(*) nafct from alumnos where periodo='jun18'";

$raltafct = $dal->query($dal->c,$sql_altafct);
$datafct[]=$raltafct[0]['nafct'];
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

$global_trabaja_por_centros=
"
SELECT replace(t1.nombrecentro,',','') as 'CENTRO', t2.des/(t2.des+t1.tra)*100 as 'DESEMPLEOPORCENTROS' , t1.tra/(t1.tra+t2.des)*100 as 'TRABAJOPORCENTROS' from 
( select nombrecentro,count(*) as tra from respuestas r, alumnos a,ciclos c,ciclo_familia cfa,centros cen where cen.idcentrofct=a.idcentro and c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and  trabaja='TRABAJA' and FCT!='NO' group by idcentro) as t1
LEFT JOIN 
( select nombrecentro,count(*) as des from respuestas r, alumnos a,ciclos c,ciclo_familia cfa,centros cen where cen.idcentrofct=a.idcentro and c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and  trabaja='EN DESEMPLEO' and FCT!='NO' group by idcentro) as t2 
on t1.nombrecentro=t2.nombrecentro 
and t1.tra is not null
and t2.des is not null
order by TRABAJOPORCENTROS desc";


$global_trabaja_relacionado_por_centros=
"
SELECT replace(t1.nombrecentro,',','') as 'CENTRO', t2.rel/(t1.tra)*100 as 'RELACIONADOPORCENTROS'  from 
( select nombrecentro,idcentro,count(*) as tra from respuestas r, alumnos a,ciclos c,ciclo_familia cfa,centros cen where cen.idcentrofct=a.idcentro and c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and  trabaja='TRABAJA' and FCT!='NO' group by idcentro) as t1
LEFT JOIN 
( select nombrecentro,idcentro,count(*) as rel from respuestas r, alumnos a,ciclos c,ciclo_familia cfa,centros cen where cen.idcentrofct=a.idcentro and c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and  trabaja='TRABAJA' and FCT!='NO' and relacionado='SI' group by idcentro) as t2 
on t1.idcentro=t2.idcentro 
and t1.tra is not null
and t2.rel is not null
order by RELACIONADOPORCENTROS desc";

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

$dato='matricula';
$filtro='global';

#DATOS GLOBALES

$fglobal='../../../../datos/globales/datos_global.csv';

$dal->insertdata($fglobal,$datafct);


#GENERACION GRAFICOS GLOBALES##############################################
$ft='trabaja_desempleo';
$ftr='trabaja_relacionado';
$ftfam='trabaja_por_familias';
$ftrfam='trabaja_relacionado_por_familias';
$ftcen='trabaja_por_centros';
$ftrcen='trabaja_relacionado_por_centros';

$csvs=new CSVS($filtro,$global_trabaja_desempleo,$dal,'',$ft);
$csvs->gen_csv($ft,$global_trabaja_desempleo);

$csvs=new CSVS($filtro,$global_trabaja_relacionado,$dal,'',$ftr);
$csvs->gen_csv($ftr,$global_trabaja_relacionado);

$csvs=new CSVS($filtro,$global_trabaja_por_familias,$dal,'',$ftfam);
$csvs->gen_csv($ftfam,$global_trabaja_por_familias);

$csvs=new CSVS($filtro,$global_trabaja_relacionado_por_familias,$dal,'',$ftrfam);
$csvs->gen_csv($ftrfam,$global_trabaja_relacionado_por_familias);

$csvs=new CSVS($filtro,$global_trabaja_por_centros,$dal,'',$ftcen);
$csvs->gen_csv($ftcen,$global_trabaja_por_centros);

$csvs=new CSVS($filtro,$global_trabaja_irelacionado_por_centros,$dal,'',$ftrcen);
$csvs->gen_csv($ftrcen,$global_trabaja_relacionado_por_centros);


CONSULTA VALIDA DE MOMENTO

   SELECT t3.grado as 'GRADO', t2.des as 'DESEMPLEO',t3.tra 'TRABAJA' from    
   ( select grado,count(*) as des from respuestas r, alumnos a,ciclos c,centros cen where cen.idcentrofct=a.idcentro and a.idcentro='107' and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and  trabaja='EN DESEMPLEO' and FCT!='NO' group by grado) as t2 RIGHT JOIN  (select grado,count(*) as tra from respuestas r, alumnos a,ciclos c ,centros cen where cen.idcentrofct=a.idcentro and a.idcentro='107' and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and trabaja='TRABAJA' and FCT!='NO' group by grado) as t3 ON t2.grado=t3.grado
UNION	
SELECT t2.grado as 'GRADO', t2.des as 'DESEMPLEO',t3.tra 'TRABAJA' from    
( select grado,count(*) as des from respuestas r, alumnos a,ciclos c,centros cen where cen.idcentrofct=a.idcentro and a.idcentro='107' and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and  trabaja='EN DESEMPLEO' and FCT!='NO' group by grado) as t2 LEFT JOIN  (select grado,count(*) as tra from respuestas r, alumnos a,ciclos c ,centros cen where cen.idcentrofct=a.idcentro and a.idcentro='107' and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and trabaja='TRABAJA' and FCT!='NO' group by grado) as t3 ON t2.grado=t3.grado;




*/

#Alumnos que han finalizado FCTs
$sqlcentros_finalizado="SELECT count(*) nafct from respuestas r, alumnos a, centros cen where cen.idcentrofct=a.idcentro and  r.idalumnofct=a.idalumnofct and r.periodo='jun18' and FCT!='NO' and idcentrofct='parametro1'";

$centros_trabaja_desempleo=
"
SELECT t2.grado as 'GRADO', floor(t2.des/(t2.des+t3.tra)*100) as 'DESEMPLEO',floor(t3.tra/(t2.des+t3.tra)*100) as 'TRABAJA' from 
(select grado,count(*) as des from respuestas r, alumnos a,ciclos c,centros cen where cen.idcentrofct=a.idcentro and a.idcentro='parametro1' and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and  trabaja='EN DESEMPLEO' and FCT!='NO' group by grado ) as t2 
RIGHT JOIN 
(select grado,count(*) as tra from respuestas r, alumnos a,ciclos c ,centros cen where cen.idcentrofct=a.idcentro and a.idcentro='parametro1' and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and trabaja='TRABAJA' and FCT!='NO' group by grado ) as t3 
on t2.grado=t3.grado
";

$param='centro';
//ESTADISTICA POR CENTROS
//$csvs=new CSVS($filtro,$sql_base,$dal,$param);
$sql_cen="SELECT idcentrofct,nombrecentro from centros"; 
$dir_centros='centros/';
$cont=0; 

$centros = $dal->query($dal->c,$sql_cen);
#print_r($centros);
   // cycle through results
  foreach ($centros as $cen){
	//generamos un fichero csv con los datos de cada centro
	$cont++;
	$param=$cen['idcentrofct'];
	$ncentro=str_replace('"','',$cen['nombrecentro']);
	//Consultas complejas
	$dal->gen_csv($centros_trabaja_desempleo,$param,'trabaja_desempleo',$dir_centros,$ncentro);
	}
exit();

//ESTADISTICA POR FAMILIAS
$csvs=new CSVS($filtro,$sql_base,$dal,$dato);
$sql_fam="SELECT FAMILIA from SIGAD_FAMILIA"; 
// cycle through the makes
//foreach ($makes as $make){
  $familias = $dal->query($dal->c,$sql_fam);
   // cycle through results
  foreach ($familias as $fam){
	//generamos un fichero csv con los datos de cada familia 
	//print($f);
	$csvs->gen_csv($f,$sql_base);
    	//break;
	}
?>

