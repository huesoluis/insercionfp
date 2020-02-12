<?php
session_start();
if(!$_SESSION)  header("location: ../login_activa.php");
 ?>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Graficos datos globales inserción laboral FCT por centros</title>

	<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script type="text/javascript" src="https://code.highcharts.com/modules/data.js"></script>
	<script src="../js/jquery.easy-autocomplete.min.js"></script>
	<script src="../js/g_global.js"></script>


	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<link rel="stylesheet" href="../css/graficos.css">
	<link rel="stylesheet" href="../css/easy-autocomplete.min.css">
	<link href="../css/easy-autocomplete.themes.min.css" rel="stylesheet">

</head>
<body>
<nav class="navbar navbar-inverse ">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="<?php echo $_SESSION['url'];?>" style='font-size:xx-large'>Inicio</a>
    </div>
	<ul style='font-size:x-large;color:white' class="nav navbar-nav navbar-right">
        <li><a href="mailto:mahernandezc@educa.aragon.es">mahernandezc@educa.aragon.es</a></li>
        <li><a href="tel:976715458">976715458</a></li>
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
        <ul class="list-unstyled components">
		                    <li>
					<input id="buscar_centros"/> 
				    </li>
					<hr>
		
		                    <li> <a href="#empleo">GLOBAL EMPLEO</a> </li>
					<hr>
		                    <li> <a href="#relacionado">GLOBAL EMPLEO RELACIONADO</a> </li>
					<hr>
		                    <li> <a href="#tfamilia">EMPLEO BRUTO POR FAMILIA</a> </li>
					<hr>
		                    <li> <a href="#trfamilia">EMPLEO RELACIONADO POR FAMILIA</a> </li>
					<hr>
        </ul>
    </nav>
</div>
<div class="col-sm-10">
	<h1 style='text-align:center' id='centro'>DATOS GLOBALES INSERCIÓN FCT EN EL CENTRO: </h1>
	<br>
	<div class='row'>	
		<h2 class='subtitulo'>% Sobre el total de alumnos inscritos en FCT</h2>
		<div class="dglobal col-sm-2 col-sm-offset-1 a2">ALUMNOS INSCRITOS EN FCTs<div class="dg"></div><div class="dgp"></div></div>
		<div class="dglobal col-sm-2 a3">ALUMNOS QUE HAN RESPONDIDO ENCUESTAS<div class="dg"></div><div class="dgp"></div></div>
		<div class="dglobal col-sm-2 a3">ALUMNOS QUE HAN FINALIZADO FCTs<div class="dg"></div><div class="dgp"></div></div>
		<div class="dglobal col-sm-2 a3 last">ALUMNOS QUE HAN FINALIZADO FCTS Y RESPONDIDO ENCUESTAS<div class="dg"></div><div class="dgp"></div></div>
	</div>
	<br>
	<br>
	<br>
	<div class='row'>	
		<div class="dglobal col-sm-2 col-sm-offset-1 a4">ALUMNOS QUE HAN HECHO FCTS Y ESTUDIAN<div class="dg"></div><div class="dgp"></div></div>
		<div class="dglobal col-sm-2 a4">ALUMNOS QUE HAN HECHO FCTS Y TRABAJAN<div class="dg"></div><div class="dgp"></div></div>
		<div class="dglobal col-sm-2 a4 last">ALUMNOS QUE HAN HECHO FCTS Y ESTAN EN DESEMPLEO<div class="dg"></div><div class="dgp"></div></div>
	</div>
	<br>
	<br>
	<br>
	<br>
	<div class='row'>	
		<div class="dglobal col-sm-4 col-sm-offset-1 a4 ">PORCENTAJE INSERCION LABORAL<div class="dg"></div><div class="dgp indicador"></div></div>
		<div class="dglobal col-sm-4 a4 last">PORCENTAJE INSERCION LABORAL EMPLEOS RELACIONADOS<div class="dg"></div><div class="dgp indicador"></div></div>
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
