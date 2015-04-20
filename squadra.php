<?php
require "connessione.php";
require "funzioni.php";


$login = autenticato();

print_head("La Squadra","Team Cannondale",$login);

print_menu("squadra",$login);

print_sub("I Nostri Ciclisti");

$query = "SELECT p.Id,p.Nome,p.Cognome,p.Nazionalita,p.AnnoNascita,c.TurnProf,c.Arrivo
          FROM PersoneFisiche p NATURAL JOIN Ciclisti c 
          ORDER BY p.Cognome";

$ciclisti = mysql_query($query,$conn) or fail_query();
$arr = array("Nome","Cognome","Nazionalit&agrave","Anno Nascita","Passato Professionista","Arrivo in Squadra");
table_start($arr);

while( $row = mysql_fetch_row($ciclisti))
    table_row($row,$login,"infociclista.php","mod_ciclista.php","elimina_ciclista.php");

table_end();


print_sub("Il Nostro Staff</h2>");

$query = "SELECT p.Id,p.Nome,p.Cognome,p.Nazionalita,p.AnnoNascita,s.Ruolo
          FROM PersoneFisiche p NATURAL JOIN Staff s 
          ORDER BY p.Cognome";

$staff = mysql_query($query,$conn) or fail_query();
$arr = array("Nome","Cognome","Nazionalit&agrave","Anno Nascita","Ruolo");
table_start($arr);

while ( $row = mysql_fetch_row($staff))
    table_row($row,$login,"infostaff.php","mod_staff.php","elimina_staff.php");

table_end();

if($login)
	DS_button("add_ciclista.php","Aggiungi Ciclista");

if($login)
	DS_button("add_staff.php","Aggiungi Staff");


print_footer();
?>
