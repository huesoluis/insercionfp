<?php
$dir = '../csvs_fcts_familias/';
$a = scandir($dir);
$b=count($a);
$res = '';
$rp='';
for($x=2;$x<$b;$x++)
   {
     $res.= "<div class='filePass'>";
     $res.= $a[$x];
     $res.= "</div>";
     $rp.=$a[$x]."/";
   }
echo $rp;
?>
