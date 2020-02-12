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
<button type="" class="btn btn-primary cabecera">tipo contrato</button>
</div>
      <div class="col-25 ">
<button type="" class="btn btn-primary cabecera">Misma empresa</button>
</div>
</div>
<br>
 <form class="form-inline" action="/action_page.php">
<div class="row" style='border-bottom:0'>
<button type="" class="btn btn-primary">Ciclo formativo</button>
</div>
<div class="row">
      <div class="col-25 ">
        <h4>Pepe Garcia</h4>
        <h4>666666666</h4>
        <h4>email@email.com</h4>
      </div>
	<div class="form-group col-25"> <!-- Full Name -->
		 <input type="radio" name="fct" value="si">SI<br>
		  <input type="radio" name="fct" value="no">NO<br>
	</div>

	<div class="form-group col-25" id="trab"> <!-- Street 1 -->
		 <input type="radio" name="trabaja" id="trabajasa" value="si">SI<br>
		  <input type="radio" name="trabaja" value="no">NO<br>
	</div>
	<div class="sitrabaja">
	<div class="form-group col-25"> <!-- Street 1 -->
		 <input type="radio" name="relacionado" value="si">SI<br>
		  <input type="radio" name="relacionado" value="no">NO<br>
	</div>
	<div class="form-group col-25"> <!-- Street 1 -->
		 <input type="radio" name="contrato" value="fijo">FIJO<br>
		  <input type="radio" name="contrato" value="otro">OTRO<br>
	</div>
	<div class="form-group  col-25"> <!-- Street 1 -->
		 <input type="radio" name="mismaempresa" value="si">SI<br>
		  <input type="radio" name="mismaempresa" value="no">NO<br>
	</div>
	</div>
</div>
<br>
<div class="row">
      <div class="col-25 ">
        <h4>Pepe Garcia</h4>
        <h4>666666666</h4>
        <h4>email@email.com</h4>
      </div>
	<div class="form-group col-25"> <!-- Full Name -->
		 <input type="radio" name="fc" value="si">SI<br>
		  <input type="radio" name="fc" value="no">NO<br>
	</div>

	<div class="form-group col-25" id="trab"> <!-- Street 1 -->
		 <input type="radio" name="trabaja" id="trabajasa" value="si">SI<br>
		  <input type="radio" name="trabaja" value="no">NO<br>
	</div>
	<div class="sitrabaja">
	<div class="form-group col-25"> <!-- Street 1 -->
		 <input type="radio" name="relacionado" value="si">SI<br>
		  <input type="radio" name="relacionado" value="no">NO<br>
	</div>
	<div class="form-group col-25"> <!-- Street 1 -->
		 <input type="radio" name="contrato" value="fijo">FIJO<br>
		  <input type="radio" name="contrato" value="otro">OTRO<br>
	</div>
	<div class="form-group  col-25"> <!-- Street 1 -->
		 <input type="radio" name="mismaempresa" value="si">SI<br>
		  <input type="radio" name="mismaempresa" value="no">NO<br>
	</div>
	</div>
</div>
<br>
<div class="row">
      <div class="col-25 ">
        <h4>Pepe Garcia</h4>
        <h4>666666666</h4>
        <h4>email@email.com</h4>
      </div>
	<div class="form-group"> <!-- Full Name -->
	<input type="text" class="nombre form-control"  name="" placeholder="Nombre">
	</div>

	<div class="form-group"> <!-- Street 1 -->
		 <input type="radio" name="gender" value="male" checked> Male<br>
		  <input type="radio" name="gender" value="female"> Female<br>
		  <input type="radio" name="gender" value="other"> Other
	</div>

	<div class="form-group"> <!-- Street 1 -->
		<input type="checkbox" name="vehicle1" value="Bike"> I have a bike<br>
		  <input type="checkbox" name="vehicle2" value="Car"> I have a car 
	</div>
</div>
<div class="row" id='pri'>
      <div class="col-25 ">
        <h4>Pepe Garcia</h4>
        <h4>666666666</h4>
        <h4>email@email.com</h4>
      </div>
	<div class="form-group"> <!-- Full Name -->
	<input type="text" class="nombre form-control"  name="" placeholder="Nombre">
	</div>

	<div class="form-group"> <!-- Street 1 -->
		 <input type="radio" name="gender" value="male" checked> Male<br>
		  <input type="radio" name="gender" value="female"> Female<br>
		  <input type="radio" name="gender" value="other"> Other
	</div>

	<div class="form-group"> <!-- Street 1 -->
		<input type="checkbox" name="vehicle1" value="Bike"> I have a bike<br>
		  <input type="checkbox" name="vehicle2" value="Car"> I have a car 
	</div>
</div>
<br>
<br>
<button type="submit" class="btn btn-primary " id="grd">Guardar</button>
  </form>
<button class="btn btn-primary" data-toggle="collapse" data-target="#formal" >Anadir alumno</button>
	<div id='formal' class='collapse'>
	<input type="text" class="nombre form-control" id="nnombre"  name="" placeholder="Nombre">
	<input type="text" class="nombre form-control"  name="" placeholder="Nombre">
	<input type="text" class="nombre form-control"  name="" placeholder="Nombre">
	<button type="submit" class="btn btn-primary " id="bpri">Anadir</button>
	</div>

</div>
</body>
