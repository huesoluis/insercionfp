<?php header('Content-Type: text/html; charset=UTF-8');  ?>
<nav class="navbar navbar-inverse ">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="<?php echo $_SESSION['url']; ?>/encuestas.php" style='font-size:xx-large'>Inicio</a>
    </div>
	<ul style='font-size:x-large;color:white' class="nav navbar-nav">
        <li class='dropdown'>
		<a data-toggle="dropdown" href="#" >ESTADISTICAS <span class="caret"></span></a>

	<ul class="dropdown-menu">
 	          <li><a href="<?php echo $_SESSION['url']; ?>/stats/global_diciembre19.php">Encuestas diciembre 2019</a></li>
 	          <li><a href="<?php echo $_SESSION['url']; ?>/stats/global_junio19.php">Encuestas junio 2019</a></li>
 	    <!--      <li><a href="<?php echo $_SESSION['url']; ?>/historico/insercionlaboral/stats/global.php">Encuestas enero 2019</a></li>-->
        </ul>
	</li>
	</ul>
	<ul style='font-size:x-large;color:white' class="nav navbar-nav navbar-right">
        <li><a>Perfil: <?php echo $_SESSION['idgrupo'];?></a></li>
        <li><a href="mailto:mahernandezc@educa.aragon.es">mahernandezc@educa.aragon.es</a></li>
        <li><a href="tel:976715458">976715458</a></li>
	<li>
      <a href="/logout.php">Salir</a>
	</li>
	</ul>
  </div>
</nav>
