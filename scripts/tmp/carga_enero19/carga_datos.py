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

ftutores='tutores_curso1819.csv'
falumnos_dic18='alumnos_dic18_6meses_bunuel.csv'
falumnos_jun18='alumnos_jun18_12meses_bunuel.csv'

c=conecta(cfg.usuario,cfg.password,cfg.database)

#solo para pruebas
#res=vaciar_tablas(c)
#print("Tablas vacias\n")

'''
nututores=carga_usuarios(c,dir_datos+ftutores)
print("USUARIOS TUTORES Cargados: "+str(nututores))


ntutores=carga_tutores(c,dir_datos+ftutores)
print("TUTORES Cargados: "+str(ntutores))
'''

nualumnos=carga_usuarios(c,dir_datos+falumnos_dic18)
nualumnos+=carga_usuarios(c,dir_datos+falumnos_jun18)
print("USUARIOS ALUMNOS Cargados: "+str(nualumnos))

nalumnos=carga_alumnos(c,dir_datos+falumnos_dic18)
nalumnos+=carga_alumnos(c,dir_datos+falumnos_jun18)
print("ALUMNOS Cargados: "+str(nalumnos))


c.close()


