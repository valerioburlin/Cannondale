<?php
require "connessione.php";
require "funzioni.php";


$login = autenticato();

/* Recupero dati */
$id = $_GET['id'];

$query = "SELECT *
          FROM PersoneFisiche p, Ciclisti c, Recapiti r, PassBio b
          WHERE p.Id = \"$id\" AND p.Id = c.Id AND p.Id = r.Id AND c.id = b.Id";

$ciclista = mysql_query($query,$conn) or fail_query();
$arr = mysql_fetch_assoc($ciclista);

print_head($arr['Nome'] . " " . $arr['Cognome'],"Team Cannondale",$login);

print_menu(" ",$login);

print_sub($arr['Nome'] . " " . $arr['Cognome']);

print_ciclista($arr);


print_footer();

?>  
