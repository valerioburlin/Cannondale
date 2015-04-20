<?php
require "connessione.php";
require "funzioni.php";


$login = autenticato();

/* Recupero dati */
$id = $_GET['id'];

$query = "SELECT *
          FROM PersoneFisiche p, Staff s, Recapiti r
          WHERE p.Id = \"$id\" AND p.Id = s.Id AND p.Id = r.Id";

$staff = mysql_query($query,$conn) or fail_query();
$arr = mysql_fetch_assoc($staff);

print_head($arr['Nome'] . " " . $arr['Cognome'],"Team Cannondale",$login);

print_menu(" ",$login);

print_sub($arr['Nome'] . " " . $arr['Cognome']);

print_staff($arr);


print_footer();

?>  