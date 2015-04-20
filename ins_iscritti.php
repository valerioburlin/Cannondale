<?php
require "connessione.php";
require "funzioni.php";


$login = autenticato();

$id_corsa = $_REQUEST['hid'];   // recupero parametro hidden input

$query = "SELECT NomeCorsa FROM Corse WHERE IdCorsa=\"$id_corsa\" ";
$result = mysql_query($query,$conn) or fail_query();
$row = mysql_fetch_row($result);
$nome_corsa = $row[0];

print_head("Iscrizione Ciclisti - " . $nome_corsa,"Team Cannondale",$login);

print_menu(" ",$login);

print_sub("Iscrivi Ciclisti - " . $nome_corsa);

$self = $_SERVER['PHP_SELF'] . "?hid=" . urlencode($id_corsa);
$first = !isset($_REQUEST['button1']);

if(!$login)
	echo "<p class=\"err_mex\">Devi prima autenticarti!!<p>";
else
{
	if(!$first)
	{
		$ciclista1 = $_POST['ciclista1'];
		$ciclista2 = $_POST['ciclista2'];
		$ciclista3 = $_POST['ciclista3'];
		$ciclista4 = $_POST['ciclista4'];
		$ciclista5 = $_POST['ciclista5'];
		$ciclista6 = $_POST['ciclista6'];
		$ciclista7 = $_POST['ciclista7'];
		$ciclista8 = $_POST['ciclista8'];
		$ciclista9 = $_POST['ciclista9'];
		
		$array_ciclisti = array();
		$errore = check_ciclista($array_ciclisti,$ciclista1);
		if(!$errore && $ciclista1)
			$array_ciclisti[] = $ciclista1;
	
		if(!$errore)
		{
			$errore = check_ciclista($array_ciclisti,$ciclista2);
			if(!$errore && $ciclista2)
				$array_ciclisti[] = $ciclista2;

		}
		if(!$errore)
		{
			$errore = check_ciclista($array_ciclisti,$ciclista3);
			if(!$errore && $ciclista3)
				$array_ciclisti[] = $ciclista3;
		}
		if(!$errore)
		{
			$errore = check_ciclista($array_ciclisti,$ciclista4);
			if(!$errore && $ciclista4)
				$array_ciclisti[] = $ciclista4;
		}
		if(!$errore)
		{
			$errore = check_ciclista($array_ciclisti,$ciclista5);
			if(!$errore && $ciclista5)
				$array_ciclisti[] = $ciclista5;
		}
		if(!$errore)
		{
			$errore = check_ciclista($array_ciclisti,$ciclista6);
			if(!$errore && $ciclista6)
				$array_ciclisti[] = $ciclista6;
		}
		if(!$errore)
		{
			$errore = check_ciclista($array_ciclisti,$ciclista7);
			if(!$errore && $ciclista7)
				$array_ciclisti[] = $ciclista7;
		}
		if(!$errore)
		{
			$errore = check_ciclista($array_ciclisti,$ciclista8);
			if(!$errore && $ciclista8)
				$array_ciclisti[] = $ciclista8;
		}
		if(!$errore)
		{
			$errore = check_ciclista($array_ciclisti,$ciclista9);
			if(!$errore && $ciclista9)
				$array_ciclisti[] = $ciclista9;
		}
		
		if(!$array_ciclisti)
			$errore = "Errore: Devi iscrivere almeno un corridore.";
	}	
	
	if($first || $errore)
	{
		if($first)  // Se è la prima volta mostro la form coi campi vuoti
		{
			$query = "SELECT p.Id,p.Nome,p.Cognome FROM PersoneFisiche p NATURAL JOIN Ciclisti c";
			
			echo<<<END
<form method="post" action="$self" name="button1">
<fieldset class="modifica">
<legend>Form di iscrizione ciclisti</legend>
<p class="descr">N.B. : puoi iscrivere un massimo di 9 corridori</p>
<label for="ciclista1">1.</label>
END;
			$result = mysql_query($query,$conn) or fail_query();;
			print_select("ciclista1",$result);
			
			$result = mysql_query($query,$conn) or fail_query();;
			echo "<label for=\"ciclista2\">2.</label>";
			print_select("ciclista2",$result);
			
			$result = mysql_query($query,$conn) or fail_query();;
			echo "<label for=\"ciclista3\">3.</label>";
			print_select("ciclista3",$result);
			
			$result = mysql_query($query,$conn) or fail_query();;
			echo "<label for=\"ciclista4\">4.</label>";
			print_select("ciclista4",$result);
			
			$result = mysql_query($query,$conn) or fail_query();;
			echo "<label for=\"ciclista5\">5.</label>";
			print_select("ciclista5",$result);
			
			$result = mysql_query($query,$conn) or fail_query();;
			echo "<label for=\"ciclista6\">6.</label>";
			print_select("ciclista6",$result);
			
			$result = mysql_query($query,$conn) or fail_query();;
			echo "<label for=\"ciclista7\">7.</label>";
			print_select("ciclista7",$result);
			
			$result = mysql_query($query,$conn) or fail_query();;
			echo "<label for=\"ciclista8\">8.</label>";
			print_select("ciclista8",$result);
			
			$result = mysql_query($query,$conn) or fail_query();;
			echo "<label for=\"ciclista9\">9.</label>";
			print_select("ciclista9",$result);

			echo<<<END
<input type="submit" id="submit" value="Iscrivi" name="button1" />
</fieldset>
</form>
END;
		}
		else
			echo "<p class=\"err_mex\">$errore</p>";
	}
	else
	{
		foreach($array_ciclisti as $pers)
		{
			$query = "INSERT INTO CiclistiCorse(Id,IdCorsa,Piazzamento) VALUES ('$pers','$id_corsa','')";
			$result = mysql_query($query,$conn) or fail_query();
		}
		$url = "infocorsa?id=" . urlencode($id_corsa);
		echo "<p>Iscrizione avvenuta con successo. <a href=\"$url\">Vai alla corsa</a></p>";
	}
}


print_footer();
?>