<?php require_once('../../Connections/basepangloria.php'); ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE CATPERMISOS SET DESCRIPCION=%s WHERE IDPERMISO=%s",
                       GetSQLValueString($_POST['DESCRIPCION'], "text"),
                       GetSQLValueString($_POST['IDPERMISO'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($updateSQL, $basepangloria) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE CATATRIBUCIONES SET IDUSUARIO=%s, IDROL=%s, IDPERMISO=%s, C=%s, R=%s, U=%s, D=%s WHERE ID_ATRIB=%s",
                       GetSQLValueString($_POST['IDUSUARIO'], "int"),
                       GetSQLValueString($_POST['IDROL'], "int"),
                       GetSQLValueString($_POST['IDPERMISO'], "int"),
                       GetSQLValueString($_POST['C'], "int"),
                       GetSQLValueString($_POST['R'], "int"),
                       GetSQLValueString($_POST['U'], "int"),
                       GetSQLValueString($_POST['D'], "int"),
                       GetSQLValueString($_POST['ID_ATRIB'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($updateSQL, $basepangloria) or die(mysql_error());
}

$colname_modiatribu = "-1";
if (isset($_GET['root'])) {
  $colname_modiatribu = $_GET['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_modiatribu = sprintf("SELECT * FROM CATATRIBUCIONES WHERE IDPERMISO = %s", GetSQLValueString($colname_modiatribu, "int"));
$modiatribu = mysql_query($query_modiatribu, $basepangloria) or die(mysql_error());
$row_modiatribu = mysql_fetch_assoc($modiatribu);
$totalRows_modiatribu = mysql_num_rows($modiatribu);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
</form>
<form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">ID_ATRIB:</td>
      <td><?php echo $row_modiatribu['ID_ATRIB']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">IDUSUARIO:</td>
      <td><input type="text" name="IDUSUARIO" value="<?php echo htmlentities($row_modiatribu['IDUSUARIO'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">IDROL:</td>
      <td><input type="text" name="IDROL" value="<?php echo htmlentities($row_modiatribu['IDROL'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">IDPERMISO:</td>
      <td><input type="text" name="IDPERMISO" value="<?php echo htmlentities($row_modiatribu['IDPERMISO'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">C:</td>
      <td><input type="text" name="C" value="<?php echo htmlentities($row_modiatribu['C'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">R:</td>
      <td><input type="text" name="R" value="<?php echo htmlentities($row_modiatribu['R'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">U:</td>
      <td><input type="text" name="U" value="<?php echo htmlentities($row_modiatribu['U'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">D:</td>
      <td><input type="text" name="D" value="<?php echo htmlentities($row_modiatribu['D'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Actualizar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form2" />
  <input type="hidden" name="ID_ATRIB" value="<?php echo $row_modiatribu['ID_ATRIB']; ?>" />
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($modiatribu);
?>
