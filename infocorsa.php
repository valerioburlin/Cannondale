<?php
require "connessione.php";
require "funzioni.php";


$login = autenticato();

/* Recupero dati */
$id = $_GET['id'];

$query = "SELECT c.*, l1.Localita AS loc1, l1.Nazione AS naz1, l1.Regione AS reg1, l1.Prov AS prov1, 
					  l2.Localita AS loc2, l2.Nazione AS naz2, l2.Regione AS reg2, l2.Prov AS prov2
          FROM Corse c, Luoghi l1, Luoghi l2
          WHERE c.IdCorsa = \"$id\" AND c.Partenza = l1.CAP AND c.Arrivo = l2.CAP";

$corsa = mysql_query($query,$conn) or fail_query();
$arr = mysql_fetch_assoc($corsa);

print_head($arr['NomeCorsa'],"Team Cannondale",$login);

print_menu(" ",$login);

print_sub($arr['NomeCorsa']);

print_corsa($arr);

$query = "SELECT HaTappe(\"$id\")";
$result = mysql_query($query,$conn) or fail_query();
$row = mysql_fetch_row($result);
if($row[0])
{
	$query = "SELECT COUNT(*) AS numtappe FROM Tappe t WHERE t.IdCorsa = \"$id\" ";
	$result = mysql_query($query,$conn) or fail_query();
	$row = mysql_fetch_row($result);
	echo "<div class=\"info\"><span class=\"tit\">Numero Tappe :</span> $row[0]</div>";
	
	print_sub("Tappe Intermedie");
	
	$query = "SELECT t.IdTappa, t.Numero, t.Data, t.Distanza, l1.Localita, l2.Localita 
	          FROM Tappe t, Luoghi l1, Luoghi l2 
	          WHERE t.IdCorsa = \"$id\" AND t.Partenza = l1.CAP AND t.Arrivo = l2.CAP
			  ORDER BY t.Numero";
	$tappe = mysql_query($query,$conn) or fail_query();
	$arr2 = array("Numero","Data","Distanza","Partenza","Arrivo");
	table_start($arr2);
	while($row = mysql_fetch_row($tappe))
		table_row($row,$login,"infotappa.php","mod_tappa.php","elimina_tappa.php");
	table_end();
}

$query = "SELECT p.Nome, p.Cognome, cc.Piazzamento
		  FROM CiclistiCorse cc NATURAL JOIN PersoneFisiche p
		  WHERE cc.IdCorsa = \"$arr[IdCorsa]\" ";
$iscritti = mysql_query($query,$conn) or fail_query();
$titolo = array("Nome","Cognome","Piazzamento Finale");
print_sub("Ciclisti Iscritti");
table_start($titolo);
$n_iscritti = mysql_num_rows($iscritti);
while($row = mysql_fetch_row($iscritti))
{
	echo "<tr>";
	foreach ($row as $field) 
		if($field)
			echo "<td>$field</td>\n";
		else
			echo "<td></td>\n";
}
table_end();

if($login)
	DS_button_hid("add_tappa.php","Aggiungi Tappa",$arr['NomeCorsa']);

if($login)
{
	$oggi = date("Y-m-d");
	if($oggi > $arr['DataFine'])
		button_hid("ins_piazzamento.php","Inserisci Piazzamento",$arr['IdCorsa']);
}
	
if($login)
	if(!$arr['Approvata'])
		DS_button_hid("conferma_corsa.php","Conferma Corsa",$arr['IdCorsa']);

if($login)
	if(!$arr['Terminata'])
		if($n_iscritti)
			button_hid("mod_iscritti.php","Modifica Iscritti",$arr['IdCorsa']);
		else
			button_hid("ins_iscritti.php","Iscrivi Ciclisti",$arr['IdCorsa']);

print_footer();

?>