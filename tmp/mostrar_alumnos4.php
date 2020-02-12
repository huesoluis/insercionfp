 <?php
    session_start();
    // If session variable is not set it will redirect to login page

    if(!isset($_SESSION['username']) || empty($_SESSION['username'])){

      header("location: login3.php");

      exit;

    }
	require  'php/config.php';
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
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="js/addalumno.js"></script>

<!-- Inline CSS based on choices in "Settings" tab -->

<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {
    box-sizing: border-box;
}

input[type=radio] {

margin:10px;
}

input[type=text], select, textarea {
    width: 15%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    resize: vertical;
}

label {
    padding: 12px 12px 12px 0;
    display: inline-block;
}

input[type=submit] {
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    float: right;
}

input[type=submit]:hover {
    background-color: #45a049;
}

.container {
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 12px;
    width: 1510px ;
}

.col-25 {
    float: left;
    width: 15% !important;
    margin-top: 10px;
    margin-bottom: 10px;
}

.col-75 {
    float: left;
    width: 75%;
    margin-top: 6px;
}
.cabecera{

position:fixed;
}
/* Clear floats after the columns */
.row:after {
    content: "";
    display: table;
    clear: both;
}
.row{
margin-left: 10px !important;

}
div.row { 
  border-bottom: 1px solid;
}
.form-group{
    float: left;
height: auto;
width: 25%;
margin-top:12px;
}

.bciclo{
white-space:normal !important;
text-align:left;
width: 195px;
}

.bform{
margin-top: 11px;
margin-bottom: 11px;

}
/* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
    .col-25, .col-75, input[type=submit] {
        width: 100%;
        margin-top: 0;
    }
}
</style>
</head>
<body>

<nav class="navbar navbar-inverse ">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="/">Info FP Aragón</a>
    </div>
	<ul class="nav navbar-nav navbar-center">

     <li>
	 <a class="btn btn-lg btn-social-icon btn-telegram" href='http://t.me/fp_leaks' target='blank' style="color:#3F729B">
    <span class="fa fa-telegram"></span>
  </a>


</li> 
     <li>
	 <a href='https://twitter.com/fp_aragon' class="btn btn-lg btn-social-icon btn-twitter" target='blank' style="color:#3F729B">
    <span class="fa fa-twitter"></span>
  </a>


</li> 
    </ul>
  </div>
</nav>

<div class="container">
<h1 style='text-align:center'>ENCUESTA DE INSERCIÓN LABORAL DE ALUMNOS DE FCTs</h1>
<br>

<div class="row" style='border-bottom:0;'>
      <div class="col-25 ">
<button type="" class="btn btn-primary">Datos alumno</button>
</div>
      <div class="col-25 ">
<button type="" class="btn btn-primary cabecera">Ha realizado FCT</button>
</div>
      <div class="col-25 ">
<button type="" class="btn btn-primary cabecera">Trabajas actualmente</button>
</div>
      <div class="col-25 ">
<button type="" class="btn btn-primary cabecera">Trabajo relacionado</button>
</div>
      <div class="col-25 ">
<button type="" class="btn btn-primary cabecera">Tipo contrato</button>
</div>
      <div class="col-25 ">
<button type="" class="btn btn-primary cabecera">Misma empresa</button>
</div>
</div>
<br>
 <form lang="es" class="form-inline" action="php/get_datos.php" method='post'>

<?php $ciclos=$helper->get_ciclos("us");

foreach($ciclos as $ci) 
	{
	$helper->showciclo($ci);
	echo "<div class='collapse' id='".substr($ci,0,4)."'>";
	$helper->showalumnos($ci);
	echo "</div>";
	}
?>

<br>
<button type="submit" class="btn btn-primary bform" id="grd">Guardar</button>
<button class="btn btn-primary bform" data-toggle="collapse" data-target="#formal" style='float:right'>Anadir alumno</button>
	<div id='formal' class='collapse'>
	<input type="text" class="nombre form-control" id="nnombre"  name="" placeholder="Nombre" required >
	<input type="text" class="nombre form-control"  id="telefono" placeholder="telefono">
	<input type="text" class="nombre form-control"  id="email" placeholder="email">
	<input type="text" class="nombre form-control"  id="dni" placeholder="dni" required>
	<button type="submit" class="btn btn-primary " id="bpri">Anadir</button>
	</div>
  </form>

</div>
</body>
