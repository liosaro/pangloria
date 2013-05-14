<head>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
}
</style>
</head>

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
  $updateSQL = sprintf("UPDATE CATROL SET DESCRIPCION=%s WHERE IDROL=%s",
                       GetSQLValueString($_POST['DESCRIPCION'], "text"),
                       GetSQLValueString($_POST['IDROL'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($updateSQL, $basepangloria) or die(mysql_error());
}

$colname_modiRol = "-1";
if (isset($_GET['root'])) {
  $colname_modiRol = $_GET['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_modiRol = sprintf("SELECT * FROM CATROL WHERE IDROL = %s", GetSQLValueString($colname_modiRol, "int"));
$modiRol = mysql_query($query_modiRol, $basepangloria) or die(mysql_error());
$row_modiRol = mysql_fetch_assoc($modiRol);
$totalRows_modiRol = mysql_num_rows($modiRol);$colname_modiRol = "-1";
if (isset($_GET['root'])) {
  $colname_modiRol = $_GET['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_modiRol = sprintf("SELECT * FROM CATROL WHERE IDROL = %s", GetSQLValueString($colname_modiRol, "int"));
$modiRol = mysql_query($query_modiRol, $basepangloria) or die(mysql_error());
$row_modiRol = mysql_fetch_assoc($modiRol);
$totalRows_modiRol = mysql_num_rows($modiRol);

mysql_free_result($modiRol);
?>
<form method="post" name="modiRol" id="modiRol"action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">IDROL:</td>
      <td><?php echo $row_modiRol['IDROL']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">DESCRIPCION:</td>
      <td><input type="text" name="DESCRIPCION" value="<?php echo htmlentities($row_modiRol['DESCRIPCION'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Actualizar registro"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="IDROL" value="<?php echo $row_modiRol['IDROL']; ?>">
</form>
<p>&nbsp;</p>
