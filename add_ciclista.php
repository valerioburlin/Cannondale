<?php
require "connessione.php";
require "funzioni.php";


$login = autenticato();

print_head("Aggiungi Ciclista","Team Cannondale",$login);

print_menu(" ",$login);

print_sub("Aggiungi Ciclista");

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
			$cognome = trim($_POST['cognome']);
			$nazionalita = strtoupper($_POST['nazionalita']);
			$nascita = $_POST['nascita'];
			$errore = check_dati($nome,$cognome,$nascita);
								
			$id = $_POST['login'];
			if(!$errore)
			{
				if(!$id)
					$errore = "Errore: L'Username non pu&ograve essere nullo.";
				else	
					$errore = check_id($id,$conn);
			}
			$prof = $_POST['prof'];
			$arrivo = $_POST['arrivo'];
			if(!$errore)
			{
				if( ($arrivo && !ctype_digit($arrivo)) || ($prof && !ctype_digit($prof)))
					$errore = "Errore: Arrivo in Squadra e Professionista dal devono essere numerici(Anno!).";
			}
			
			$telefono = $_POST['telefono'];
			$via = trim($_POST['via']);
			$numero = $_POST['numero'];
			$localita = trim($_POST['localita']);
			$prov = strtoupper($_POST['prov']);
			if(!$errore)
				$errore = check_recapito($telefono,$numero);

			$rbc = $_POST['rbc'];
			$hb = $_POST['hb'];
			$hct = $_POST['hct'];
			if(!$errore)
			{
				if(!$rbc || !$hb || !$hct)
					$errore = "Errore: I valori del Passaporto Biologico non possono essere nulli! Obbligatori per tesseramento in squadra e per partecipare alle corse.";
				if( !is_numeric($rbc) || !ctype_digit($hb) || !ctype_digit($hct) )
					$errore = "Errore: I valori del Passaporto Biologico devono essere numerici.";
			}
		}
		
		if($first || $errore)
		{
			if($first)  // Se è la prima volta mostro la form coi campi vuoti
			{
				echo<<<END
<form method="post" action="$self" name="button1">
<fieldset class="modifica">
<legend>Form di inserimento dati ciclista</legend>
<p class="descr">Dati Personali:</p>
<label for="nome">Nome</label> 
<input type="text" id="nome" name="nome" /> 
<label for="cognome">Cognome</label>
<input type="text" id="cognome" name="cognome" /> 
<label for="nazionalita">Nazionalit&agrave</label>
<input type="text" id="nazionalita" name="nazionalita" maxlength="3" /> 
<label for="nascita">Anno di Nascita</label>
<input type="text" id="nascita" name="nascita" /> 

<p class="descr">Dati Specifici Ciclista:</p> 
<label for="login">Username</label>
<input type="text" id="login" name="login" maxlength="8" /> 
<label for="prof">Professionista dal</label>
<input type="text" id="prof" name="prof" />
<label for="arrivo">Arrivo in Squadra</label>
<input type="text" id="arrivo" name="arrivo" />

<p class="descr">Recapito:</p> 
<label for="telefono">Telefono</label>
<input type="text" id="telefono" name="telefono" /> 
<label for="via">Via</label>
<input type="text" id="via" name="via" /> 
<label for="numero">Numero Civico</label>
<input type="text" id="numero" name="numero" />
<label for="localita">Localit&agrave</label>
<input type="text" id="localita" name="localita" />
<label for="prov">Provincia</label>
<input type="text" id="prov" name="prov" maxlength="2" /> 

<p class="descr">Passaporto Biologico:</p>
<label for="rbc">RBC</label>
<input type="text" id="rbc" name="rbc" /> 
<label for="hb">Hb</label>
<input type="text" id="hb" name="hb" /> 
<label for="hct">Hct</label>
<input type="text" id="hct" name="hct" /> 
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
<legend>Form di inserimento dati staff</legend>
<p class="descr">Dati Personali:</p>
<label for="nome">Nome</label> 
<input type="text" id="nome" name="nome" value="$nome" /> 
<label for="cognome">Cognome</label>
<input type="text" id="cognome" name="cognome" value="$cognome" /> 
<label for="nazionalita">Nazionalit&agrave</label>
<input type="text" id="nazionalita" name="nazionalita" maxlength="3" value="$nazionalita" /> 
<label for="nascita">Anno di Nascita</label>
<input type="text" id="nascita" name="nascita" value="$nascita" /> 

<p class="descr">Dati Specifici Ciclista:</p> 
<label for="login">Username</label>
<input type="text" id="login" name="login" maxlength="8" value="$id" /> 
<label for="prof">Professionista dal</label>
<input type="text" id="prof" name="prof" value="$prof" />
<label for="arrivo">Arrivo in Squadra</label>
<input type="text" id="arrivo" name="arrivo" value="$arrivo" />

<p class="descr">Recapito:</p> 
<label for="telefono">Telefono</label>
<input type="text" id="telefono" name="telefono" value="$telefono" /> 
<label for="via">Via</label>
<input type="text" id="via" name="via" value="$via" /> 
<label for="numero">Numero Civico</label>
<input type="text" id="numero" name="numero" value="$numero" />
<label for="localita">Localit&agrave</label>
<input type="text" id="localita" name="localita" value="$localita" />
<label for="prov">Provincia</label>
<input type="text" id="prov" name="prov" maxlength="2" value="$prov" /> 

<p class="descr">Passaporto Biologico:</p>
<label for="rbc">RBC</label>
<input type="text" id="rbc" name="rbc" value="$rbc" /> 
<label for="hb">Hb</label>
<input type="text" id="hb" name="hb" value="$hb" /> 
<label for="hct">Hct</label>
<input type="text" id="hct" name="hct" value="$hct"/> 
<input type="submit" id="submit" value="Inserisci" name="button1" />
<p class=\"err_mex\">$errore</p>
</fieldset>
</form>
END;
			}
		}
		else  // Se invece non ci sono errori inserisco nel DB richiamando la procedura corretta
		{
			$query1 = "CALL InserisciCiclisti('$id','$nome','$cognome','$nazionalita','$nascita','$arrivo','$prof')";
			$result1 = mysql_query($query1,$conn) or fail_query();
			
			$query2 = "INSERT INTO Recapiti(Id,Telefono,Via,Num,Localita,Prov)
							  VALUES ('$id','$telefono','$via','$numero','$localita','$prov')";
			$result2 = mysql_query($query2,$conn) or fail_query(); 
			
			$query3 = "INSERT INTO PassBio(RBC,Hb,Hct,Id)
							  VALUES ('$rbc','$hb','$hct','$id')";
			$result3 = mysql_query($query3,$conn) or fail_query();
			if($result1 && $result2)
			{
				$str = build_rec($via,$numero,$localita,$prov);
				
				echo "<p>Hai inserito correttamente <span class=\"tit\">$nome $cognome</span> <br />
				      <p>Con il seguente recapito: <br />
					     $str - <span class=\"tit\">Telefono :</span> $telefono</p>
					  <p>Con il seguente Passaporto Biologico: <br />
						 <span class=\"tit\">RBC :</span> $rbc , <span class=\"tit\">Hb :</span> $hb , <span class=\"tit\">Hct :</span> $hct.</p>";
			}
		}
	}

	
print_footer();
?>