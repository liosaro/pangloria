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
  $updateSQL = sprintf("UPDATE CATDEPARTAMENEMPRESA SET DEPARTAMENTO=%s, NUMEROTELEFONO=%s WHERE IDDEPTO=%s",
                       GetSQLValueString($_POST['DEPARTAMENTO'], "text"),
                       GetSQLValueString($_POST['NUMEROTELEFONO'], "text"),
                       GetSQLValueString($_POST['IDDEPTO'], "int"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($updateSQL, $basepangloria) or die(mysql_error());
}

$colname_modifidept = "-1";
if (isset($_GET['root'])) {
  $colname_modifidept = $_GET['root'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_modifidept = sprintf("SELECT * FROM CATDEPARTAMENEMPRESA WHERE IDDEPTO = %s", GetSQLValueString($colname_modifidept, "int"));
$modifidept = mysql_query($query_modifidept, $basepangloria) or die(mysql_error());
$row_modifidept = mysql_fetch_assoc($modifidept);
$totalRows_modifidept = mysql_num_rows($modifidept);
?>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td colspan="2" align="right" nowrap bgcolor="#999999"><h1>Modificar Departamento de la Empresa</h1></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Id Departemento:</td>
      <td><?php echo $row_modifidept['IDDEPTO']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Departameto:</td>
      <td><input type="text" name="DEPARTAMENTO" value="<?php echo htmlentities($row_modifidept['DEPARTAMENTO'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Numero de Telefono:</td>
      <td><input type="text" name="NUMEROTELEFONO" value="<?php echo htmlentities($row_modifidept['NUMEROTELEFONO'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Actualizar registro"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="IDDEPTO" value="<?php echo $row_modifidept['IDDEPTO']; ?>">
</form>
<p>&nbsp;</p>
<?php
mysql_free_result($modifidept);
?>
