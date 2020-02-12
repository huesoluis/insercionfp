 <?php
    session_start();
    // If session variable is not set it will redirect to login page

    if(!isset($_SESSION['username']) || empty($_SESSION['username'])){

      header("location: login.php");

      exit;

    }
	require  'php/configuracion.php';
	require  'php/db.php';
	$helper=new DataBase($mysqli);
    ?>
<html>
<head>
<!-- Special version of Bootstrap that only affects content wrapped in .bootstrap-iso -->
        <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Acceso encuestas insercion laboral FP</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<link rel="stylesheet" href="css/custom.css">

	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="js/addalumno.js"></script>

<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>


<div class="container-fluid">
<h1 style='text-align:center'>ENCUESTA DE INSERCIÓN LABORAL DE ALUMNOS DE FCTs</h1>
 <div class="panel-group" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#dic17">
	 <h2 style='text-align:center'><button  id='d17'>Periodo Septiembre-Diciembre, curso 2017-18</button></h2>
	</a>
      </h4>
    </div>
    <div  id='dic17' class="panel-collapse collapse"> 
	<div class="panel-body">
	<div class="row" style='border-bottom:0;'>
		<div class="col-25 ">
			<button type="" class="btn btn-primary bda">Datos alumno</button>
		</div>
		<div class="col-25 ">
			<button type="" class="btn btn-primary  cabecera">¿Ha titulado en el periodo de Septiembre a Diciembre de 2017?</button>
		</div>
		<div class="col-25 ">
			<button type="" class="btn btn-primary cabecera">Situación laboral a los 6 meses de finalización</button>
		</div>
		<div class="col-25 ">
			<button type="" class="btn btn-primary cabecera">¿En un trabajo relacionado con el título cursado?</button>
		</div>
		<div class="col-25 ">
			<button type="" class="btn btn-primary cabecera">¿En la misma empresa de la FCT?</button>
		</div>
		<div class="col-25 ">
			<button type="" class="btn btn-primary cabecera">Tipo contrato</button>
		</div>
	</div>
	<form lang="es" class="form-inline" action="php/pr_getdatos.php" method='post'>
	<?php 
	 echo "<h2 style='text-align:center'>Periodo Septiembre-Diciembre, curso 2017-18</h2>";
	$datosusuario=$helper->get_tipousuario($_SESSION['username']);
	$_SESSION['idcentro']=$datosusuario['idcentrofct'];
	$_SESSION['idgrupo']=$datosusuario['idgrupo'];
	print("<b>".$datosusuario['idgrupo']."</b>"); 
	#Obtenemos los ciclos en los que hay alumnos para ese periodo
	$ciclos=$helper->get_ciclos($datosusuario['idcentrofct'],'dic17');
	$desc_ciclos=$helper->get_ciclos($datosusuario['idcentrofct'],'dic17','desc');
	$cc=count($ciclos);
	if($cc!=0) 
	{
	foreach($ciclos as $ci) 
	{
	$helper->showciclo($ci,'d17');

	echo "<div class='collapse' id='".$ci."d17'>";
	$helper->showalumnos($ci,$_SESSION['idcentro'],$_SESSION['idgrupo'],'dic17');
	echo "</div>";
	}
	echo ' <div class="col-25 pres"><button type="" class="btn btn-primary cabecera">¿Ha titulado en el periodo de Septiembre a Diciembre de 2017?</button></div>';
	}
	else 
	{
	echo "<h1>No hay ciclos asociados a este tutor o centro educativo</h1>";
	}
	?>

	<button  type="submit" class="btn btn-primary " value="bpri_junio">Añadir </button>
	</form>
    	</div>
   </div>
  </div>
    </div>
  </div>
	<br>

</body>
