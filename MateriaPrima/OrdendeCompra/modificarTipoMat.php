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
  $updateSQL = sprintf("UPDATE CatTipoMatPri SET DESCRIPCIONPRODUCTO=%s WHERE IDTIPO=%s",
                       GetSQLValueString($_POST['DESCRIPCIONPRODUCTO'], "text"),
                       GetSQLValueString($_POST['IDTIPO'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($updateSQL, $basepangloria) or die(mysql_error());
}

$colname_modiTipo = "-1";
if (isset($_GET['root'])) {
  $colname_modiTipo = $_GET['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_modiTipo = sprintf("SELECT * FROM CatTipoMatPri WHERE IDTIPO = %s ORDER BY IDTIPO ASC", GetSQLValueString($colname_modiTipo, "int"));
$modiTipo = mysql_query($query_modiTipo, $basepangloria) or die(mysql_error());
$row_modiTipo = mysql_fetch_assoc($modiTipo);
$totalRows_modiTipo = mysql_num_rows($modiTipo);
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
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#999999"><h1>Modificar Tipo de Materia Prima</h1></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id Tipo:</td>
      <td><?php echo $row_modiTipo['IDTIPO']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Descripcion del Producto:</td>
      <td><input type="text" name="DESCRIPCIONPRODUCTO" value="<?php echo htmlentities($row_modiTipo['DESCRIPCIONPRODUCTO'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Actualizar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="IDTIPO" value="<?php echo $row_modiTipo['IDTIPO']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($modiTipo);
?>
