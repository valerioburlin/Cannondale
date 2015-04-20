<?php
require "connessione.php";
require "funzioni.php";


$login = autenticato();

$ciclista = $_GET['ciclista'];
$corsa = $_GET['corsa'];

print_head("Elimina Staff","Team Cannondale",$login);

print_menu(" ",$login);

print_sub("");

if(!$login)
	echo "<p class=\"err_mex\">Devi prima autenticarti!!<p>";
else
{
	$url = "mod_iscritti?hid=" . urlencode($corsa);
	$query = "DELETE FROM CiclistiCorse WHERE Id=\"$ciclista\" AND IdCorsa=\"$corsa\" ";
	$result = mysql_query($query,$conn) or fail_query();
	if($result)
		header("Location: $url");
}
	
	
print_footer();
?>