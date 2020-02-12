import mysql.connector
#FUNCIONES DE CARGA
def carga_usuarios(c,fichero):
	nusuarios=0
	with open(fichero) as f:
		for line in f:
			line=line.strip()
			adata=line.split(';')
			idusuariofct=adata[0]
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

def insertar_usuario(c,idf,p,g,unf,cr,icf):
	cursor=c.cursor()
	sql="insert into usuarios values(0,'"+idf+"','"+p+"','"+g+"','"+unf+"',DEFAULT,'"+icf+"')"
	#if(prob==0): print(sql)
	try:
		vd=cursor.execute(sql)
	except Exception as e:
    		#salvo que el error sea de clave duplicada lo mostramos
		if(e.errno!=1062):
			print(sql)
			print("Error insertando usuarios"+str(e.err))
			exit()
		else:
			print("usuario duplicado")
	c.commit()
	return 1

def actualizar_alumnos(c,fichero):
	alact=0
	with open(fichero) as f:
		for line in f:
			line=line.strip()
			adata=line.split(';')
			if(adata[0]==''): continue
			if(adata[1]=='' and adata[2]==''): continue
			dni=adata[0]
			email=adata[2]
			telefono=adata[1]
			try:
				idalumnofct,mail=get_idalumnofct(c,dni)
			except Exception as e:
				print(dni)
			if(idalumnofct!=0): 
				if(mail==''):
					sql="update alumnos set telefono='"+telefono+"',email='"+email+"' where idalumnofct="+str(idalumnofct)
				else:
					sql="update alumnos set telefono='"+telefono+"' where idalumnofct="+str(idalumnofct)
				
				try:
					cursor=c.cursor(buffered=True)
					vd=cursor.execute(sql)
					alact=alact+1
					c.commit()
				except Exception as e:
					r=0
	return alact

def carga_alumnos(c,fichero):
	nalumnos=0
	with open(fichero) as f:
		for line in f:
			line=line.strip()
			adata=line.split(';')
			idcentrofct=adata[5]
			idalumnofct=adata[6]
			idtutorfct=adata[7]
			nombre=adata[8]
			primer_apellido=adata[9]
			segundo_apellido=adata[10]
			fecha_nacimiento=adata[11]
			telefono=adata[12]
			email=adata[13]
			idciclofct=adata[14]
			dni=adata[15]
			fecha_fct=adata[16]
			id_usuariofct=adata[0]	
			if(len(idcentrofct)!=0):
				res=insertar_alumno(c,idalumnofct,idtutorfct,nombre,primer_apellido,segundo_apellido,fecha_nacimiento,telefono,email,idcentrofct,idciclofct,dni,id_usuariofct,fecha_fct)
				if(res!=0): 
					nalumnos=nalumnos+1
				else:
					print("error ins alumno")
					print(idalumnofct)
					exit()
			else:
				print("alumno inexistente")
	return nalumnos

def insertar_alumno(c,idalumnofct,idtutorfct,nombre,primer_apellido,segundo_apellido,fecha_nacimiento,telefono,email,idcentrofct,idciclofct,dni,id_usuariofct,fecha_fct):
	cursor=c.cursor()
	nuevoid=check_id(c,idalumnofct,dni)
	if(nuevoid==1): 
		return 1;
	if(nuevoid==0):
		nuevoid=idalumnofct 
	sql='insert into alumnos values("'+str(nuevoid)+'","'+idtutorfct+'","'+nombre+'","'+primer_apellido+'","'+segundo_apellido+'","'+fecha_nacimiento+'","'+telefono+'","'+email+'","'+idcentrofct+'","'+idciclofct+'","'+dni+'","'+id_usuariofct+'","'+fecha_fct+'")'
	try:
		vd=cursor.execute(sql)
		c.commit()
		r=1
	except Exception as e:
		print("error")
		print(sql)
		return 0
		r=0
	return r

def get_idalumnofct(c,dni):
	sql="select idalumnofct,email from alumnos where dni='"+dni+"'"
	cursor=c.cursor(buffered=True)
	vd=cursor.execute(sql)
	row = cursor.fetchone()
	if(row is None): 
		return 0,''
	else: return row[0],row[1]

def check_id(c,idalumnofct,dni):
	sql="select idalumnofct,dni from alumnos where idalumnofct='"+idalumnofct+"'"
	cursor=c.cursor()
	vd=cursor.execute(sql)
	row = cursor.fetchone()
	if(row is None): 
		return 0
	elif(row[1]==dni):	return 1
	else: return lastid(c)

def lastid(c):
	sql="select idalumnofct from alumnos order by idalumnofct desc limit 1"
	cursor=c.cursor()
	vd=cursor.execute(sql)
	row = cursor.fetchone()
	return row[0]+1

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

#FUNCIONES GENERALES
def vaciar_tablas(c):
	cursor=c.cursor()	
	sqls=['delete from respuestas','delete from alumnos','delete from tutores','delete from usuarios where idgrupo!="director"']
	
	for sql in sqls:
		vd=cursor.execute(sql)
	
	c.commit()
	cursor.close()
	return 0

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

def insertar_tutor(c,idtutorfct,idusuariofct,nombre,apellido,dni,idciclofct):
	cursor=c.cursor()
	sql='insert into tutores values("'+idtutorfct+'","'+idusuariofct+'","'+nombre+'","'+apellido+'","'+dni+'","'+idciclofct+'")'
	try:
		vd=cursor.execute(sql)
	except Exception as e:
		if(e.errno!=1062):
			print(e)
			print("Error insertando tutores")
			print(sql)
			return 0
	c.commit()
	return 1


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
	with open(fichero) as f:
		for line in f:
			line=line.strip()
			adata=line.split(';')
			idtutorfct=adata[6]
			idusuariofct=adata[0]
			nombre=adata[7]
			apellido=adata[8]
			dni=adata[10]
			idciclofct=adata[9]
			res=insertar_tutor(c,idtutorfct,idusuariofct,nombre,apellido,dni,idciclofct)
			ntutores=ntutores+res
			if(res==0): 
				print("error:"+idtutorfct)
	return ntutores

#FUNCIONES SOBRANTEs

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
				nalumnos=nalumnos+1
			else:
				print("alumno inexistente")
	return nalumnos
