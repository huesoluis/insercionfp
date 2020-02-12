<?php 
//genrar csvs con datos de la matrícula por familia
// include configuration
require_once('../config.php');
// instanciate a new DAL
 
$dirdestino='../../csvs_ofertas_familias/';

$dal = new ACCESO($dirdestino);

$sql_real="SELECT so.familia as familia, COUNT(1) AS nofertas,COUNT(1) / t.totalofertas * 100 as porcentajeofertas FROM SERVICIO_OFERTAS so CROSS  JOIN (SELECT COUNT(1) AS totalofertas FROM SERVICIO_OFERTAS sof where sof.familia!='COM' ) t where so.familia!='COM' GROUP BY so.familia";


$csvs=new CSVS($filtro='',$sql_real,$dal,$dato='',$names='ofertas');
$sql_fam="SELECT FAMILIA from SIGAD_FAMILIA"; 
$csvs->gen_csv($f='',$sql_real,$names);

?>

