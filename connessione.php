<?php
require "errori.php";

/* File unico per la gestione della connessione alla BD. */

$host = "basidati.studenti.math.unipd.it";
$user = "vburlin";
$pwd = "3SR8vVbs";
$dbname = "vburlin-PR";

$conn = mysql_connect($host,$user,$pwd) or fail_conn("Connessione non riuscita!");
	
mysql_select_db($dbname) or fail_conn("DB non selezionato!");
 
?>
