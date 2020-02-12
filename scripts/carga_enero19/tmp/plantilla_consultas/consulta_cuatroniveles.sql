use FPDATA_DB;
SELECT concat(
	'\"codigo\":','\"',mt.codigo_titulo_aragon,'\"',
	',\"denominacion\":','\"',mt.denominacion_titulo_aragon,'\"',
	'-n-',
	'\"modulo\":','\"',tam.nombre_modulo,'\"',
	'-n-',
	'\"resultado\":','\"',mar.resultado,'\"',
	'-n-',
	'\"criterio\":','\"',c.criterio,'\"') 
FROM
MEC_TITULO mt, MEC_TITULOARAGON_MODULOS tam, MEC_MODULOSARAGON_RESULTADOS mar,  MEC_CRITERIOSEVALUACION c 
where 
mt.codigo_titulo_aragon=tam.codigo_titulo_aragon 
and 
tam.codigo=mar.codigo_modulo 
and 
mar.codigo_resultado=c.codigo_resultado
order by mt.codigo_titulo_aragon,tam.nombre_modulo,mar.resultado; 
