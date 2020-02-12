use FPDATA_DB;
SELECT concat(
	'\"codigo\":','\"',cp.CODIGO_FAMILIA,'\"',
	'-n-',
	'\"codigo\":','\"',cp.CODIGO_CUALIFICACION,'\"',',\"den_cual\":',"\"", upper(replace(cp.DENOMINACION,'"','')),"\"",
	'-n-',
	'\"codigo\":','\"',uc.CODIGO_UNIDAD,'\"',',\"denominacion\":','\"',replace(uc.DENOMINACION,'"',''),'\"') 
FROM SIGAD_FAMILIA sf,INCUAL_CUALIFICACION_PROF cp, INCUAL_CUALIFICACION_UNIDAD cu, INCUAL_UNIDAD_COMPETENCIA uc
Where cp.CODIGO_CUALIFICACION=cu.CODIGO_CUALIFICACION
and uc.CODIGO_UNIDAD=cu.CODIGO_UNIDAD_COMPETENCIA
and sf.CODIGO_FAMILIA=cp.CODIGO_FAMILIA


#PARA EL CASO DE BASES ORACLE
select  '"denominacion":' || '"' || ci.denominacion || '"' || ',"ciclo":' || '"'|| CI.CICLO || '"' ||
'-n-' ||
'"empresa":' ||'"'|| em.nombre_empresa ||'"' || ',"urlempresa":'||'"'||'https://www.google.es/search?q='||em.nombre_empresa||'"'
from fct_alumnos al, FCT_ALUMNOSPROGRAMA ap, FCT_TUTORESTRABAJO tt,FCT_EMPRESAS_CENTROSTRA et, FCT_EMPRESAS em,FCT_CICLOS ci
where al.id_alumno=ap.ID_ALUMNO 
and ci.ID_CICLO=al.ID_CICLO
and ci.curso=al.curso
and al.CURSO=ap.CURSO 
and  tt.CURSO=al.curso 
and tt.ID_TUTORTRABAJO =ap.ID_TUTORTRABAJO
and tt.ID_CENTROTRABAJO=et.ID_CENTROTRABAJO
and tt.curso=et.CURSO
and em.CURSO=al.curso
and em.ID_EMPRESA=et.ID_EMPRESA
group by CI.DENOMINACION, ci.ciclo,em.nombre_empresa
order by CI.DENOMINACION, em.nombre_empresa;
