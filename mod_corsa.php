<?php
require "connessione.php";
require "funzioni.php";


$login = autenticato();

/* Recupero dati */
if(isset($_GET['id']))
	$id = $_GET['id'];
	
/* Aggiornamento DB */	
if(isset($_POST['button1']))
	$mess1 = upd_dati_corsa($id,$conn);

if(isset($_POST['button2']))
	$mess2 = upd_dati_luogo($conn);
	
if(isset($_POST['button3']))
	$mess3 = upd_dati_luogo($conn);
	
/* Recupero parametri corsa */	
$query = "SELECT c.NomeCorsa, c.DataInizio, c.DataFine, c.Distanza, c.Partenza, c.Arrivo, 
				l1.CAP AS CAP1, l1.Localita AS loc1, l1.Nazione AS naz1, l1.Regione AS reg1, l1.Prov AS prov1, 
				l2.CAP AS CAP2, l2.Localita AS loc2, l2.Nazione AS naz2, l2.Regione AS reg2, l2.Prov AS prov2
    	  FROM Corse c, Luoghi l1, Luoghi l2
		  WHERE c.IdCorsa = \"$id\" AND c.Partenza = l1.CAP AND c.Arrivo = l2.CAP ";
$corsa = mysql_query($query,$conn) or fail_query();
$arr = mysql_fetch_assoc($corsa);	

$self = $_SERVER['PHP_SELF'] . "?id=" . urlencode($id);

print_head("Modifica - " . $arr['NomeCorsa'],"Team Cannondale",$login);

print_menu(" ",$login);

print_sub($arr['NomeCorsa']);

if(!$login)
	echo "<p class=\"err_mex\">Devi prima autenticarti!!<p>";
else
	if($_SESSION['ruolo'] != "DS")
		echo "<p class=\"err_mex\">Non hai l'autorizzazione necessaria per accedere a questa pagina!!<p>";
	else
	{
		echo<<<END
<form method="post" action="$self" name="button1">
<fieldset class="modifica">
<legend>Form di modifica dati corsa</legend>
<label for="nome">Nome</label>
<input type="text" id="nome" name="nome" value="$arr[NomeCorsa]" /> 
<label for="inizio">Data Inizio(YYYY-MM-DD)</label>
<input type="text" id="inizio" name="inizio" value="$arr[DataInizio]" /> 
<label for="fine">Data Fine(YYYY-MM-DD)</label>
<input type="text" id="fine" name="fine" value="$arr[DataFine]" /> 
<label for="distanza">Distanza</label>
<input type="text" id="distanza" name="distanza" value="$arr[Distanza]" /> 
<input type="submit" id="submit" value="Aggiorna" name="button1" />
END;
		if(isset($mess1))
			echo "<p class=\"err_mex\">$mess1</p>";
		echo<<<END
</fieldset>
</form>

<form method="post" action="$self" name="button2">
<fieldset class="modifica">
<legend>Form di modifica dati luogo di partenza</legend>
<input type="hidden" name="oldcap1" value="$arr[Partenza]"> 
<label for="cap1">CAP</label>
<input type="text" id="cap1" name="cap1" value="$arr[CAP1]" maxlength="5" /> 
<label for="loc1">Localit&agrave</label>
<input type="text" id="loc1" name="loc1" value="$arr[loc1]" />
<label for="naz1">Nazione</label>
<input type="text" id="naz1" name="naz1" value="$arr[naz1]" maxlength="3" />
<label for="reg1">Regione</label>
<input type="text" id="reg1" name="reg1" value="$arr[reg1]" />
<label for="prov1">Provincia</label>
<input type="text" id="prov1" name="prov1" value="$arr[prov1]" maxlength="2" />
<input type="submit" id="submit" value="Aggiorna" name="button2" />
END;
	if(isset($mess2))
		echo "<p class=\"err_mex\">$mess2</p>";
	echo<<<END
</fieldset>
</form>

<form method="post" action="$self" name="button3">
<fieldset class="modifica">
<legend>Form di modifica dati luogo di arrivo</legend>
<input type="hidden" name="oldcap2" value="$arr[Arrivo]"> 
<label for="cap2">CAP</label>
<input type="text" id="cap2" name="cap2" value="$arr[CAP2]" maxlength="5" /> 
<label for="loc2">Localit&agrave</label>
<input type="text" id="loc2" name="loc2" value="$arr[loc2]" />
<label for="naz2">Nazione</label>
<input type="text" id="naz2" name="naz2" value="$arr[naz2]" maxlength="3" />
<label for="reg2">Regione</label>
<input type="text" id="reg2" name="reg2" value="$arr[reg2]" />
<label for="prov2">Provincia</label>
<input type="text" id="prov2" name="prov2" value="$arr[prov2]" maxlength="2" />
<input type="submit" id="submit" value="Aggiorna" name="button3" />
END;
	if(isset($mess3))
		echo "<p class=\"err_mex\">$mess3</p>";
	echo<<<END
</fieldset>
</form>
END;
	}

	
print_footer();
?>