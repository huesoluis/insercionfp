use FPDATA_DB;
select t1.cc,t1.nal as "MUJERES", t2.nal as "HOMBRES"
from
(select count(*) as nal, codigo_ciclo cc from GIR_MATRICULA gm,GIR_CENTRO gc where gm.cod_centro=gc.iddenomcentro and fecha='9042018' and sexo='M' group by codigo_ciclo) as t1,
(select count(*) as nal, codigo_ciclo cc from GIR_MATRICULA gm,GIR_CENTRO gc where gm.cod_centro=gc.iddenomcentro and fecha='9042018' and sexo='H' group by codigo_ciclo) as t2
where 
t1.cc=t2.cc

