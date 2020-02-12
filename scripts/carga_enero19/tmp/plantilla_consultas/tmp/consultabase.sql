use FPDATA_DB;
SELECT concat('\"codigo\":','\"',cp.CODIGO_CUALIFICACION,'\"',',\"den_cual\":',"\"", 
	upper(replace(cp.DENOMINACION,'"','\"')),"\"",'-n-',
	'\"codigo\":','\"',uc.CODIGO_UNIDAD,'\"',',\"denominacion\":','\"',replace(uc.DENOMINACION,'"','\\"'),'\"') 
FROM INCUAL_CUALIFICACION_PROF cp, INCUAL_CUALIFICACION_UNIDAD cu, INCUAL_UNIDAD_COMPETENCIA uc
Where cp.CODIGO_CUALIFICACION=cu.CODIGO_CUALIFICACION
and uc.CODIGO_UNIDAD=cu.CODIGO_UNIDAD_COMPETENCIA

