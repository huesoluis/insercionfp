 <?php
    session_start();
    // If session variable is not set it will redirect to login page

    if(!isset($_SESSION['username']) || empty($_SESSION['username'])){

      header("location: login.php");

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
}

.col-25 {
    float: left;
    width: 15%;
    margin-top: 10px;
    margin-bottom: 10px;
}

.col-75 {
    float: left;
    width: 75%;
    margin-top: 6px;
}
.cabecera{
white-space: normal;
position:fixed;
width:270px;
height:50px;

}

.preg{
padding-left:90px;

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
padding-right:20px;
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
width: 100%;
}

.bform{
margin-top: 11px;
margin-bottom: 11px;

}
.pres{
display:none;
}
/* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
    .col-25, .col-75, input[type=submit] {
        width: 100%;
        margin-top: 0;
}
.cabecera, .bda{
display:none;
}

.pres{

white-space: normal;
display:block;
width:inherit;
}
}
</style>
</head>
<body>

<nav class="navbar navbar-inverse ">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="http://www.fpcualifica.tk" style='font-size:xx-large'>Info FP Aragón</a>
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

	<ul style='font-size:x-large;color:white' class="nav navbar-nav navbar-right">
        <li><a href="mailto:lhueso@aragon.es">lhueso@aragon.es</a></li>
        <li><a href="tel:976715444">976715444</a></li>
	<li>
      <a href="/logout.php">Salir</a>
	</li>
	</ul>
  </div>
</nav>

<div class="container-fluid">
<h1 style='text-align:center'>ENCUESTA DE INSERCIÓN LABORAL DE ALUMNOS DE FCTs</h1>
<h2 style='text-align:center'>Periodo Septiembre-Diciembre, curso 2017-18</h2>
<br>

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
<br>
 <form lang="es" class="form-inline" action="php/get_datos.php" method='post'>

<?php 
$tipousuario=$helper->get_tipousuario($_SESSION['username']);

if($tipousuario==1) 
	$idtutor=$helper->get_idtutor($_SESSION['username']);
else $idtutor='';
$ciclos=$helper->get_ciclos($_SESSION['username']);
$centro=$helper->get_centro($_SESSION['username']);
$cc=1;
if(count($ciclos)==0 || $ciclos==0){
 $cc=0;
}
echo '<input type="hidden" name="centro" value="'.$centro.'">';
echo '<input type="hidden" name="idtutor" value="'.$idtutor.'">';
if($cc==0) echo "<h1>No hay ciclos asociados a este tutor o centro educativo</h1>";
else{
foreach($ciclos as $ci) 
	{

	$helper->showciclo($ci);
	$idciclo=str_replace(' ','',$ci);
	$idciclo=str_replace('(','',$idciclo);
	$idciclo=str_replace(')','',$idciclo);
	$idciclo=trim($idciclo);
	echo "<div class='collapse' id='".$idciclo."'>";
	$helper->showalumnos($ci,$centro,$tipousuario,$_SESSION['username']);
	echo "</div>";
	}
echo ' <div class="col-25 pres"><button type="" class="btn btn-primary cabecera">¿Ha titulado en el periodo de Septiembre a Diciembre de 2017?</button></div>';
}
?>
<br>
<button type="submit" class="btn btn-primary bform" id="grd">Guardar Datos Encuesta</button>
  </form>

<button class="btn btn-primary bform" data-toggle="collapse" data-target="#formal" style='float:right'>Anadir alumno</button>
	<div id='formal' class='collapse' style="margin-bottom:100">
	<input type="text" class="nombre form-control" id="nnombre"  name="nombre" placeholder="Nombre y apellidos" required >
	<input type="text" class="nombre form-control"  id="telefono" name="telefono"  placeholder="telefono">
	<input type="text" class="nombre form-control"  id="email" name="email" placeholder="email">
	<input type="text" class="nombre form-control"  id="dni" name="dni" placeholder="dni">
	<?php
	if($cc!=0){
	echo 	'<select  class="nombre" id="codciclo" name="codciclo" placeholder="codciclo" required>';
	foreach($ciclos as $ci)
{
 echo  '<option value="'.$ci.'">'.$ci.'</option>';
}
echo '</select>';
}
else{
echo 	'<input tye="text" class="nombre"  id="codciclo" name="codciclo" placeholder="codigo de ciclo">';

}

?>
	<button  type="submit" class="btn btn-primary " id="bpri">Añadir </button>
	</div>
</div>
</body>
