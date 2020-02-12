/*datos de ciclos formativos*/

select ciclo as codciclo, denominacion as denciclo,grado,id_ciclo as idciclofct from FCT2.FCT2_CICLOS ci,FCT2.FCT2_GRADOS gr where
GR.ID_GRADO = CI.ID_GRADO ;

/*datos de usuarios tutores activos en el curso 2018*/

select  us.id_usuario as idusuariofct,clave as password,'tutor' as grupo,
 usuario as usernamefct,fecha_alta as created_at,id_centroeducativo as idcentroeducativo,
 TUT.ID_TUTOR as idtutorfct,TUT.NOMBRE,TUT.PRIMER_APELLIDO as apellido,TCC.ID_CICLO as idciclofct,tut.dni
from FCT2.FCT2_USUARIOS us, FCT2.FCT2_TUTORES tut,FCT2.FCT2_TUTORES_CICLO_CURSO tcc
where
tcc.id_tutor=tut.id_tutor
and id_grupo=1
and TUT.ID_USUARIO = US.ID_USUARIO
and TCC.ID_CURSO='2018'
order by usernamefct;  

/*alumnos finalizados entre 1 de febero y 1 de septiembre de 2019*/

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
and AL.ID_ALUMNO in (select id_alumno from FCT2.FCT2_ALUMNOSPROGRAMA where fecha_fin between '01/02/2019' and '01/09/2019' and id_calificacion=1);

/*alumnos finalizados entre septiembre de 2018 y enero de 2019*/

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
        dni,'dic18' as fecha_fct
from FCT2.FCT2_USUARIOS us, FCT2.FCT2_ALUMNOS al,FCT2.FCT2_ALUMNOS_CURSO ac
where
AL.ID_USUARIO = US.ID_USUARIO
and
AC.ID_ALUMNO = AL.ID_ALUMNO
and ac.ID_CURSO='2018'
and AL.ID_ALUMNO in (select id_alumno from FCT2.FCT2_ALUMNOSPROGRAMA where fecha_fin between '02/09/2018' and '31/01/2019' and id_calificacion=1);
