<?php
require "connessione.php";
require "funzioni.php";


$login = autenticato();

$id_corsa = $_REQUEST['hid'];   // recupero parametro hidden input

if(isset($_REQUEST['button1']))
	$mess = add_corridore($id_corsa,$conn);

$query = "SELECT NomeCorsa FROM Corse WHERE IdCorsa=\"$id_corsa\" ";
$result = mysql_query($query,$conn) or fail_query();
$row = mysql_fetch_row($result);
$nome_corsa = $row[0];

print_head("Modifica Iscrizione - " . $nome_corsa,"Team Cannondale",$login);

print_menu(" ",$login);

print_sub("Modifica Iscrizione - " . $nome_corsa);

$self = $_SERVER['PHP_SELF'] . "?hid=" . urlencode($id_corsa);

if(!$login)
	echo "<p class=\"err_mex\">Devi prima autenticarti!!<p>";
else
{
	$query = "SELECT p.Id, p.Nome, p.Cognome
			  FROM PersoneFisiche p NATURAL JOIN CiclistiCorse cc
			  WHERE cc.IdCorsa=\"$id_corsa\" ";
	$result = mysql_query($query,$conn) or fail_query();
	$n_ciclisti = mysql_num_rows($result);
	
	$titolo = array("Nome","Cognome");
	table_start($titolo);
	
	while($row = mysql_fetch_assoc($result))
	{
		$url = "elimina_iscritto.php?ciclista=" . urlencode($row['Id']) . "&corsa=" . urlencode($id_corsa);
		echo "<tr><td>$row[Nome]</td><td>$row[Cognome]</td><td><a href=\"$url\">elimina</td></tr>";
	}
	
	table_end();
	
	if($n_ciclisti<9)
	{
		$query2 = "SELECT p.Id,p.Nome,p.Cognome FROM PersoneFisiche p NATURAL JOIN Ciclisti c WHERE p.Id = c.Id";
		echo<<<END
<form method="post" action="$self" name="button1">
<fieldset class="modifica">
<legend>Aggiungi Ciclista</legend>
<p class="descr">N.B. : puoi iscrivere un massimo di 9 corridori</p>
<label for="ciclista">Ciclista</label>
END;
		$result = mysql_query($query2,$conn) or fail_query();;
		print_select("ciclista",$result);
		
		echo "<input type=\"submit\" id=\"submit\" value=\"Iscrivi\" name=\"button1\" />";
		if(isset($mess))
			echo "<p class=\"err_mex\">$mess</p>";
		echo<<<END
</fieldset>
</form>
END;
	}
	else 
		echo "<p class=\"descr\">Massimo numero di ciclisti iscritti: 9.</p>";
}


print_footer();
?>