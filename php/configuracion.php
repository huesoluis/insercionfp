<?php
    /* Database credentials. Assuming you are running MySQL
    server with default setting (user 'root' with no password) */
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', 'Suricato1.fp');
    define('DB_NAME', 'INSERCIONFP');
    define('URL', 'http://insercionfp.aragon.es');
    define('DEBUG', '');
    /* Attempt to connect to MySQL database */
    $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
	$mysqli->set_charset("utf8");    
    // Check connection
    if($mysqli === false){
        die("ERROR: No ha sido posible conectar. " . $mysqli->connect_error);
    }
    ?>
