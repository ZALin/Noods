<?php
$mysql_hostname = "sql5.freesqldatabase.com";
$mysql_user = "sql544303";
$mysql_password = "eT2*wK6*";
$mysql_database = "sql544303";
$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) 
or die("Opps some thing went wrong");
mysql_select_db($mysql_database, $bd) or die("Opps some thing went wrong");
?>