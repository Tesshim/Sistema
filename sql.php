<?php
error_reporting (E_ALL & ~ E_NOTICE & ~ E_DEPRECATED);
$host = "localhost";

$user = "root";// padrão para xampp ou wamp é root

$pass = "";// padrão para xampp ou wamp é ""

$db = "table";// nome do banco

$conn = mysql_connect($host, $user, $pass) or die (mysql_error());



@mysql_select_db($db);



?>