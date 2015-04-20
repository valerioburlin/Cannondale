<?php
require "connessione.php";
require "funzioni.php";


$login = autenticato();

print_head("Le Corse","Team Cannondale",$login);

print_menu("corse",$login);

print_sub("Corse Disputate");

$query = "SELECT c.IdCorsa,c.NomeCorsa,c.DataInizio,c.DataFine,c.Distanza,l1.localita,l2.localita
	      FROM Corse c JOIN Luoghi l1 JOIN Luoghi l2
          WHERE c.Partenza=l1.CAP AND c.Arrivo=l2.CAP AND c.Terminata=1 AND c.Approvata=1 
          ORDER BY c.DataInizio";

$corse_concl = mysql_query($query,$conn) or fail_query();
$arr = array("Nome","Data Inizio","Data Fine","Distanza","Partenza","Arrivo");
table_start($arr);

while( $row = mysql_fetch_row($corse_concl)) 
   table_row($row,$login,"infocorsa.php","mod_corsa.php","elimina_corsa.php");

table_end();

if($login)
{
	$query = "SELECT c.IdCorsa,c.NomeCorsa,c.DataInizio,c.DataFine,c.Distanza,l1.localita,l2.localita
			  FROM Corse c JOIN Luoghi l1 JOIN Luoghi l2
			  WHERE c.Partenza=l1.CAP AND c.Arrivo=l2.CAP AND c.Approvata=0 
			  ORDER BY c.DataInizio";

	$corse_nappr = mysql_query($query,$conn) or fail_query();
	$num = mysql_num_rows($corse_nappr);
	if($num)
	{
		print_sub("Corse Da Approvare");
		
		$arr = array("Nome","Data Inizio","Data Fine","Distanza","Partenza","Arrivo");
		table_start($arr);

		while( $row = mysql_fetch_row($corse_nappr)) 
			table_row($row,$login,"infocorsa.php","mod_corsa.php","elimina_corsa.php");

		table_end();
	}
}

$query = "SELECT c.IdCorsa,c.NomeCorsa,c.DataInizio,c.DataFine,c.Distanza,l1.localita,l2.localita
		  FROM Corse c JOIN Luoghi l1 JOIN Luoghi l2
          WHERE c.Partenza=l1.CAP AND c.Arrivo=l2.CAP AND c.Terminata=0 AND c.Approvata=1 
          ORDER BY c.DataInizio";

$corse_nonconcl = mysql_query($query,$conn) or fail_query();
$num = mysql_num_rows($corse_nonconcl);
if($num)
{
	print_sub("Corse da Disputare");
	
	$arr = array("Nome","Data Inizio","Data Fine","Distanza","Partenza","Arrivo");
	table_start($arr);

	while( $row = mysql_fetch_row($corse_nonconcl)) 
		table_row($row,$login,"infocorsa.php","mod_corsa.php","elimina_corsa.php");

	table_end();
}

if($login)
	DS_button("add_corsa.php","Aggiungi Corsa");


print_footer();
?>
