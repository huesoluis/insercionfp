<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

$time = date('r');
sleep(10);
echo "data: The server time is: {$time}\n\n";
flush();
?>
