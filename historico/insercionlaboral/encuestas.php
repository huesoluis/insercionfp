<?php
session_start();
require  'php/configuracion.php';
require  'php/db.php';
$helper=new DataBase($mysqli);
$acentrousuario=$helper->get_centrousuario($_SESSION['username']);
$centro=$acentrousuario['nombrecentro'];
$centro=str_replace('"','',$centro);
$centro=str_replace('.','',$centro);
$centro=str_replace(' ','_',$centro);
if($centro!='') $centro="?centro=".$centro;
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
<?php include "includes/navbar.php";?>
<div class="container-fluid">
	<h1 style='text-align:center'>ENCUESTA DE INSERCIÓN LABORAL DE ALUMNOS DE FCTs</h1>
<!--BLOQUE JUNIO 2018-->
	<div class="panel-group" id="accordion">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#jun18">
						<h2 style='text-align:center'><button  id='j18'>Periodo Marzo-Junio, curso 2017-18</button></h2>
						<h5 style='text-align:center'>A los 6 meses de finalización de las FCTs</h5>
					</a>
	      			</h4>
	    		</div>
	    		<div  id='jun18' class="panel-collapse collapse"> 
				<div class="panel-body">
					<div class="row" style='border-bottom:0;'>
						<div class="col-25 ">
							<button type="" class="btn btn-primary bda">Datos alumnos Junio año 2018</button>
						</div>
						<div class="col-25 ">
							<button type="" class="btn btn-primary  cabecera">¿Ha titulado en el periodo de Marzo a Junio del año 2018?</button>
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
					<form lang="es" class="form-inline" action="php/get_datos.php" method='post'>
					<?php 
					echo '<input type="hidden" id="periodo" name="periodo" value="jun18">';
					 echo "<h2 style='text-align:center;background-color:gold'>Encuesta a los 6 meses de finalización</h2>";
					echo "<div id='ejun'><button  type='submit' class='btn btn-primary enviarjun' id='jun_grd'>Enviar datos Junio 2018 </button></div>";
					$datosusuario=$helper->get_tipousuario($_SESSION['username']);
					$idcentro=$datosusuario['idcentrofct'];
					$idgrupo=$datosusuario['idgrupo'];
					$idtutor=$datosusuario['idtutorfct'];
					#Obtenemos los ciclos en los que hay alumnos para ese periodo
					$ciclos=$helper->get_ciclos($datosusuario['idcentrofct'],'jun18',$dato='id',$idgrupo,$idtutor);
			
					$desc_ciclos=$helper->get_ciclos($datosusuario['idcentrofct'],'jun18','den',$idgrupo,$idtutor);
					$ncjun=count($ciclos);
					if($ncjun!=0) 
					{
					foreach($ciclos as $ci) 
					{
					$helper->showciclo($ci,'jun18');
					echo "<div class='collapse' id='".$ci."jun18'>";
					$helper->showalumnos($ci,$idcentro,$idgrupo,'jun18',$idtutor);
					echo "</div>";
					}
					echo ' <div class="col-25 pres"><button type="" class="btn btn-primary cabecera">¿Ha titulado en el periodo de Marzo a Junio de 2018?</button></div>';
					echo '<input type="hidden" id="centro" name="centro" value='.$idcentro.'>';
					echo '<input type="hidden" id="tutor" name="idtutorfct" value='.$idtutor.'>';
					}
					else 
					{
					echo "<h1>No hay ciclos asociados a este tutor o centro educativo</h1>";
					}
					?>

					</form>
				</div>
	<!-- BEGIN # MODAL LOGIN -->
					<?php if(count($ciclos)!=0){
					?>
			<div class="container">
				<div class="row">
					<p class="text-center"><a href="#" class="btn btn-primary btn-lg" role="button" data-toggle="modal" data-target="#login-modal_jun">Nuevo alumno junio 2018</a></p>
				</div>

				<div class="modal fade" id="login-modal_jun" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header" align="center">
								<b>Datos del nuevo alumno</b>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
								</button>
							</div>
							<div id="div-forms">
			    <!-- Begin # Login Form -->
								<form id="login-form">
									<div class="modal-body">
			<!-- Begin # DIV Form -->
										<div class='formal'  style="margin-bottom:20px">
											<input type="text" class="nombre form-control" id="jun_nombremodal"  name="nombre" placeholder="Nombre y apellidos" required >
											<input type="text" class="nombre form-control"  id="jun_telefonomodal" name="telefono"  placeholder="telefono">
											<input type="text" class="nombre form-control"  id="jun_emailmodal" name="email" placeholder="email">
											<input type="text" class="nombre form-control"  id="jun_dnimodal" name="dni" placeholder="dni" required>
											<?php
											$i=0;
											echo 	'<select  class="nombre" id="jun_codciclomodal" name="codciclo" placeholder="denciclo" required>';
											echo  '<option value="elige ciclo">Elige Ciclo</option>';
											foreach($desc_ciclos as $ci)
											{
											echo  '<option value="'.$ciclos[$i].'">'.$ci.'</option>';
											$i=$i+1;	
											}
											echo '</select>';
											?>
										</div>
											<button  type="submit" class="btn btn-primary bpr" id="jun_bpr">Añadir alumno de junio de 2018</button>
									</div>
							       </form>
							</div>
						</div>
					</div>
				</div>
					
			</div><!--fin container-->
					<?php }?>
		</div><!--fin panel default-->
	</div><!--fin panel group-->
</div>
	<!--FIN BLOQUE JUNIO 2018-->
	<!--INICIO BLOQUE SEPTIEMBRE 2017-->
	<div class="panel-group" id="accordion1">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion1" href="#dic17">
						<h2 style='text-align:center'><button  id='d17'>Periodo Septiembre-Diciembre, curso 2017-18</button></h2>
						<h5 style='text-align:center'>A los 12 meses de finalización de las FCTs</h5>
					</a>
	      			</h4>
	    		</div>
	    		<div  id='dic17' class="panel-collapse collapse"> 
				<div class="panel-body">
					<div class="row" style='border-bottom:0;'>
						<div class="col-25 ">
							<button type="" class="btn btn-primary bda">Datos alumnos Diciembre año 2017</button>
						</div>
						<div class="col-25 ">
							<button type="" class="btn btn-primary  cabecera">¿Ha titulado en el periodo de Septiembre a Diciembre del año 2017?</button>
						</div>
						<div class="col-25 ">
							<button type="" class="btn btn-primary cabecera">Situación laboral a los 12 meses de finalización</button>
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
					<form lang="es" class="form-inline" action="php/get_datos.php" method='post'>
					<?php 
					 echo "<h2 style='text-align:center;background-color:gold'>Encuesta a los 12 meses de finalización de FCTs</h2>";
					$datosusuario=$helper->get_tipousuario($_SESSION['username']);
					$idcentro=$datosusuario['idcentrofct'];
					$idgrupo=$datosusuario['idgrupo'];
					$idtutor=$datosusuario['idtutorfct'];
					#Obtenemos los ciclos en los que hay alumnos para ese periodo
					$ciclos=$helper->get_ciclos($datosusuario['idcentrofct'],'dic17',$dato='id',$idgrupo,$idtutor);
					$desc_ciclos=$helper->get_ciclos($datosusuario['idcentrofct'],'dic17',$dato='den',$idgrupo,$idtutor);
					$ncsep=count($ciclos);
					if($ncsep!=0) 
					{
					echo '<button  type="submit" class="btn btn-primary enviardic" id="sep_grd">Enviar datos diciembre 2017 </button>';
					foreach($ciclos as $ci) 
					{
					$helper->showciclo($ci,'dic17');
					echo "<div class='collapse' id='".$ci."dic17'>";
					$helper->showalumnos($ci,$idcentro,$idgrupo,'dic17',$idtutor);
					echo "</div>";
					}
					echo ' <div class="col-25 pres"><button type="" class="btn btn-primary cabecera">¿Ha titulado en el periodo de Septiembre a Diciembre de 2017?</button></div>';
					}
					else 
					{
					echo "<h1>No hay ciclos asociados a este tutor o centro educativo</h1>";
					}
					?>
					<input type="hidden" id="periodo" name="periodo" value="dic17">
					<?php echo '<input type="hidden" id="centro" name="centro" value='.$idcentro.'>';?>
					<?php echo '<input type="hidden" id="tutor" name="idtutorfct" value='.$idtutor.'>';?>
					</form>
				</div>
	<!-- BEGIN # MODAL LOGIN -->
					<?php if(count($ciclos)!=0){
					?>
			<div class="container">
				<div class="row">
					<p class="text-center"><a href="#" class="btn btn-primary btn-lg" role="button" data-toggle="modal" data-target="#login-modal_sep">Nuevo alumno Diciembre 2017</a></p>
				</div>

				<div class="modal fade" id="login-modal_sep" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header" align="center">
								<b>Datos del nuevo alumno</b>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
								</button>
							</div>
							<div id="div-forms">
			    <!-- Begin # Login Form -->
								<form id="sep_login-form">
									<div class="modal-body">
			<!-- Begin # DIV Form -->
										<div class='formal'  style="margin-bottom:20px">
											<input type="text" class="nombre form-control" id="sep_nombremodal"  name="nombre" placeholder="Nombre y apellidos" required >
											<input type="text" class="nombre form-control"  id="sep_telefonomodal" name="telefono"  placeholder="telefono">
											<input type="text" class="nombre form-control"  id="sep_emailmodal" name="email" placeholder="email">
											<input type="text" class="nombre form-control"  id="sep_dnimodal" name="dni" placeholder="dni" required>
											<?php
											$i=0;
											echo 	'<select  class="nombre" id="sep_codciclomodal" name="codciclo" placeholder="denciclo" required>';
											echo  '<option value="elige ciclo">Elige Ciclo</option>';
											foreach($desc_ciclos as $ci)
											{
											echo  '<option value="'.$ciclos[$i].'">'.$ci.'</option>';
											$i=$i+1;	
											}
											echo '</select>';
											?>
										</div>
											<button  type="submit" class="btn btn-primary bpr" id="sep_bpr">Añadir alumno de diciembre de 2017</button>
									</div>
							       </form>
							</div>
						</div>
					</div>
				</div>
			</div><!--fin container-->
					<?php }?>
		</div><!--fin panel default-->
	</div><!--fin panel group-->
	<!--FIN BLOQUE SEPTIEMBRE 2017-->

</div>
</body>
