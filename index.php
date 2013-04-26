<?php require_once('Connections/basepangloria.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['user'])) {
  $loginUsername=$_POST['user'];
  $password=$_POST['pass'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "proceso/base.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_basepangloria, $basepangloria);
  
  $LoginRS__query=sprintf("SELECT NOMBREUSUARIO, CONTRASENA FROM CATUSUARIO WHERE NOMBREUSUARIO=%s AND CONTRASENA=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $basepangloria) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Control Inventarios Pan Gloria</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top"><table width="1024px" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><div class="tope" id="top"></div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><table width="1024" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="205"><div class="usuario" id="user">
          <table width="100%" border="0">
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td align="center" valign="bottom"><p>&nbsp;</p>
                <p>&nbsp;</p></td>
            </tr>
          </table>
        </div></td>
        <td width="205"><div class="usuario" id="user2">
          <table width="100%" border="0">
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td align="center" valign="bottom"><p>&nbsp;</p>
                <p>&nbsp;</p></td>
            </tr>
          </table>
        </div></td>
        <td width="205"><div class="usuario" id="user3">
          <table width="100%" border="0">
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table>
        </div></td>
        <td width="205"><div class="usuario" id="user4">
          <table width="100%" border="0">
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table>
        </div></td>
        <td width="202"><div class="usuario" id="user5">
          <table width="100%" border="0">
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><table width="1024px" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="184"><div class="menuiz" id="leftmenu">
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
        </div></td>
        <td width="830" align="center"><div class="cont" id="contenido">
          <p>&nbsp;</p>
          <p><img src="imagenes/logotipo.png" width="242" height="114" /></p>
          <form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
            <p>Inicio de secion:
</p>
            <p>Usuario:
              <label for="user"></label>
              <input type="text" name="user" id="user" />
            </p>
            <p>Clave:
              <input type="text" name="pass" id="pass" />
            </p>
            <p>
              <label for="pass"></label>
              <input type="submit" name="Inicio" id="Inicio" value="ingresar" />
            </p>
          </form>
          <p>&nbsp;</p>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><table width="1024" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="184" align="center"><div class="menuiz">CCEMAG </div></td>
        <td align="center"><div class="footer" id="pie">UNICAES</div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>