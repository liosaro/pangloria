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

$colname_moditipoPago = "-1";
if (isset($_GET['root'])) {
  $colname_moditipoPago = $_GET['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_moditipoPago = sprintf("SELECT * FROM CATCONDICIONPAGO WHERE IDCONDICION = %s ORDER BY IDCONDICION ASC", GetSQLValueString($colname_moditipoPago, "int"));
$moditipoPago = mysql_query($query_moditipoPago, $basepangloria) or die(mysql_error());
$row_moditipoPago = mysql_fetch_assoc($moditipoPago);
$totalRows_moditipoPago = mysql_num_rows($moditipoPago);

mysql_select_db($database_basepangloria, $basepangloria);
$query_combotipo = "SELECT * FROM CATCONDICIONPAGO";
$combotipo = mysql_query($query_combotipo, $basepangloria) or die(mysql_error());
$row_combotipo = mysql_fetch_assoc($combotipo);
$totalRows_combotipo = mysql_num_rows($combotipo);
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
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#999999"><h1>Modificar Tipo de Pago</h1></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id Condicion:</td>
      <td><?php echo $row_moditipoPago['IDCONDICION']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tipo:</td>
      <td><select name="TIPO">
        <?php
do {  
?>
        <option value="<?php echo $row_combotipo['TIPO']?>"<?php if (!(strcmp($row_combotipo['TIPO'], htmlentities($row_moditipoPago['TIPO'], ENT_COMPAT, 'utf-8')))) {echo "selected=\"selected\"";} ?>><?php echo $row_combotipo['TIPO']?></option>
        <?php
} while ($row_combotipo = mysql_fetch_assoc($combotipo));
  $rows = mysql_num_rows($combotipo);
  if($rows > 0) {
      mysql_data_seek($combotipo, 0);
	  $row_combotipo = mysql_fetch_assoc($combotipo);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Actualizar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="IDCONDICION" value="<?php echo $row_moditipoPago['IDCONDICION']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($moditipoPago);

mysql_free_result($combotipo);
?>
