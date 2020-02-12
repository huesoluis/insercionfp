#Tener en cuenta que la matricula es mensual o se auqe habría que fiultrar la fecha

use FPDATA_DB;
select t1.gz,t1.nal as "Zaragoza", t2.nal as "Huesca", t3.nal as "Teruel"
from
(select count(*) as nal, grado gz from GIR_MATRICULA gm,GIR_CENTRO gc where gm.cod_centro=gc.iddenomcentro and gc.provincia='Zaragoza' group by grado) as t1,
(select count(*) as nal, grado gh from GIR_MATRICULA gm,GIR_CENTRO gc where gm.cod_centro=gc.iddenomcentro and gc.provincia='Huesca' group by grado) as t2,
(select count(*) as nal, grado gt from GIR_MATRICULA gm,GIR_CENTRO gc where gm.cod_centro=gc.iddenomcentro and gc.provincia='Teruel' group by grado) as t3
where 
t1.gz=t2.gh
and
t1.gz=t3.gt

