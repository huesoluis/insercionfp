<?php
session_start();
    // If session variable is not set it will redirect to login page
    if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
      header("location: login_activa.php");
      exit;
    }
require  'php/configuracion.php';
require  'php/parametros.php';
require  'php/db.php';
$helper=new DataBase($mysqli,DB_NAME);

#RECUPERAMOS DATOS GENERALES
$datosusuario=$helper->get_datosusuario($_SESSION['username']);
$idcentro=$datosusuario['idcentrofct'];
$idgrupo=$datosusuario['idgrupo'];
$centro=$datosusuario['centrocodificado'];
$nombrecentro=$datosusuario['centrocodificado'];
$idtutor=$datosusuario['idtutorfct'];
$idusuariofct=$datosusuario['idusuariofct'];
$fecha_fct='';

if($centro!='') $centro="?centro=".$centro;
if($idgrupo=='alumno'){ $collapse='collapsed'; $fecha_fct=$datosusuario['fecha_fct'];
} else $collapse='collapse';

if(DEBUG) print_r($datosusuario);

$periodo1='6m';

$periodo2='12m';

#Obtenemos los ciclos en los que hay alumnos para ese periodo
$ciclos1=$helper->get_ciclos($idcentro,BLOQUE1,$dato='id',$idgrupo,$idtutor,$idusuariofct);
if(DEBUG) print_r($ciclos1);
$desc_ciclos1=$helper->get_ciclos($idcentro,BLOQUE1,'den',$idgrupo,$idtutor,$idusuariofct);
$nc1=count($ciclos1);

#Obtenemos los ciclos en los que hay alumnos para ese periodo
$ciclos2=$helper->get_ciclos($datosusuario['idcentrofct'],BLOQUE2,$dato='id',$idgrupo,$idtutor,$idusuariofct);
$desc_ciclos2=$helper->get_ciclos($datosusuario['idcentrofct'],BLOQUE2,$dato='den',$idgrupo,$idtutor,$idusuariofct);
$nc2=count($ciclos2);

?>
<html>
<head>
<!-- Special version of Bootstrap that only affects content wrapped in .bootstrap-iso -->
        <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Acceso encuestas insercion laboral FP</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<link rel="stylesheet" href="css/encuestas.css">

	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="js/addalumno.js"></script>

<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<?php include "includes/navbar.php";?>
<div class="container-fluid">
	<h1 style='text-align:center'>ENCUESTA DE INSERCIÓN LABORAL DE ALUMNOS DE FCTs</h1>

	<h3 style='text-align:center'><?php echo $nombrecentro; ?></h3>
<!--
		<?php if($idgrupo=='director'){ ?><p style='text-align:center'><a  id='datacentro' title='Para ver en Excel usar pestaña DATOS, opcion TEXTO EN COLUMNAS' href='<?php echo "../datos_diciembre19/centros/".$_SESSION["nombrecentro"]."/datos_alumnos_respuestas.csv" ?>' >Descargar datos brutos en csv</a></p><?php }?>
-->
<?php if(($idgrupo=='alumno' and BLOQUE1==$fecha_fct) or ($nc1!=0 and $idgrupo!='alumno')){ ?>
<!--BLOQUE JUNIO 2018-->
	<div class="panel-group" id="accordion">
		<div class="panel panel-default">
			<div class="panel-heading">
			<?php if($idgrupo!='alumno'){?>
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#6m">
						<h2 style='text-align:center'><button  id='j18'>Periodo <?php echo FECHAFCT1 ?></button></h2>
						<h5 style='text-align:center'>A los 6 meses de finalización de las FCTs</h5>
					</a>
	      			</h4>
			<?php } ?>
	    		</div>
	    		<div  id='6m' class="panel-collapse <?php echo $collapse; ?>"> 
				<div class="row">
		<?php if($idgrupo!='alumno'){ ?><p class="text-center"><a href="#" class="btn btn-primary btn-lg" role="button" data-toggle="modal" data-target="#login-modal_p1">Nuevo alumno <?php echo FECHAFCT1; ?></a></p><?php }?>
				</div>
				<div class="panel-body">
					<div class="row" style='border-bottom:0;'>
						<div class="col-25 ">
						</div>
						<div class="col-25 ">
							<button type="" class="btn btn-primary cabecera"><?php echo P1; ?></button>
						</div>
						<div class="col-25 ">
							<button type="" class="btn btn-primary cabecera"><?php echo P2; ?></button>
						</div>
						<div class="col-25 ">
							<button type="" class="btn btn-primary cabecera"><?php echo P3; ?></button>
						</div>
						<div class="col-25 ">
							<button type="" class="btn btn-primary cabecera"><?php echo P4; ?></button>
						</div>
						<div class="col-25 ">
							<button type="" class="btn btn-primary cabecera"><?php echo P5; ?></button>
						</div>
					</div>
					<form lang="es" class="form-inline" action="php/get_datos.php" method='post'>
					<?php 
					echo "<div id='enviar6m'><button  type='submit' class='btn btn-primary enviarp1' id='p1_grd'>Enviar datos ".FECHAFCT1." </button></div>";
					if($nc1!=0) 
					{
					foreach($ciclos1 as $ci) 
					{
					$helper->showciclo($ci,$periodo1);
					echo "<div class='".$collapse."' id='".$ci.$periodo1."'>";
					$helper->showalumnos($ci,$idcentro,$idgrupo,$periodo1,$idtutor,$idusuariofct,BLOQUE1);
					echo "</div>";
					}
					echo '<input type="hidden" id="fecha_fct" name="fecha_fct" value='.BLOQUE1.'>';
					echo '<input type="hidden" id="periodo" name="periodo" value='.$periodo1.'>';
					echo '<input type="hidden" id="centro" name="centro" value='.$idcentro.'>';
					echo '<input type="hidden" id="tutor" name="idtutorfct" value='.$idtutor.'>';
					}
					else 
					{
					echo "<h1>No hay ciclos asociados a este tutor o centro educativo</h1>";
					}
					echo '<input type="hidden" id="nalumnop1" name="nalumnop1" value="nalumnop1">';
					?>

					</form>
				</div>
	<!-- BEGIN # MODAL LOGIN -->
					<?php if(count($ciclos1)!=0){
					?>
			<div class="container">
				<div class="row">
				</div>

				<div class="modal fade" id="login-modal_p1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
											<input type="text" class="nombre form-control" id="p1_nombremodal"  name="nombre" placeholder="Nombre*" required >
											<input type="text" class="nombre form-control" id="p1_apmodal"  name="primer_apellido" placeholder="Primer apellido*" required >
											<input type="text" class="nombre form-control" id="p1_sapmodal"  name="segundo_apellido" placeholder="Segundo apellido" >
											<input type="text" class="nombre form-control"  id="p1_telefonomodal" name="telefono"  placeholder="Telefono">
											<input type="text" class="nombre form-control"  id="p1_emailmodal" name="email" placeholder="Email">
											<input type="text" class="nombre form-control"  id="p1_dnimodal" name="dni" placeholder="Dni" required>
											<?php
											$i=0;
											echo 	'<select  class="nombre" id="p1_codciclomodal" name="codciclo" placeholder="denciclo" required>';
											echo  '<option value="elige ciclo">Elige Ciclo*</option>';
											foreach($desc_ciclos1 as $ci)
											{
											echo  '<option value="'.$ciclos1[$i].'">'.$ci.'</option>';
											$i=$i+1;	
											}
											echo '</select>';
											?>
										</div>
											<button  type="submit" class="btn btn-primary bpr" id="b6m">Añadir alumno de <?php echo FECHAFCT1; ?></button>
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
<?php } ?>
	<!--FIN BLOQUE JUNIO 2018-->
<?php if(($idgrupo=='alumno' and BLOQUE2==$fecha_fct) or ($nc2!=0 and $idgrupo!='alumno')){ ?>
	<!--INICIO BLOQUE SEPTIEMBRE 2017-->
	<div class="panel-group" id="accordion1">
		<div class="panel panel-default">
			<div class="panel-heading">
			<?php if($idgrupo!='alumno'){?>
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion1" href="#12m">
						<h2 style='text-align:center'><button  id='d17'>Periodo <?php echo FECHAFCT2;?></button></h2>
						<h5 style='text-align:center'>A los 12 meses de finalización de las FCTs</h5>
					</a>
	      			</h4>
			<?php } ?>
	    		</div>
	    		<div  id='12m' class="panel-collapse <?php if($idgrupo== 'alumno') echo '';else echo 'collapse'; ?>"> 
				<div class="row">
		<?php if($idgrupo!='alumno'){ ?><p class="text-center"><a href="#" class="btn btn-primary btn-lg" role="button" data-toggle="modal" data-target="#login-modal_p2">Nuevo alumno <?php echo FECHAFCT2; ?></a></p><?php }?>
				</div>
				<div class="panel-body">
					<div class="row" style='border-bottom:0;'>
						<div class="col-25 ">
						</div>
						<div class="col-25 ">
							<button type="" class="btn btn-primary cabecera"><?php echo P1; ?></button>
						</div>
						<div class="col-25 ">
							<button type="" class="btn btn-primary cabecera"><?php echo P22; ?></button>
						</div>
						<div class="col-25 ">
							<button type="" class="btn btn-primary cabecera"><?php echo P3; ?></button>
						</div>
						<div class="col-25 ">
							<button type="" class="btn btn-primary cabecera"><?php echo P4; ?></button>
						</div>
						<div class="col-25 ">
							<button type="" class="btn btn-primary cabecera"><?php echo P5; ?></button>
						</div>
					</div>
					<form lang="es" class="form-inline" action="php/get_datos.php" method='post'>
					<?php 
					echo "<div id='enviar12m'><button  type='submit' class='btn btn-primary enviarp2' id='p2_grd'>Enviar datos ".FECHAFCT2."</button></div>";
					if($nc2!=0) 
					{
						foreach($ciclos2 as $ci) 
						{
						$helper->showciclo($ci,$periodo2);
						echo "<div class='".$collapse."' id='".$ci.$periodo2."'>";
						$helper->showalumnos($ci,$idcentro,$idgrupo,$periodo2,$idtutor,$idusuariofct,BLOQUE2);
						echo "</div>";
						}
					echo '<input type="hidden" id="fecha_fct" name="fecha_fct" value='.BLOQUE2.'>';
					echo '<input type="hidden" id="periodo" name="periodo" value='.$periodo2.'>';
					echo '<input type="hidden" id="centro" name="centro" value='.$idcentro.'>';
					echo '<input type="hidden" id="tutor" name="idtutorfct" value='.$idtutor.'>';
					}
					else 
					{
						echo "<h1>No hay ciclos asociados a este tutor o centro educativo</h1>";
					}
					echo '<input type="hidden" id="nalumnop2" name="nalumnop2" value="nalumnop2">';
					?>
					</form>
				</div>
	<!-- BEGIN # MODAL LOGIN -->
					<?php if(count($ciclos2)!=0){
					?>
			<div class="container">
				<div class="row">
		<?php if($idgrupo!='alumno'){ ?><p class="text-center"><a href="#" class="btn btn-primary btn-lg" role="button" data-toggle="modal" data-target="#login-modal_p2">Nuevo alumno <?php echo FECHAFCT2; ?></a></p><?php }?>
				</div>

				<div class="modal fade" id="login-modal_p2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
								<form id="p2_login-form">
									<div class="modal-body">
			<!-- Begin # DIV Form -->
										<div class='formal'  style="margin-bottom:20px">
											<input type="text" class="nombre form-control" id="p2_nombremodal"  name="nombre" placeholder="Nombre*" required >
											<input type="text" class="nombre form-control" id="p2_apmodal"  name="primer_apellido" placeholder="Primer apellido*" required >
											<input type="text" class="nombre form-control" id="p2_sapmodal"  name="segundo_apellido" placeholder="Segundo apellido" >
											<input type="text" class="nombre form-control"  id="p2_telefonomodal" name="telefono"  placeholder="Telefono">
											<input type="text" class="nombre form-control"  id="p2_emailmodal" name="email" placeholder="Email">
											<input type="text" class="nombre form-control"  id="p2_dnimodal" name="dni" placeholder="Dni" required>
											<?php
											$i=0;
											echo 	'<select  class="nombre" id="p2_codciclomodal" name="codciclo" placeholder="denciclo" required>';
											echo  '<option value="elige ciclo">Elige Ciclo*</option>';
											foreach($desc_ciclos2 as $ci)
											{
											echo  '<option value="'.$ciclos2[$i].'">'.$ci.'</option>';
											$i=$i+1;	
											}
											echo '</select>';
											?>
										</div>
											<button  type="submit" class="btn btn-primary bpr" id="b12m">Añadir alumno de <?php echo FECHAFCT2; ?></button>
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
<?php } ?>
</div>
</body>
