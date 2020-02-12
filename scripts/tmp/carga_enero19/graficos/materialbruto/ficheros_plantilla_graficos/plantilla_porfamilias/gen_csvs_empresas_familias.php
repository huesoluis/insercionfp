<?php 
//genrar csvs con datos de empresas por familia
// include configuration
require_once(dirname(__FILE__) . '/config.php');
// instanciate a new DAL

$dirdestino='../csvs_empresas_familias/';
$dal = new ACCESO($dirdestino);
 
$dirdestino_completos='../csvs_empresas_familias_dcompletos/';
$dal_dcompletos = new ACCESO($dirdestino_completos);

$sql_graficos=
"
select substring(replace(so.empresa,',',''),1,20) as empresa, COUNT(1) AS total,COUNT(1)/t.totalofertas * 100  FROM SERVICIO_OFERTAS so,SIGAD_FAMILIA sf CROSS  JOIN (SELECT COUNT(1) AS totalofertas FROM SERVICIO_OFERTAS sof,SIGAD_FAMILIA sfa where sof.empresa!='' and sfa.codigo_familia=sof.familia and sfa.familia like '%parametro1%'  ) t where sf.familia like '%parametro1%' and so.empresa!='' and sf.CODIGO_FAMILIA=so.familia  GROUP BY so.empresa  order by total desc limit 20;
";
$sql_dcompletos=
"
select substring(replace(so.empresa,',',''),1,20) as empresa, COUNT(1) AS total,COUNT(1)/t.totalofertas * 100  FROM SERVICIO_OFERTAS so,SIGAD_FAMILIA sf CROSS  JOIN (SELECT COUNT(1) AS totalofertas FROM SERVICIO_OFERTAS sof,SIGAD_FAMILIA sfa where sof.empresa!='' and sfa.codigo_familia=sof.familia and sfa.familia like '%parametro1%'  ) t where sf.familia like '%parametro1%' and so.empresa!='' and sf.CODIGO_FAMILIA=so.familia  GROUP BY so.empresa  order by total desc;
";


$dato='nofertas';
$filtro='familia';
$names='empofertas';

$csvs=new CSVS($filtro,$sql_graficos,$dal,$dato,$names);
$csvs_dcompletos=new CSVS($filtro,$sql_dcompletos,$dal_dcompletos,$dato,$names);

$sql_fam="SELECT FAMILIA from SIGAD_FAMILIA"; 
$familias = $dal->query($dal->c,$sql_fam);
foreach ($familias as $fam){
	//generamos un fichero csv con los datos de cada familia 
	$f=$fam->FAMILIA;
	$csvs_dcompletos->gen_csv($f,$sql_dcompletos);
    	//break;
	}

$familias = $dal_dcompletos->query($dal_dcompletos->c,$sql_fam);

foreach ($familias as $fam){
	//generamos un fichero csv con los datos de cada familia 
	$f=$fam->FAMILIA;
	$csvs_dcompletos->gen_csv($f,$sql_dcompletos);
    	//break;
	}

?>

