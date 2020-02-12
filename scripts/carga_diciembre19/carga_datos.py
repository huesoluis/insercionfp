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
#cargamos dtos de usuarios alumnos, tutores y directores, solo de los nuevos que pueda haber

ftutores='tutores_2019.csv'
falumnos_jun19='alumnos_jun19_6meses.csv'
falumnos_dic18='alumnos_dic18_12meses.csv'

factualizaralumnos='dnistelefono_alumnosfct1819_SIGAD.csv'

c=conecta(cfg.usuario,cfg.password,cfg.database)

#solo para pruebas
#res=vaciar_tablas(c)
#print("Tablas vacias\n")

#nalumnos=actualizar_alumnos(c,dir_datos+factualizaralumnos)

'''
nututores=carga_usuarios(c,dir_datos+ftutores)
print("USUARIOS TUTORES Cargados: "+str(nututores))


ntutores=carga_tutores(c,dir_datos+ftutores)
print("TUTORES Cargados: "+str(ntutores))


#ALUMNOS DE HACE 6 MESES
nualumnos=carga_usuarios(c,dir_datos+falumnos_jun19)
print("USUARIOS ALUMNOS Cargados: "+str(nualumnos))

nalumnos=carga_alumnos(c,dir_datos+falumnos_jun19)
print("ALUMNOS Cargados: "+str(nalumnos))

#ALUMNOS DE HACE 12 MESES
nualumnos=carga_usuarios(c,dir_datos+falumnos_jun19)
print("USUARIOS ALUMNOS Cargados: "+str(nualumnos))
'''
#ALUMNOS DE HACE 12 MESES
nualumnos=carga_usuarios(c,dir_datos+falumnos_dic18)
print("USUARIOS ALUMNOS Cargados: "+str(nualumnos))

nalumnos=carga_alumnos(c,dir_datos+falumnos_dic18)
print("ALUMNOS Cargados: "+str(nalumnos))


c.close()


