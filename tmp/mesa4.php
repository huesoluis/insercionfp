<?php
session_start();
    // If session variable is not set it will redirect to login page
if(!$_SESSION)  header("location: ../login_activa.php");
 ?>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Graficos datos globales inserción laboral FCT</title>

	<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script type="text/javascript" src="https://code.highcharts.com/modules/data.js"></script>
	<script src="../js/jquery.easy-autocomplete.min.js"></script>
	<script src="../js/g_global_mesa4.js"></script>
	<script src="../js/mesas.js"></script>


	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<link rel="stylesheet" href="../css/graficos.css">
	<link rel="stylesheet" href="../css/easy-autocomplete.min.css">
	<link href="../css/easy-autocomplete.themes.min.css" rel="stylesheet">
	<link href="../css/mesas.css" rel="stylesheet">

</head>
<body>
<nav class="navbar navbar-inverse ">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="http://insercionfp.tk:81/encuestas.php" style='font-size:xx-large'>Inicio</a>
    </div>
	<ul style='font-size:x-large;color:white' class="nav navbar-nav navbar-right">
        <li><a href="mailto:lhueso@aragon.es">lhueso@aragon.es</a></li>
        <li><a href="tel:976715444">976715444</a></li>
	<li>
      <a href="/logout.php">Salir</a>
	</li>
	</ul>
  </div>
</nav>
<div id="wrapper" >
            <!-- Sidebar -->
<div class="container-fluid">
<div class="row">
<div class="col-sm-2">
 <!-- Sidebar -->
    <nav id="">
<h2 style='text-align:center'> MESA 4<p> Ciencias sociales y jurídicas</p></h2>
        <ul class="list-unstyled components">
<h5 style='border: 1px solid black;padding: 16px;text-align: center;'>ACTIVIDADES FISICO DEPORTIVAS</h5>
                                    <li> 
Técnico Superior  en Enseñanza y Animación Sociodeportiva

									</li>
<h5 style='border: 1px solid black;padding: 16px;text-align: center;'>ADMINISTRACIÓN Y GESTIÓN</h5>
									<li> 
Técnico Superior  en Administración y Finanzas 

</li>
									<li> 
Técnico Superior  en Asistencia a la Dirección
									</li>
<h5 style='border: 1px solid black;padding: 16px;text-align: center;'>COMERCIO Y MARKETING</h5>
									<li> 
								Técnico Superior  en Marketing y Publicidad 
	
									</li>
									<li> 
Técnico Superior  en Transporte y Logística

 
									
									</li>
									<li> 
Técnico Superior  en Gestión de Ventas y Espacios Comerciales

									</li>
									<li> 
Técnico Superior  en Comercio Internacional 
									
									</li>
<h5 style='border: 1px solid black;padding: 16px;text-align: center;'>HOSTELERÍA Y TURISMO</h5>
									<li>
Técnico Superior en Gestión de Alojamientos Turísticos

				
									</li>
									<li> 
Técnico Superior en Guía, Información y Asistencias Turísticas
									</li>
									<li>
Técnico Superior en Agencias de Viajes y Gestión de Eventos 
	
									</li>
									<li>
Técnico Superior en Dirección de Cocina
	
									</li>
									<li> 
Técnico Superior en Dirección de Servicios de Restauración
									</li>
									
<h5 style='border: 1px solid black;padding: 16px;text-align: center;'>IMAGEN PERSONAL</h5>
									<li> 
			Técnico Superior en Estilismo y Dirección de peluquería 
	
									</li>

									<li> 
Técnico Superior en Asesoría de Imagen Personal y Corporativa 

									</li>
									
<h5 style='border: 1px solid black;padding: 16px;text-align: center;'>SANIDAD</h5>
									<li> 
Técnico Superior en Documentación y Administración Sanitaria

									</li>
<h5 style='border: 1px solid black;padding: 16px;text-align: center;'>SEGURIDAD Y MEDIO AMBIENTE</h5>
									<li> 
Técnico Superior en Educación y Control Ambiental 
									</li>
									<li> 
Técnico Superior en Coordinación de Emergencias y Protección Civil 
									</li>
<h5 style='border: 1px solid black;padding: 16px;text-align: center;'>SERVICIOS SOCIOCULTURALES Y A LA COMUNIDAD</h5>
									<li> 

Técnico superior en Mediación Comunicativa 
									</li>
									<li> 
Técnico superior en Educación Infantil
									</li>
									<li> 
Técnico superior en Animación Sociocultural y Turística
									</li>
									<li> 
Técnico superior en Integracíón Social 
									</li>
									<li> 
Técnico superior en Promoción de Igualdad de Género
									</li>
        </ul>
    </nav>
</div>
<div class="col-sm-10">

<div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="nav navbar-nav navbar-center" style='font-size:20px'>
                    <li><a href="mesa1.php" style='font-weight:bold;color:darkblue;' id='m1'>Mesa 1 - Artes y Humanidades</a>
			</li>           
                    <li><a href="mesa2.php" style='font-weight:bold;color:darkblue;'>Mesa 2 - Ciencias y ciencias de la salud</a></li>
                    <li><a href="mesa3.php" style='font-weight:bold;color:darkblue;'>Mesa 3 - Ingenierías y arquitectura</a></li>
                    <li><a href="mesa4.php" style='font-weight:bold;color:darkblue;'>Mesa 4 - Ciencias sociales y jurídicas</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->


	<h1 style='text-align:center'>DATOS GLOBALES INSERCIÓN FCT</h1>
	<p style='text-align:center'>Porcentajes obtenidos respecto a alumnos inscritos</p>
	<br>
	<div class='row dgeneral'>	
		<div class="dglobal col-sm-2 col-sm-offset-1 a2">ALUMNOS INSCRITOS EN FCTs<div class="dg"></div><div class="dgp"></div></div>
		<div class="dglobal col-sm-2 a3">ALUMNOS QUE RESPONDIDO ENCUESTAS<div class="dg"></div><div class="dgp"></div></div>
		<div class="dglobal col-sm-2 a3">ALUMNOS QUE HAN FINALIZADO FCTs<div class="dg"></div><div class="dgp"></div></div>
		<div class="dglobal col-sm-2 a3 last">ALUMNOS QUE HAN FINALIZADO FCTS Y RESPONDIDO ENCUESTAS<div class="dg"></div><div class="dgp"></div></div>
	</div>
	<br>
	<br>
	<br>
	<p style='text-align:center'>Porcentajes obtenidos respecto a alumnos que han respondido y han realizado la fct</p>
	<div class='row dgeneral'>	
		<div class="dglobal col-sm-2 col-sm-offset-1 a4">ALUMNOS QUE HAN HECHO FCTS Y ESTUDIAN<div class="dg"></div><div class="dgp"></div></div>
		<div class="dglobal col-sm-2 a4">ALUMNOS QUE HAN HECHO FCTS Y TRABAJAN<div class="dg"></div><div class="dgp"></div></div>
		<div class="dglobal col-sm-2 a4 ">ALUMNOS QUE HAN HECHO FCTS Y TRABAJAN EN ALGO RELACIONADO<div class="dg"></div><div class="dgp"></div></div>
		<div class="dglobal col-sm-2 a4 last">ALUMNOS QUE HAN HECHO FCTS Y ESTAN EN DESEMPLEO<div class="dg"></div><div class="dgp"></div></div>
	</div>
	<br>
	<br>
	<br>
	<br>
	<div class='row dgeneral'>	
		<div class="dglobal col-sm-4 col-sm-offset-1 a4 ">PORCENTAJE INSERCION LABORAL<div class="dg"></div><div class="dgp indicador"></div><p style='font-size:10px'>Respecto total de alumnos que quieren trabajar</p></div>
		<div class="dglobal col-sm-4 a4 last">PORCENTAJE INSERCION LABORAL EMPLEOS RELACIONADOS<div class="dg"></div><div class="dgp indicador"></div><p style='font-size:10px'>Respecto total de alumnos que trabajan</p></div>
	</div>

	<div class='row' id='empleo'>
		<div class='col-sm-12' id="trabaja_desempleo"></div>
	</div>
	<div class='row' id='relacionado'>
		<div id="trabaja_relacionado"></div>

	</div>
	<div class='row' id='tfamilia'>
		<div id="trabaja_por_familias"></div>

	</div>
	<div class='row' id='trfamilia'>
		<div id="trabaja_relacionado_por_familias"></div>

	</div>
	<div class='row' id='tcentro'>
		<div id="trabaja_por_centros"></div>

	</div>
	<div class='row' id='trcentro'>
		<div id="trabaja_relacionado_por_centros"></div>

	</div>

</div>
</div>
</div>
</body>
