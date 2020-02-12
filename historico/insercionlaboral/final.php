 <?php
    session_start();
    // If session variable is not set it will redirect to login page
    if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
      header("location: login.php");
      exit;
    }
    ?>
<html>
<head>
<!-- Special version of Bootstrap that only affects content wrapped in .bootstrap-iso -->
        <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, minimum-scale=1">
        <title>Acceso encuestas insercion laboral FP</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="js/addalumno.js"></script>


<style>

body{
width:100%;
overflow-x:hidden;

}
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
      <a class="navbar-brand" href="<?php echo $_SESSION['url'];?>" style='font-size:xx-large'>Inicio</a>
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

<div class="container-fluid">
<h2 style='text-align:center'>ENCUESTA DE INSERCIÓN LABORAL DE ALUMNOS DE FCTs</h2>
</div>

<!--Footer-->
<footer class="page-footer font-small stylish-color-dark pt-4 mt-4">

    <hr>
    <div class="footer-copyright py-3 text-center">
<?php
if($_SESSION['final']==1)
	print("<h3 style='text-align:center'>DATOS INSERTADOS CORRECTAMENTE</h3><span><a style='font-size:x-large' href='../encuestas.php'>Continuar</a></span><br> <span><a style='font-size:x-large' href='../logout.php'>Salir</a></span>");
else
	print("<h3 style='text-align:center'>Glubs!!!, hubo algún problema, consulta al administrador</h3><span><a style='font-size:x-large' href='../encuestas.php'>Reintentar</a></span><br><span><a style='font-size:x-large' href='../logout.php'>Salir</a></span>");
?>
    </div>
    <!--/.Copyright-->

</footer>
<!--/.Footer-->
                      
</body>
