<?php
require "connessione.php";
require "funzioni.php";


$login = autenticato();

/* Recupero dati */
$id = $_GET['id'];


$query = "SELECT t.IdTappa, t.Numero, t.Data, t.Distanza, t.VintaDa, c.NomeCorsa,
				 l1.CAP AS CAP1, l1.Localita AS loc1, l1.Nazione AS naz1, l1.Regione AS reg1, l1.Prov AS prov1, 
				 l2.CAP AS CAP2, l2.Localita AS loc2, l2.Nazione AS naz2, l2.Regione AS reg2, l2.Prov AS prov2
          FROM Tappe t, Corse c, Luoghi l1, Luoghi l2
          WHERE t.IdTappa = \"$id\" AND t.IdCorsa = c.IdCorsa AND t.Partenza = l1.CAP AND t.Arrivo = l2.CAP";

$tappa = mysql_query($query,$conn) or fail_query();
$arr = mysql_fetch_assoc($tappa);

print_head($arr['Numero'] . "&degTappa - " . $arr['NomeCorsa'],"Team Cannondale",$login);

print_menu(" ",$login);

print_sub($arr['Numero'] . "&degTappa - " . $arr['NomeCorsa']);

print_tappa($arr);

if($arr['VintaDa'])
{	
	$query = "SELECT Nome, Cognome FROM PersoneFisiche WHERE Id = \"$arr[VintaDa]\" ";
	$result = mysql_query($query,$conn) or fail_query();
	$assoc = mysql_fetch_assoc($result);
	echo "<div class=\"info\"><span class=\"tit\">Vincitore :</span> $assoc[Nome] $assoc[Cognome]</div>";
	if($login)
		button_hid("ins_vittoria.php","Modifica Vittoria",$arr['IdTappa']);
}
else
	if($login)
		button_hid("ins_vittoria.php","Inserisci Vittoria",$arr['IdTappa']);


print_footer();
?>