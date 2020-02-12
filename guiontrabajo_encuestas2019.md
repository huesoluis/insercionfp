PASOS CREACION NUEVA CONVOCATORIA ENCUESTAS FCT

#1. Crear base de datos nueva

mysql -u username -p -e "CREATE DATABASE new_dbname"

#2. Exportar la existente

mysqldump -u root -p INSERCIONFP > insercionfp_junio2019.sql

#3. Importar la nueva base

mysql -u root -p INSERCIONFP_JUNIO2019  < insercionfp_junio2019.sql

Cargar alumnos de nuevo

#4. Vaciar la antigua base

delete from respuestas

delete from alumnos

delete from tutores

delete from usuarios where idgrupo!='director'

#5. Cargar desde scripts

Quitar puntos de miles en la excel, antes de convertir a csv

cargar datos de tutores

```sql
select  us.id_usuario as idusuariofct,clave as password,'tutor' as grupo,
 usuario as usernamefct,fecha_alta as created_at,id_centroeducativo as idcentroeducativo,
 TUT.ID_TUTOR as idtutorfct,TUT.NOMBRE,TUT.PRIMER_APELLIDO as apellido,TCC.ID_CICLO as idciclofct,tut.dni
from FCT2.FCT2_USUARIOS us, FCT2.FCT2_TUTORES tut,FCT2.FCT2_TUTORES_CICLO_CURSO tcc
where
tcc.id_tutor=tut.id_tutor
and id_grupo=1
and TUT.ID_USUARIO = US.ID_USUARIO
and TCC.ID_CURSO='2019'
order by usernamefct;  

```

Datos de alumnos en cada periodo


```sql

select us.id_usuario as idusuariofct,
        clave as password,
        'alumno' as grupo,
        usuario as usernamefct,
        fecha_alta as created_at,
        id_centroeducativo as idcentroeducativo,
        al.id_alumno as idalumnofct,
        ac.id_tutor as idtutorfct,
        nombre,
        primer_apellido,
        segundo_apellido,
        fecha_nacimiento,
        al.telefono,
        al.email,
        AC.ID_CICLO as idciclofct,
        dni,'jun19' as fecha_fct
from FCT2.FCT2_USUARIOS us, FCT2.FCT2_ALUMNOS al,FCT2.FCT2_ALUMNOS_CURSO ac
where
AL.ID_USUARIO = US.ID_USUARIO
and
AC.ID_ALUMNO = AL.ID_ALUMNO
and ac.ID_CURSO='2018'
and AL.ID_ALUMNO in (select id_alumno from FCT2.FCT2_ALUMNOSPROGRAMA where fecha_fin between '01/07/2018' and '31/01/2019' and id_calificacion=1)
order by usernamefct;

```

#6. Revisar copias de seguridad para que sean cada 3 horas durante el mes de enero

#7. Ejecutar script de base de datos para sincronizar base de datos en sentido desarrollo->produccion

#8. Reviasr script de base de datos para sincronizar base de datos en sentido produccion->desarrollo

#9. Generar scrips para graficos

##9.1 cambiar fechas en los ficheros 
		en el directorio gendata_graficos: gen_csvs_datos_globales.php y gencsvs_datos_centros.php
		en el fichero stats/global.php





