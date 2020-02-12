<?php header('Content-Type: text/html; charset=UTF-8');  ?>
<nav class="navbar navbar-inverse ">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="<?php echo URL; ?>encuestas.php" style='font-size:xx-large'>Inicio</a>
    </div>
	<ul style='font-size:x-large;color:white' class="nav navbar-nav">
        <li><a href="<?php echo $_SESSION['url'] ?>stats/global.php">ESTADISTICAS GLOBALES</a></li>
        <?php if($_SESSION['idgrupo']=='administrador') { ?><li><a href="mesa1.php">ESTADISTICAS MESAS DE TRABAJO</a></li><?php }?>
	</ul>
	<ul style='font-size:x-large;color:white' class="nav navbar-nav navbar-right">
        <li><a>Usuario: <?php echo $_SESSION['idgrupo'];?></a></li>
        <li><a href="mailto:lhueso@aragon.es">lhueso@aragon.es</a></li>
        <li><a href="tel:976715444">976715444</a></li>
	<li>
      <a href="/logout.php">Salir</a>
	</li>
	</ul>
  </div>
</nav>
