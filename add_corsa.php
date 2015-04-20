<?php
require "connessione.php";
require "funzioni.php";


$login = autenticato();

print_head("Aggiungi Corsa","Team Cannondale",$login);

print_menu(" ",$login);

print_sub("Aggiungi Corsa");

$self = $_SERVER['PHP_SELF'];
$first = !isset($_REQUEST['button1']);

if(!$login)
	echo "<p class=\"err_mex\">Devi prima autenticarti!!<p>";
else
	if($_SESSION['ruolo'] != "DS")
		echo "<p class=\"err_mex\">Non hai l'autorizzazione necessaria per accedere a questa pagina!!<p>";
	else
	{
		if(!$first)
		{
			$nome = trim($_POST['nome']);
			$inizio = $_POST['inizio'];
			$fine = $_POST['fine'];
			$distanza = $_POST['distanza'];
			$errore = check_dati_corsa($inizio,$fine,$distanza);
		
			$cap1 = $_POST['cap1'];
			$loc1 = trim($_POST['loc1']);
			$naz1 = strtoupper($_POST['naz1']);
			$reg1 = trim($_POST['reg1']);
			$prov1 = strtoupper($_POST['prov1']);
			if(!$errore)
			{
				if(!$cap1)
					$errore = "Errore: il CAP non pu&ograve essere nullo.";
			}
			
			$cap2 = $_POST['cap2'];
			$loc2 = trim($_POST['loc2']);
			$naz2 = strtoupper($_POST['naz2']);
			$reg2 = trim($_POST['reg2']);
			$prov2 = strtoupper($_POST['prov2']);
			if(!$errore)
			{
				if(!$cap2)
					$errore = "Errore: il CAP non pu&ograve essere nullo.";
			}
		}
		
		if($first || $errore)
		{
			if($first)  // Se � la prima volta mostro la form coi campi vuoti
			{
				echo<<<END
<form method="post" action="$self" name="button1">
<fieldset class="modifica">
<legend>Form di modifica dati corsa</legend>
<p class="descr">Dati Corsa:</p>
<label for="nome">Nome</label>
<input type="text" id="nome" name="nome" /> 
<label for="inizio">Data Inizio(YYYY-MM-DD)</label>
<input type="text" id="inizio" name="inizio" /> 
<label for="fine">Data Fine(YYYY-MM-DD)</label>
<input type="text" id="fine" name="fine" /> 
<label for="distanza">Distanza</label>
<input type="text" id="distanza" name="distanza" /> 

<p class="descr">Dati Luogo di Partenza:</p>
<label for="cap1">CAP</label>
<input type="text" id="cap1" name="cap1" maxlength="5" /> 
<label for="loc1">Localit&agrave</label>
<input type="text" id="loc1" name="loc1" />
<label for="naz1">Nazione</label>
<input type="text" id="naz1" name="naz1" maxlength="3" />
<label for="reg1">Regione</label>
<input type="text" id="reg1" name="reg1" />
<label for="prov1">Provincia</label>
<input type="text" id="prov1" name="prov1" maxlength="2" />	
	
<p class="descr">Dati Luogo di Arrivo:</p>
<label for="cap2">CAP</label>
<input type="text" id="cap2" name="cap2" maxlength="5" /> 
<label for="loc2">Localit&agrave</label>
<input type="text" id="loc2" name="loc2" />
<label for="naz2">Nazione</label>
<input type="text" id="naz2" name="naz2" maxlength="3" />
<label for="reg2">Regione</label>
<input type="text" id="reg2" name="reg2" />
<label for="prov2">Provincia</label>
<input type="text" id="prov2" name="prov2" maxlength="2" />		
<input type="submit" id="submit" value="Inserisci" name="button1" />
</fieldset>
</form>
END;
			}
			else  // Se invece c'era un errore mostro la form ma mantengo i valori inseriti e mostro il messaggio di errore
			{
				echo<<<END
<form method="post" action="$self" name="button1">
<fieldset class="modifica">
<legend>Form di inserimento dati corsa</legend>
<p class="descr">Dati Corsa:</p>
<label for="nome">Nome</label>
<input type="text" id="nome" name="nome" value="$nome" /> 
<label for="inizio">Data Inizio(YYYY-MM-DD)</label>
<input type="text" id="inizio" name="inizio" value="$inizio" /> 
<label for="fine">Data Fine(YYYY-MM-DD)</label>
<input type="text" id="fine" name="fine" value="$fine" /> 
<label for="distanza">Distanza</label>
<input type="text" id="distanza" name="distanza" value="$distanza" /> 

<p class="descr">Dati Luogo di Partenza:</p>
<label for="cap1">CAP</label>
<input type="text" id="cap1" name="cap1" value="$cap1" maxlength="5" /> 
<label for="loc1">Localit&agrave</label>
<input type="text" id="loc1" name="loc1" value="$loc1" />
<label for="naz1">Nazione</label>
<input type="text" id="naz1" name="naz1" value="$naz1" maxlength="3" />
<label for="reg1">Regione</label>
<input type="text" id="reg1" name="reg1" value="$reg1" />
<label for="prov1">Provincia</label>
<input type="text" id="prov1" name="prov1" value="$prov1" maxlength="2" />	
	
<p class="descr">Dati Luogo di Arrivo:</p>
<label for="cap2">CAP</label>
<input type="text" id="cap2" name="cap2" value="$cap2" maxlength="5" /> 
<label for="loc2">Localit&agrave</label>
<input type="text" id="loc2" name="loc2" value="$loc2" />
<label for="naz2">Nazione</label>
<input type="text" id="naz2" name="naz2" value="$naz2" maxlength="3" />
<label for="reg2">Regione</label>
<input type="text" id="reg2" name="reg2" value="$reg2" />
<label for="prov2">Provincia</label>
<input type="text" id="prov2" name="prov2" value="$prov2" maxlength="2" />		
<input type="submit" id="submit" value="Inserisci" name="button1" />
</fieldset>
</form>
END;
			}
		}
		else  // Se invece non ci sono errori inserisco nel DB la Corsa e i Luoghi di partenza e arrivo
		{
			$luogo = check_luogo($cap1,$conn);  // Controllo se il Luogo di Partenza � gi� presente del DB
			if(!$luogo)
			{
				$query = "INSERT INTO Luoghi(CAP,Localita,Nazione,Regione,Prov) 
				                 VALUES ('$cap1','$loc1','$naz1','$reg1','$prov1')";
				$result = mysql_query($query,$conn) or fail_query();
			}
			
			$luogo = check_luogo($cap2,$conn);  // Controllo se il Luogo di Arrivo � gi� presente del DB
			if(!$luogo)
			{
				$query = "INSERT INTO Luoghi(CAP,Localita,Nazione,Regione,Prov) 
				                 VALUES ('$cap2','$loc2','$naz2','$reg2','$prov2')";
				$result = mysql_query($query,$conn) or fail_query();
			}
			
			$query = "INSERT INTO Corse(NomeCorsa,DataInizio,DataFine,Distanza,Terminata,Approvata,Partenza,Arrivo)
			                 VALUES ('$nome','$inizio','$fine','$distanza',0,0,'$cap1','$cap2')";
			$result = mysql_query($query,$conn) or fail_query();
			if($result)
			{
				$str1 = build_luogo($cap1,$loc1,$prov1,$reg1,$naz1);
				$str2 = build_luogo($cap2,$loc2,$prov2,$reg2,$naz2);
				
				echo "<p>Hai inserito correttamente la corsa <span class=\"tit\">$nome</span> <br />
				      <p>Con la seguente partenza: $str1</p>
					  <p>Con il seguente arrivo: $str2</p>";
			}
		}
	
	}
	
	
print_footer();
?>