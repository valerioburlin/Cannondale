<?php
require "funzioni.php";


$login = autenticato();

print_head("Home Page","Team Cannondale",$login);

print_menu("home",$login);

print_sub("Team Cannondale Pro Cycling Team");

echo "<div id='content'><img src='img/Cannondale-Pro-Cycling.jpg' alt='foto di gruppo del team' /> </div>";

print_footer();
?>
