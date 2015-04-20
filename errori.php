<?php
/* 
File contenente funzioni che danno informazioni sugli errori generati dalla connessione
alla BD e sugli errori generati dalle query effettuate.
*/

function fail_conn($msg) {
	die($_SERVER['PHP_SELF'] . ": $msg<br />");
};

function fail_query() {
	die("Query fallita." . mysql_error());
};

?>
