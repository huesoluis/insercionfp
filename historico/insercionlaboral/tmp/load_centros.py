import pandas as pd
import numpy as np
import os
from datetime import datetime
from dateutil.relativedelta import relativedelta
import re
import PyPDF2
import mysql.connector

def get_centro_fromtutor(tut):
	with open('datos/tutores_centrosfcts.csv') as f:
		for line in f:
			line=line.strip()
			tdata=line.split(';')
			if(tdata[0]==tut):
				return tdata[1]
	return 0		
def get_centro(al):
	with open('datos/alumnos_centrosfcts.csv') as f:
		for line in f:
			line=line.strip()
			adata=line.split(';')
			if(adata[0]==al):
				return adata[1]
	return 0		

def insertar_centro(c,centro,alumno,cursor):

	sql='update alumnos set idcentro="'+centro+'" where idalumno="'+alumno+'"'
	print(sql)
	try:
		vd=cursor.execute(sql)
	except Exception as e:
    		print(e)
    		print("Error insertando ocupacion")
	c.commit()
	return 1

nfiles=0
cnx = mysql.connector.connect(user='root',password='Suricato1.fp', database='INSERCION_LABORALFP')
cursor = cnx.cursor()
nr=0
with open('datos/alumnos_tutoresins.csv') as f:
	for line in f:
		line=line.strip()
		print(line)
		adata=line.split('\t')
		print("\n\n\nProcesando :"+str(adata)+"\n")
		tutor=adata[1]
		alumno=adata[0]
		centro=get_centro_fromtutor(tutor)
		if(centro!=0):
			insertar_centro(cnx,centro,alumno,cursor)
			nr=nr+1
		else:
			print("centro inexistente")
print("total registros insertados:"+str(nr))
'''
with open('datos/alumnos_centrosins.csv') as f:
	for line in f:
		line=line.strip()
		print(line)
		adata=line.split(' ')
		print("\n\n\nProcesando :"+str(adata)+"\n")
		alumno=adata[0]
		centro=get_centro(alumno)
		if(centro!=0):
			insertar_centro(cnx,centro,alumno,cursor)
		else:
			print("centro inexistente")

'''
cursor.close()
cnx.close()
#cnx.close()


