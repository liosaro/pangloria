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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE CATPROVEEDOR SET IDPAIS=%s, NOMBREPROVEEDOR=%s, DIRECCIONPROVEEDOR=%s, TELEFONOPROVEEDOR=%s, CORREOPROVEEDOR=%s, FECHAINGRESOPROVE=%s, GIRO=%s, NUMEROREGISTRO=%s, WEB=%s, DEPTOPAISPROVEEDOR=%s WHERE IDPROVEEDOR=%s",
                       GetSQLValueString($_POST['IDPAIS'], "int"),
                       GetSQLValueString($_POST['NOMBREPROVEEDOR'], "text"),
                       GetSQLValueString($_POST['DIRECCIONPROVEEDOR'], "text"),
                       GetSQLValueString($_POST['TELEFONOPROVEEDOR'], "text"),
                       GetSQLValueString($_POST['CORREOPROVEEDOR'], "text"),
                       GetSQLValueString($_POST['FECHAINGRESOPROVE'], "date"),
                       GetSQLValueString($_POST['GIRO'], "text"),
                       GetSQLValueString($_POST['NUMEROREGISTRO'], "text"),
                       GetSQLValueString($_POST['WEB'], "text"),
                       GetSQLValueString($_POST['DEPTOPAISPROVEEDOR'], "int"),
                       GetSQLValueString($_POST['IDPROVEEDOR'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($updateSQL, $basepangloria) or die(mysql_error());

  $updateGoTo = "consulta_proveedor.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_proveedores = "-1";
if (isset($_GET['IDPROVEEDOR'])) {
  $colname_proveedores = $_GET['IDPROVEEDOR'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_proveedores = sprintf("SELECT * FROM CATPROVEEDOR WHERE IDPROVEEDOR = %s", GetSQLValueString($colname_proveedores, "int"));
$proveedores = mysql_query($query_proveedores, $basepangloria) or die(mysql_error());
$row_proveedores = mysql_fetch_assoc($proveedores);
$totalRows_proveedores = mysql_num_rows($proveedores);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">IDPROVEEDOR:</td>
      <td><?php echo $row_proveedores['IDPROVEEDOR']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">IDPAIS:</td>
      <td><input type="text" name="IDPAIS" value="<?php echo htmlentities($row_proveedores['IDPAIS'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">NOMBREPROVEEDOR:</td>
      <td><input type="text" name="NOMBREPROVEEDOR" value="<?php echo htmlentities($row_proveedores['NOMBREPROVEEDOR'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">DIRECCIONPROVEEDOR:</td>
      <td><input type="text" name="DIRECCIONPROVEEDOR" value="<?php echo htmlentities($row_proveedores['DIRECCIONPROVEEDOR'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">TELEFONOPROVEEDOR:</td>
      <td><input type="text" name="TELEFONOPROVEEDOR" value="<?php echo htmlentities($row_proveedores['TELEFONOPROVEEDOR'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">CORREOPROVEEDOR:</td>
      <td><input type="text" name="CORREOPROVEEDOR" value="<?php echo htmlentities($row_proveedores['CORREOPROVEEDOR'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">FECHAINGRESOPROVE:</td>
      <td><input type="text" name="FECHAINGRESOPROVE" value="<?php echo htmlentities($row_proveedores['FECHAINGRESOPROVE'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">GIRO:</td>
      <td><input type="text" name="GIRO" value="<?php echo htmlentities($row_proveedores['GIRO'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">NUMEROREGISTRO:</td>
      <td><input type="text" name="NUMEROREGISTRO" value="<?php echo htmlentities($row_proveedores['NUMEROREGISTRO'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">WEB:</td>
      <td><input type="text" name="WEB" value="<?php echo htmlentities($row_proveedores['WEB'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">DEPTOPAISPROVEEDOR:</td>
      <td><input type="text" name="DEPTOPAISPROVEEDOR" value="<?php echo htmlentities($row_proveedores['DEPTOPAISPROVEEDOR'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Actualizar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="IDPROVEEDOR" value="<?php echo $row_proveedores['IDPROVEEDOR']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($proveedores);
?>
