<?php

#DATOS EN BRUTO

$sql_brutos="select nombre,primer_apellido,segundo_apellido,telefono,email,codciclo,denciclo,c.provincia as provincia,ci.grado as grado,ci.codciclo,fct,trabaja,relacionado,contrato,mismaempresa from respuestas r, alumnos a, centros c,ciclos ci where ci.idciclofct=a.idciclofct and r.idalumnofct=a.idalumnofct and a.idcentrofct=c.idcentrofct and c.idcentrofct='pcentro' into outfile '/home/fpleaks/insercion_tiemposmodernos.csv' FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n'";


#CONSULTAS SIMPLES#########################################################################

#Alumnos inscritos en la encuesta en cada centro, incluyendo fcts y exentos
$sql_altafct="SELECT count(*) nafct from alumnos a, centros c where a.idcentrofct=c.idcentrofct and  fecha_fct='".$fecha_fct."' and a.idcentrofct='pcentro'";

#Alumnos finalizadofct
#$sql_altafct="SELECT count(*) nafct from alumnos a, centros c where a.idcentrofct=c.idcentrofct and  fecha_fct='".$fecha_fct."' and a.idcentrofct='pcentro'";

#Alumnos que han finalizado FCTs
#$sql_finalizado="SELECT count(*) nafct from respuestas r, alumnos a,ciclos c,centros cen  where a.idcentrofct=cen.idcentrofct and a.idciclofct=c.idciclofct and r.idalumnofct=a.idalumnofct and r.periodo='".$periodo."' and FCT='SI'  and a.idcentrofct='pcentro'";

#Alumnos que han respondido encuestas
#$sql_respondido="SELECT count(*) nafct from respuestas r, alumnos a,ciclos c,centros cen  where a.idcentrofct=cen.idcentrofct and a.idciclofct=c.idciclofct and r.idalumnofct=a.idalumnofct and r.periodo='".$periodo."' and  trabaja!='NSNC' and a.idcentrofct='pcentro'";

#Alumnos que han finalizado FCTs y han respondido encuestas
$sql_finresp="SELECT count(*) nafct from respuestas r, alumnos a ,ciclos c ,centros cen  where a.idcentrofct=cen.idcentrofct and a.idciclofct=c.idciclofct and  r.idalumnofct=a.idalumnofct and r.periodo='".$periodo."'  and a.idcentrofct='pcentro'";

#Alumnos que siguen estudiando
$sql_estudia="SELECT count(*) nafct from respuestas r, alumnos a,ciclos c, centros cen where a.idcentrofct=cen.idcentrofct and a.idciclofct=c.idciclofct and  r.idalumnofct=a.idalumnofct and r.periodo='".$periodo."' and trabaja='ESTUDIA' and a.idcentrofct='pcentro'";

#Alumnos que trabajan
$sql_trabaja="SELECT count(*) nafct from respuestas r, alumnos a,ciclos c, centros cen where a.idcentrofct=cen.idcentrofct and a.idciclofct=c.idciclofct and  r.idalumnofct=a.idalumnofct and r.periodo='".$periodo."'  and trabaja='TRABAJA' and a.idcentrofct='pcentro'";

#Alumnos que trabajan en algo relacionado
$sql_rrelacionado="SELECT count(*) nafct from respuestas r, alumnos a, ciclos c,centros cen where a.idcentrofct=cen.idcentrofct and  a.idciclofct=c.idciclofct and  r.idalumnofct=a.idalumnofct and r.periodo='".$periodo."'  and trabaja='TRABAJA' and relacionado='SI' and a.idcentrofct='pcentro'";

#Alumnos en desempleo
$sql_desempleo="SELECT count(*) nafct from respuestas r, alumnos a , ciclos c,centros cen where a.idcentrofct=cen.idcentrofct and  a.idciclofct=c.idciclofct and r.idalumnofct=a.idalumnofct and r.periodo='".$periodo."'   and trabaja='EN DESEMPLEO' and a.idcentrofct='pcentro'";

#FIN CONSULTAS SIMPLES#########################################################################

#CONSULTAS COMPLEJAS#########################################################################


$centros_trabaja_desempleo=
"
SELECT t2.grado as 'GRADO',ifnull( ifnull(t3.des,0)/(ifnull(t3.des,0)+ifnull(t2.tra,0))*100,0) as 'DESEMPLEO',ifnull(t2.tra,0)/ifnull((t3.des+t2.tra),1)*100 as 'TRABAJA' from ( select grado,count(*) as tra from respuestas r, alumnos a,ciclos c,centros cen where cen.idcentrofct=a.idcentrofct and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."'  and  trabaja='TRABAJA'  and a.idcentrofct='pcentro' group by grado ) as t2 LEFT JOIN ( select grado,count(*) as des from respuestas r, alumnos a,ciclos c,centros cen where cen.idcentrofct=a.idcentrofct and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."'  and  trabaja='EN DESEMPLEO' and a.idcentrofct='pcentro'  group by grado ) as t3 on t3.grado=t2.grado

UNION ALL

SELECT t2.grado as 'GRADO',ifnull( ifnull(t3.des,0)/(ifnull(t3.des,0)+ifnull(t2.tra,0))*100,0) as 'DESEMPLEO',ifnull(t2.tra,0)/ifnull((t3.des+t2.tra),1)*100 as 'TRABAJA' from ( select grado,count(*) as tra from respuestas r, alumnos a,ciclos c,centros cen where cen.idcentrofct=a.idcentrofct and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."'  and  trabaja='TRABAJA'  and a.idcentrofct='pcentro' group by grado ) as t2 RIGHT JOIN ( select grado,count(*) as des from respuestas r, alumnos a,ciclos c,centros cen where cen.idcentrofct=a.idcentrofct and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."'  and  trabaja='EN DESEMPLEO' and a.idcentrofct='pcentro'  group by grado ) as t3 on t3.grado=t2.grado 
where t2.grado is null or t3.grado is null
";

$centros_trabaja_relacionado=
"
SELECT t2.grado as 'GRADO', ifnull(t3.rel/t2.tra,0)*100 as 'TRABAJO RELACIONADO' from 
( SELECT grado,count(*) as tra from respuestas r, alumnos a,ciclos c,centros cen where cen.idcentrofct=a.idcentrofct and  c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and  trabaja='TRABAJA' and a.idcentrofct='pcentro' group by grado ) as t2 
LEFT JOIN 
( SELECT grado,count(*) as rel from respuestas r, alumnos a,ciclos c,centros cen where a.idcentrofct=cen.idcentrofct and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."'  and trabaja='TRABAJA'  and relacionado='SI' and a.idcentrofct='pcentro' group by grado ) as t3 
on t2.grado=t3.grado

UNION ALL

SELECT t2.grado as 'GRADO', ifnull(t3.rel/t2.tra,0)*100 as 'TRABAJO RELACIONADO' from 
( select grado,count(*) as tra from respuestas r, alumnos a,ciclos c,centros cen where cen.idcentrofct=a.idcentrofct and  c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and  trabaja='TRABAJA' and a.idcentrofct='pcentro' group by grado ) as t2 
RIGHT JOIN 
( SELECT grado,count(*) as rel from respuestas r, alumnos a,ciclos c,centros cen where a.idcentrofct=cen.idcentrofct and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."'  and trabaja='TRABAJA'  and relacionado='SI' and a.idcentrofct='pcentro' group by grado ) as t3 
on t2.grado=t3.grado
where t2.grado is null or t3.grado is null

";


$centros_trabaja_por_familias=
"
SELECT replace(t1.familia,',','') as 'FAMILIA', ifnull(t2.des/(ifnull(t2.des,0)+ifnull(t1.tra,0))*100,0) as 'DESEMPLEOPORFAMILIAS' , ifnull(t1.tra/(ifnull(t1.tra,0)+ifnull(t2.des,0))*100,0)  as 'TRABAJOPORFAMILIAS' from ( select familia,count(*) as tra from respuestas r, alumnos a,ciclos c,ciclos_familias cfa,centros cen where a.idcentrofct=cen.idcentrofct and c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and  trabaja='TRABAJA' and FCT='SI' and a.idcentrofct='pcentro' group by familia) as t1 LEFT JOIN ( select familia,count(*) as des from respuestas r, alumnos a,ciclos c,ciclos_familias cfa,centros cen where cen.idcentrofct=a.idcentrofct and c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and  trabaja='EN DESEMPLEO'  and a.idcentrofct='pcentro' group by familia) as t2 on t1.familia=t2.familia

UNION ALL

SELECT replace(t1.familia,',','') as 'FAMILIA', ifnull(t2.des/(ifnull(t2.des,0)+ifnull(t1.tra,0))*100,0) as 'DESEMPLEOPORFAMILIAS' ,ifnull(t1.tra/(ifnull(t1.tra,0)+ifnull(t2.des,0))*100,0)  as 'TRABAJOPORFAMILIAS' from ( select familia,count(*) as tra from respuestas r, alumnos a,ciclos c,ciclos_familias cfa,centros cen where a.idcentrofct=cen.idcentrofct and c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and  trabaja='TRABAJA' and FCT='SI' and a.idcentrofct='pcentro' group by familia) as t1 RIGHT JOIN ( select familia,count(*) as des from respuestas r, alumnos a,ciclos c,ciclos_familias cfa,centros cen where cen.idcentrofct=a.idcentrofct and c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and  trabaja='EN DESEMPLEO'  and a.idcentrofct='pcentro' group by familia) as t2 on t1.familia=t2.familia
where t1.familia is null or t2.familia is null
";

$centros_trabaja_relacionado_por_familias=
"
SELECT replace(t1.familia,',','') as 'FAMILIA', ifnull(t1.rel/(t2.tra)*100,0) as 'RELACIONADOPORFAMILIAS'  from ( select familia,count(*) as rel from respuestas r, alumnos a,ciclos c,ciclos_familias cfa,centros cen where a.idcentrofct=cen.idcentrofct and c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and  trabaja='TRABAJA' and relacionado='SI' and a.idcentrofct='pcentro' group by familia) as t1 LEFT JOIN ( select familia,count(*) as tra from respuestas r, alumnos a,ciclos c,ciclos_familias cfa,centros cen where cen.idcentrofct=a.idcentrofct and c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and  trabaja='TRABAJA'  and a.idcentrofct='pcentro' group by familia) as t2 on t1.familia=t2.familia

UNION ALL

SELECT replace(t1.familia,',','') as 'FAMILIA', ifnull(t1.rel/(t2.tra)*100,0) as 'RELACIONADOPORFAMILIAS'  from ( select familia,count(*) as rel from respuestas r, alumnos a,ciclos c,ciclos_familias cfa,centros cen where a.idcentrofct=cen.idcentrofct and c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and  trabaja='TRABAJA' and relacionado='SI' and a.idcentrofct='pcentro' group by familia) as t1 RIGHT JOIN ( select familia,count(*) as tra from respuestas r, alumnos a,ciclos c,ciclos_familias cfa,centros cen where cen.idcentrofct=a.idcentrofct and c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and  trabaja='TRABAJA'  and a.idcentrofct='pcentro' group by familia) as t2 on t1.familia=t2.familia
where t1.familia is null or t2.familia is null
";
$centros_trabaja_relacionado_por_familias0=
"
SELECT replace(t1.familia,',','') as 'FAMILIA', ifnull(t2.des/(ifnull(t2.des,0)+ifnull(t1.tra,0)),0)*100 as 'DESEMPLEOPORFAMILIAS' ,  ifnull( t1.tra/(ifnull(t1.tra,0)+ifnull(t2.des,0))*100,0)  as 'TRABAJOPORFAMILIAS' from ( select familia,count(*) as tra from respuestas r, alumnos a,ciclos c,ciclos_familias cfa,centros cen where a.idcentrofct=cen.idcentrofct and c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and  trabaja='TRABAJA' and relacionado='SI' and a.idcentrofct='pcentro' group by familia) as t1 LEFT JOIN ( select familia,count(*) as des from respuestas r, alumnos a,ciclos c,ciclos_familias cfa,centros cen where cen.idcentrofct=a.idcentrofct and c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and  trabaja='EN DESEMPLEO'  and a.idcentrofct='pcentro' group by familia) as t2 on t1.familia=t2.familia

UNION ALL

SELECT replace(t1.familia,',','') as 'FAMILIA', ifnull(t2.des/(ifnull(t2.des,0)+ifnull(t1.tra,0)),0)*100 as 'DESEMPLEOPORFAMILIAS' ,  ifnull( t1.tra/(ifnull(t1.tra,0)+ifnull(t2.des,0))*100,0)  as 'TRABAJOPORFAMILIAS' from ( select familia,count(*) as tra from respuestas r, alumnos a,ciclos c,ciclos_familias cfa,centros cen where a.idcentrofct=cen.idcentrofct and c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and  trabaja='TRABAJA' and relacionado='SI' and a.idcentrofct='pcentro' group by familia) as t1 RIGHT JOIN ( select familia,count(*) as des from respuestas r, alumnos a,ciclos c,ciclos_familias cfa,centros cen where cen.idcentrofct=a.idcentrofct and c.codciclo=cfa.codciclo and c.idciclofct=a.idciclofct and  r.idalumnofct=a.idalumnofct and  r.periodo='".$periodo."' and  trabaja='EN DESEMPLEO'  and a.idcentrofct='pcentro' group by familia) as t2 on t1.familia=t2.familia
where t1.familia is null or t2.familia is null
";

?>
