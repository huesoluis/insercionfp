<?php
###DATOS CONSULTAS GLOBALES

#DATOS COMPLETOS EN BRUTO####################################################################

$cabecera_respuestas="select 'fecha fct', 'nombre','primer_apellido','segundo apellido','telefono','email','codigo ciclo','denominacion ciclo','provincia','grado','fct','trabaja','relacionado con el estudio','tipo de contrato','misma empresa' union ";
$sql_brutos_respuestas=$cabecera_respuestas." select a.periodo,nombre,primer_apellido,segundo_apellido,telefono,email,codciclo,denciclo,c.provincia as provincia,ci.grado as grado,fct,trabaja,relacionado,contrato,mismaempresa from alumnos a left join respuestas r on a.idalumnofct=r.idalumnofct, centros c,ciclos ci where ci.idciclofct=a.idciclofct and a.idcentro=c.idcentrofct  into outfile '/home/fpleaks/tmp/brutos.csv' FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n'";

#CONSULTAS SIMPLES#########################################################################

#Alumnos inscritos en fcts
$sql_altafct="SELECT count(*) nafct from alumnos where periodo='".$periodo."'";
$sql_altafct="SELECT count(*) nafct from alumnos_respuestas where periodo='".$periodo."'";

$raltafct = $dal->query($dal->c,$sql_altafct);
$datafct[]=$raltafct[0]['nafct'];
$datafct[]="100%";

#Alumnos que han finalizado FCTs
$sql_finalizado="SELECT count(*) nafct from respuestas r, alumnos a where  r.idalumnofct=a.idalumnofct and r.periodo='".$periodo."' and FCT!='NO'";
$sql_finalizado="SELECT count(*) nafct from alumnos_respuestas where  periodo='".$periodo."' and fct!='NO'";

$rfinalizado = $dal->query($dal->c,$sql_finalizado);
$datafct[]=$rfinalizado[0]['nafct'];
$datafct[]=floor($rfinalizado[0]['nafct']/$raltafct[0]['nafct']*100).'%';

#Alumnos que han respondido encuestas
$sql_respondido="SELECT count(*) nafct from respuestas r, alumnos a where  r.idalumnofct=a.idalumnofct and r.periodo='".$periodo."' and trabaja!='NSNC'";
$sql_respondido="SELECT count(*) nafct from alumnos_respuestas  where periodo='".$periodo."' and trabaja!='NSNC'";

$rrespondido = $dal->query($dal->c,$sql_respondido);
$datafct[]=$rrespondido[0]['nafct'];
$datafct[]=floor($rrespondido[0]['nafct']/$raltafct[0]['nafct']*100).'%';


#Alumnos que han finalizado FCTs y han respondido encuestas
$sql_finresp="SELECT count(*) nafct from respuestas r, alumnos a where  r.idalumnofct=a.idalumnofct and r.periodo='".$periodo."' and FCT!='NO' and trabaja!='NSNC'";
$sql_finresp="SELECT count(*) nafct from alumnos_respuestas where  periodo='".$periodo."' and FCT!='NO' and trabaja!='NSNC'";

$rfinresp = $dal->query($dal->c,$sql_finresp);
$datafct[]=$rfinresp[0]['nafct'];
$datafct[]=floor($rfinresp[0]['nafct']/$raltafct[0]['nafct']*100).'%';


#Alumnos que siguen estudiando
$sql_estudia="SELECT count(*) nafct from respuestas r, alumnos a where  r.idalumnofct=a.idalumnofct and r.periodo='".$periodo."' and FCT='SI' and trabaja='ESTUDIA'";
$sql_estudia="SELECT count(*) nafct from alumnos_respuestas where  periodo='".$periodo."' and FCT='SI' and trabaja='ESTUDIA'";

$restudia = $dal->query($dal->c,$sql_estudia);
$datafct[]=$restudia[0]['nafct'];
$datafct[]=floor($restudia[0]['nafct']/$rfinresp[0]['nafct']*100).'%';

#Alumnos que trabajan
$sql_trabaja="SELECT count(*) nafct from respuestas r, alumnos a where  r.idalumnofct=a.idalumnofct and r.periodo='".$periodo."' and FCT='SI' and trabaja='TRABAJA'";
$sql_trabaja="SELECT count(*) nafct from alumnos_respuestas where periodo='".$periodo."' and FCT='SI' and trabaja='TRABAJA'";

$rtrabaja = $dal->query($dal->c,$sql_trabaja);
$datafct[]=$rtrabaja[0]['nafct'];
$datafct[]=floor($rtrabaja[0]['nafct']/$rfinresp[0]['nafct']*100).'%';

#Alumnos en desempleo
$sql_desempleo="SELECT count(*) nafct from respuestas r, alumnos a where  r.idalumnofct=a.idalumnofct and r.periodo='".$periodo."' and FCT='SI' and trabaja='EN DESEMPLEO'";
$sql_desempleo="SELECT count(*) nafct from alumnos_respuestas where periodo='".$periodo."' and FCT='SI' and trabaja='EN DESEMPLEO'";

$rdesempleo = $dal->query($dal->c,$sql_desempleo);
$datafct[]=$rdesempleo[0]['nafct'];
$datafct[]=floor($rdesempleo[0]['nafct']/$rfinresp[0]['nafct']*100).'%';

#Alumnos que trabajan en algo relacionado
$sql_rrelacionado="SELECT count(*) nafct from respuestas r, alumnos a where  r.idalumnofct=a.idalumnofct and r.periodo='".$periodo."' and FCT='SI' and trabaja='TRABAJA' and relacionado='SI'";
$sql_rrelacionado="SELECT count(*) nafct from alumnos_respuestas  where periodo='".$periodo."' and FCT='SI' and trabaja='TRABAJA' and relacionado='SI'";

$rrelacionado = $dal->query($dal->c,$sql_rrelacionado);
#$datafct[]=$rrelacionado[0]['nafct'];
#$datafct[]=floor($rrelacionado[0]['nafct']/$rfinresp[0]['nafct']*100).'%';


#Alumnos que trabajan respecto al total de alumnos que quieren trabajar (en desempleo + trabajando)
$datafct[]='';
$datafct[]=floor($rtrabaja[0]['nafct']/($rdesempleo[0]['nafct']+$rtrabaja[0]['nafct'])*100).'%';
#Alumnos que trabajan en algo relacionado respecto al total de alumnos que trabaja
$datafct[]='';
$datafct[]=floor($rrelacionado[0]['nafct']/($rtrabaja[0]['nafct'])*100).'%';

/*
#FIN CONSULTAS SIMPLES#########################################################################


#CONSULTAS COMPLEJAS#########################################################################

#De todos los que quieren trabajar, es decir, quitando los que estudian, cuales están en desempleo y cuales trabajan
 
$global_trabaja_desempleo=
"
 SELECT t2.grado as 'GRADO', t2.des/(t2.des+t3.tra)*100 as 'DESEMPLEO',t3.tra/(t2.des+t3.tra)*100 as 'TRABAJA' from 
( select grado,count(*) as des from respuestas r, alumnos a,ciclos c where c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and  trabaja='EN DESEMPLEO' and FCT!='NO' group by grado ) as t2 
LEFT JOIN 
( select grado,count(*) as tra from respuestas r, alumnos a,ciclos c where c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and trabaja='TRABAJA' and FCT!='NO' group by grado ) as t3 
on t2.grado=t3.grado";

$global_trabaja_relacionado=
"
SELECT t2.grado as 'GRADO', t3.rel/t2.tra*100 as 'TRABAJO RELACIONADO' from 
( select grado,count(*) as tra from respuestas r, alumnos a,ciclos c where c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and  trabaja='TRABAJA' and FCT!='NO' group by grado ) as t2 
LEFT JOIN 
( select grado,count(*) as rel from respuestas r, alumnos a,ciclos c where c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and trabaja='TRABAJA' and FCT!='NO' and relacionado='SI' group by grado ) as t3 
on t2.grado=t3.grado";

$global_trabaja_por_familias=
"
SELECT replace(t1.familia,',','') as 'FAMILIA', t2.des/(t2.des+t1.tra)*100 as 'DESEMPLEOPORFAMILIAS' , t1.tra/(t1.tra+t2.des)*100 as 'TRABAJOPORFAMILIAS' from 
( select familia,count(*) as tra from respuestas r, alumnos a,ciclos c,ciclo_familia cfa where c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and  trabaja='TRABAJA' and FCT!='NO' group by familia) as t1
LEFT JOIN 
( select familia,count(*) as des from respuestas r, alumnos a,ciclos c,ciclo_familia cfa where c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and  trabaja='EN DESEMPLEO' and FCT!='NO' group by familia) as t2 
on t1.familia=t2.familia 
and t1.tra is not null
and t2.des is not null
order by TRABAJOPORFAMILIAS desc";

$global_trabaja_relacionado_por_familias=
"
SELECT replace(t1.familia,',','') as 'FAMILIA', t2.rel/(t1.tra)*100 as 'RELACIONADOPORFAMILIAS' from 
( select familia,count(*) as tra from respuestas r, alumnos a,ciclos c,ciclo_familia cfa where c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and  trabaja='TRABAJA' and FCT!='NO'  group by familia) as t1
LEFT JOIN 
( select familia,count(*) as rel from respuestas r, alumnos a,ciclos c,ciclo_familia cfa where c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and  trabaja='TRABAJA' and FCT!='NO' and relacionado='SI' group by familia) as t2 
on t1.familia=t2.familia 
and t1.tra is not null
and t2.rel is not null
order by RELACIONADOPORFAMILIAS desc";

$global_trabaja_por_centros=
"
SELECT replace(t1.nombrecentro,',','') as 'CENTRO', t2.des/(t2.des+t1.tra)*100 as 'DESEMPLEOPORCENTROS' , t1.tra/(t1.tra+t2.des)*100 as 'TRABAJOPORCENTROS' from 
( select nombrecentro,count(*) as tra from respuestas r, alumnos a,ciclos c,ciclo_familia cfa,centros cen where cen.idcentrofct=a.idcentro and c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and  trabaja='TRABAJA' and FCT!='NO' group by idcentro) as t1
LEFT JOIN 
( select nombrecentro,count(*) as des from respuestas r, alumnos a,ciclos c,ciclo_familia cfa,centros cen where cen.idcentrofct=a.idcentro and c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and  trabaja='EN DESEMPLEO' and FCT!='NO' group by idcentro) as t2 
on t1.nombrecentro=t2.nombrecentro 
and t1.tra is not null
and t2.des is not null
order by TRABAJOPORCENTROS desc";


$global_trabaja_relacionado_por_centros=
"
SELECT replace(t1.nombrecentro,',','') as 'CENTRO', t2.rel/(t1.tra)*100 as 'RELACIONADOPORCENTROS'  from 
( select nombrecentro,idcentro,count(*) as tra from respuestas r, alumnos a,ciclos c,ciclo_familia cfa,centros cen where cen.idcentrofct=a.idcentro and c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and  trabaja='TRABAJA' and FCT!='NO' group by idcentro) as t1
LEFT JOIN 
( select nombrecentro,idcentro,count(*) as rel from respuestas r, alumnos a,ciclos c,ciclo_familia cfa,centros cen where cen.idcentrofct=a.idcentro and c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and  trabaja='TRABAJA' and FCT!='NO' and relacionado='SI' group by idcentro) as t2 
on t1.idcentro=t2.idcentro 
and t1.tra is not null
and t2.rel is not null
order by RELACIONADOPORCENTROS desc";

$centros_trabaja=
"
 SELECT t1.grado as 'GRADO',t1.est/(t1.est+t2.des+t3.tra)*100 as 'ESTUDIA', t2.des/(t1.est+t2.des+t3.tra)*100 as 'DESEMPLEO',t3.tra/(t1.est+t2.des+t3.tra)*100 as 'TRABAJA' from 
( select grado,count(*) est from respuestas r, alumnos a,ciclos c,centros cen where cen.idcentrofct='%param_centro%' and cen.idcentrofct=a.idcentro and  c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and  trabaja='ESTUDIA' and FCT!='NO' group by grado ) as t1 
LEFT JOIN 
( select grado,count(*) as des from respuestas r, alumnos a,ciclos c,centros cen where cen.idcentrofct='%param_centro%' and cen.idcentrofct=a.idcentro and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and  trabaja='EN DESEMPLEO' and FCT!='NO' group by grado ) as t2 
on t1.grado=t2.grado 
LEFT JOIN 
( select grado,count(*) as tra from respuestas r, alumnos a,ciclos c, centros cen where cen.idcentrofct='%param_centro%' and cen.idcentrofct=a.idcentro and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and trabaja='TRABAJA' and FCT!='NO' group by grado ) as t3 
on t2.grado=t3.grado";
*/
?>
