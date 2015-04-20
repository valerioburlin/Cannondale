<?php
require "connessione.php";
require "funzioni.php";


$login = autenticato();

$id_tappa = $_REQUEST['hid'];   // recupero parametro hidden input

$query = "SELECT p.Numero,c.IdCorsa,c.NomeCorsa FROM Corse c, Tappe p 
          WHERE p.IdTappa=\"$id_tappa\" AND p.IdCorsa=c.IdCorsa ";
$result = mysql_query($query,$conn) or fail_query();
$row = mysql_fetch_row($result);
$numero = $row[0];
$id_corsa = $row[1];
$nome_corsa = $row[2];

print_head("Inserimento Vittoria - " . $numero . "&degTappa - " . $nome_corsa,"Team Cannondale",$login);

print_menu(" ",$login);

print_sub("Inserimento Vittoria - " . $numero . "&degTappa - " . $nome_corsa);

$self = $_SERVER['PHP_SELF'] . "?hid=" . urlencode($id_tappa);
$first = !isset($_REQUEST['button']);

if(!$login)
	echo "<p class=\"err_mex\">Devi prima autenticarti!!<p>";
else
{
	if(!$first)
	{
		$errore = FALSE;
		$ciclista = $_POST['ciclista'];
		if(!$ciclista)
			$errore = "Errore: non hai selezionato nessun corridore.";
	}
	if($first || $errore)
	{
		if($first)  // Se è la prima volta mostro la form coi campi vuoti
		{
			$query = "SELECT p.Id,p.Nome,p.Cognome FROM PersoneFisiche p NATURAL JOIN CiclistiCorse cc 
			          WHERE cc.IdCorsa=\"$id_corsa\" ";
			
			echo<<<END
<form method="post" action="$self" name="button">
<fieldset class="modifica">
<legend>Form di inserimento vittoria parziale</legend>
<p class="descr">Scegli Ciclista Vincitore</p>
<label for="ciclista">Ciclista</label>
END;
			$result = mysql_query($query,$conn) or fail_query();
			print_select("ciclista",$result);
			echo<<<END
<input type="submit" id="submit" value="Inserisci" name="button" />
</fieldset>
</form>
END;
		}
		else
			echo "<p class=\"err_mex\">$errore</p>
			      <p><a href=\"$self\">Torna Indietro</a></p>";
		
	}
	else
	{
		$query = "UPDATE Tappe SET VintaDa=\"$ciclista\" WHERE IdTappa=\"$id_tappa\" ";
		$result = mysql_query($query,$conn) or fail_query();
		echo "<p class=\"descr\">Hai inserito correttamente la vittoria!</p>";
		$url = "infotappa.php?id=" . urlencode($id_tappa);
		echo "<p><a href=\"$url\">Vai alla tappa</a></p>";
	}
}


print_footer();
?>