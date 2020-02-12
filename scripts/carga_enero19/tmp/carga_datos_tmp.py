import pandas as pd
import numpy as np
import os
from datetime import datetime
from dateutil.relativedelta import relativedelta
import re
import PyPDF2

import databaseconfig as cfg
from funciones import *

#SCRIPT PARA CARGAR DATOS DE ENCUESTAS DEL PRIMER DIA, ANTES DE LA RECARGA
#Leemos cada registro de respuestas de los ya insertados en la tabla temporal y los insertamos en la base original, porbaremos en la de pruebas priemro. Solo los insertamos si no hay respuestas en el destino

def check_respuesta(cd,ida,per):
	cr=cd.cursor()
	sql="select idalumnofct from respuestas where periodo='"+per+"' and idalumnofct='"+str(ida)+"'"
	cr.execute(sql)
	cr.fetchall()
	print(cr.rowcount)
	if(cr.rowcount==0): 
		print("no existe")
		return 0
	else:
		return 1

#Base origen
db_origen='TMP_INSERCION_LABORAL'
db_destino='INSERCION_LABORAL'

co=conecta(cfg.usuario,cfg.password,db_origen)
cd=conecta(cfg.usuario,cfg.password,db_destino)

n=fct=tra=''
cr=0
nresp=0
per='jun18'

sql_origen="select a.idalumnofct,nombre,a.primer_apellido,r.fct,r.trabaja,r.relacionado,r.contrato,r.mismaempresa from alumnos a, respuestas r where (fct!='NULL' or trabaja!='NULL' or relacionado!='NSNC' or contrato!='NSNC' or mismaempresa!='NSNC') and a.idalumnofct=r.idalumnofct and a.periodo='"+per+"'"

try:
	curd=cd.cursor()
	cursor=co.cursor()
	vo=cursor.execute(sql_origen)
	ro = cursor.fetchall()
	for r in ro:
		print("procesando: "+str(nresp))
		print(r)
		idal=r[0]
		fct=r[3]
		tra=r[4]
		cr=check_respuesta(cd,idal,per)
		if r[3] is None: fct='NULL'	
		if r[4] is None: tra='NULL'	
		if(cr==0):
			if(tra=='NULL' and fct=='NULL'):
				sql_destino="insert into respuestas values('"+str(r[0])+"','"+per+"',"+fct+","+tra+",'"+r[5]+"','"+r[6]+"','"+r[7]+"')"
			elif(tra=='NULL'):
				sql_destino="insert into respuestas values('"+str(r[0])+"','"+per+"','"+fct+"',"+tra+",'"+r[5]+"','"+r[6]+"','"+r[7]+"')"
			elif(fct=='NULL'):
				sql_destino="insert into respuestas values('"+str(r[0])+"','"+per+"',"+fct+",'"+tra+"','"+r[5]+"','"+r[6]+"','"+r[7]+"')"
			else:
				sql_destino="insert into respuestas values('"+str(r[0])+"','"+per+"','"+fct+"','"+tra+"','"+r[5]+"','"+r[6]+"','"+r[7]+"')"
		else:
			if(tra=='NULL' and fct=='NULL'):
				sql_destino="update respuestas set fct="+fct+",trabaja="+tra+",relacionado='"+r[5]+"',contrato='"+r[6]+"',mismaempresa='"+r[7]+"' where idalumnofct='"+str(r[0])+"'"
			elif(tra=='NULL'):
				sql_destino="update respuestas set fct='"+fct+"',trabaja="+tra+",relacionado='"+r[5]+"',contrato='"+r[6]+"',mismaempresa='"+r[7]+"' where idalumnofct='"+str(r[0])+"'"
			elif(fct=='NULL'):
				sql_destino="update respuestas set fct="+fct+",trabaja='"+tra+"',relacionado='"+r[5]+"',contrato='"+r[6]+"',mismaempresa='"+r[7]+"' where idalumnofct='"+str(r[0])+"'"
			else:
				sql_destino="update respuestas set fct='"+fct+"',trabaja='"+tra+"',relacionado='"+r[5]+"',contrato='"+r[6]+"',mismaempresa='"+r[7]+"' where idalumnofct='"+str(r[0])+"'"
		print(sql_destino)
		nresp=nresp+1
		vd=curd.execute(sql_destino)
		cd.commit()
except Exception as e:
	print(e)
	exit()


print("total respuestas: "+str(nresp))
co.close()
cd.close()


