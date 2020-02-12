CONSULTAS SOBRE LA BASE DE FCTS
===================================
select * from FCT2.FCT2_ALUMNOS;

select * from FCT2.FCT2_ALUMNOS_CURSO ;

select * from FCT2.FCT2_TUTORES;

select id_usuario,clave,id_centro_educativo,id_grupo from FCT2.FCT2_USUARIOS where id_centro_educativo='73' and id_grupo=2;

/*listado de tutores de 2017*/

select us.id_usuario,clave,tcc.id_centroeducativo,id_grupo,us.usuario from FCT2.FCT2_TUTORES_CICLO_CURSO tcc, FCT2.FCT2_USUARIOS us,FCT2.FCT2_TUTORES tut where
 US.ID_USUARIO = TUT.ID_USUARIO
and tut.id_tutor in (select id_tutor from FCT2.FCT2_TUTORES_CICLO_CURSO where id_curso='2017') and 
TUT.ID_TUTOR = TCC.ID_TUTOR;

select count(*) from FCT2.FCT2_USUARIOS us,FCT2.FCT2_TUTORES tut where US.ID_USUARIO = TUT.ID_USUARIO
and id_tutor in (select id_tutor from FCT2.FCT2_TUTORES_CICLO_CURSO where id_curso='2017') ;

/*listado de directores*/

select us.id_usuario,clave,id_centro_educativo,id_grupo,us.usuario from FCT2.FCT2_USUARIOS us where us.id_grupo='2';

select count(*) from FCT2.FCT2_USUARIOS us where us.id_grupo='2';


select count(*) from FCT2.FCT2_USUARIOS us,FCT2.FCT2_TUTORES tut where US.ID_USUARIO = TUT.ID_USUARIO
and id_tutor in (select id_tutor from FCT2.FCT2_TUTORES_CICLO_CURSO where id_curso='2017') ;




select al.id_alumno,tut.id_tutor,al.nombre,al.primer_apellido,al.segundo_apellido,al.fecha_nacimiento, al.telefono, al.email,cen.nombre_centro,cen.id_centroeducativo,CI.DENOMINACION,CI.CICLO
from FCT2.FCT2_USUARIOS us, FCT2.FCT2_ALUMNOS al, FCT2.FCT2_ALUMNOS_CURSO alc,FCT2.FCT2_TUTORES tut, FCT2.FCT2_CENTROSEDUCATIVOS cen, FCT2.FCT2_CICLOS ci
where al.id_alumno=ALC.ID_ALUMNO and ALC.ID_CURSO='2017' and ALC.ID_TUTOR=TUT.ID_TUTOR
and us.id_usuario=tut.id_usuario  
and cen.id_centroeducativo=alc.id_centroeducativo
and CI.ID_CICLO = ALC.ID_CICLO
and al.id_alumno in(select id_alumno from FCT2.FCT2_ALUMNOSPROGRAMA ap where AP.FECHA_FIN like '%17');

select id_alumno,fecha_fin from FCT2.FCT2_ALUMNOSPROGRAMA ap where AP.FECHA_FIN like '%17%';

select * from FCT2.FCT2_CENTROSEDUCATIVOS where nombre_centro like '%ENLACES%';

update FCT2.FCT2_ALUMNOS set dni='17454200Y' where dni='72995766E';

update FCT2.FCT2_USUARIOS set usuario='17454200Y' where usuario='72995766E';

describe FCT2.FCT2_USUARIOS;

select * from  FCT2.FCT2_USUARIOS where id_grupo='2';

select * from FCT2.FCT2_ALUMNOS_CURSO ac, FCT2.FCT2_USUARIOS us where AC.ID_CENTROEDUCATIVO=us.id_centro_educativo and id_grupo='1' and id_centro_educativo=73 ;


/*datos de ciclos formativos 2018 y especialidades*/

select id_especialidad, id_ciclo, ciclo, especialidad from FCT2.FCT2_CICLOS;

select * from FCT2.FCT2_CICLOS;

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

/*aplicacion en PRE*/

select al.id_alumno as idalumnofct, ac.id_tutor as idtutorfct,nombre,primer_apellido,segundo_apellido,fecha_nacimiento,al.telefono,al.email,
cen.id_centroeducativo as idcentro, 
AC.ID_CICLO as idciclofct,dni,'dic17' as periodo
from FCT2.FCT2_ALUMNOS al, FCT2.FCT2_ALUMNOS_CURSO ac, FCT2.FCT2_CENTROSEDUCATIVOS cen Where 
ac.id_alumno=al.id_alumno
and
CEN.ID_CENTROEDUCATIVO = AC.ID_CENTROEDUCATIVO
and AC.ID_CURSO='2017'
and CEN.NOMBRE_CENTRO like '%CORONA%'
and AL.ID_ALUMNO in (select id_alumno from FCT2.FCT2_ALUMNOSPROGRAMA where fecha_fin like '%18')
and AL.PRIMER_APELLIDO like '%oto%';


select * from FCT2.FCT2_ALUMNOS where dni='Y4265938G';

select al.id_alumno as idalumnofct, ac.id_tutor as idtutorfct,nombre,primer_apellido,segundo_apellido,fecha_nacimiento,al.telefono,al.email,
cen.id_centroeducativo as idcentro, 
AC.ID_CICLO as idciclofct,dni,'jun18' as periodo
from FCT2.FCT2_ALUMNOS al, FCT2.FCT2_ALUMNOS_CURSO ac, FCT2.FCT2_CENTROSEDUCATIVOS cen Where 
ac.id_alumno=al.id_alumno
and
CEN.ID_CENTROEDUCATIVO = AC.ID_CENTROEDUCATIVO
and AC.ID_CURSO='2017'
and AL.ID_ALUMNO in (select id_alumno from FCT2.FCT2_ALUMNOSPROGRAMA where fecha_inicio like '%18');

/*alumnos de un tutor dado inscritos en una determinada fecha. Esta consulta debe hacerse para las dos plataformas, PRE y PRO*/

select * from FCT2.FCT2_TUTORES where primer_apellido like '%VILAL%';

select al.id_alumno as idalumnofct, ac.id_tutor as idtutorfct,nombre,primer_apellido,segundo_apellido,fecha_nacimiento,al.telefono,al.email,cen.id_centroeducativo as idcentro, 
AC.ID_CICLO as idciclofct,dni
from FCT2.FCT2_ALUMNOS al, FCT2.FCT2_ALUMNOS_CURSO ac, FCT2.FCT2_CENTROSEDUCATIVOS cen Where 
ac.id_alumno=al.id_alumno
and
CEN.ID_CENTROEDUCATIVO = AC.ID_CENTROEDUCATIVO
and AC.ID_TUTOR='21058'
and AL.ID_ALUMNO in (select id_alumno from FCT2.FCT2_ALUMNOSPROGRAMA where fecha_inicio like '%18' or fecha_fin like '%17');

select * from FCT2.FCT2_TUTORES where nombre like '%TOM%';

/*alumnos que han terminado APTOS en una determinada fecha. Esta consulta debe hacerse para las dos plataformas, PRE y PRO*/

select al.id_alumno as idalumnofct, ac.id_tutor as idtutorfct,nombre,primer_apellido,segundo_apellido,
fecha_nacimiento,al.telefono,al.email,cen.id_centroeducativo as idcentro, 
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
TUT.DNI='07222412K'
and
 tcc.id_tutor=tut.id_tutor
and id_grupo=1
and TUT.ID_USUARIO = US.ID_USUARIO
and TCC.ID_CURSO='2017'
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
and tut.dni='17452572B'
order by TUT.dni;

/*datos alumnos de un centro dado*/

select cen.nombre_centro,al.nombre,al.primer_apellido,al.segundo_apellido,al.email,al.telefono from FCT2.FCT2_ALUMNOS al, FCT2.FCT2_ALUMNOS_CURSO ac,FCT2.FCT2_CENTROSEDUCATIVOS cen where 
AC.ID_ALUMNO=al.id_alumno
and
CEN.ID_CENTROEDUCATIVO = AC.ID_CENTROEDUCATIVO
and nombre_centro like '%';

select * from FCT2.FCT2_TUTORES where dni='17452572B';

#TITULADOS EN UN CENTRO

select nombre,primer_apellido,segundo_apellido,fecha_nacimiento,al.telefono,al.email,
cen.id_centroeducativo as idcentro, 
AC.ID_CICLO as idciclofct,dni,'dic17' as periodo
from FCT2.FCT2_ALUMNOS al, FCT2.FCT2_ALUMNOS_CURSO ac, FCT2.FCT2_CENTROSEDUCATIVOS cen Where 
ac.id_alumno=al.id_alumno
and
CEN.ID_CENTROEDUCATIVO = AC.ID_CENTROEDUCATIVO
and AC.ID_CURSO='2017'
and AL.ID_ALUMNO in (select id_alumno from FCT2.FCT2_ALUMNOSPROGRAMA where fecha_fin like '%17')
and AC.ID_CENTROEDUCATIVO='75';

select * from FCT2.FCT2_CENTROSEDUCATIVOS where nombre_centro like '%HOST%';

select nombre,primer_apellido,segundo_apellido,fecha_nacimiento,al.telefono,al.email,
cen.id_centroeducativo as idcentro, 
AC.ID_CICLO as idciclofct,dni,'jun18' as periodo
from FCT2.FCT2_ALUMNOS al, FCT2.FCT2_ALUMNOS_CURSO ac, FCT2.FCT2_CENTROSEDUCATIVOS cen Where 
ac.id_alumno=al.id_alumno
and
CEN.ID_CENTROEDUCATIVO = AC.ID_CENTROEDUCATIVO
and AC.ID_CURSO='2017'
and AL.ID_ALUMNO in (select id_alumno from FCT2.FCT2_ALUMNOSPROGRAMA where fecha_inicio like '%18')
and AC.ID_CENTROEDUCATIVO='75';



