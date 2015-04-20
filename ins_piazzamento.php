<?php
require "connessione.php";
require "funzioni.php";


$login = autenticato();

$id_corsa = $_REQUEST['hid'];   // recupero parametro hidden input

$query = "SELECT NomeCorsa FROM Corse WHERE IdCorsa=\"$id_corsa\" ";
$result = mysql_query($query,$conn) or fail_query();
$row = mysql_fetch_row($result);
$nome_corsa = $row[0];

print_head("Inserimento Piazzamento - " . $nome_corsa,"Team Cannondale",$login);

print_menu(" ",$login);

print_sub("Inserimento Piazzamento - " . $nome_corsa);

$self = $_SERVER['PHP_SELF'] . "?hid=" . urlencode($id_corsa);
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
		
		if(!$errore)
		{
			$piazzamento = $_POST['piazzamento'];
			if($piazzamento < 0 || $piazzamento > 10)
				$errore = "Errore: piazzamento non valido(si considerano solo le prime dieci posizioni).";
		}
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
<legend>Form di inserimento piazzamento ciclista</legend>
<p class="descr">Scegli Ciclista e Piazzamento</p>
<label for="ciclista">Ciclista</label>
END;
			$result = mysql_query($query,$conn) or fail_query();
			print_select("ciclista",$result);
			echo<<<END
<label for="piazzamento">Piazzamento</label>
<input type="number" id="piazzamento" name="piazzamento" />
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
		$query = "UPDATE CiclistiCorse SET Piazzamento=\"$piazzamento\" 
				  WHERE Id=\"$ciclista\" AND IdCorsa=\"$id_corsa\" ";
		$result = mysql_query($query,$conn) or fail_query();
		echo "<p class=\"descr\">Hai inserito correttamente il piazzamento!</p>";
		$url = "infocorsa.php?id=" . urlencode($id_corsa);
		echo "<p><a href=\"$url\">Vai alla corsa</a></p>";
	}
}


print_footer();
?>