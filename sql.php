<?php
error_reporting (E_ALL & ~ E_NOTICE & ~ E_DEPRECATED);
$host = "localhost";

$user = "root";// padr�o para xampp ou wamp � root

$pass = "";// padr�o para xampp ou wamp � ""

$db = "table";// nome do banco

$conn = mysql_connect($host, $user, $pass) or die (mysql_error());



@mysql_select_db($db);



?>