<?php

session_start();

$sname = session_name();

session_destroy();

if(isset($_COOKIE['$name']))
	setcookie($name,'',time()-3600,'/');

header("Location: home.php");
	
?>
