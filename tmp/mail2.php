<?php
$to = "obabakoak@google.com";
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: lhueso@insercionfp.tk" . "\r\n" .
"CC: lhueso@aragon.es";

mail($to,$subject,$txt,$headers);
?>
