<?php 
//genrar csvs con datos de empresas por familia
// include configuration
require_once(dirname(__FILE__) . '/config.php');
// instanciate a new DAL

$dirdestino='../csvs_fcts_familias/';
$dal = new ACCESO($dirdestino);
 
$dirdestino_completos='../csvs_fcts_familias_dcompletos/';
$dal_dcompletos = new ACCESO($dirdestino_completos);

$sql_fam="SELECT CODIGO_FAMILIA from SIGAD_FAMILIA"; 

$numminfcts=5;
#cabecera
$names="fcts";


$sql_graficos=
"
SELECT replace(nombre_empresa,',',''),count(*) as numfcts,count(*)/t.totalfcts*100 from FCTS f, MEC_TITULO m CROSS JOIN (SELECT sum(nfcts) as totalfcts from (SELECT nombre_empresa,count(*) as nfcts FROM FCTS fc,MEC_TITULO mt where fc.ciclo=mt.codigo_titulo_aragon and mt.codigo_familia like '%parametro1%'group by nombre_empresa  having nfcts>$numminfcts ) t1) t  where m.codigo_titulo_aragon=f.ciclo and codigo_familia like '%parametro1%' group by nombre_empresa having numfcts>$numminfcts order by numfcts  desc limit 10
";
$sql_dcompletos=
"
 SELECT replace(nombre_empresa,',',''),count(*) as numfcts,count(*)/t.totalfcts*100 from FCTS f, MEC_TITULO m CROSS JOIN (SELECT count(1) as totalfcts FROM FCTS fc,MEC_TITULO mt where fc.ciclo=mt.codigo_titulo_aragon and mt.codigo_familia like '%parametro1%' ) t  where m.codigo_titulo_aragon=f.ciclo and codigo_familia like '%parametro1%' group by nombre_empresa  order by numfcts desc
";

$dato='';
$csvs=new CSVS($filtro,$sql_graficos,$dal,$dato,$names);
$csvs_dcompletos=new CSVS($filtro,$sql_dcompletos,$dal_dcompletos,$dato,$names);

$familias = $dal->query($dal->c,$sql_fam);
foreach ($familias as $fam){
	//generamos un fichero csv con los datos de cada familia 
	$f=$fam->CODIGO_FAMILIA;
	$csvs->gen_csv($f,$sql_graficos);
	}


$familias = $dal_dcompletos->query($dal_dcompletos->c,$sql_fam);
foreach ($familias as $fam){
	//generamos un fichero csv con los datos de cada familia 
	$f=$fam->CODIGO_FAMILIA;
	$csvs_dcompletos->gen_csv($f,$sql_dcompletos);
    	//break;
	}
?>

