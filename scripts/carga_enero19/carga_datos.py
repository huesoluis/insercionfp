import pandas as pd
import numpy as np
import os
from datetime import datetime
from dateutil.relativedelta import relativedelta
import re
import PyPDF2

import databaseconfig as cfg
from funciones import *

#cargamos dtos de usuarios alumnos, tutores y directores, solo de los nuevos que pueda haber

fciclos='ciclos2018.csv'
fcentros='centros2018.csv'

fusuarios_alumnos_septiembre='alumnos_sep2018.csv'
falumnos_junio='alumnos_jun2018.csv'
falumnos_diciembre='alumnos_dic2017.csv'

fusuarios_directores='usuarios_directores2018.csv'
fusuarios_tutores='usuarios_tutores2018.csv'

ftutores='tutores2018.csv'

#alunos de la edición anterior que se añadireon manualmente
fal17='alumnos_recuperadosdic2017.csv'

ftmp='alumnos_tmp.csv'

fausentes='fcts_calves.csv'


c=conecta(cfg.usuario,cfg.password,cfg.database)


dir_datos='datos/'

'''
#solo para pruebas
res=vaciar_tablas(c)
print("Tablas vacias\n")

nciclos=carga_ciclos(c,dir_jun+fciclos)
print("CICLOS Cargados: "+str(nciclos))
ncentros=carga_centros(c,dir_jun+fcentros)
print("CENTROS Cargados: "+str(ncentros))

'''

nalumnos=carga_usuarios(c,dir_datos+fusuarios_alumnos_septiembre)
print("USUARIOS ALUMNOS septiembre 18 Cargados: "+str(nalumnos))

'''
nusuariosd=carga_alumnos(c,dir_datos+falumnos_septiembre)
print("ALUMNOS septiembre Cargados: "+str(nusuariosd))

nusuariost=carga_usuarios(c,dir_jun+fusuarios_tutores)
print("USUARIOS TUTORES Cargados: "+str(nusuariost))

ntutores=carga_tutores(c,dir_jun+ftutores)
print("TUTORES Cargados: "+str(ntutores))

nalumnos=carga_alumnos_fromciclo(c,dir_dic+fal17)
print("ALUMNOS historíco (de la aplicación) re-Cargados: "+str(nalumnos))

nalumnos=carga_alumnos_fromciclo(c,dir_dic+ftmp)
print("ALUMNOS Cargados: "+str(nalumnos))
'''

nalumnos=carga_alumnos(c,dir_ausentes+fausentes,'jun18')
print("ALUMNOS ausentes  Cargados: "+str(nalumnos))

c.close()


