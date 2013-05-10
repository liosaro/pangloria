<?php require_once('../../../Connections/basepangloria.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO CATUSUARIO (IDUSUARIO, NOMBREUSUARIO, CONTRASENA, PRIMERINICIO, ULTIMOINICIO) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IDUSUARIO'], "int"),
                       GetSQLValueString($_POST['NOMBREUSUARIO'], "text"),
                       GetSQLValueString($_POST['CONTRASENA'], "text"),
                       GetSQLValueString($_POST['PRIMERINICIO'], "date"),
                       GetSQLValueString($_POST['ULTIMOINICIO'], "date"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_usuario = "SELECT IDUSUARIO FROM CATUSUARIO";
$usuario = mysql_query($query_usuario, $basepangloria) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

mysql_select_db($database_basepangloria, $basepangloria);
$query_nomUsu = "SELECT IDUSUARIO, NOMBREUSUARIO FROM CATUSUARIO";
$nomUsu = mysql_query($query_nomUsu, $basepangloria) or die(mysql_error());
$row_nomUsu = mysql_fetch_assoc($nomUsu);
$totalRows_nomUsu = mysql_num_rows($nomUsu);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<table width="820" border="0">
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td>&nbsp;
          <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
            <table width="100%" border="0">
              <tr>
                <td colspan="4" align="center" bgcolor="#999999"><h1>USUARIO</h1></td>
                </tr>
              <tr>
                <td>IDUSUARIO</td>
                <td><select name="IDUSUARIO">
                  <?php
do {  
?>
                  <option value="<?php echo $row_usuario['IDUSUARIO']?>"><?php echo $row_usuario['IDUSUARIO']?></option>
                  <?php
} while ($row_usuario = mysql_fetch_assoc($usuario));
  $rows = mysql_num_rows($usuario);
  if($rows > 0) {
      mysql_data_seek($usuario, 0);
	  $row_usuario = mysql_fetch_assoc($usuario);
  }
?>
                </select></td>
                <td>NOMBREUSUARIO:</td>
                <td><label for="text"></label>
                  <input type="text" name="text" id="text" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="4" align="center">CONTRASENA:
                  <input type="password" name="CONTRASENA" value="" size="32" />
:</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>PRIMERINICIO</td>
                <td><input type="text" name="PRIMERINICIO" size="32" /></td>
                <td>ULTIMOINICIO</td>
                <td><input type="text" name="ULTIMOINICIO" value="" size="32" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="submit" value="Enviar" /></td>
                <td>&nbsp;</td>
              </tr>
            </table>
            <p>&nbsp;</p>
            <table align="center">
              <tr valign="baseline">
                <td nowrap="nowrap" align="right">:</td>
                <td>&nbsp;</td>
              </tr>
              <tr valign="baseline">
                <td nowrap="nowrap" align="right">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr valign="baseline">
                <td nowrap="nowrap" align="right">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr valign="baseline">
                <td nowrap="nowrap" align="right">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr valign="baseline">
                <td nowrap="nowrap" align="right">:</td>
                <td>&nbsp;</td>
              </tr>
              <tr valign="baseline">
                <td nowrap="nowrap" align="right">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
            <input type="hidden" name="MM_insert" value="form1" />
          </form>
          <p>&nbsp;</p></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($usuario);

mysql_free_result($nomUsu);
?>
