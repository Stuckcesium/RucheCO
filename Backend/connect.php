<?php

$user="follow";
$host="localhost";
$password="xxxxxxxx";
$database="follow_copie";


// Connexion et s�lection de la base
$link = mysql_connect($host,$user,$password)
or die("Impossible de se connecter");

mysql_select_db($database);

?>