<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_cartConn = "localhost";
$database_cartConn = "cart";
$username_cartConn = "admin";
$password_cartConn = "123456";
$cartConn = mysql_pconnect($hostname_cartConn, $username_cartConn, $password_cartConn) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_query("SET NAMES utf8");
?>