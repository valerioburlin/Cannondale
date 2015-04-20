<?php
require "connessione.php";
require "funzioni.php";


$login = autenticato();

$id = $_GET['id'];

print_head("Elimina Tappa","Team Cannondale",$login);

print_menu(" ",$login);

print_sub("");

if(!$login)
	echo "<p class=\"err_mex\">Devi prima autenticarti!!<p>";
else
	if($_SESSION['ruolo'] != "DS")
		echo "<p class=\"err_mex\">Non hai l'autorizzazione necessaria per accedere a questa pagina!!<p>";
	else
	{
		$query = "DELETE FROM Tappe WHERE IdTappa = \"$id\" ";
		$result = mysql_query($query,$conn) or fail_query();
		if($result)
			header("Location: corse.php");
	}
	

print_footer();
?>