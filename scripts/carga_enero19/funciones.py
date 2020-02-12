
import mysql.connector
def conecta(usu,pwd,dat):
	cnx = mysql.connector.connect(user=usu,password=pwd,database=dat)
	return cnx

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

def actualizar_centro(c,centro,alumno,cursor):

	sql='update alumnos set idcentro="'+centro+'" where idalumno="'+alumno+'"'
	try:
		vd=cursor.execute(sql)
	except Exception as e:
    		print(e)
    		print("Error insertando ocupacion")
	c.commit()
	return 1



def insertar_tutor(c,idtutorfct,idusuariofct,nombre,apellido,cc,periodo,est,dni,idciclofct):
	cursor=c.cursor()
	sql='insert into tutores values("'+idtutorfct+'","'+idusuariofct+'","'+nombre+'","'+apellido+'","'+cc+'","'+periodo+'","'+est+'","'+dni+'","'+idciclofct+'")'
	try:
		vd=cursor.execute(sql)
	except Exception as e:
    		print(e)
    		print("Error insertando tutores")
    		return 0
	c.commit()
	return 1

def insertar_alumnos(c,idalumnofct,idtutorfct,nombre,primer_apellido,segundo_apellido,fecha_nacimiento,telefono,email,idcentro,idciclofct,dni,periodo):
	cursor=c.cursor()
	sql='insert into alumnos values("'+idalumnofct+'","'+idtutorfct+'","'+nombre+'","'+primer_apellido+'","'+segundo_apellido+'","'+fecha_nacimiento+'","'+telefono+'","'+email+'","'+idcentro+'","'+idciclofct+'","'+dni+'","'+periodo+'")'
	try:
		vd=cursor.execute(sql)
		r=1
	except Exception as e:
		#if(e.errno!=1062):
		if(e.errno==1062): return 0
		print(e)
		print("Error insertando alumnos")
		
		r=0
	c.commit()
	return r

def insertar_ciclo(c,cc,gc,dc,est,idfct):
	cursor=c.cursor()
	sql="insert into ciclos values('"+cc+"','"+dc+"','"+gc+"','"+est+"','"+idfct+"')"
	try:
		vd=cursor.execute(sql)
	except Exception as e:
    		print(e)
    		print("Error insertando ciclo")
	c.commit()
	return 1

def insertar_centro(c,ic,nc,pc):
	cursor=c.cursor()
	sql="insert into centros values('"+ic+"','"+nc+"','"+pc+"')"
	try:
		vd=cursor.execute(sql)
	except Exception as e:
    		print(e)
    		______iprint("Error insertando centro")
	c.commit()
	return 1

def get_grado(grado):
	if ('BASICA' or 'BÁSICA') in grado: g='BASICA'
	elif 'MEDIO' in grado: g='MEDIO'
	else: g='SUPERIOR'
	return g

def carga_tutores(c,fichero):
	ntutores=0
	est='LOGSE'
	with open('datos/'+fichero) as f:
		for line in f:
			line=line.strip()
			adata=line.split(';')
			idtutorfct=adata[0]
			idusuariofct=adata[1]
			nombre=adata[2]
			apellido=adata[3]
			codciclo=adata[4]
			cc=codciclo[:6]
			periodo=adata[5]
			dni=adata[6]
			idciclofct=adata[7]
			if ('LOE' or 'FPB') in codciclo: est='LOE'
			res=insertar_tutor(c,idtutorfct,idusuariofct,nombre,apellido, cc,periodo,est,dni,idciclofct)
			ntutores=ntutores+1
			if(res==0): 
				print("error:"+idtutorfct)
	return ntutores
def insertar_usuario(c,idf,p,g,unf,cr,icf):
	cursor=c.cursor()
	sql='insert into usuarios values(0,"'+idf+'","'+p+'","'+g+'","'+unf+'",DEFAULT,"'+icf+'")'
	#if(prob==0): print(sql)
	try:
		vd=cursor.execute(sql)
	except Exception as e:
    		if(e.errno!=1062):
	    		print("Error insertando usuarios"+str(e.errno))
	c.commit()
	return 1
def carga_usuarios(c,fichero):
	nusuarios=0
	with open('datos/'+fichero) as f:
		for line in f:
			#prob=1
			line=line.strip()
			adata=line.split(';')
			idusuariofct=adata[0]
			'''
			if(idusuariofct=='83062'): 
				print("usuario prob")
				prob=0
			'''
			password=adata[1]
			idgrupo=adata[2]
			username=adata[3]
			created=adata[4]
			idcentrofct=adata[5]
			res=insertar_usuario(c,idusuariofct,password,idgrupo, username,created,idcentrofct)
			nusuarios=nusuarios+1
			if(res==0): 
				print("error:"+idusuariofct)
	return nusuarios

def get_idciclo(c,ciclo):
	cursor=c.cursor()
	estudio='LOGSE'
	cdata=ciclo.strip().split('(')
	if(len(cdata)>1): estudio='LOE'
	ciclo=cdata[0]
	ciclo=ciclo.strip()
	idciclo=''
	sql='select idciclofct from ciclos where estudio="'+estudio+'" and codciclo="'+ciclo+'"'
	try:
		vd=cursor.execute(sql)
		results = cursor.fetchall()
		for r in results:
			idciclo=r[0]

	except Exception as e:
    		print(e)
    		return 0
	return idciclo;
		
def carga_alumnos_fromciclo(c,fichero):
	nalumnos=0
	with open('datos/'+fichero) as f:
		for line in f:
			line=line.strip()
			adata=line.split(';')
			idalumnofct=adata[0]
			idtutorfct=adata[1]
			nombre=adata[2]
			primer_apellido=adata[3]
			segundo_apellido=adata[4]
			fecha_nacimiento=adata[5]
			telefono=adata[6]
			email=adata[7]
			idcentro=adata[8]
			idciclofct=get_idciclo(c,adata[9])
			if(idciclofct==0): 
				print("ciclo no encontrado: "+adata[9])
				break

			dni=adata[10]
			periodo=adata[11]
			if(len(idcentro)!=0):
				res=insertar_alumnos(c,idalumnofct,idtutorfct,nombre,primer_apellido,segundo_apellido,fecha_nacimiento,telefono,email,idcentro,idciclofct,dni,periodo)
				if(res==0): 
					print("error:"+idalumnofct)
				else: nalumnos=nalumnos+1
			else:
				print("alumno inexistente")
	return nalumnos
def carga_alumnos(c,fichero,periodo):
	nalumnos=0
	with open('datos/'+fichero) as f:
		for line in f:
			line=line.strip()
			adata=line.split(';')
			idalumnofct=adata[0]
			idtutorfct=adata[1]
			nombre=adata[2]
			primer_apellido=adata[3]
			segundo_apellido=adata[4]
			fecha_nacimiento=adata[5]
			telefono=adata[6]
			email=adata[7]
			idcentro=adata[8]
			idciclofct=adata[9]
			dni=adata[10]
			
			if(len(idcentro)!=0):
				res=insertar_alumnos(c,idalumnofct,idtutorfct,nombre,primer_apellido,segundo_apellido,fecha_nacimiento,telefono,email,idcentro,idciclofct,dni,periodo)
				if(res!=0): 
					nalumnos=nalumnos+1
			else:
				print("alumno inexistente")
	return nalumnos
def carga_centros(c,fichero):
	ncentros=0
	with open('datos/'+fichero) as f:
		for line in f:
			line=line.strip()
			adata=line.split(';')
			idcentro=adata[0]
			nombrecentro=adata[1]
			provincia=adata[2]
			if(len(idcentro)!=0):
				ncentros=ncentros+insertar_centro(c,idcentro,nombrecentro,provincia)
			else:
				print("centro inexistente")
	return ncentros	
def vaciar_tablas(c):
	cursor=c.cursor()	
	sqls=['delete from respuestas','delete from alumnos','delete from tutores','delete from ciclos','delete from usuarios','delete from centros']
	
	for sql in sqls:
		vd=cursor.execute(sql)
	
	c.commit()
	cursor.close()
	return 0


def carga_ciclos(c,fichero):
	nc=0
	
	with open('datos/'+fichero) as f:
		for line in f:
			est='LOGSE'
			line=line.strip()
			adata=line.split(';')
			codciclo=adata[0]
			cc=adata[0][:6]
			dc=adata[1]
			gc=get_grado(adata[2])
			idfct=adata[3]
			if ('LOE' or 'FPB') in codciclo: est='LOE'
			if(len(cc)!=0):
				nc=nc+insertar_ciclo(c,cc,gc,dc,est,idfct)
				nc=nc+1
			else:
				print("ciclo inexistente")
	return nc	

