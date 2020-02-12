<?php

#generamos csvs a partir de los datos de matrícula en la base de datos

#el formato es, en las columnas el eje X, cada valor con varis posibilidades que están en la primera columna, en el eje Y el número de laumnos
/*
por ejemplo

num	F1	F2	F3
H	1	1	3
Z	4	5	3
T	9	8	3
*/

#nos conectamos a la base de datos

#hacemos la consulta





?>
consulta_fpgraphs.txt


select t1.gz,t1.nal as "zaragoza", t2.nal as "Huesca", t3.nal as "Teruel"
from

(select count(*) as nal, grado gz from GIR_MATRICULA gm,GIR_CENTRO gc where gm.num_matriculados=gc.iddenomcentro and gc.provincia='Zaragoza' group by grado) as t1,

(select count(*) as nal, grado gh from GIR_MATRICULA gm,GIR_CENTRO gc where gm.num_matriculados=gc.iddenomcentro and gc.provincia='Huesca' group by grado) as t2,

(select count(*) as nal, grado gt from GIR_MATRICULA gm,GIR_CENTRO gc where gm.num_matriculados=gc.iddenomcentro and gc.provincia='Teruel' group by grado) as t3

where 

t1.gz=t2.gh

and

t1.gz=t3.gt


	
	
