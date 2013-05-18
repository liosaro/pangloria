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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO CATCONDICIONPAGO (IDCONDICION, TIPO) VALUES (%s, %s)",
                       GetSQLValueString($_POST['IDCONDICION'], "int"),
                       GetSQLValueString($_POST['TIPO'], "text"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

mysql_select_db($database_basepangloria, $basepangloria);
$query_tipodepago = "SELECT IDCONDICION FROM CATCONDICIONPAGO ORDER BY IDCONDICION ASC";
$tipodepago = mysql_query($query_tipodepago, $basepangloria) or die(mysql_error());
$row_tipodepago = mysql_fetch_assoc($tipodepago);
$totalRows_tipodepago = mysql_num_rows($tipodepago);

mysql_select_db($database_basepangloria, $basepangloria);
$query_comboTipo = "SELECT * FROM CATCONDICIONPAGO";
$comboTipo = mysql_query($query_comboTipo, $basepangloria) or die(mysql_error());
$row_comboTipo = mysql_fetch_assoc($comboTipo);
$totalRows_comboTipo = mysql_num_rows($comboTipo);
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
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#999999"><h1>Ingresar Tipo de Pago</h1></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id Condicion:</td>
      <td><input type="text" name="IDCONDICION" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tipo:</td>
      <td><select name="TIPO">
        <?php
do {  
?>
        <option value="<?php echo $row_comboTipo['TIPO']?>"><?php echo $row_comboTipo['TIPO']?></option>
        <?php
} while ($row_comboTipo = mysql_fetch_assoc($comboTipo));
  $rows = mysql_num_rows($comboTipo);
  if($rows > 0) {
      mysql_data_seek($comboTipo, 0);
	  $row_comboTipo = mysql_fetch_assoc($comboTipo);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Insertar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($tipodepago);

mysql_free_result($comboTipo);
?>
