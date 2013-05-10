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
  $updateSQL = sprintf("UPDATE TRNDETORDENPRODUCCION SET IDENCABEORDPROD=%s, CANTIDADORPROD=%s, ID_MEDIDA=%s, PRODUCTOORDPRODUC=%s, FECHAHORAUSUA=%s, USUARIO=%s WHERE IDORDENPRODUCCION=%s",
                       GetSQLValueString($_POST['IDENCABEORDPROD'], "int"),
                       GetSQLValueString($_POST['CANTIDADORPROD'], "double"),
                       GetSQLValueString($_POST['ID_MEDIDA'], "int"),
                       GetSQLValueString($_POST['PRODUCTOORDPRODUC'], "int"),
                       GetSQLValueString($_POST['FECHAHORAUSUA'], "date"),
                       GetSQLValueString($_POST['USUARIO'], "int"),
                       GetSQLValueString($_POST['IDORDENPRODUCCION'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($updateSQL, $basepangloria) or die(mysql_error());
}

$colname_condetalle = "-1";
if (isset($_GET['root'])) {
  $colname_condetalle = $_GET['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_condetalle = sprintf("SELECT * FROM TRNDETORDENPRODUCCION WHERE IDENCABEORDPROD = %s", GetSQLValueString($colname_condetalle, "int"));
$condetalle = mysql_query($query_condetalle, $basepangloria) or die(mysql_error());
$row_condetalle = mysql_fetch_assoc($condetalle);
$totalRows_condetalle = mysql_num_rows($condetalle);
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
      <td nowrap="nowrap" align="right">IDORDENPRODUCCION:</td>
      <td><?php echo $row_condetalle['IDORDENPRODUCCION']; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">IDENCABEORDPROD:</td>
      <td><input type="text" name="IDENCABEORDPROD" value="<?php echo htmlentities($row_condetalle['IDENCABEORDPROD'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      <td>CANTIDADORPROD:</td>
      <td><input type="text" name="CANTIDADORPROD" value="<?php echo htmlentities($row_condetalle['CANTIDADORPROD'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">ID_MEDIDA:</td>
      <td><input type="text" name="ID_MEDIDA" value="<?php echo htmlentities($row_condetalle['ID_MEDIDA'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      <td>PRODUCTOORDPRODUC</td>
      <td><input type="text" name="PRODUCTOORDPRODUC" value="<?php echo htmlentities($row_condetalle['PRODUCTOORDPRODUC'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">FECHAHORAUSUA</td>
      <td><input type="text" name="FECHAHORAUSUA" value="<?php echo htmlentities($row_condetalle['FECHAHORAUSUA'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      <td>USUARIO</td>
      <td><input type="text" name="USUARIO" value="<?php echo htmlentities($row_condetalle['USUARIO'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Actualizar registro" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="IDORDENPRODUCCION" value="<?php echo $row_condetalle['IDORDENPRODUCCION']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($condetalle);
?>
