<?php
require "connessione.php";

$id = $_REQUEST['hid'];  // recupero parametro hidden input

$query = "UPDATE Corse SET Approvata=\"1\" WHERE IdCorsa=\"$id\" ";
$result = mysql_query($query,$conn) or fail_query();
header("Location: corse.php");

?>