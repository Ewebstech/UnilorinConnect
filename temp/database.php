<?php
$host		= "localhost";
$username	= "root";
$password	= "";
$db_name	= "connect";
$conn		= mysql_pconnect($host,$username,$password);
if(!$conn) header("location:./install");
mysql_select_db($db_name);
?>