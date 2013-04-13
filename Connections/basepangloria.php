<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_basepangloria = "sql.byethost16.org";
$database_basepangloria = "liosarpc_pangloria";
$username_basepangloria = "liosarpc";
$password_basepangloria = "proview2010$";
$basepangloria = mysql_pconnect($hostname_basepangloria, $username_basepangloria, $password_basepangloria) or trigger_error(mysql_error(),E_USER_ERROR); 
?>