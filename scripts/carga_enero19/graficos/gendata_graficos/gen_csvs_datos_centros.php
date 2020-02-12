<?php 
//genrar csvs con datos de la matrícula por familia
// include configuration
require_once('../config.php');

error_reporting(E_ERROR | E_PARSE);

#DATOS 12 MESES
#PARAMETROS GLOBALES

$periododir='12m';
$periodo='dic17';
require('datos_consultas_centros.php');
$dirbase='../../../../historico/datos_enero19/centros/';
$dirperiodo='../../../../historico/datos_enero19/centros/'.$periododir.'/';
$dal = new ACCESO($dirbase,$dirperiodo);

//ESTADISTICA POR CENTROS
$sql_cen="SELECT distinct(idcentro) as idcentrofct, nombrecentro from alumnos a,centros c where a.idcentro=c.idcentrofct"; 
$cont=0; 
$centros = $dal->query($dal->c,$sql_cen);
  foreach ($centros as $cen){
	//generamos un fichero csv con los datos de cada centro
	$cont++;
	$param=$cen['idcentrofct'];
	$ncentro=str_replace('"','',$cen['nombrecentro']);
	$ncentro=str_replace('.','',$ncentro);
	$ncentro=str_replace(' ','_',$ncentro);
	#if($param!='89') continue;	
	Print("CENTRO: ".$ncentro."\n");	
	//generamos fichero con datos brutos	
	$cabecera="select 'nombre','primer_apellido','segundo apellido','telefono','email','codigo ciclo','denominacion ciclo','provincia','grado','fct','trabaja','relacionado con el estudio','tipo de contrato','misma empresa' union ";
	$sql_brutos=$cabecera."select nombre,primer_apellido,segundo_apellido,telefono,email,codciclo,denciclo,c.provincia as provincia,ci.grado as grado,fct,trabaja,relacionado,contrato,mismaempresa from respuestas r, alumnos a, centros c,ciclos ci where ci.idciclofct=a.idciclofct and r.idalumnofct=a.idalumnofct and a.idcentro=c.idcentrofct and c.idcentrofct=".$param." into outfile '/home/fpleaks/tmp/historicobrutos.csv' FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n'";
	

	$rbrutos = $dal->gen_brutos($sql_brutos,$ncentro);

	$ftmp = "/home/fpleaks/tmp/historicobrutos.csv";
	try {unlink($ftmp) ;}
	catch(Exception $e){  echo "Couldn't delete file";}
	//consultas simples
	$raltafct = $dal->query($dal->c,$sql_altafct,$param,$ncentro);
	$datafct[]=$raltafct[0]['nafct'];
	$datafct[]="100%";
	if($raltafct[0]['nafct']==0) {print($ncentro." no tiene alumnos");unset($datafct); continue;}	
	$res = $dal->query($dal->c,$sql_finalizado,$param,$ncentro);
	$datafct[]=$res[0]['nafct'];
	$datafct[]=floor($res[0]['nafct']/$raltafct[0]['nafct']*100).'%';
	
	$res = $dal->query($dal->c,$sql_respondido,$param,$ncentro);
	$datafct[]=$res[0]['nafct'];
	$datafct[]=floor($res[0]['nafct']/$raltafct[0]['nafct']*100).'%';
	
	$rfinresp = $dal->query($dal->c,$sql_finresp,$param,$ncentro);
	$datafct[]=$rfinresp[0]['nafct'];
	$datafct[]=floor($rfinresp[0]['nafct']/$raltafct[0]['nafct']*100).'%';
	
	if($rfinresp[0]['nafct']==0) {print($ncentro." no tiene alumnos que hayan respondido\n");unset($datafct); continue;}	
	$res = $dal->query($dal->c,$sql_estudia,$param,$ncentro);
	$datafct[]=$res[0]['nafct'];
	$datafct[]=floor($res[0]['nafct']/$rfinresp[0]['nafct']*100).'%';
	
	$rtrabaja = $dal->query($dal->c,$sql_trabaja,$param,$ncentro);
	$datafct[]=$rtrabaja[0]['nafct'];
	$datafct[]=floor($rtrabaja[0]['nafct']/$rfinresp[0]['nafct']*100).'%';
	
	$rrelacionado = $dal->query($dal->c,$sql_rrelacionado,$param,$ncentro);
	$datafct[]=$rrelacionado[0]['nafct'];
	$datafct[]=floor($rrelacionado[0]['nafct']/$rfinresp[0]['nafct']*100).'%';
	
	$rdesempleo= $dal->query($dal->c,$sql_desempleo,$param,$ncentro);
	#$datafct[]=$rdesempleo[0]['nafct'];
	#$datafct[]=floor($rdesempleo[0]['nafct']/$rfinresp[0]['nafct']*100).'%';
	
	if($rtrabaja[0]['nafct']==0 or $rdesempleo[0]['nafct']==0) {print($ncentro." no tiene alumnos que estudian o trabajan\n");unset($datafct); continue;}	
	$datafct[]='';
	$datafct[]=floor($rtrabaja[0]['nafct']/($rdesempleo[0]['nafct']+$rtrabaja[0]['nafct'])*100).'%';
	$datafct[]='';
	$datafct[]=floor($rrelacionado[0]['nafct']/($rtrabaja[0]['nafct'])*100).'%';
	
	$dal->insertdata($fcentro,$datafct,$dirppal.'/'.$ncentro);
	unset($datafct);
	//Consultas complejas
	$dal->gen_csv($centros_trabaja_desempleo,$param,'trabaja_desempleo',$ncentro);
	$dal->gen_csv($centros_trabaja_relacionado,$param,'trabaja_relacionado',$ncentro);
	$dal->gen_csv($centros_trabaja_por_familias,$param,'trabaja_por_familias',$ncentro);
	$dal->gen_csv($centros_trabaja_relacionado_por_familias,$param,'trabaja_relacionado_por_familias',$ncentro);
	}

#DATOS 6 MESES
#PARAMETROS GLOBALES

$periododir='6m';
$periodo='jun18';
require('datos_consultas_centros.php');
$dirppal='../../../../historico/datos/centros/'.$periododir.'/';
$dal = new ACCESO($dirppal);

//ESTADISTICA POR CENTROS
$sql_cen="SELECT distinct(idcentro) as idcentrofct, nombrecentro from alumnos a,centros c where a.idcentro=c.idcentrofct"; 
$cont=0; 
$centros = $dal->query($dal->c,$sql_cen);
   // cycle through results
  foreach ($centros as $cen){
	//generamos un fichero csv con los datos de cada centro
	$cont++;
	
	$param=$cen['idcentrofct'];
	$ncentro=str_replace('"','',$cen['nombrecentro']);
	$ncentro=str_replace('.','',$ncentro);
	$ncentro=str_replace(' ','_',$ncentro);
	$dircentro=$dirppal.'/';
	$fcentro=$dirppal.'/'.$ncentro.'/datos_global.csv';

	//generamos fichero de datos del centro
	$rbruto = $dal->query($dal->c,$sql_brutos,$param,$ncentro);

	//consultas simples
	$raltafct = $dal->query($dal->c,$sql_altafct,$param,$ncentro);
	$datafct[]=$raltafct[0]['nafct'];
	$datafct[]="100%";

	if($raltafct[0]['nafct']==0) {print($ncentro." no tiene alumnos");unset($datafct); continue;}	
	$res = $dal->query($dal->c,$sql_finalizado,$param,$ncentro);
	$datafct[]=$res[0]['nafct'];
	$datafct[]=floor($res[0]['nafct']/$raltafct[0]['nafct']*100).'%';
	
	$res = $dal->query($dal->c,$sql_respondido,$param,$ncentro);
	$datafct[]=$res[0]['nafct'];
	$datafct[]=floor($res[0]['nafct']/$raltafct[0]['nafct']*100).'%';
	
	$rfinresp = $dal->query($dal->c,$sql_finresp,$param,$ncentro);
	$datafct[]=$rfinresp[0]['nafct'];
	$datafct[]=floor($rfinresp[0]['nafct']/$raltafct[0]['nafct']*100).'%';
	
	if($rfinresp[0]['nafct']==0) {print($ncentro." no tiene alumnosi que hayan respondido");unset($datafct); continue;}	
	$res = $dal->query($dal->c,$sql_estudia,$param,$ncentro);
	$datafct[]=$res[0]['nafct'];
	$datafct[]=floor($res[0]['nafct']/$rfinresp[0]['nafct']*100).'%';
	
	$rtrabaja = $dal->query($dal->c,$sql_trabaja,$param,$ncentro);
	$datafct[]=$rtrabaja[0]['nafct'];
	$datafct[]=floor($rtrabaja[0]['nafct']/$rfinresp[0]['nafct']*100).'%';
	
	$rrelacionado = $dal->query($dal->c,$sql_rrelacionado,$param,$ncentro);
	#$datafct[]=$rrelacionado[0]['nafct'];
	#$datafct[]=floor($rrelacionado[0]['nafct']/$rfinresp[0]['nafct']*100).'%';
	
	$rdesempleo= $dal->query($dal->c,$sql_desempleo,$param,$ncentro);
	$datafct[]=$rdesempleo[0]['nafct'];
	$datafct[]=floor($rdesempleo[0]['nafct']/$rfinresp[0]['nafct']*100).'%';
	
	if($rtrabaja[0]['nafct']==0 or $rdesempleo[0]['nafct']==0) {print($ncentro." no tiene alumnos que estudian o trabajan");unset($datafct); continue;}	
	$datafct[]='';
	$datafct[]=floor($rtrabaja[0]['nafct']/($rdesempleo[0]['nafct']+$rtrabaja[0]['nafct'])*100).'%';
	$datafct[]='';
	$datafct[]=floor($rrelacionado[0]['nafct']/($rtrabaja[0]['nafct'])*100).'%';
	
	$dal->insertdata($fcentro,$datafct,$dirppal.'/'.$ncentro);
	unset($datafct);
	//Consultas complejas
	$dal->gen_csv($centros_trabaja_desempleo,$param,'trabaja_desempleo',$ncentro);
	$dal->gen_csv($centros_trabaja_relacionado,$param,'trabaja_relacionado',$ncentro);
	$dal->gen_csv($centros_trabaja_por_familias,$param,'trabaja_por_familias',$ncentro);
	$dal->gen_csv($centros_trabaja_relacionado_por_familias,$param,'trabaja_relacionado_por_familias',$ncentro);
	}
?>

