<?php 
//genrar csvs con datos de la matrícula por familia
// include configuration
require_once('../config.php');
// instanciate a new DAL
$dal = new ACCESO('../../../../datos/mesa4/');
#CONSULTAS SIMPLES#########################################################################

#Alumnos inscritos en fcts en cada mesa

$mesa1=['ARG301','IMS305','IMS303','IMS304','IMS301','IMS302','MAM301','SSC304','TCP301'];
$mesa2=['AGA304','AGA303','AGA302','IMP302','INA301','QUI301','QUI304','SAN309','SAN306','SAN305','SAN304','SAN301','SAN303','SAN308'];
$mesa3=['EOC303','EOC301','EOC302','IMP302','ELE301','ELE302','ELE303','ELE304','ENA301','ENA302','FME301','FME302','FME303','FME304','FME305','IFC301','IFC302','IFC303','IMA301','IMA302','MSP301','MVA301','MVA302','TMV301'];
$mesa4=['AFD301','ADG301','ADG302','COM301','COM302','COM303','COM304','HOT301','HOT302','HOT303','HOt304','HOT305','SAN303','SEA302','SSC301','SSC302','SSC303','SSC304','SSC305'];

$sql_altafct="SELECT count(*) nafct from alumnos where periodo='jun18'";

$sql_comp=' and (';
foreach($mesa4 as $m)
	$sql_comp=$sql_comp." c.codciclo='".$m."' or";


$sql_comp= substr($sql_comp, 0, -2);
$sql_comp=$sql_comp.")";

$sql_altafct="SELECT count(*) nafct from alumnos a,ciclos c where a.idciclofct=c.idciclofct" ;
$sql_altafct=$sql_altafct.$sql_comp;


$raltafct = $dal->query($dal->c,$sql_altafct);
$datafct[]=$raltafct[0]['nafct'];
$datafct[]="100%";


#Alumnos que han finalizado FCTs
$sql_finalizado="SELECT count(*) nafct from respuestas r, alumnos a,ciclos c  where a.idciclofct=c.idciclofct and r.idalumnofct=a.idalumnofct and r.periodo='jun18' and FCT!='NO'";
$sql_finalizado=$sql_finalizado.$sql_comp;

$rfinalizado = $dal->query($dal->c,$sql_finalizado);
$datafct[]=$rfinalizado[0]['nafct'];
$datafct[]=floor($rfinalizado[0]['nafct']/$raltafct[0]['nafct']*100).'%';

print($sql_finalizado);

#Alumnos que han respondido encuestas
$sql_respondido="SELECT count(*) nafct from respuestas r, alumnos a,ciclos c where a.idciclofct=c.idciclofct and r.idalumnofct=a.idalumnofct and r.periodo='jun18' and trabaja!='NSNC'";

$sql_respondido=$sql_respondido.$sql_comp;
print($sql_respondido);
$rrespondido = $dal->query($dal->c,$sql_respondido);

$datafct[]=$rrespondido[0]['nafct'];
$datafct[]=floor($rrespondido[0]['nafct']/$raltafct[0]['nafct']*100).'%';

#Alumnos que han finalizado FCTs y han respondido encuestas
$sql_finresp="SELECT count(*) nafct from respuestas r, alumnos a ,ciclos c where a.idciclofct=c.idciclofct and  r.idalumnofct=a.idalumnofct and r.periodo='jun18' and FCT!='NO' and trabaja!='NSNC'";
$sql_finresp=$sql_finresp.$sql_comp;

$rfinresp = $dal->query($dal->c,$sql_finresp);
$datafct[]=$rfinresp[0]['nafct'];
$datafct[]=floor($rfinresp[0]['nafct']/$raltafct[0]['nafct']*100).'%';

#Alumnos que siguen estudiando
$sql_estudia="SELECT count(*) nafct from respuestas r, alumnos a,ciclos c where a.idciclofct=c.idciclofct and  r.idalumnofct=a.idalumnofct and r.periodo='jun18' and FCT!='NO' and trabaja='ESTUDIA'";

$sql_estudia=$sql_estudia.$sql_comp;
$restudia = $dal->query($dal->c,$sql_estudia);
$datafct[]=$restudia[0]['nafct'];
$datafct[]=floor($restudia[0]['nafct']/$rfinresp[0]['nafct']*100).'%';

#Alumnos que trabajan
$sql_trabaja="SELECT count(*) nafct from respuestas r, alumnos a,ciclos c where a.idciclofct=c.idciclofct and  r.idalumnofct=a.idalumnofct and r.periodo='jun18' and FCT!='NO' and trabaja='TRABAJA'";

$sql_trabaja=$sql_trabaja.$sql_comp;
$rtrabaja = $dal->query($dal->c,$sql_trabaja);
$datafct[]=$rtrabaja[0]['nafct'];
$datafct[]=floor($rtrabaja[0]['nafct']/$rfinresp[0]['nafct']*100).'%';

#Alumnos que trabajan en algo relacionado
$sql_rrelacionado="SELECT count(*) nafct from respuestas r, alumnos a, ciclos c where a.idciclofct=c.idciclofct and  r.idalumnofct=a.idalumnofct and r.periodo='jun18' and FCT='SI' and trabaja='TRABAJA' and relacionado='SI'";
$sql_rrelacionado=$sql_rrelacionado.$sql_comp;

$rrelacionado = $dal->query($dal->c,$sql_rrelacionado);
$datafct[]=$rrelacionado[0]['nafct'];
$datafct[]=floor($rrelacionado[0]['nafct']/$rfinresp[0]['nafct']*100).'%';

#Alumnos en desempleo
$sql_desempleo="SELECT count(*) nafct from respuestas r, alumnos a , ciclos c where a.idciclofct=c.idciclofct and r.idalumnofct=a.idalumnofct and r.periodo='jun18' and FCT='SI' and trabaja='EN DESEMPLEO'";
$sql_desempleo=$sql_desempleo.$sql_comp;

$rdesempleo = $dal->query($dal->c,$sql_desempleo);
$datafct[]=$rdesempleo[0]['nafct'];
$datafct[]=floor($rdesempleo[0]['nafct']/$rfinresp[0]['nafct']*100).'%';

#Alumnos que trabajan respecto al total de alumnos que quieren trabajar (en desempleo + trabajando)
$datafct[]='';
$datafct[]=floor($rtrabaja[0]['nafct']/($rdesempleo[0]['nafct']+$rtrabaja[0]['nafct'])*100).'%';
#Alumnos que trabajan en algo relacionado respecto al total de alumnos que trabaja
$datafct[]='';
$datafct[]=floor($rrelacionado[0]['nafct']/($rtrabaja[0]['nafct'])*100).'%';


/*
#FIN CONSULTAS SIMPLES#########################################################################
*/
#CONSULTAS COMPLEJAS#########################################################################
#De todos los que quieren trabajar, es decir, quitando los que estudian, cuales están en desempleo y cuales trabajan
#MESA1
 
$global_trabaja_desempleo=
"
 SELECT t2.grado as 'GRADO', t2.des/(t2.des+t3.tra)*100 as 'DESEMPLEO',t3.tra/(t2.des+t3.tra)*100 as 'TRABAJA' from 
( select grado,count(*) as des from respuestas r, alumnos a,ciclos c where c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and  trabaja='EN DESEMPLEO' and FCT!='NO' ".$sql_comp." group by grado ) as t2 
LEFT JOIN 
( select grado,count(*) as tra from respuestas r, alumnos a,ciclos c where c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and trabaja='TRABAJA' and FCT!='NO' ".$sql_comp." group by grado ) as t3 
on t2.grado=t3.grado";

#print($global_trabaja_desempleo);

$global_trabaja_relacionado=
"
SELECT t2.grado as 'GRADO', t3.rel/t2.tra*100 as 'TRABAJO RELACIONADO' from 
( select grado,count(*) as tra from respuestas r, alumnos a,ciclos c where c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and  trabaja='TRABAJA' and FCT!='NO' ".$sql_comp." group by grado ) as t2 
LEFT JOIN 
( select grado,count(*) as rel from respuestas r, alumnos a,ciclos c where c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and trabaja='TRABAJA' and FCT!='NO' and relacionado='SI' ".$sql_comp." group by grado ) as t3 
on t2.grado=t3.grado";

$dato='matricula';
$filtro='global';

#DATOS GLOBALES

$fmesa1='../../../../datos/mesa4/datos_mesa4.csv';

$dal->insertdata($fmesa1,$datafct);


#GENERACION GRAFICOS GLOBALES##############################################
$ft='trabaja_desempleo';
$ftr='trabaja_relacionado';

$dal->gen_csv($global_trabaja_desempleo,'',$ft,'','');
$dal->gen_csv($global_trabaja_relacionado,'',$ftr,'','');

exit();
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


#CONSULTA VALIDA DE MOMENTO
/*
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

