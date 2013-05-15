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
  $updateSQL = sprintf("UPDATE TRNDETACONTROL_PRODUCTO_HORNO SET IDPRODUCTO=%s, IDENCABEZADO=%s, ID_MEDIDA=%s, CANTIDAD_INGRESO=%s, CANTIDADEGRESO=%s WHERE ID_CONTROLPRODHORNO=%s",
                       GetSQLValueString($_POST['IDPRODUCTO'], "int"),
                       GetSQLValueString($_POST['IDENCABEZADO'], "int"),
                       GetSQLValueString($_POST['ID_MEDIDA'], "int"),
                       GetSQLValueString($_POST['CANTIDAD_INGRESO'], "double"),
                       GetSQLValueString($_POST['CANTIDADEGRESO'], "double"),
                       GetSQLValueString($_POST['ID_CONTROLPRODHORNO'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($updateSQL, $basepangloria) or die(mysql_error());
}

$colname_consultafiltrada = "-1";
if (isset($_GET['root'])) {
  $colname_consultafiltrada = $_GET['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_consultafiltrada = sprintf("SELECT * FROM TRNDETACONTROL_PRODUCTO_HORNO WHERE ID_CONTROLPRODHORNO = %s ORDER BY ID_CONTROLPRODHORNO DESC", GetSQLValueString($colname_consultafiltrada, "int"));
$consultafiltrada = mysql_query($query_consultafiltrada, $basepangloria) or die(mysql_error());
$row_consultafiltrada = mysql_fetch_assoc($consultafiltrada);
$totalRows_consultafiltrada = mysql_num_rows($consultafiltrada);
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
}
</style>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">ID_CONTROLPRODHORNO:</td>
      <td><?php echo $row_consultafiltrada['ID_CONTROLPRODHORNO']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">IDPRODUCTO:</td>
      <td><input type="text" name="IDPRODUCTO" value="<?php echo htmlentities($row_consultafiltrada['IDPRODUCTO'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">IDENCABEZADO:</td>
      <td><input type="text" name="IDENCABEZADO" value="<?php echo htmlentities($row_consultafiltrada['IDENCABEZADO'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">ID_MEDIDA:</td>
      <td><input type="text" name="ID_MEDIDA" value="<?php echo htmlentities($row_consultafiltrada['ID_MEDIDA'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">CANTIDAD_INGRESO:</td>
      <td><input type="text" name="CANTIDAD_INGRESO" value="<?php echo htmlentities($row_consultafiltrada['CANTIDAD_INGRESO'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">CANTIDADEGRESO:</td>
      <td><input type="text" name="CANTIDADEGRESO" value="<?php echo htmlentities($row_consultafiltrada['CANTIDADEGRESO'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Actualizar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="ID_CONTROLPRODHORNO" value="<?php echo $row_consultafiltrada['ID_CONTROLPRODHORNO']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($consultafiltrada);
?>
