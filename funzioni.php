<?php

/**************************************/ 
/* FUNZIONI GENERICHE PER PAGINE HTML */

/* Funzione che stampa l'inizio delle pagine HTML. */
function print_head ($title,$h1,$login) {
   echo<<<END
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="it" lang="it">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>$title - Cannondale</title>
<link rel="StyleSheet" href="CSS/style.css" type"text/css">
</head>
<body>
<div id="header"><h1>$h1</h1>
END;
	if($login)
	{
		if(isset($_COOKIE['lastvisit']))
			echo "<h3>Ciao $_SESSION[nome], l' ultimo accesso autenticato al sito risale al $_COOKIE[lastvisit]</h3>";
	}
	echo<<<END
</div>
END;
}

/* Funzione per la stampa del menù di navigazione. */
function print_menu($item,$login) {
   echo<<<END
<div id="menu">
<ul>
END;
   if($item === "home")
	echo "<li>Home</li>";
   else
	echo "<li><a href=\"home.php\">Home</a></li>";

   if($item === "squadra")
	echo "<li>La Squadra</li>";
   else
	echo "<li><a href=\"squadra.php\">La Squadra</a></li>";

   if($item === "corse")
	echo "<li>Le Corse</li>";
   else
 	echo "<li><a href=\"corse.php\">Le Corse</a></li>";

   if($item === "ricerca")
	echo "<li>Ricerca</li>";
   else
 	echo "<li><a href=\"ricerca.php\">Ricerca</a></li>";
   
   if($login)
	 echo "<li><a href=\"logout.php\">Logout</a></li>";
   else
	 if($item === "login")
	   echo "<li>Login</li>";
     else
       echo "<li><a href=\"ins_login.php\">Login</a></li>";
   
   echo<<<END
</ul>
</div>
END;
}

/* Funzione per la stampa del sottotitolo */
function print_sub($sub) {
   echo "<h2>$sub</h2>";
}

/* Funzione per la stampa della fine delle pagine HTML. */
function print_footer() {
   echo<<<END
<div id="footer"> </div>
</body>
</html>
END;
}

/* Funzione per la stampa di pulsanti di utilità per i DS */
function DS_button($link,$descr) {
	$ruolo = $_SESSION['ruolo'];
	if($ruolo == "DS") 
		echo<<<END
<form id="button" method="get" action="$link">
<input type="submit" value="$descr" />
</form>
END;
}

/* Funzione per la stampa di pulsanti di utilità per i DS e Allenatori con hidden input */
function button_hid($link,$descr,$hidden) {
	echo<<<END
<form id="button" method="get" action="$link">
<input type="hidden" name="hid" value="$hidden" />
<input type="submit" value="$descr" />
</form>
END;
}

/* Funzione per la stampa di pulsanti di utilità per i DS con hidden input */
function DS_button_hid($link,$descr,$hidden) {
	$ruolo = $_SESSION['ruolo'];
	if($ruolo == "DS") 
		echo<<<END
<form id="button" method="get" action="$link">
<input type="hidden" name="hid" value="$hidden" />
<input type="submit" value="$descr" />
</form>
END;
}


/***************************************/ 
/* FUNZIONI PER LA GESTIONE DI TABELLE */

/* Funzione per iniziare una tabella HTML. 
   In input l'array che contiene gli header delle colonne. */
function table_start($row) {
  echo "<table>\n";
  echo "<tr>\n";
  foreach ($row as $field) 
    echo "<th>$field</th>\n";
  
  echo "</tr>\n";
}

/* Funzione per stampare un array come riga di tabella HTML. */
function table_row($row,$login,$ref1,$ref2,$ref3) {
  echo "<tr>";
  $info = $row[0];
  unset($row[0]);    // l'Id mi serve per i vari link ma non nella stampa delle tabelle
  foreach ($row as $field) 
    if($field)
      echo "<td>$field</td>\n";
    else
      echo "<td>---</td>\n";
  $url = $ref1 . "?id=" . urlencode($info);
  echo "<td><a href=\"$url\">info</a></td>";
  
  if($login)
  {
	$ruolo = $_SESSION['ruolo'];
	if($ruolo == "DS")
	{
		$url1 = $ref2 . "?id=" . urlencode($info);
		echo "<td><a href=\"$url1\">modifica</a></td>";
		
		$url2 = $ref3 . "?id=" .urlencode($info);
		echo "<td><a href=\"$url2\">elimina</a></td>";
	}
  }
  echo "</tr>";
}

/* Funzione per chiudere una tabella HTML. */
function table_end() {
  echo "</table>\n";
}


/********************************************/
/* FUNZIONI PER LA STAMPA DI DATI SPECIFICI */

/* Funzione per stampare tutti i dati specifici di un ciclista */
function print_ciclista($arr) {
   echo<<<END
<div class="info">
<span class="tit">Nazionalit&agrave :</span> $arr[Nazionalita] <br /> <span class="tit">Anno di Nascita :</span> $arr[AnnoNascita] <br /> 
<span class="tit">Professionista dal :</span> $arr[TurnProf] <br /> <span class="tit">Anno di Arrivo in Squadra :</span> $arr[Arrivo]
</div>
<div class="info">
<span class="tit">Passaporto Biologico :</span><br /> <span class="tit">RBC =</span> $arr[RBC] <br /> <span class="tit">Hb =</span> 
	$arr[Hb] <br /><span class="tit">Hct =</span> $arr[Hct]
</div>
END;
	$str = build_rec($arr['Via'],$arr['Num'],$arr['Localita'],$arr['Prov']);
	echo<<<END
<div class="info">
<span class="tit">Recapito :</span> $str - <span class="tit">Telefono :</span> $arr[Telefono] 
</div>
END;
}

/* Funzione per stampare tutti i dati specifici di un membro dello staff */
function print_staff($arr) {
echo<<<END
<div class="info">
<span class="tit">Nazionalit&agrave :</span> $arr[Nazionalita] <br /> <span class="tit">Anno di Nascita :</span> $arr[AnnoNascita] <br /> 
<span class="tit">Ruolo :</span> $arr[Ruolo]
</div>
END;
	$str = build_rec($arr['Via'],$arr['Num'],$arr['Localita'],$arr['Prov']);
	echo<<<END
<div class="info">
<span class="tit">Recapito :</span> $str - <span class="tit">Telefono :</span> $arr[Telefono] 
</div>
END;
}

/* Funzione per stampare tutti i dati specifici di una corsa */
function print_corsa($arr) {
	$data_i = $arr['DataInizio'];
	$data_f = $arr['DataFine'];
	if($data_i == $data_f)
		echo "<div class=\"info\"><span class=\"tit\">Data :</span> $data_i</div>";
	else
		echo "<div class=\"info\"><span class=\"tit\">Data Inizio :</span> $data_i <br />
		                          <span class=\"tit\">Data Fine :</span> $data_f</div>";
   echo<<<END
<div class="info"><span class="tit">Distanza :</span> $arr[Distanza]Km</div>
END;
	$str1 = build_luogo($arr['Partenza'],$arr['loc1'],$arr['prov1'],$arr['reg1'],$arr['naz1']);
	$str2 = build_luogo($arr['Arrivo'],$arr['loc2'],$arr['prov2'],$arr['reg2'],$arr['naz2']);
	echo<<<END
<div class="info">
<span class="tit">Partenza :</span> $str1  <br /> 
<span class="tit">Arrivo :</span> $str2
</div>
END;
}

/* Funzione per stampare tutti i dati specifici di una tappa */
function print_tappa($arr) {
	echo<<<END
<div class="info"><span class="tit">Data :</span> $arr[Data]</div>
<div class="info"><span class="tit">Distanza :</span> $arr[Distanza]Km</div>
END;
	$str1 = build_luogo($arr['CAP1'],$arr['loc1'],$arr['prov1'],$arr['reg1'],$arr['naz1']);
	$str2 = build_luogo($arr['CAP2'],$arr['loc2'],$arr['prov2'],$arr['reg2'],$arr['naz2']);
	echo<<<END
<div class="info">
<span class="tit">Partenza :</span> $str1  <br /> 
<span class="tit">Arrivo :</span> $str2
</div>
END;
}

/* Funzione per costruzione stringa output recapito */
function build_rec($via,$numero,$localita,$prov) {
	$str = "via "; 	  
	if($via)
		$str .= $via;
	if($numero)
		$str .= " " . $numero;
	if($localita)
		$str .= ", " . $localita;
	if($prov)
		$str .= "(" . $prov . ")";
	return $str;
}

/* Funzione per costruzione stringa output luogo */
function build_luogo($cap,$loc,$prov,$reg,$naz) {
	$str = $cap;    
	if($loc)   
		$str .= " - " . $loc;
	if($prov)
		$str .= "(" . $prov . ")";
	if($reg)
		$str .= " - " . $reg;
	if($naz)
		$str .= ", " . $naz;
	return $str;
}

/* Funzione che stampa una select con tutti i corridori che possono essere iscritti ad una corsa*/
function print_select($nome,$result) {
	echo<<<END
<select id="$nome" name="$nome">
<option selected="selected"> </option>
END;
	while($row = mysql_fetch_row($result))
		echo "<option name=\"id\" value=\"$row[0]\">$row[1] $row[2]</option>";
	echo "</select>";
}


/*******************************/
/* FUNZIONI PER AUTENTICAZIONE */

/* Funzione che inizia la sessione e verifica che l'utente sia autenticato */
function autenticato() {
	session_start();
	if(isset($_SESSION['autenticato']))
	{
		$login=$_SESSION['autenticato'];
		return $login;
	}
	else
		return FALSE;
}

function get_pwd($login,$conn) {
	$query = "SELECT *
	          FROM Staff s
			  WHERE s.Id = \"$login\" ";
			  
	$result = mysql_query($query,$conn) or fail_query();
	$output = mysql_fetch_assoc($result);
	
	if($output)
		return $output;
	else
		return FALSE;
}


/******************************/
/* FUNZIONI VARIE DI UTILITA' */

/* Funzione che controlla la presenza di un determinato username all'interno del DB */
function check_id($id,$conn) {
	$query = "SELECT Id FROM PersoneFisiche";
	$result = mysql_query($query,$conn) or fail_query();
	while($row = mysql_fetch_row($result))
	{
		if($row[0] == $id)
			return "Errore: Username gi&agrave nel Database.";
	}
	return FALSE;
}

/* Funzione che controlla la consistenza dei dati da inserire in PersoneFisiche */
function check_dati($nome,$cognome,$nascita) {
	if(!$nome || !$cognome)
		return "Errore: Nome e Cognome sono campi obbligatori.";
	else
		if( (!preg_match('/^[a-zA-Z]*$/',$nome)) && (!preg_match('/^[a-zA-Z]*$/',$cognome)) )
			return "Errore: Nome e Cognome devono essere alfabetici.";
		else
			if(!preg_match('/^[a-zA-Z]*$/',$nome))
				return "Errore: Nome deve essere alfabetico.";
			else
				if(!preg_match('/^[a-zA-Z]*$/',$cognome))
					return "Errore: Cognome deve essere alfabetico.";
		
	if($nascita && !ctype_digit($nascita))
		return "Errore: l'anno di nascita deve essere un numero(Anno!).";
	
	return FALSE;
}

/* Funzione che controlla la consistenza dei dati da inserire in PersoneFisiche */
function check_recapito($telefono,$numero) {
	if($telefono && !ctype_digit($telefono))
		return "Errore: il numero di telefono deve essere numerico.";
		
	if($numero && !ctype_digit($numero))
		return "Errore: il numero civico deve essere un numero.";

	return FALSE;
}

/* Funzione che controlla la consistenza del formato delle date */
function check_data($data) {
	if(!preg_match('/^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$/',$data))
		return "Errore: il formato delle date &egrave YYYY-MM-DD.";
	else	
		return FALSE;
}

/* Funzione che controlla la consistenza dei dati da inserire in Corse */
function check_dati_corsa($inizio,$fine,$distanza) {
	$err1 = check_data($inizio);
	$err2 = check_data($fine);
	
	if(!$err1 && !$err2)
	{
		if($distanza && !is_numeric($distanza))
			return "Errore: distanza deve essere numerico.";
		if($distanza < 0)
			return "Errore: La distanza non pu&ograve essere un numero negativo.";
		
		return FALSE;
	}
	else
		if($err1)
			return $err1;
		else
			return $err2;
}

/* Funzione che controlla la consistenza dei dati da inserire in Tappe */
function check_dati_tappa($numero,$data,$distanza) {
	if(!ctype_digit($numero))
		return "Errore: il numero di tappa deve essere numerico.";
	if($numero <= 0)
		return "Errore: Il numero di tappa deve essere un numero positivo maggiore di zero.";
		
	$err = check_data($data);
	if(!$err)
	{
		if($distanza && !is_numeric($distanza))
			return "Errore: distanza deve essere numerico.";
		if($distanza < 0)
			return "Errore: La distanza non pu&ograve essere un numero negativo.";
		
		return FALSE;
	}
	else	
		return $err;
}

/* Funzione che dice se un luogo è gia presente del DB */
function check_luogo($cap,$conn) {
	$query = "SELECT CAP FROM Luoghi";
	$result = mysql_query($query,$conn) or fail_query();
	while($row = mysql_fetch_row($result))
	{
		if($row[0] == $cap)
			return TRUE;
	}
	return FALSE;
}

/* Funzione che controlla se si è iscritto 2 volte ad una corsa uno stesso corridore */
function check_ciclista($array,$ciclista) {
	if($ciclista)
	{
		foreach($array as $id)
		{
			if($id == $ciclista)
				return "Errore: Ciclista iscritto 2 volte.";
		}
	}
	else
		return FALSE;
}


/*************************************************/
/* FUNZIONI PER LA MODIFICA DI DATI NEL DATABASE */

/* Funzione che aggiorna i dati in PersoneFisiche e Staff */
function upd_dati_staff($id,$conn) {	
	$nome = trim($_POST['nome']);
	$cognome = trim($_POST['cognome']);
	$nascita = $_POST['nascita'];
	
	$errore = check_dati($nome,$cognome,$nascita);
	if(!$errore)
	{	
		$nazionalita = strtoupper($_POST['nazionalita']);
		$ruolo = $_POST['ruolo'];
		if( $ruolo != "DS" && $ruolo != "Allenatore" )
			return "Errore: Ruolo deve essere 'Allenatore' o 'DS'.";
		
		$query = "UPDATE PersoneFisiche
				  SET Nome=\"$nome\", Cognome=\"$cognome\", Nazionalita=\"$nazionalita\", AnnoNascita=\"$nascita\"
				  WHERE Id = \"$id\" ";
		$result = mysql_query($query,$conn) or fail_query();
	
		$query = "UPDATE Staff 
				  SET Ruolo=\"$ruolo\" 
				  WHERE Id = \"$id\" ";
		$result = mysql_query($query,$conn) or fail_query();
		return "Modifica effettuata correttamente.";
	}
	else
		return $errore;
}

/* Funzione che aggiorna i dati in PersoneFisiche e Ciclisti */
function upd_dati_ciclista($id,$conn) {
	$nome = trim($_POST['nome']);
	$cognome = trim($_POST['cognome']);
	$nascita = $_POST['nascita'];
	
	$errore = check_dati($nome,$cognome,$nascita);
	if(!$errore)
	{
		$nazionalita = strtoupper($_POST['nazionalita']);
		$prof = $_POST['prof'];
		$arrivo = $_POST['arrivo'];
		if($prof && !ctype_digit($prof))
			return "Errore: Professionista dal deve essere un numero(Anno!).";
		if($arrivo && !ctype_digit($arrivo))
			return "Errore: Arrivo in Squadra deve essere un numero(Anno!).";	
		
		$query = "UPDATE PersoneFisiche
				  SET Nome=\"$nome\", Cognome=\"$cognome\", Nazionalita=\"$nazionalita\", AnnoNascita=\"$nascita\"
			      WHERE Id = \"$id\" ";
		$result = mysql_query($query,$conn) or fail_query();
	
		$query = "UPDATE Ciclisti 
				  SET TurnProf=\"$prof\", Arrivo=\"$arrivo\" 
				  WHERE Id = \"$id\" ";
		$result = mysql_query($query,$conn) or fail_query();
		return "Modifica effettuata correttamente.";
	}
	else	
		return $errore;
}

/* Funzione che aggiorna i dati in Recapito */
function upd_recapito($id,$conn) {
	$telefono = $_POST['telefono'];
	$via = trim($_POST['via']);
	$numero = $_POST['numero'];
	$localita = trim($_POST['localita']);
	$prov = strtoupper($_POST['prov']);
	
	$errore = check_recapito($telefono,$numero);
	if(!$errore)
	{
		$query = "UPDATE Recapiti
				  SET Telefono=\"$telefono\", Via=\"$via\", Num=\"$numero\", Localita=\"$localita\", Prov=\"$prov\"
				  WHERE Id = \"$id\" ";
		$result = mysql_query($query,$conn) or fail_query();
		return "Modifica effettuata correttamente.";
	}
	else 
		return $errore;
}

/* Funzione che permette di cambiare la password */
function upd_auth($id,$conn) {
	$password = $_POST['pwd'];
	$confirm = $_POST['c_pwd'];
	if($password == $confirm)
	{
		$pass=sha1($password);
		$query = "UPDATE Staff
		          SET Password=\"$pass\"
				  WHERE id = \"$id\" ";
		$result = mysql_query($query,$conn) or fail_query();
		return "Password cambiata correttamente.";
	}
	else
		return "Password e Conferma sono diverse.";
}

/* Funzione che aggiorna i dati in Corse */
function upd_dati_corsa($id,$conn) {
	$nome = trim($_POST['nome']);
	$inizio = $_POST['inizio'];
	$fine = $_POST['fine'];
	$distanza = $_POST['distanza'];
	
	$errore = check_dati_corsa($inizio,$fine,$distanza);
	if(!$errore)
	{
		$query = "UPDATE Corse
				  SET NomeCorsa=\"$nome\", DataInizio=\"$inizio\", DataFine=\"$fine\", Distanza=\"$distanza\"  
				  WHERE IdCorsa=\"$id\" ";
		$result = mysql_query($query,$conn) or fail_query();
		return "Modifica effettuata correttamente.";
	}
	else	
		return $errore;
}

/* Funzione che aggiorna i dati in Tappe */
function upd_dati_tappa($id,$conn) {
	$numero = $_POST['numero'];
	$data = $_POST['data'];
	$distanza = $_POST['distanza'];
	
	$errore = check_dati_tappa($numero,$data,$distanza);
	if(!$errore)
	{
		$query = "UPDATE Tappe
				  SET Data=\"$data\", Distanza=\"$distanza\"  
				  WHERE IdTappa=\"$id\" ";
		$result = mysql_query($query,$conn) or fail_query();
		return "Modifica effettuata correttamente.";
	}
	else
		return $errore;
}

/* Funzione che aggiorna i dati in Luoghi */
function upd_dati_luogo($conn) {
	if(isset($_POST['cap1']))
	{
		$oldcap = $_POST['oldcap1'];
		$cap = $_POST['cap1'];
		if(!$cap)
			return "Errore: il CAP non pu&ograve essere nullo.";
		$localita = trim($_POST['loc1']);
		$nazione = strtoupper($_POST['naz1']);
		$regione = trim($_POST['reg1']);
		$provincia = strtoupper($_POST['prov1']);
	}
	else   // se viene invocata questa funzione o è settato cap1 oppure è obbligatoriamente settato cap2
	{
		$oldcap = $_POST['oldcap2'];
		$cap = $_POST['cap2'];
		if(!$cap)
			return "Errore: il CAP non pu&ograve essere nullo.";
		$localita = trim($_POST['loc2']);
		$nazione = strtoupper($_POST['naz2']);
		$regione = trim($_POST['reg2']);
		$provincia = strtoupper($_POST['prov2']);
	}
	$query = "UPDATE Luoghi
			  SET CAP=\"$cap\", Localita=\"$localita\", Nazione=\"$nazione\", Regione=\"$regione\", Prov=\"$provincia\"
			  WHERE CAP = \"$oldcap\" ";
	$result = mysql_query($query,$conn) or fail_query();
	return "Modifica effettuata correttamente.";
}

/* Funzione per aggiungere un corridore agli iscritti in una corsa */
function add_corridore($id_corsa,$conn) {
	$id_ciclista = $_POST['ciclista'];
	$query = "SELECT Id FROM CiclistiCorse WHERE IdCorsa=\"$id_corsa\" ";
	$result = mysql_query($query,$conn);
	while($row = mysql_fetch_row($result))
	{
		if($row[0] == $id_ciclista)
			return "Errore: Ciclista gi&agrave iscritto alla corsa";
	}
	
	$query = "INSERT INTO CiclistiCorse(Id,IdCorsa) VALUES ('$id_ciclista','$id_corsa')";
	$result = mysql_query($query,$conn) or fail_query();
	return "Iscrizione avvenuta con successo.";
}
?>
