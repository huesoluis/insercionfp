/*datos de ciclos formativos 2018*/

select ciclo as codciclo, denominacion as denciclo,grado,id_ciclo as idciclofct from FCT2.FCT2_CICLOS ci,FCT2.FCT2_GRADOS gr where
GR.ID_GRADO = CI.ID_GRADO ;


select * from FCT2.FCT2_CICLOS;

select ciclo as codciclo, denominacion as denciclo from FCT2.FCT2_CICLOS where id_ciclo like '%351%';

select * from FCT2.FCT2_GRADOS;

/*datos de centros y provincias en 2018*/
select id_centroeducativo as idcentrofct,nombre_centro as nombrecentro, codigo_provincia from FCT2.FCT2_CENTROSEDUCATIVOS cen;

select * from FCT2.FCT2_CENTROSEDUCATIVOS;



/*alumnos inscritos en una determinada fecha. Esta consulta debe hacerse para las dos plataformas, PRE y PRO*/

select al.id_alumno as idalumnofct, ac.id_tutor as idtutorfct,nombre,primer_apellido,segundo_apellido,fecha_nacimiento,al.telefono,al.email,cen.id_centroeducativo as idcentro, 
AC.ID_CICLO as idciclofct,dni
from FCT2.FCT2_ALUMNOS al, FCT2.FCT2_ALUMNOS_CURSO ac, FCT2.FCT2_CENTROSEDUCATIVOS cen Where 
ac.id_alumno=al.id_alumno
and
CEN.ID_CENTROEDUCATIVO = AC.ID_CENTROEDUCATIVO
and AL.ID_ALUMNO in (select id_alumno from FCT2.FCT2_ALUMNOSPROGRAMA where fecha_fin between '01/02/2018' and '31/07/2018');

select * from FCT2.FCT2_ALUMNOSPROGRAMA where fecha_fin between '01/02/2018' and '31/07/2018';

select * from FCT2.FCT2_USUARIOS where usuario like '%SAMPER%';


select * from FCT2.FCT2_ALUMNOSPROGRAMA order by fecha_fin desc;

/*alumnos que han terminado APTOS en una determinada fecha. Esta consulta debe hacerse para las dos plataformas, PRE y PRO*/

select al.id_alumno as idalumnofct, ac.id_tutor as idtutorfct,nombre,primer_apellido,segundo_apellido,fecha_nacimiento,al.telefono,al.email,cen.id_centroeducativo as idcentro, 
AC.ID_CICLO as idciclofct,dni
from FCT2.FCT2_ALUMNOS al, FCT2.FCT2_ALUMNOS_CURSO ac, FCT2.FCT2_CENTROSEDUCATIVOS cen Where 
ac.id_alumno=al.id_alumno
and
CEN.ID_CENTROEDUCATIVO = AC.ID_CENTROEDUCATIVO
and AL.ID_ALUMNO in (select id_alumno from FCT2.FCT2_ALUMNOSPROGRAMA where fecha_fin between '01/09/2017' and '31/12/2017' and id_calificacion='1');


/*datos de usuarios directores*/
select id_usuario as idusuariofct,clave as password,'director' as grupo,usuario as usernamefct,fecha_alta as created_at,id_centro_educativo as idcentroeducativo 
from FCT2.FCT2_USUARIOS us where id_centro_educativo is not null and id_grupo=2 ;  

select * from FCT2.FCT2_USUARIOS us where usuario='MJTORO';  

select * from FCT2.FCT2_GRUPOSUSUARIO;

select * from FCT2.FCT2_TUTORES_CICLO_CURSO;



/*datos de usuarios tutores activos en el curso 2018*/
select us.id_usuario as idusuariofct,clave as password,'tutor' as grupo,usuario as usernamefct,fecha_alta as created_at,id_centroeducativo as idcentroeducativo
from FCT2.FCT2_USUARIOS us, FCT2.FCT2_TUTORES tut,FCT2.FCT2_TUTORES_CICLO_CURSO tcc
where
 tcc.id_tutor=tut.id_tutor
and id_grupo=1
and TUT.ID_USUARIO = US.ID_USUARIO
and TCC.ID_CURSO='2018'
order by usernamefct;  

/*datos de tutores*/

select tut.id_tutor as idtutorfct,us.id_usuario as idusuariofct,nombre,primer_apellido as apellido, ciclo as codciclo,'dic17' as periodo,dni,ci.id_ciclo as idciclofct 
from FCT2.FCT2_USUARIOS us, FCT2.FCT2_CICLOS ci, FCT2.FCT2_TUTORES tut, FCT2.FCT2_TUTORES_CICLO_CURSO tcc 
where
id_curso='2018'
and
CI.ID_CICLO=TCC.ID_CICLO
and
us.id_usuario=tut.id_usuario
and
TUT.ID_TUTOR=TCC.ID_TUTOR
order by TUT.dni;


select count(*) 
from FCT2.FCT2_USUARIOS us, FCT2.FCT2_CICLOS ci, FCT2.FCT2_TUTORES tut, FCT2.FCT2_TUTORES_CICLO_CURSO tcc 
where
id_curso='2018'
and
CI.ID_CICLO=TCC.ID_CICLO
and
us.id_usuario=tut.id_usuario
and
TUT.ID_TUTOR=TCC.ID_TUTOR
order by TUT.dni;


select *
from FCT2.FCT2_USUARIOS us, FCT2.FCT2_TUTORES tut,FCT2.FCT2_TUTORES_CICLO_CURSO tcc
where
id_centro_educativo is  null 
and tcc.id_tutor=tut.id_tutor
and id_grupo=1
and TUT.ID_USUARIO = US.ID_USUARIO
and TCC.ID_CURSO='2018'
and us.id_usuario='577711';  

select * from FCT2.FCT2_CICLOS where id_ciclo='6';
