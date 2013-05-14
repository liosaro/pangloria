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
  $updateSQL = sprintf("UPDATE TRNJUSTIFICACIONFALTAPRODUCTO SET IDCONTROLPRODUCCION=%s, CANTIDA_FALTANTE=%s, IDPRODUCTOFALTA=%s, ID_MEDIDA=%s, FECHAINGRESOJUSFAPROD=%s, JUSTIFICACIONFALTAPROD=%s WHERE ID_JUSTIFICACION=%s",
                       GetSQLValueString($_POST['IDCONTROLPRODUCCION'], "int"),
                       GetSQLValueString($_POST['CANTIDA_FALTANTE'], "double"),
                       GetSQLValueString($_POST['IDPRODUCTOFALTA'], "int"),
                       GetSQLValueString($_POST['ID_MEDIDA'], "int"),
                       GetSQLValueString($_POST['FECHAINGRESOJUSFAPROD'], "date"),
                       GetSQLValueString($_POST['JUSTIFICACIONFALTAPROD'], "text"),
                       GetSQLValueString($_POST['ID_JUSTIFICACION'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($updateSQL, $basepangloria) or die(mysql_error());

  $updateGoTo = "modificacion.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_producto = "-1";
if (isset($_GET['root'])) {
  $colname_producto = $_GET['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_producto = sprintf("SELECT * FROM TRNJUSTIFICACIONFALTAPRODUCTO WHERE ID_JUSTIFICACION = %s", GetSQLValueString($colname_producto, "int"));
$producto = mysql_query($query_producto, $basepangloria) or die(mysql_error());
$row_producto = mysql_fetch_assoc($producto);
$totalRows_producto = mysql_num_rows($producto);$colname_producto = "-1";
if (isset($_GET['root'])) {
  $colname_producto = $_GET['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_producto = sprintf("SELECT * FROM TRNJUSTIFICACIONFALTAPRODUCTO WHERE ID_JUSTIFICACION = %s", GetSQLValueString($colname_producto, "int"));
$producto = mysql_query($query_producto, $basepangloria) or die(mysql_error());
$row_producto = mysql_fetch_assoc($producto);
$totalRows_producto = mysql_num_rows($producto);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<table width="100%" border="1">
  <tr>
    <td align="center" bgcolor="#999999"><h1>Modificacion de Justificacion de Falta de Producto</h1></td>
  </tr>
</table>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">ID_JUSTIFICACION:</td>
      <td><?php echo $row_producto['ID_JUSTIFICACION']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">IDCONTROLPRODUCCION:</td>
      <td><input type="text" name="IDCONTROLPRODUCCION" value="<?php echo htmlentities($row_producto['IDCONTROLPRODUCCION'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">CANTIDA_FALTANTE:</td>
      <td><input type="text" name="CANTIDA_FALTANTE" value="<?php echo htmlentities($row_producto['CANTIDA_FALTANTE'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">IDPRODUCTOFALTA:</td>
      <td><input type="text" name="IDPRODUCTOFALTA" value="<?php echo htmlentities($row_producto['IDPRODUCTOFALTA'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">ID_MEDIDA:</td>
      <td><input type="text" name="ID_MEDIDA" value="<?php echo htmlentities($row_producto['ID_MEDIDA'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">FECHAINGRESOJUSFAPROD:</td>
      <td><input type="text" name="FECHAINGRESOJUSFAPROD" value="<?php echo htmlentities($row_producto['FECHAINGRESOJUSFAPROD'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">JUSTIFICACIONFALTAPROD:</td>
      <td><input type="text" name="JUSTIFICACIONFALTAPROD" value="<?php echo htmlentities($row_producto['JUSTIFICACIONFALTAPROD'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Actualizar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="ID_JUSTIFICACION" value="<?php echo $row_producto['ID_JUSTIFICACION']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($producto);
?>
