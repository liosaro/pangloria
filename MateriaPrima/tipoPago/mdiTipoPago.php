
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap bgcolor="#999999"><h1>Modificar Tipo de Pago</h1></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Id Condicion:</td>
      <td><?php echo $row_moditipo['IDCONDICION']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Tipo:</td>
      <td><input type="text" name="TIPO" value="<?php echo htmlentities($row_moditipo['TIPO'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Actualizar registro"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="IDCONDICION" value="<?php echo $row_moditipo['IDCONDICION']; ?>">
</form>
<p>&nbsp;</p>
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
  $updateSQL = sprintf("UPDATE CATCONDICIONPAGO SET TIPO=%s WHERE IDCONDICION=%s",
                       GetSQLValueString($_POST['TIPO'], "text"),
                       GetSQLValueString($_POST['IDCONDICION'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($updateSQL, $basepangloria) or die(mysql_error());
}

$colname_moditipo = "-1";
if (isset($_GET['root'])) {
  $colname_moditipo = $_GET['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_moditipo = sprintf("SELECT * FROM CATCONDICIONPAGO WHERE IDCONDICION = %s ORDER BY IDCONDICION ASC", GetSQLValueString($colname_moditipo, "int"));
$moditipo = mysql_query($query_moditipo, $basepangloria) or die(mysql_error());
$row_moditipo = mysql_fetch_assoc($moditipo);
$totalRows_moditipo = mysql_num_rows($moditipo);

mysql_free_result($moditipo);
?>
