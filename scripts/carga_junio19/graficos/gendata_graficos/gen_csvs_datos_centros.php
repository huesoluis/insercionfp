<?php 
// include configuration
require_once('../config.php');
error_reporting(E_ERROR | E_PARSE);

#DATOS 12 MESES
#PARAMETROS GLOBALES

$periododir='12m';
$periodo='12m';
$fecha_fct='jun18';
require('datos_consultas_centros.php');
$dirppal='../../../../datos_junio19/centros/'.$periododir;
$dirbase='../../../../datos_junio19/centros/';
$dal = new ACCESO($dirppal);

//ESTADISTICA POR CENTROS
$sql_cen="SELECT distinct(a.idcentrofct) as idcentrofct, nombrecentro,centrocodificado from alumnos a,centros c where a.idcentrofct=c.idcentrofct"; 
$cont=0; 
$centros = $dal->query($dal->c,$sql_cen);
  foreach ($centros as $cen){
	unlink('/home/fpleaks/tmp/brutoscentros.csv');
	//generamos un fichero csv con los datos de cada centro
	
	$cont++;
	$param=$cen['idcentrofct'];
	$ncentro=$cen['centrocodificado'];
	$dircentro=$dirbase.'/'.$ncentro;
	$fcentro=$dirppal.'/'.$ncentro.'/datos_global.csv';
	$fcentro_alumnos=$dirbase.'/'.$ncentro.'/datos_alumnos_global.csv';
	$fcentro_respuestas=$dirbase.'/'.$ncentro.'/datos_alumnos_respuestas.csv';
	//generamos fichero con datos brutos de alumnos	
	$cabecera_alumnos="select 'fecha fct', 'nombre','primer_apellido','segundo apellido','telefono','email','codigo ciclo','denominacion ciclo','provincia','grado' union ";
	$sql_brutos_alumnos=$cabecera_alumnos."select a.fecha_fct, nombre,primer_apellido,segundo_apellido,telefono,email,codciclo,denciclo,c.provincia as provincia,ci.grado as grado from alumnos a left join respuestas r on a.idalumnofct=r.idalumnofct, centros c,ciclos ci where ci.idciclofct=a.idciclofct and a.idcentrofct=c.idcentrofct and c.idcentrofct=".$param."  into outfile '/home/fpleaks/tmp/brutoscentros.csv' FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n'";
	//$rbrutos_alumnos = $dal->gen_brutos($sql_brutos_alumnos,$fcentro_alumnos,$dircentro);
	
	//generamos fichero con datos brutos de respuestas
	$cabecera_respuestas="select 'fecha fct', 'nombre','primer_apellido','segundo apellido','telefono','email','codigo ciclo','denominacion ciclo','provincia','grado','fct','trabaja','relacionado con el estudio','tipo de contrato','misma empresa' union ";
	$sql_brutos_respuestas=$cabecera_respuestas." select a.fecha_fct,nombre,primer_apellido,segundo_apellido,telefono,email,codciclo,denciclo,c.provincia as provincia,ci.grado as grado,fct,trabaja,relacionado,contrato,mismaempresa from alumnos a left join respuestas r on a.idalumnofct=r.idalumnofct, centros c,ciclos ci where ci.idciclofct=a.idciclofct and a.idcentrofct=c.idcentrofct and c.idcentrofct=".$param."  into outfile '/home/fpleaks/tmp/brutoscentros.csv' FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n'";
	$rbrutos_respuestas = $dal->gen_brutos($sql_brutos_respuestas,$fcentro_respuestas,$dircentro);
	#print($sql_brutos_respuestas);	
	#exit();
	//consultas simples
	$raltafct = $dal->query($dal->c,$sql_altafct,$param,$ncentro);
	$datafct[]=$raltafct[0]['nafct'];
	$datafct[]="100%";

	if($raltafct[0]['nafct']==0) {print($ncentro." no tiene alumnos");unset($datafct); continue;}	
	/*
	$res = $dal->query($dal->c,$sql_finalizado,$param,$ncentro);
	$datafct[]=$res[0]['nafct'];
	$datafct[]=floor($res[0]['nafct']/$raltafct[0]['nafct']*100).'%';
	
	$res = $dal->query($dal->c,$sql_respondido,$param,$ncentro);
	$datafct[]=$res[0]['nafct'];
	$datafct[]=floor($res[0]['nafct']/$raltafct[0]['nafct']*100).'%';
	*/
	$rfinresp = $dal->query($dal->c,$sql_finresp,$param,$ncentro);
	$datafct[]=$rfinresp[0]['nafct'];
	$datafct[]=floor($rfinresp[0]['nafct']/$raltafct[0]['nafct']*100).'%';
	
	if($rfinresp[0]['nafct']==0) {print($ncentro." no tiene alumnos que hayan respondido");unset($datafct); continue;}	
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
	
	if($rtrabaja[0]['nafct']==0 and $rdesempleo[0]['nafct']==0) 
	{
	$datafct[]='';
	$datafct[]='No hay datos';
	}
	else{
	$datafct[]='';
	$datafct[]=floor($rtrabaja[0]['nafct']/($rdesempleo[0]['nafct']+$rtrabaja[0]['nafct'])*100).'%';
	}
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
$periodo='6m';
$fecha_fct='dic18';
require('datos_consultas_centros.php');
$dirppal='../../../../datos_junio19/centros/'.$periododir;
$dirbase='../../../../datos_junio19/centros/';
$dal = new ACCESO($dirppal);

//ESTADISTICA POR CENTROS
$sql_cen="SELECT distinct(a.idcentrofct) as idcentrofct, nombrecentro,centrocodificado from alumnos a,centros c where a.idcentrofct=c.idcentrofct"; 
$cont=0; 
$centros = $dal->query($dal->c,$sql_cen);
   // cycle through results
  foreach ($centros as $cen){
	//generamos un fichero csv con los datos de cada centro
	$cont++;
	$param=$cen['idcentrofct'];
	$ncentro=$cen['centrocodificado'];
	$dircentro=$dirbase.'/'.$ncentro;
	$fcentro=$dirppal.'/'.$ncentro.'/datos_global.csv';
	$fcentro_alumnos=$dirbase.'/'.$ncentro.'/datos_alumnos_global.csv';
	$fcentro_respuestas=$dirbase.'/'.$ncentro.'/datos_alumnos_respuestas.csv';

	//generamos fichero de datos del centro
	//$rbruto = $dal->query($dal->c,$sql_brutos,$param,$ncentro);

	//consultas simples
	$raltafct = $dal->query($dal->c,$sql_altafct,$param,$ncentro);
	$datafct[]=$raltafct[0]['nafct'];
	$datafct[]="100%";

	if($raltafct[0]['nafct']==0) {print($ncentro." no tiene alumnos");unset($datafct); continue;}	
	/*
	$res = $dal->query($dal->c,$sql_finalizado,$param,$ncentro);
	$datafct[]=$res[0]['nafct'];
	$datafct[]=floor($res[0]['nafct']/$raltafct[0]['nafct']*100).'%';
	
	$res = $dal->query($dal->c,$sql_respondido,$param,$ncentro);
	$datafct[]=$res[0]['nafct'];
	$datafct[]=floor($res[0]['nafct']/$raltafct[0]['nafct']*100).'%';
	*/
	$rfinresp = $dal->query($dal->c,$sql_finresp,$param,$ncentro);
	$datafct[]=$rfinresp[0]['nafct'];
	$datafct[]=floor($rfinresp[0]['nafct']/$raltafct[0]['nafct']*100).'%';
	
	if($rfinresp[0]['nafct']==0) {print($ncentro." no tiene alumnos que hayan respondido");unset($datafct); continue;}	
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
	
	if($rtrabaja[0]['nafct']==0 and $rdesempleo[0]['nafct']==0) 
	{
	$datafct[]='';
	$datafct[]='No hay datos';
	}
	else{
	$datafct[]='';
	$datafct[]=floor($rtrabaja[0]['nafct']/($rdesempleo[0]['nafct']+$rtrabaja[0]['nafct'])*100).'%';
	}
	$datafct[]='';
	if($rtrabaja[0]['nafct']==0) $datafct[]=floor($rrelacionado[0]['nafct']/(1)*100).'%';
	else
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

