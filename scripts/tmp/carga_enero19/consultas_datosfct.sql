/*datos de usuarios alumnos activos en septiembre en el curso 2018*/

select us.id_usuario as idusuariofct,clave as password,'alumno' as grupo,usuario as usernamefct
,fecha_alta as created_at,id_centroeducativo as idcentroeducativo,al.id_alumno as idalumnofct,ac.id_tutor as idtutorfct,
nombre,primer_apellido,segundo_apellido,fecha_nacimiento,al.telefono,al.email,AC.ID_CICLO as idciclofct,dni,'dic18' as fecha_fct
from FCT2.FCT2_USUARIOS us, FCT2.FCT2_ALUMNOS al,FCT2.FCT2_ALUMNOS_CURSO ac
where
AL.ID_USUARIO = US.ID_USUARIO
and
AC.ID_ALUMNO = AL.ID_ALUMNO
and ac.ID_CURSO='2018'
and AL.ID_ALUMNO in (select id_alumno from FCT2.FCT2_ALUMNOSPROGRAMA where fecha_fin between '01/09/2018' and '31/12/2018' and id_calificacion='1')
order by usernamefct;  


