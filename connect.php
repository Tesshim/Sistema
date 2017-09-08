<?php

if(!defined('INCLUDE_CHECK')) die('Você não pode executar esta página diretamente!');


error_reporting (E_ALL & ~ E_NOTICE & ~ E_DEPRECATED);
$db_host		= 'localhost';
$db_user		= 'root';
$db_pass		= '';
$db_database	= 'table'; 



$link = mysql_connect($db_host,$db_user,$db_pass) or die('Não foi possível se conectar ao banco de dados!');

mysql_select_db($db_database,$link);
mysql_query("SET names UTF8");

?>