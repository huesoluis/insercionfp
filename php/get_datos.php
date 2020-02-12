<?php 
session_start();
    // If session variable is not set it will redirect to login page
    if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
      header("location: login_activa.php");
      exit;
    }
require  'configuracion.php';
require  'db.php';
$helper=new DataBase($mysqli,DB_NAME);
$alumno=array();

$fecha_fct=$_POST['fecha_fct'];
$periodo=$_POST['periodo'];
$idcentro=$_POST['centro'];
$idtutor=$_POST['idtutorfct'];

if (array_key_exists('fct', $_POST)) 
{
foreach($_POST["fct"] as $k=>$v)
	{
	$alumno[$k]['fct']=$v[0];
	}
}
if (array_key_exists('trabaja', $_POST)) 
foreach($_POST["trabaja"] as $k=>$v)
	{
	$alumno[$k]['trabaja']=$v[0];
	}

if (array_key_exists('relacionado', $_POST)) 
foreach($_POST["relacionado"] as $k=>$v)
	{
	$alumno[$k]['relacionado']=$v[0];
	}
if (array_key_exists('contrato', $_POST)) 
foreach($_POST["contrato"] as $k=>$v)
	{
	$alumno[$k]['contrato']=$v[0];
	}
if (array_key_exists('mismaempresa', $_POST)) 
foreach($_POST["mismaempresa"] as $k=>$v)
	{
	$alumno[$k]['mismaempresa']=$v[0];
	}

if (array_key_exists('nombre', $_POST)) 
foreach($_POST["nombre"] as $k=>$v)
	{
	$alumno[$k]['nombre']=$v[0];
	}
if (array_key_exists('dni', $_POST)) 
foreach($_POST["dni"] as $k=>$v)
	{
	$alumno[$k]['dni']=$v[0];
	}

if (array_key_exists('codciclo', $_POST)) 
{
foreach($_POST['codciclo'] as $k=>$v)
	{
	$alumno[$k]['codciclo']=$v[0];
	}

}
if (array_key_exists('email', $_POST)) 
foreach($_POST['email'] as $k=>$v)
	{
	$alumno[$k]['email']=$v[0];
	}
if (array_key_exists('telefono', $_POST)) 
foreach($_POST['telefono'] as $k=>$v)
	{
	$alumno[$k]['telefono']=$v[0];
	}
?> 
<html>
<body>

<br>
<?php
$final=0;
foreach($alumno as $k=>$v)
{
$a=array();
$a['idalumnofct']=$k;
$a=array_merge($a,$v);
$final=$helper->insert_respuestas($a,$idcentro,$idtutor,$periodo,$fecha_fct);
}
$_SESSION['final']=$final;
header("location: ../final.php");
?>

</body>
</html> 
