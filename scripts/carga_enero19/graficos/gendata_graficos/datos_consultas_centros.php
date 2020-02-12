<?php

#DATOS EN BRUTO

$sql_brutos="select nombre,primer_apellido,segundo_apellido,telefono,email,codciclo,denciclo,c.provincia as provincia,ci.grado as grado,ci.codciclo,fct,trabaja,relacionado,contrato,mismaempresa from respuestas r, alumnos a, centros c,ciclos ci where ci.idciclofct=a.idciclofct and r.idalumnofct=a.idalumnofct and a.idcentro=c.idcentrofct and c.idcentrofct='pcentro' into outfile '/home/fpleaks/insercion_tiemposmodernos.csv' FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n'";


#CONSULTAS SIMPLES#########################################################################

#Alumnos inscritos en fcts en cada centro
$sql_altafct="SELECT count(*) nafct from alumnos a, centros c where a.idcentro=c.idcentrofct and  periodo='".$periodo."' and idcentrofct='pcentro'";

#Alumnos que han finalizado FCTs
$sql_finalizado="SELECT count(*) nafct from respuestas r, alumnos a,ciclos c,centros cen  where a.idcentro=cen.idcentrofct and a.idciclofct=c.idciclofct and r.idalumnofct=a.idalumnofct and r.periodo='".$periodo."' and FCT='SI'  and a.idcentro='pcentro'";

#Alumnos que han respondido encuestas
$sql_respondido="SELECT count(*) nafct from respuestas r, alumnos a,ciclos c,centros cen  where a.idcentro=cen.idcentrofct and a.idciclofct=c.idciclofct and r.idalumnofct=a.idalumnofct and r.periodo='".$periodo."' and  trabaja!='NSNC' and a.idcentro='pcentro'";

#Alumnos que han finalizado FCTs y han respondido encuestas
$sql_finresp="SELECT count(*) nafct from respuestas r, alumnos a ,ciclos c ,centros cen  where a.idcentro=cen.idcentrofct and a.idciclofct=c.idciclofct and  r.idalumnofct=a.idalumnofct and r.periodo='".$periodo."' and FCT='SI'  and trabaja!='NSNC' and a.idcentro='pcentro'";

#Alumnos que siguen estudiando
$sql_estudia="SELECT count(*) nafct from respuestas r, alumnos a,ciclos c, centros cen where a.idcentro=cen.idcentrofct and a.idciclofct=c.idciclofct and  r.idalumnofct=a.idalumnofct and r.periodo='".$periodo."' and FCT='SI' and trabaja='ESTUDIA' and a.idcentro='pcentro'";

#Alumnos que trabajan
$sql_trabaja="SELECT count(*) nafct from respuestas r, alumnos a,ciclos c, centros cen where a.idcentro=cen.idcentrofct and a.idciclofct=c.idciclofct and  r.idalumnofct=a.idalumnofct and r.periodo='".$periodo."' and FCT='SI' and trabaja='TRABAJA' and a.idcentro='pcentro'";

#Alumnos que trabajan en algo relacionado
$sql_rrelacionado="SELECT count(*) nafct from respuestas r, alumnos a, ciclos c,centros cen where a.idcentro=cen.idcentrofct and  a.idciclofct=c.idciclofct and  r.idalumnofct=a.idalumnofct and r.periodo='".$periodo."' and FCT='SI'  and trabaja='TRABAJA' and relacionado='SI' and a.idcentro='pcentro'";

#Alumnos en desempleo
$sql_desempleo="SELECT count(*) nafct from respuestas r, alumnos a , ciclos c,centros cen where a.idcentro=cen.idcentrofct and  a.idciclofct=c.idciclofct and r.idalumnofct=a.idalumnofct and r.periodo='".$periodo."' and FCT='SI'  and trabaja='EN DESEMPLEO' and a.idcentro='pcentro'";

#FIN CONSULTAS SIMPLES#########################################################################

#CONSULTAS COMPLEJAS#########################################################################

$centros_trabaja_desempleo=
"
 SELECT t2.grado as 'GRADO', t2.des/(t2.des+t3.tra)*100 as 'DESEMPLEO',t3.tra/(t2.des+t3.tra)*100 as 'TRABAJA' from 
( select grado,count(*) as des from respuestas r, alumnos a,ciclos c,centros cen where cen.idcentrofct=a.idcentro and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and FCT='SI' and  trabaja='EN DESEMPLEO'  and a.idcentro='pcentro' group by grado ) as t2 
LEFT JOIN 
( select grado,count(*) as tra from respuestas r, alumnos a,ciclos c,centros cen where cen.idcentrofct=a.idcentro and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and FCT='SI' and  trabaja='TRABAJA' and a.idcentro='pcentro'  group by grado ) as t3 
on t2.grado=t3.grado";

$centros_trabaja_relacionado=
"
SELECT t2.grado as 'GRADO', t3.rel/t2.tra*100 as 'TRABAJO RELACIONADO' from 
( select grado,count(*) as tra from respuestas r, alumnos a,ciclos c,centros cen where cen.idcentrofct=a.idcentro and  c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and FCT='SI' and  trabaja='TRABAJA' and a.idcentro='pcentro' group by grado ) as t2 
LEFT JOIN 
( select grado,count(*) as rel from respuestas r, alumnos a,ciclos c,centros cen where a.idcentro=cen.idcentrofct and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and FCT='SI'  and trabaja='TRABAJA'  and relacionado='SI' and a.idcentro='pcentro' group by grado ) as t3 
on t2.grado=t3.grado";

$centros_trabaja_por_familias=
"
SELECT replace(t1.familia,',','') as 'FAMILIA', ifnull(t2.des,0)/(ifnull(t2.des,0)+t1.tra)*100 as 'DESEMPLEOPORFAMILIAS' ,   t1.tra/(t1.tra+ifnull(t2.des,0))*100  as 'TRABAJOPORFAMILIAS' from ( select familia,count(*) as tra from respuestas r, alumnos a,ciclos c,ciclo_familia cfa,centros cen where a.idcentro=cen.idcentrofct and c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and  trabaja='TRABAJA' and FCT='SI' and a.idcentro='pcentro' group by familia) as t1 LEFT JOIN ( select familia,count(*) as des from respuestas r, alumnos a,ciclos c,ciclo_familia cfa,centros cen where cen.idcentrofct=a.idcentro and c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and  trabaja='EN DESEMPLEO' and FCT='SI' and a.idcentro='pcentro' group by familia) as t2 on t1.familia=t2.familia

union

SELECT replace(t1.familia,',','') as 'FAMILIA', ifnull(t2.des,0)/(ifnull(t2.des,0)+t1.tra)*100 as 'DESEMPLEOPORFAMILIAS' ,   t1.tra/(t1.tra+ifnull(t2.des,0))*100  as 'TRABAJOPORFAMILIAS' from ( select familia,count(*) as tra from respuestas r, alumnos a,ciclos c,ciclo_familia cfa,centros cen where a.idcentro=cen.idcentrofct and c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and  trabaja='TRABAJA' and FCT='SI' and a.idcentro='pcentro' group by familia) as t1 RIGHT JOIN ( select familia,count(*) as des from respuestas r, alumnos a,ciclos c,ciclo_familia cfa,centros cen where cen.idcentrofct=a.idcentro and c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and  trabaja='EN DESEMPLEO' and FCT='SI' and a.idcentro='pcentro' group by familia) as t2 on t1.familia=t2.familia
";

$centros_trabaja_relacionado_por_familias=
"
SELECT replace(t1.familia,',','') as 'FAMILIA', ifnull(t2.des,0)/(ifnull(t2.des,0)+t1.tra)*100 as 'DESEMPLEOPORFAMILIAS' ,   t1.tra/(t1.tra+ifnull(t2.des,0))*100  as 'TRABAJOPORFAMILIAS' from ( select familia,count(*) as tra from respuestas r, alumnos a,ciclos c,ciclo_familia cfa,centros cen where a.idcentro=cen.idcentrofct and c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and  trabaja='TRABAJA' and FCT='SI' and a.idcentro='pcentro' group by familia) as t1 LEFT JOIN ( select familia,count(*) as des from respuestas r, alumnos a,ciclos c,ciclo_familia cfa,centros cen where cen.idcentrofct=a.idcentro and c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and  trabaja='EN DESEMPLEO' and FCT='SI' and a.idcentro='pcentro' group by familia) as t2 on t1.familia=t2.familia

union

SELECT replace(t1.familia,',','') as 'FAMILIA', ifnull(t2.des,0)/(ifnull(t2.des,0)+t1.tra)*100 as 'DESEMPLEOPORFAMILIAS' ,   t1.tra/(t1.tra+ifnull(t2.des,0))*100  as 'TRABAJOPORFAMILIAS' from ( select familia,count(*) as tra from respuestas r, alumnos a,ciclos c,ciclo_familia cfa,centros cen where a.idcentro=cen.idcentrofct and c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and  trabaja='TRABAJA' and FCT='SI' and a.idcentro='pcentro' group by familia) as t1 RIGHT JOIN ( select familia,count(*) as des from respuestas r, alumnos a,ciclos c,ciclo_familia cfa,centros cen where cen.idcentrofct=a.idcentro and c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='jun18' and  trabaja='EN DESEMPLEO' and FCT='SI' and a.idcentro='pcentro' group by familia) as t2 on t1.familia=t2.familia
";

?>
