<?php
/* Pagina di autenticazione e gestione login per lo staff */

require "connessione.php";
require "funzioni.php";

$login = autenticato();

if($login)
  header("Location: home.php");
  
print_head("Autenticazione","Team Cannondale",$login);

print_menu("login",$login);

print_sub("Autenticazione");

if(isset($_POST['login']) && isset($_POST['pwd']))
{
	$login = $_POST['login']; 
	$pwd = $_POST['pwd']; 
		
	$assoc = get_pwd($login,$conn);

	if( $login && (sha1($pwd) == $assoc['Password']) ) 
	{
		$_SESSION['autenticato'] = $login;
		$_SESSION['ruolo'] = $assoc['Ruolo'];
		
		$query = "SELECT Nome FROM PersoneFisiche WHERE Id=\"$login\" ";
		$result = mysql_query($query,$conn) or fail_query();
		$row = mysql_fetch_row($result);
		$nome = $row[0];
		$_SESSION['nome'] = $nome;
		
		$today = date("d/M/Y");
		setcookie('lastvisit',"$today",time()+3600*12*7);
		header("Location: home.php");
	}
	else
		$errore = TRUE;
}

$self = $_SERVER['PHP_SELF'];
echo<<<END
<form method="post" action="$self">
<fieldset id="autenticazione">
<legend>Form di autenticazione staff</legend>
<label for="login">Username</label>
<input type="text" id="login" name="login" />
<label for="pwd">Password</label>
<input type="password" id="pwd" name="pwd" maxlength="8" />
<input type="submit" id="submit" value="Procedi">
END;

/* Se ho ricaricato il form vuol dire che la password o il login erano sbagliate */
	if(isset($errore))
		echo "<p class=\"err_mex\">Autenticazione fallita! Riprova!</p>";
			
echo<<<END
</fieldset>
</form>
END;

	 
print_footer();
?>
