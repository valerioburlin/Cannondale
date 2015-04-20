<?php
require "connessione.php";
require "funzioni.php";


$login = autenticato();

/* Recupero dati */
if(isset($_GET['id']))
	$id = $_GET['id'];
else	
	$id = $_POST['login'];

/* Aggiornamento DB */	
if(isset($_POST['button1']))
	$mess1 = upd_dati_staff($id,$conn);

if(isset($_POST['button2']))
	$mess2 = upd_auth($id,$conn);

if(isset($_POST['button3']))
	$mess3 = upd_recapito($id,$conn);
	
/* Recupero parametri membro staff */	
$query = "SELECT *
    	  FROM PersoneFisiche p, Staff s, Recapiti r
		  WHERE p.Id = \"$id\" AND p.Id = s.Id AND p.Id = r.Id";
$staff = mysql_query($query,$conn) or fail_query();
$arr = mysql_fetch_assoc($staff);

$self = $_SERVER['PHP_SELF'] . "?id=" . urlencode($id);

print_head("Modifica - " . $arr['Nome'] . " " . $arr['Cognome'],"Team Cannondale",$login);

print_menu(" ",$login);

print_sub($arr['Nome'] . " " . $arr['Cognome']);

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
<legend>Form di modifica dati personali</legend>
<label for="nome">Nome</label> 
<input type="text" id="nome" name="nome" value="$arr[Nome]" /> 
<label for="cognome">Cognome</label>
<input type="text" id="cognome" name="cognome" value="$arr[Cognome]" /> 
<label for="nazionalita">Nazionalit&agrave</label>
<input type="text" id="nazionalita" name="nazionalita" value="$arr[Nazionalita]" maxlength="3" /> 
<label for="nascita">Anno di Nascita</label>
<input type="text" id="nascita" name="nascita" value="$arr[AnnoNascita]" /> 
<label for="ruolo">Ruolo</label>
<input type="text" id="ruolo" name="ruolo" value="$arr[Ruolo]" />
<input type="submit" id="submit" value="Aggiorna" name="button1" />
END;
		if(isset($mess1))
			echo "<p class=\"err_mex\">$mess1</p>";
		echo<<<END
</fieldset>
</form>

<form method="post" action="$self" name="button2">
<fieldset class="modifica">
<legend>Form di modifica password</legend>
<label for="pwd">Password</label>
<input type="password" id="pwd" name="pwd" maxlength="8" /> 
<label for="c_pwd">Conferma Password</label>
<input type="password" id="c_pwd" name="c_pwd" maxlength="8" />
<input type="submit" id="submit" value="Aggiorna" name="button2" />
END;
		if(isset($mess2))
			echo "<p class=\"err_mex\">$mess2</p>";
		echo<<<END
</fieldset>
</form>

<form method="post" action="$self" name="button3">
<fieldset class="modifica">
<legend>Form di modifica recapito</legend>
<label for="telefono">Telefono</label>
<input type="text" id="telefono" name="telefono" value="$arr[Telefono]" /> 
<label for="via">Via</label>
<input type="text" id="via" name="via" value="$arr[Via]"/> 
<label for="numero">Numero Civico</label>
<input type="text" id="numero" name="numero" value="$arr[Num]" />
<label for="localita">Localit&agrave</label>
<input type="text" id="localita" name="localita" value="$arr[Localita]" />
<label for="prov">Provincia</label>
<input type="text" id="prov" name="prov" value="$arr[Prov]" maxlength="2" /> 
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