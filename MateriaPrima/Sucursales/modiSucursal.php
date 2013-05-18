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
  $updateSQL = sprintf("UPDATE CATSUCURSAL SET NOMBRESUCURSAL=%s, DIRECCIONSUCURSAL=%s, TELEFONOSUCURSAL=%s WHERE IDSUCURSAL=%s",
                       GetSQLValueString($_POST['NOMBRESUCURSAL'], "text"),
                       GetSQLValueString($_POST['DIRECCIONSUCURSAL'], "text"),
                       GetSQLValueString($_POST['TELEFONOSUCURSAL'], "text"),
                       GetSQLValueString($_POST['IDSUCURSAL'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($updateSQL, $basepangloria) or die(mysql_error());
}

$colname_modiSucur = "-1";
if (isset($_GET['root'])) {
  $colname_modiSucur = $_GET['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_modiSucur = sprintf("SELECT * FROM CATSUCURSAL WHERE IDSUCURSAL = %s ORDER BY IDSUCURSAL ASC", GetSQLValueString($colname_modiSucur, "int"));
$modiSucur = mysql_query($query_modiSucur, $basepangloria) or die(mysql_error());
$row_modiSucur = mysql_fetch_assoc($modiSucur);
$totalRows_modiSucur = mysql_num_rows($modiSucur);$colname_modiSucur = "-1";
if (isset($_GET['root'])) {
  $colname_modiSucur = $_GET['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_modiSucur = sprintf("SELECT * FROM CATSUCURSAL WHERE IDSUCURSAL = %s ORDER BY IDSUCURSAL ASC", GetSQLValueString($colname_modiSucur, "int"));
$modiSucur = mysql_query($query_modiSucur, $basepangloria) or die(mysql_error());
$row_modiSucur = mysql_fetch_assoc($modiSucur);
$totalRows_modiSucur = mysql_num_rows($modiSucur);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
}
</style>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id Sucursal:</td>
      <td><?php echo $row_modiSucur['IDSUCURSAL']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nombre Sucursal:</td>
      <td><input type="text" name="NOMBRESUCURSAL" value="<?php echo htmlentities($row_modiSucur['NOMBRESUCURSAL'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Direccion Sucursal:</td>
      <td><input type="text" name="DIRECCIONSUCURSAL" value="<?php echo htmlentities($row_modiSucur['DIRECCIONSUCURSAL'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Telefono Sucursal:</td>
      <td><input type="text" name="TELEFONOSUCURSAL" value="<?php echo htmlentities($row_modiSucur['TELEFONOSUCURSAL'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Actualizar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="IDSUCURSAL" value="<?php echo $row_modiSucur['IDSUCURSAL']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($modiSucur);
?>
