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
  $updateSQL = sprintf("UPDATE TRNDEVOLUCIONCOMPRA SET IDEMPLEADO=%s, ID_DETENCCOM=%s, DOCADEVOLVER=%s, FECHADEVOLUCION=%s, IMPORTE=%s, GASTOGENERADO=%s, OBSERVACION=%s WHERE IDDEVOLUCION=%s",
                       GetSQLValueString($_POST['IDEMPLEADO'], "int"),
                       GetSQLValueString($_POST['ID_DETENCCOM'], "int"),
                       GetSQLValueString($_POST['DOCADEVOLVER'], "text"),
                       GetSQLValueString($_POST['FECHADEVOLUCION'], "date"),
                       GetSQLValueString($_POST['IMPORTE'], "double"),
                       GetSQLValueString($_POST['GASTOGENERADO'], "double"),
                       GetSQLValueString($_POST['OBSERVACION'], "text"),
                       GetSQLValueString($_POST['IDDEVOLUCION'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($updateSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_modifi = "SELECT * FROM TRNDEVOLUCIONCOMPRA ORDER BY IDDEVOLUCION DESC";
$modifi = mysql_query($query_modifi, $basepangloria) or die(mysql_error());
$row_modifi = mysql_fetch_assoc($modifi);
$totalRows_modifi = mysql_num_rows($modifi);
$query_modifi = "SELECT * FROM TRNDEVOLUCIONCOMPRA ORDER BY IDDEVOLUCION DESC";
$modifi = mysql_query($query_modifi, $basepangloria) or die(mysql_error());
$row_modifi = mysql_fetch_assoc($modifi);
$totalRows_modifi = mysql_num_rows($modifi);

mysql_select_db($database_basepangloria, $basepangloria);
$query_empleado = "SELECT IDEMPLEADO, NOMBREEMPLEADO FROM CATEMPLEADO";
$empleado = mysql_query($query_empleado, $basepangloria) or die(mysql_error());
$row_empleado = mysql_fetch_assoc($empleado);
$totalRows_empleado = mysql_num_rows($empleado);
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
      <td nowrap="nowrap" align="right">IDDEVOLUCION:</td>
      <td><?php echo $row_modifi['IDDEVOLUCION']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">IDEMPLEADO:</td>
      <td><input type="text" name="IDEMPLEADO" value="<?php echo htmlentities($row_modifi['IDEMPLEADO'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">ID_DETENCCOM:</td>
      <td><input type="text" name="ID_DETENCCOM" value="<?php echo htmlentities($row_modifi['ID_DETENCCOM'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">DOCADEVOLVER:</td>
      <td><input type="text" name="DOCADEVOLVER" value="<?php echo htmlentities($row_modifi['DOCADEVOLVER'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">FECHADEVOLUCION:</td>
      <td><input type="text" name="FECHADEVOLUCION" value="<?php echo htmlentities($row_modifi['FECHADEVOLUCION'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">IMPORTE:</td>
      <td><input type="text" name="IMPORTE" value="<?php echo htmlentities($row_modifi['IMPORTE'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">GASTOGENERADO:</td>
      <td><input type="text" name="GASTOGENERADO" value="<?php echo htmlentities($row_modifi['GASTOGENERADO'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">OBSERVACION:</td>
      <td><input type="text" name="OBSERVACION" value="<?php echo htmlentities($row_modifi['OBSERVACION'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Actualizar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="IDDEVOLUCION" value="<?php echo $row_modifi['IDDEVOLUCION']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($modifi);

mysql_free_result($empleado);
?>
