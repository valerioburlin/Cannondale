<?php
require "connessione.php";
require "funzioni.php";


$login = autenticato();

print_head("Aggiungi Staff","Team Cannondale",$login);

print_menu(" ",$login);

print_sub("Aggiungi Membro dello Staff");

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
			
			$ruolo = $_POST['ruolo'];
			if(!$errore)
				if(!$ruolo)
					$errore = "Errore: Ruolo deve essere 'Allenatore' o 'DS'.";
					
			$id = $_POST['login'];
			if(!$errore)
			{
				if(!$id)
					$errore = "Errore: L'Username non pu&ograve essere nullo.";
				else	
					$errore = check_id($id,$conn);
			}
			
			$password = $_POST['pwd'];
			$confirm = $_POST['c_pwd'];
			if(!$errore)
			{
				if(!$password)
					$errore = "Errore: La Password non pu&ograve essere nulla.";
				else
				{
					if($password == $confirm)
						$password=sha1($password);
					else
						$errore = "Errore: Password e Conferma sono diverse.";
				}
			}
			
			$telefono = $_POST['telefono'];
			$via = trim($_POST['via']);
			$numero = $_POST['numero'];
			$localita = trim($_POST['localita']);
			$prov = strtoupper($_POST['prov']);
			if(!$errore)
				$errore = check_recapito($telefono,$numero);			
		}
		
		if($first || $errore)
		{
			if($first)  // Se è la prima volta mostro la form coi campi vuoti
			{
				echo<<<END
<form method="post" action="$self" name="button1">
<fieldset class="modifica">
<legend>Form di inserimento dati staff</legend>
<p class="descr">Dati Personali:</p>
<label for="nome">Nome</label> 
<input type="text" id="nome" name="nome" /> 
<label for="cognome">Cognome</label>
<input type="text" id="cognome" name="cognome" /> 
<label for="nazionalita">Nazionalit&agrave</label>
<input type="text" id="nazionalita" name="nazionalita" maxlength="3" /> 
<label for="nascita">Anno di Nascita</label>
<input type="text" id="nascita" name="nascita" /> 
<label for="ruolo">Ruolo</label>
<select id="ruolo" name="ruolo">
<option value="Null" selected="selected"> </option>
<option value="DS">DS</option>
<option value="Allenatore">Allenatore</option>
</select>

<p class="descr">Accesso Area Riservata:</p> 
<label for="login">Username</label>
<input type="text" id="login" name="login" maxlength="8" /> 
<label for="pwd">Password</label>
<input type="password" id="pwd" name="pwd" maxlength="8" /> 
<label for="c_pwd">Conferma Password</label>
<input type="password" id="c_pwd" name="c_pwd" maxlength="8" />

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
<label for="ruolo">Ruolo</label>
<select id="ruolo" name="ruolo">
<option value="Null" selected="selected"> </option>
<option value="DS">DS</option>
<option value="Allenatore">Allenatore</option>
</select>

<p class="descr">Accesso Area Riservata:</p> 
<label for="login">Username</label>
<input type="text" id="login" name="login" maxlength="8" value="$id" /> 
<label for="pwd">Password</label>
<input type="password" id="pwd" name="pwd" maxlength="8" value="$password" /> 
<label for="c_pwd">Conferma Password</label>
<input type="password" id="c_pwd" name="c_pwd" maxlength="8" value="$confirm" />

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
<input type="submit" id="submit" value="Inserisci" name="button1" />
<p class=\"err_mex\">$errore</p>
</fieldset>
</form>
END;
			}
		}
		else  // Se invece non ci sono errori inserisco nel DB richiamando la procedura corretta
		{
			$query1 = "CALL InserisciStaff('$id','$nome','$cognome','$nazionalita','$nascita','$ruolo','$password')";
			$result1 = mysql_query($query1,$conn) or fail_query();
			
			$query2 = "INSERT INTO Recapiti(Id,Telefono,Via,Num,Localita,Prov)
							  VALUES ('$id','$telefono','$via','$numero','$localita','$prov')";
			$result2 = mysql_query($query2,$conn) or fail_query(); 
			if($result1 && $result2)
			{
				$str = build_rec($via,$numero,$localita,$prov);
				
				echo "<p>Hai inserito correttamente <span class=\"tit\">$nome $cognome</span> <br />
				         con le seguenti credenziali di accesso: <br />
					 	 <span class=\"tit\">Username =</span> $id; <br /> 
					  <p>E con il seguente recapito: <br />
					     $str - <span class=\"tit\">Telefono :</span> $telefono</p>";
			}
		}
	}

	
print_footer();
?>