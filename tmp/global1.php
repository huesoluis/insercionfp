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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<link rel="stylesheet" href="../css/graficos.css">

	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="../js/g_global.js"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script type="text/javascript" src="https://code.highcharts.com/modules/data.js"></script>



	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<nav class="navbar navbar-inverse ">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="http://insercionfp.tk" style='font-size:xx-large'>Inicio</a>
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
 <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-header">
        </div>

        <ul class="list-unstyled components">
		
                		    <li class="sidebar-brand"> <a href="#">6 MESES Junio 2018</a> </li>
					<hr>
		                    <li> <a href="#">12 MESES diciembre 2017</a> </li>
					<hr>
		                    <li> <a href="#">CENTROS</a> </li>
					<hr>
		                    <li> <a href="#">CENTROS</a> </li>
					<hr>
		                    <li> <a href="#">CENTROS</a> </li>
					<hr>
		                    <li> <a href="#">CENTROS</a> </li>
					<hr>
		                    <li> <a href="#">CENTROS</a> </li>
					<hr>
		                    <li> <a href="#">CENTROS</a> </li>
					<hr>
		                    <li> <a href="#">CENTROS</a> </li>
					<hr>
		                    <li> <a href="#">CENTROS</a> </li>
					<hr>
		                    <li> <a href="#">CENTROS</a> </li>
					<hr>
        </ul>
    </nav>
<section class="gcontenido">
	<h1 style='text-align:center'>DATOS GLOBALES INSERCIÓN FCT</h1>
	<br>
		<div class="dglobal col-sm-3 a2">ALUMNOS INSCRITOS EN FCTs<div class="dg"></div><div class="dgp"></div></div>
		<div class="dglobal col-sm-3 a3">ALUMNOS QUE RESPONDIDO ENCUESTAS<div class="dg"></div><div class="dgp"></div></div>
		<div class="dglobal col-sm-3 a3">ALUMNOS QUE HAN FINALIZADO FCTs<div class="dg"></div><div class="dgp"></div></div>
		<div class="dglobal col-sm-3 a3">ALUMNOS QUE HAN FINALIZADO FCTS Y RESPONDIDO ENCUESTAS<div class="dg"></div><div class="dgp"></div></div>
		<div class="dglobal col-sm-4 a4">ALUMNOS QUE HAN HECHO FCTS Y ESTUDIAN<div class="dg"></div><div class="dgp"></div></div>
		<div class="dglobal col-sm-4 a4">ALUMNOS QUE HAN HECHO FCTS Y TRABAJAN<div class="dg"></div><div class="dgp"></div></div>
		<div class="dglobal col-sm-4 a4">ALUMNOS QUE HAN HECHO FCTS Y ESTAN EN DESEMPLEO<div class="dg"></div><div class="dgp"></div></div>
	<div id='graficos'>
	<h1 style='text-align:center'>GRAFICA GLOBAL EMPLEO</h1>
		<div id="globalempleo"></div>
		<div id="trabaja_desempleo"></div>

	</div>

</section>

</div>
</div>
</body>
