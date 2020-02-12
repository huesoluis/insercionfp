import pandas as pd
import numpy as np
import os
from datetime import datetime
from dateutil.relativedelta import relativedelta
import re
import PyPDF2

import databaseconfig as cfg
from funciones import *

#DATOS GLOBALES
dir_datos='datos/'
periodo='dic18'
#cargamos dtos de usuarios alumnos, tutores y directores, solo de los nuevos que pueda haber

falumnos='alumnos_final.csv'
ftutores='tutores.csv'

factualizaralumnos='dnistelefono_alumnosfct1819_SIGAD.csv'

c=conecta(cfg.usuario,cfg.password,cfg.database)

#solo para pruebas
#res=vaciar_tablas(c)
#print("Tablas vacias\n")

nualumnos=carga_usuarios(c,dir_datos+falumnos)
nalumnos=carga_alumnos(c,dir_datos+falumnos)
print("USUARIOS ALUMNOS Cargados: "+str(nualumnos))
print("ALUMNOS Cargados: "+str(nalumnos))
'''
nututores=carga_usuarios(c,dir_datos+ftutores)
print("USUARIOS TUTORES Cargados: "+str(nututores))
ntutores=carga_tutores(c,dir_datos+ftutores)
print("TUTORES Cargados: "+str(ntutores))
nualumnos=carga_usuarios(c,dir_datos+falumnos)
nalumnos=carga_alumnos(c,dir_datos+falumnos)
print("USUARIOS ALUMNOS Cargados: "+str(nualumnos))
print("ALUMNOS Cargados: "+str(nalumnos))

nututores=carga_usuarios(c,dir_datos+ftutores)
print("USUARIOS TUTORES Cargados: "+str(nututores))
ntutores=carga_tutores(c,dir_datos+ftutores)
print("TUTORES Cargados: "+str(ntutores))

if(periodo=='dic18'):
	nualumnos=carga_usuarios(c,dir_datos+falumnos_dic18)
	nalumnos=carga_alumnos(c,dir_datos+falumnos_dic18)
	print("DIC18 ALUMNOS Cargados: "+str(nualumnos))
elif(periodo=='jun18'):
	nualumnos=carga_usuarios(c,dir_datos+falumnos_jun18)
	nalumnos=carga_alumnos(c,dir_datos+falumnos_jun18)
	print("JUN18 Cargados: "+str(nalumnos))
else:
	nualumnos=carga_usuarios(c,dir_datos+falumnos_dic18)
	nualumnos+=carga_usuarios(c,dir_datos+falumnos_jun18)
	print("USUARIOS TOTAL ALUMNOS Cargados: "+str(nualumnos))
	nalumnos=carga_alumnos(c,dir_datos+falumnos_dic18)
	nalumnos+=carga_alumnos(c,dir_datos+falumnos_jun18)
	print("ALUMNOS TOTAL Cargados: "+str(nalumnos))

nalumnos=actualizar_alumnos(c,dir_datos+factualizaralumnos)
'''
c.close()


